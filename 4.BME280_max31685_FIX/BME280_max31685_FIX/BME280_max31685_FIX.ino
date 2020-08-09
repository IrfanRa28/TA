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
Adafruit_MAX31865 thermo = Adafruit_MAX31865(10, 11, 12, 13);
// Nilai Rref resistor 430.0 digunakan untuk sensor PT100
#define RREF      430.0
// Nilai resistor pada sesnor saat keadaan 0 derajat Celcius 
#define RNOMINAL  100.0

float SuhuUdara = 0, TekananUdara = 0, Kelembapan = 0, SuhuAir = 0;


void setup() {

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
}


void loop() {

  
  AmbilDataBME280();
  AmbilDataMAX31865();
  
  Serial.print("Suhu Air = ");
  Serial.println(SuhuAir);

  Serial.print("Suhu Udara = ");
  Serial.println(SuhuUdara);

  Serial.print("Tekanan Udara = ");
  Serial.println(TekananUdara);

  Serial.print("Kelembapan = ");
  Serial.println(Kelembapan);
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
