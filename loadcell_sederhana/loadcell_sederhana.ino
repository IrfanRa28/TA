#include <Q2HX711.h>
#include <Wire.h> 

const byte hx711_data_pin = 3;    //Data pin from HX711
const byte hx711_clock_pin = 2;   //Clock pin from HX711
Q2HX711 hx711(hx711_data_pin, hx711_clock_pin); // prep hx711


long x1 = 8795297;//0L;
long x0 = 0L;
float avg_size = 15.0; // amount of averages for each mass measurement
float tara = 0;
int mode = 0;
float oz_conversion = 0.035274;

float y1 = 509.1; // calibrated mass to be added

void setup() {
  Serial.begin(9600);                 // prepare serial port
  PCICR |= (1 << PCIE0);              //enable PCMSK0 scan
  delay(2000);   //Waktu untuk menstabilkan loadcell


// tare procedure
  for (int ii=0;ii<int(avg_size);ii++){
    delay(10);
    x0+=hx711.read();
  }
  x0/=long(avg_size);
}

void loop() {
long reading = 0;
  for (int jj=0;jj<int(avg_size);jj++)
  {
    reading+=hx711.read();
  }
  reading/=long(avg_size);

// calculating mass based on calibration and linear fit
  float ratio_1 = (float) (reading-x0);
  float ratio_2 = (float) (x1-x0);
  float ratio = ratio_1/ratio_2;
  float mass = y1*ratio;

 mass -= tara;
 Serial.println(mass);
 delay(300); 
}
