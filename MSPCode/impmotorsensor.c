
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
#define MCU_CLOCK           1000000
#define PWM_FREQUENCY       50      // In Hertz, ideally 50Hz.

#define SERVO_STEPS         180     // Maximum amount of steps in degrees (180 is common)
#define SERVO_MIN           700     // The minimum duty cycle for this servo
#define SERVO_MAX           3000    // The maximum duty cycle

unsigned int PWM_Period     = (MCU_CLOCK / PWM_FREQUENCY);  // PWM Period
unsigned int PWM_Duty       = 0;                            // %

/*GLOBAL VARIABLES*/
unsigned int servo_stepval, servo_stepnow;
unsigned int servo_lut[ SERVO_STEPS+1 ];
unsigned int i;

/*FUNCTIONS*/
void init_ports(void);
void init_timers(void);
void set_up_pwm(void);

void lock(void);
void unlock(void);

int main(void)
{
	init_timers();
	init_ports();
	set_up_pwm();

   	UC0IE |= UCA0RXIE; // Enable USCI_A0 RX interrupt - Enable UART Recieve Commands

   	__bis_SR_register(GIE);


   	while (1){
   	}
}

void init_ports(){
	P2DIR |= 0xFF; // All P2.x outputs
	P2OUT &= 0x00; // All P2.x reset

	P1SEL |= RXD_BIT + TXD_BIT + PWM_BIT; // P1.1 = RXD, P1.2=TXD
	P1SEL2 |= RXD_BIT  + TXD_BIT; // P1.1 = RXD, P1.2=TXD
	P1DIR |= RED_LED_BIT + PWM_BIT;
	P1DIR &= ~SENSOR_BIT;
	P1OUT &= 0x00;

	P1IES &= ~SENSOR_BIT; // trigger on rising edge
	P1IFG &= ~SENSOR_BIT; // prevent immediate interrupt
	P1IE |= SENSOR_BIT; // enable interrupts on P1.5
}

void init_timers(){
	WDTCTL = WDTPW + WDTHOLD; // Stop WDT

	DCOCTL = 0; // Select lowest DCOx and MODx settings
	BCSCTL1 = CALBC1_1MHZ; // Set DCO
	DCOCTL = CALDCO_1MHZ;

	/*PWM TIMERS*/
	TACCTL1 = OUTMOD_7;            // TACCR1 reset/set
	TACTL   = TASSEL_2 + MC_1;     // SMCLK, upmode
	TACCR0  = PWM_Period-1;        // PWM Period
	TACCR1  = PWM_Duty;            // TACCR1 PWM Duty Cycle

	/*UART TIMERS*/
	UCA0CTL1 |= UCSSEL_2; // SMCLK
	UCA0BR0 = 0x08; // 1MHz 115200
	UCA0BR1 = 0x00; // 1MHz 115200
	UCA0MCTL = UCBRS2 + UCBRS0; // Modulation UCBRSx = 5
	UCA0CTL1 &= ~UCSWRST; // **Initialize USCI state machine**
	UC0IE |= UCA0RXIE; // Enable USCI_A0 RX interrupt

}

void set_up_pwm(){
	// Calculate the step value and define the current step, defaults to minimum.
	servo_stepval   = ( (SERVO_MAX - SERVO_MIN) / SERVO_STEPS );
	servo_stepnow   = SERVO_MIN;

	// Fill up the LUT
	for (i = 0; i < SERVO_STEPS; i++) {
	    servo_stepnow += servo_stepval;
	    servo_lut[i] = servo_stepnow;
	}
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
   //P1OUT |= RED_LED_BIT;
     //UCA0TXBUF = string[i++]; // TX next character
    //if (i == sizeof string - 1) // TX over?
     //  UC0IE &= ~UCA0TXIE; // Disable USCI_A0 TX interrupt
   // P1OUT &= ~RED_LED_BIT;

	UC0IE &= ~UCA0TXIE; // Disable USCI_A0 TX interrupt
}

#pragma vector = PORT1_VECTOR
__interrupt void P1_ISR() {
  if ((P1IFG & SENSOR_BIT) == SENSOR_BIT) {
    P1IFG &= ~SENSOR_BIT; // clear interrupt flag

    UC0IE |= UCA0TXIE; // Enable USCI_A0 TX interrupt
    UCA0TXBUF = SENSOR;

    P1IES ^= SENSOR_BIT; // toggle edge
  } else {
    P1IFG = 0; // clear all other flags to prevent infinite interrupt loops
  }
}

void unlock(){
	for (i = SERVO_STEPS; i > 0; i--) {
		TACCR1 = servo_lut[i];
		__delay_cycles(20000);
	}
}

void lock(){
	for (i = 0; i < SERVO_STEPS; i++) {
		TACCR1 = servo_lut[i];
	    __delay_cycles(20000);
    }
}



