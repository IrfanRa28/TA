//EEPROM Untuk Menyimpan x1 kalibrasi
#include <EEPROM.h>

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

long x1 = 8787168;//0L;
long x0 = 0L;
float avg_size = 4.0; // amount of averages for each mass measurement
float tara = 0;
int mode = 0;
float oz_conversion = 0.035274;
float mass; 
float massaAwal =0;
float y1 = 509.1; // calibrated mass to be added

int jmlhJungkitan = 0; //Jumlah Jungkitan
int hal = 0;

int n = 0;
float sumTudara = 0, sumTair = 0, sumP = 0, sumRH = 0;
int lsNow = 0;
float rata2TU = 0;
float rata2TA = 0;
float rata2PU = 0;
float rata2RH = 0;
bool Running = false;

struct MyObject {
  long x1; 
};

int alamatx1 = 0;
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

  pinMode (A0, INPUT);
  pinMode (A1, INPUT);
  pinMode (A3, OUTPUT);
  digitalWrite(A3, HIGH);

  alamatx1 += sizeof(long);
  MyObject customVar;
  EEPROM.get(alamatx1, customVar);
  Tare();
  x1 = customVar.x1;
  
  while(true){
    AmbilDataLoadcell();
    int x = analogRead(A0);
    if (x<5){
      tampilLcd("Sistem Dimulai");
      Running = true;
      digitalWrite(A3, LOW);
      massaAwal = mass;
      break;
    }
    else if (x<520){
      Tare(); 
    }
    else if (x<700){
      Kalibrasi();
    }
    else{
      Serial.println("Massa kurang dari 400");
      lcd.clear();
       lcd.setCursor(5, 0);
       lcd.print("Kalibrator");
       lcd.setCursor(5, 1);
       lcd.print("Rain Gauge");
       lcd.setCursor(0, 2);
       lcd.print("");
       lcd.setCursor(0, 3);
       lcd.print("Massa : " + (String)mass);
    }
  }

    
}


void loop() {
  
  AmbilDataBME280();
  AmbilDataMAX31865();
  AmbilDataLoadcell();
  PengaturanAliran();
  RecordSum();
  //ReedSwitch();
  printAll();

  
  
}
