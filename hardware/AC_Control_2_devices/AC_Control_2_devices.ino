#include <TimerOne.h>           // Avaiable from http://www.arduino.cc/playground/Code/Timer1

volatile int i = 0;             // Variable to use as a counter
volatile int j = 0;
volatile boolean zero_cross1 = 0; // Boolean to store a "switch" to tell us if we have crossed zero
volatile boolean zero_cross2 = 0;
int AC_pin1 = 4;                 // Output to Opto Triac
int AC_pin2 = 5;
int dim1_2 = 0;                   // led control
int dim1 = 128;                  // Dimming level (0-128)  0 = on, 128 = 0ff
int dim2_2 = 0;
int dim2 = 128;
int pas = 8;                    // step for count;
char str[100];
int freqStep = 75;    // This is the delay-per-brightness step in microseconds for 50Hz (change the value in 65 for 60Hz)
int time;

void setup()
{
  Serial.begin(9600);
  pinMode(AC_pin1, OUTPUT);                          // Set the Triac pin as output
  pinMode(AC_pin2, OUTPUT);
  attachInterrupt(0, zero_cross_detect, RISING);    // Attach an Interupt to Pin 2 (interupt 0) for Zero Cross Detection
  Timer1.initialize(freqStep);                      // Initialize TimerOne library for the freq we need
  Timer1.attachInterrupt(dim_check, freqStep);
  // Use the TimerOne Library to attach an interrupt
  while (!Serial);
  time=0;
}

void zero_cross_detect() {
  zero_cross1 = true;               // set the boolean to true to tell our dimming function that a zero cross has occured
  zero_cross2 = true;
  i = 0;
  j = 0;
  digitalWrite(AC_pin1, LOW);
  digitalWrite(AC_pin2, LOW);
}

// Turn on the TRIAC at the appropriate time
void dim_check() {
  if (dim1_2 > 0)
  {
    if (zero_cross1 == true) {
      if (i >= dim1) {
        digitalWrite(AC_pin1, HIGH);  // turn on light
        i = 0; // 2reset time step counter
        zero_cross1 = false;  // reset zero cross detection
      }
      else {
        i++;  // increment time step counter
      }
    }
  }
  if (dim2_2 > 0)
  {
    if (zero_cross2 == true) {
      if (j >= dim2) {
        digitalWrite(AC_pin2, HIGH);  // turn on light
        j = 0; // reset time step counter
        zero_cross2 = false;  // reset zero cross detection
      }
      else {
        j++;  // increment time step counter
      }
    }
  }

}

void loop()
{
  if (Serial.available())
  {
    char ch = Serial.read();
    if (ch == '1')
    {
      if (dim1 < 127)
      {
        dim1 = dim1 + pas;
        if (dim1 > 127)
          dim1 = 128;
      }
    }
    else if (ch == '2')
    {
      if (dim1 > 5)
      {
        dim1 = dim1 - pas;
        if (dim1 < 0)
          dim1 = 0;
      }
    }
    if (ch == '4')
    {
      if (dim2 < 127)
      {
        dim2 = dim2 + pas;
        if (dim2 > 127)
          dim2 = 128;
      }
    }
    else if (ch == '5')
    {
      if (dim2 > 5)
      {
        dim2 = dim2 - pas;
        if (dim2 < 0)
          dim2 = 0;
      }
    }
  }
  dim1_2 = 255 - 2 * dim1;
  dim2_2 = 255 - 2 * dim2;
  if (dim1_2 < 0)
    dim1_2 = 0;
  if (dim2_2 < 0)
    dim2_2 = 0;
  
  sprintf(str,"Device1: %d|%d     Device2: %d|%d",dim1,dim1_2,dim2,dim2_2);
  Serial.println(str);
  delay (100);
}
