/* Arduino code for a precision scale with a 1Kg load cell, HX711 ADC and mode selector 
 * Schematic: https://electronoobs.com/eng_arduino_tut115_sch1.php
 * Code: https://electronoobs.com/eng_arduino_tut115_code1.php
 * Video: https://youtu.be/LRd3W_p8PJ4 */


#include <Q2HX711.h>              //Downlaod from here: https://electronoobs.com/eng_arduino_hx711.php
//LCD config
#include <Wire.h> 
#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x27,20,4); //sometimes the LCD adress is not 0x3f. Change to 0x27 if it dosn't work.


//Pins 
const byte hx711_data_pin = 3;    //Data pin from HX711
const byte hx711_clock_pin = 2;   //Clock pin from HX711
int tara_button = 8;              //Tara button
int mode_button = 11;             //Mode change button
Q2HX711 hx711(hx711_data_pin, hx711_clock_pin); // prep hx711

//Variables
/////////Change here with your calibrated mass////////////
float y1 = 509.1; // calibrated mass to be added
//////////////////////////////////////////////////////////

long x1 = 0L;//0L;
long x0 = 0L;
float avg_size = 15.0; // amount of averages for each mass measurement
float tara = 0;
bool tara_pushed = false;
bool mode_pushed = false;
int mode = 0;
float oz_conversion = 0.035274;
//////////////////////////////////////////////////////////



void setup() {
  Serial.begin(9600);                 // prepare serial port
  PCICR |= (1 << PCIE0);              //enable PCMSK0 scan                                                 
  PCMSK0 |= (1 << PCINT0);            //Set pin D8 trigger an interrupt on state change.
  PCMSK0 |= (1 << PCINT3);            //Set pin D10 trigger an interrupt on state change.   
  pinMode(tara_button, INPUT_PULLUP);
  pinMode(mode_button, INPUT_PULLUP);

  lcd.begin();                         //Init the LCD
  lcd.backlight();                    //Activate backlight 
  
  delay(3000);                        // allow load cell and hx711 to settle

  
  // tare procedure
  for (int ii=0;ii<int(avg_size);ii++){
    delay(10);
    x0+=hx711.read();
  }
  x0/=long(avg_size);
  Serial.println("Add Calibrated Mass");
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print(" Add Calibrated ");
  lcd.setCursor(0,1);
  lcd.print("      Mass      ");
  // calibration procedure (mass should be added equal to y1)
  int ii = 1;
  while(true){
    float baca = hx711.read();
    Serial.println(baca);
    if (baca<x0+10000)
    {
      //do nothing...
    } 
    else 
    {
      ii++;
      delay(2000);
      for (int jj=0;jj<int(avg_size);jj++){
        x1+=hx711.read();
      }
      x1/=long(avg_size);
      delay(10000);
      break;
    }
  }
  Serial.println("Calibration Complete");
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("  Calibration   ");
  lcd.setCursor(0,1);
  lcd.print("    Complete    ");
}

void loop() {
  // averaging reading
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

  if(tara_pushed)
  {
    tara = mass;
    tara_pushed = false;
    Serial.print("TARA");
    Serial.print(".");
    lcd.setCursor(0,0);
    lcd.print("      TARA      ");
    lcd.setCursor(0,1);
    lcd.print("      .         ");    
    delay(300);
    Serial.print(".");
    lcd.setCursor(0,0);
    lcd.print("      TARA      ");
    lcd.setCursor(0,1);
    lcd.print("      ..        "); 
    delay(300);
    Serial.println(".");
    lcd.setCursor(0,0);
    lcd.print("      TARA      ");
    lcd.setCursor(0,1);
    lcd.print("      ...       "); 
    delay(300);   
  }
  if(mode_pushed)
  {
    mode = mode + 1;
    mode_pushed = false;
    if(mode > 2)
    {
      mode = 0;
    }
  }
  
  if(mode == 0)
  {
    Serial.print(mass - tara);
    Serial.println(" g");
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("     SCALE!     ");
    lcd.setCursor(0,1);
    lcd.print(mass - tara);
    lcd.print(" g"); 
  }
  else if(mode == 1)
  {
    Serial.print(mass - tara);
    Serial.println(" ml");
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("     SCALE!     ");
    lcd.setCursor(0,1);
    lcd.print(mass - tara);
    lcd.print(" ml");
  }
  else
  {
    Serial.print((mass - tara)*oz_conversion);
    Serial.println(" oz");
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("     SCALE!     ");
    lcd.setCursor(0,1);
    lcd.print((mass - tara)*oz_conversion);
    lcd.print(" oz");
  }
  
}//End of void loop


//interruption to detect buttons
ISR(PCINT0_vect)
{
  if (!(PINB & B00000001))
  {
    tara_pushed = true;           //Tara button was pushed
  }
  
  if (!(PINB & B00001000))
  {
    mode_pushed = true;           //Mode button was pushed
  }
}

 
  
