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
float mass;
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
    
}


void loop() {
  
  AmbilDataBME280();
  AmbilDataMAX31865();
  AmbilDataLoadcell();
  
  Serial.print("Suhu Air = ");
  Serial.println(SuhuAir);

  Serial.print("Suhu Udara = ");
  Serial.println(SuhuUdara);

  Serial.print("Tekanan Udara = ");
  Serial.println(TekananUdara);

  Serial.print("Kelembapan = ");
  Serial.println(Kelembapan); 

  Serial.print("Massa = ");
  Serial.println(mass);
}

void AmbilDataBME280() {
  SuhuUdara     = bme.readTemperature();
  TekananUdara  = bme.readPressure() / 100.0F;
  Kelembapan    = bme.readHumidity();
}

void AmbilDataMAX31865(){
  
  uint16_t rtd = thermo.readRTD();

  float ratio = rtd;
  
  ratio /= 32768;
  SuhuAir = thermo.temperature(RNOMINAL, RREF);
  
  // Pengecekan Hardware
  uint8_t fault = thermo.readFault();
  if (fault) {
    Serial.print("Fault 0x"); Serial.println(fault, HEX);
    if (fault & MAX31865_FAULT_HIGHTHRESH) {
      Serial.println("RTD High Threshold"); 
    }
    if (fault & MAX31865_FAULT_LOWTHRESH) {
      Serial.println("RTD Low Threshold"); 
    }
    if (fault & MAX31865_FAULT_REFINLOW) {
      Serial.println("REFIN- > 0.85 x Bias"); 
    }
    if (fault & MAX31865_FAULT_REFINHIGH) {
      Serial.println("REFIN- < 0.85 x Bias - FORCE- open"); 
    }
    if (fault & MAX31865_FAULT_RTDINLOW) {
      Serial.println("RTDIN- < 0.85 x Bias - FORCE- open"); 
    }
    if (fault & MAX31865_FAULT_OVUV) {
      Serial.println("Under/Over voltage"); 
    }
    thermo.clearFault();
  }
  Serial.println();
  delay(1000); 
}

void AmbilDataLoadcell(){
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
  mass = y1*ratio;

 mass -= tara;
}
