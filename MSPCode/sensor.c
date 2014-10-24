#include <msp430.h> 

/*
 * main.c
 */
void main() {
  WDTCTL = WDTPW + WDTHOLD; // kill wdt
  P1DIR = BIT0 + BIT6; // set LED1 and LED2 to OUT
  P1OUT = BIT6; // LED2 always on - indicates power
  P1IES &= ~BIT5; // low-high edge initially
  P1IFG &= ~BIT5; // prevent immediate interrupt
  P1IE |= BIT5; // enable interrupts on P1.5
  _BIS_SR(LPM4_bits + GIE); // enable GPIO interrupts and send into LPM4

  //for (;;){
	  //P1OUT ^= BIT0;
  //}// loop forever
 }

// interrupt for P1
#pragma vector = PORT1_VECTOR
__interrupt void P1_ISR() {
  if ((P1IFG & BIT5) == BIT5) { // if motion sensed
    P1IFG &= ~BIT5; // clear interrupt flag
    P1OUT ^= BIT0; // toggle LED1
    P1IES ^= BIT5; // toggle edge
  } else {
    P1IFG = 0; // clear all other flags to prevent infinite interrupt loops
  }
}
