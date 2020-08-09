
#include <Wire.h>
#include <SPI.h>
#include <Adafruit_Sensor.h>
#include <Adafruit_BME280.h>


Adafruit_BME280 bme; // I2C

unsigned long delayTime;

void setup() {
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
}


void loop() { 
    printValues();
    delay(delayTime);
}


void printValues() {
    
    Serial.print("Suhu Udara (*C) = ");
    Serial.println(bme.readTemperature());

    Serial.print("Tekanan Udara (hPa) = ");
    Serial.println(bme.readPressure() / 100.0F);
    
    Serial.print("Kelembapan (%) = ");
    Serial.print(bme.readHumidity());
    Serial.println();
}
