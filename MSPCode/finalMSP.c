
#include "msp430g2553.h"
#include "useful.h"

/*Miscellaneous Defines*/
#define RED_LED_BIT BIT0 //red led bit mask
/*UART Defines*/
#define TXD_BIT BIT2 //uart transmit pin bit mask
#define RXD_BIT BIT1 //uart rcv pin bit mask
/*Sensor Defines*/
#define SENSOR_BIT BIT5 //sensor pin bit mask
#define SENSOR B8_5(P1IN)
/*Motor Defines*/
#define PWM_BIT BIT6 //PWM bit mask
#define MCU_CLOCK           1000000 //1MHz
#define FEEDBACK_BIT BIT3

unsigned int PWM_Period     = 20000;  // PWM Period

/*GLOBAL VARIABLES*/
int rawFeedback;
int rawFeedback_array[8];
int pos;
int filtered;

int minDegrees;
int maxDegrees;
int minFeedback;
int maxFeedback;


/*FUNCTIONS*/
void init_ports(void);
void init_timers(void);
void set_up_pwm(void);
void set_up_adc(void);
int adcRead(void);

void filter(int* start, int num);

void calibrate_feedback_min(int minPos);
void calibrate_feedback_max(int maxPos);
long map(long x, long in_min, long in_max, long out_min, long out_max);
void turn_servo(int degrees);

void lock(void);
void unlock(void);

int main(void)
{
	init_ports();
	init_timers();
	set_up_adc();

	minDegrees = 0;
	maxDegrees = 180;
	minFeedback = 48;
	maxFeedback = 712;

   	UC0IE |= UCA0RXIE; // Enable USCI_A0 RX interrupt - Enable UART Recieve Commands


   	__bis_SR_register(CPUOFF + GIE);

   	while (1){
   	}
}

void init_ports(){
	P2DIR |= 0xFF; // All P2.x outputs
	P2OUT &= 0x00; // All P2.x reset

	P1SEL |= RXD_BIT + TXD_BIT + PWM_BIT; // P1.1 = RXD, P1.2=TXD
	P1SEL2 |= RXD_BIT  + TXD_BIT; // P1.1 = RXD, P1.2=TXD
	P1DIR |= RED_LED_BIT + PWM_BIT;
	P1OUT &= 0x00;
	P1DIR &= ~SENSOR_BIT;
	P1DIR &= ~FEEDBACK_BIT;


	P1IES &= ~SENSOR_BIT; // trigger on rising edge
	P1IFG &= ~SENSOR_BIT; // prevent immediate interrupt
	P1IE |= SENSOR_BIT; // enable interrupts on P1.5
}

void init_timers(){
	WDTCTL = WDTPW + WDTHOLD; // Stop WDT

	DCOCTL = 0; // Select lowest DCOx and MODx settings
	BCSCTL1 = CALBC1_1MHZ; // Set DCO
	DCOCTL = CALDCO_1MHZ;

	/*ADC TIMERS*/
	TA1CCR0 = 10000;
	TA1CCTL0 = CCIE | CM_0; //CCIE = Capture/Compare Interrupt Enable & CM_0 Compare enable
	TA1CTL = TASSEL_2 | ID_0 | TACLR | MC_1;

	/*PWM TIMERS*/
	TA0CCTL1 = OUTMOD_7;            // TACCR1 reset/set
	TA0CTL   = TASSEL_2 + MC_1;     // SMCLK, upmode
	TA0CCR0  = PWM_Period-1;        // PWM Period
	TA0CCR1  = 0;            // TACCR1 PWM Duty Cycle

	/*UART TIMERS*/
	UCA0CTL1 |= UCSSEL_2; // SMCLK
	UCA0BR0 = 0x08; // 1MHz 115200
	UCA0BR1 = 0x00; // 1MHz 115200
	UCA0MCTL = UCBRS2 + UCBRS0; // Modulation UCBRSx = 5
	UCA0CTL1 &= ~UCSWRST; // **Initialize USCI state machine**
	UC0IE |= UCA0RXIE; // Enable USCI_A0 RX interrupt


	IE2 |= UCA0RXIE;
	IE2 &= ~UCA0RXIE;

	IE2 |= UCA0TXIE;
	IE2 &= ~UCA0TXIE;
}

void set_up_adc(){

	ADC10CTL0 &= ~ENC;
	ADC10CTL1 = INCH_3 + ADC10SSEL_3 + ADC10DIV_0 + CONSEQ_2;         // INCH_2 == P1.2 Highest input channel
	ADC10CTL0 = SREF_0 + ADC10SHT_3 + REFON + ADC10ON + MSC;
	ADC10DTC1 = 3;
	ADC10DTC0 = ADC10CT;
	ADC10AE0 |= FEEDBACK_BIT;
	ADC10SA = (unsigned int)(&rawFeedback);

	__delay_cycles(1000);                     // Wait for ADC Ref to settle

	ADC10CTL0 |= ENC + ADC10SC;               // Sampling and conversion start

}

void filter(int* start, int num){
	int i;
	int value;

	int tempFilt = 0;

	for (i=0; i < num; i++) {
		value = *start;

		tempFilt += value;

		start++;
	}

	tempFilt>>=3;

	filtered = tempFilt;

}


#pragma vector=USCIAB0RX_VECTOR
__interrupt void USCI0RX_ISR(void)
{
	switch (UCA0RXBUF) {
	    case 1:
	      lock();
	      break;
	    case 0:
	      unlock();
	      break;
	    default:
	      break;
	    }
}

#pragma vector=USCIAB0TX_VECTOR
__interrupt void USCI0TX_ISR(void)
{
	UC0IE &= ~UCA0TXIE; // Disable USCI_A0 TX interrupt
}

#pragma vector = PORT1_VECTOR
__interrupt void P1_ISR() {
  if ((P1IFG & SENSOR_BIT) == SENSOR_BIT) {
    P1IFG &= ~SENSOR_BIT; // clear interrupt flag

     // Enable USCI_A0 TX interrupt
    if (SENSOR == 1){
    	UC0IE |= UCA0TXIE;
    	UCA0TXBUF = 9;
    }else if(SENSOR == 0){
    	UC0IE |= UCA0TXIE;
    	UCA0TXBUF = 6;
    }
    P1IES ^= SENSOR_BIT; // toggle edge
  } else {
    P1IFG = 0; // clear all other flags to prevent infinite interrupt loops
  }
}

#pragma vector = TIMER1_A0_VECTOR
__interrupt void TimerA1_routine (void) {

	ADC10CTL0 &= ~ENC;
	ADC10CTL0 |= ENC + ADC10SC;

	rawFeedback_array[pos] = ADC10MEM;
	pos++;
	if (pos == 8)
		pos = 0;
	//filter(&rawFeedback_array[0], 8);
}

void unlock(){

	turn_servo(10);

	//__delay_cycles(100000);

	while(rawFeedback > 170){}

	if(rawFeedback < 180 ){
		UC0IE |= UCA0TXIE; // Enable USCI_A0 TX interrupt
		UCA0TXBUF = 5;
		TACCR1 = 0;
	}
}

void lock(){

	turn_servo(150);

	//__delay_cycles(1000000);


	while(rawFeedback < 600){}

	if(rawFeedback > 590 ){
			UC0IE |= UCA0TXIE; // Enable USCI_A0 TX interrupt
			UCA0TXBUF = 8;
			TACCR1 = 0;
		}
}

/*SERVO FUNCTIONS*/

void turn_servo(int degrees){ //input 1 to 180
	int mapped = map(degrees, 0, 180, 1, 2500);
	TACCR1 = mapped;
}

void calibrate_feedback_min(int minPos){
  // Move to the minimum position and record the feedback value
  TACCR1 = 100;//turn_servo(minPos);  //servo.write(minPos);
  minDegrees = minPos;
  __delay_cycles(10000); // make sure it has time to get there and settle
  minFeedback = adcRead();

}

void calibrate_feedback_max(int maxPos){
  // Move to the minimum position and record the feedback value
  TACCR1 = 2500;//turn_servo(minPos);  //servo.write(minPos);
  minDegrees = maxPos;
  __delay_cycles(10000); // make sure it has time to get there and settle
  maxFeedback = adcRead();

}

long map(long x, long in_min, long in_max, long out_min, long out_max){

  return (x - in_min) * (out_max - out_min) / (in_max - in_min) + out_min;

}



