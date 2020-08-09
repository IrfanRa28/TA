//Loadcell
#include <Q2HX711.h>
#include <Wire.h> 
//==========================================LCD INIT====================
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x27, 20, 4);
void tampilLcd(String s1, String s2="", String s3="", String s4="");
//==============================LCD END=================================
//==============================hxstart=================================
const byte hx711_data_pin = 3;    //Data pin from HX711
const byte hx711_clock_pin = 2;   //Clock pin from HX711
Q2HX711 hx711(hx711_data_pin, hx711_clock_pin); // prep hx711

long x1 = 8795297;//0L;
long x0 = 0L;
float avg_size = 15.0; // amount of averages for each mass measurement
float tara = 0;
int mode = 0;
float oz_conversion = 0.035274;
float mass, massaAwal =0;
float y1 = 509.1; // calibrated mass to be added
//=======================================end hx=============================

//===============================
//BME280
#include <Wire.h>
#include <SPI.h>
#include <Adafruit_Sensor.h>
#include <Adafruit_BME280.h>

Adafruit_BME280 bme; // I2C

unsigned long delayTime;

//PT100
#include <Adafruit_MAX31865.h>

// Pengunaan Pin SPI: CS, DI, DO, CLK
Adafruit_MAX31865 thermo = Adafruit_MAX31865(6, 7, 8, 9);

// Nilai Rref resistor 430.0 digunakan untuk sensor PT100
#define RREF      430.0

// Nilai resistor pada sesnor saat keadaan 0 derajat Celcius 
#define RNOMINAL  100.0

float SuhuUdara = 0, TekananUdara = 0, Kelembapan = 0, SuhuAir = 0;


void setup() {

//=============================LCD===================================
  lcd.begin();
  lcd.backlight();
//==============================Loacell================================
PCICR |= (1 << PCIE0);              //enable PCMSK0 scan
  delay(2000);   //Waktu untuk menstabilkan loadcell
// tare procedure
  for (int ii=0;ii<int(avg_size);ii++){
    delay(10);
    x0+=hx711.read();
  }
  x0/=long(avg_size);
//============================EndLoacell==============================
  
  //BME280
 Serial.begin(9600);
    while(!Serial);    
    Serial.println(F("BME280 test"));
 unsigned status;
    
    // default settings
    status = bme.begin(); 
     
    // You can also pass in a Wire library object like &Wire2
    status = bme.begin(0x76);
    if (!status) {
        Serial.println("Could not find a valid BME280 sensor, check wiring, address, sensor ID!");
        Serial.print("SensorID was: 0x"); Serial.println(bme.sensorID(),16);
        Serial.print("        ID of 0xFF probably means a bad address, a BMP 180 or BMP 085\n");
        Serial.print("   ID of 0x56-0x58 represents a BMP 280,\n");
        Serial.print("        ID of 0x60 represents a BME 280.\n");
        Serial.print("        ID of 0x61 represents a BME 680.\n");
        while (1) delay(10);
    }
    
    Serial.println("-- Default Test --");
    delayTime = 5000;

    Serial.println();

    //PT100
Serial.println("Adafruit MAX31865 PT100 Sensor Test!");
thermo.begin(MAX31865_3WIRE);  // '3WIRE" karena PT100 yang digunakan hanya ada 3 kabel

  while(true){
    AmbilDataLoadcell();
    if (mass>400){
      tampilLcd("tekan Start!");
      break;
    }else{
      Serial.println("Massa kurang dari 400");
      tampilLcd("Massa Kurang");
    }
  }
  while(true){
    if(!digitalRead(A2)){
      massaAwal = mass;
      break;
    }
  }
    
}


void loop() {
  
  AmbilDataBME280();
  AmbilDataMAX31865();
  AmbilDataLoadcell();
  printAll();
  float selisih = massaAwal - mass;
  if(selisih>990){
    //massa lebih dari 990 yang sudah netes
    
  }else if(selisih>660){
    //massa lebih dari 660 yang sudah netes
    
  }else if(selisih>330){
    //massa lebih dari 330 yang sudah netes
    
  }
  
}
