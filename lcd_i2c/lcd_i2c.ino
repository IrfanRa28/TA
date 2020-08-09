#include <Wire.h>
#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x27, 20, 4);
void tampilLcd(String s1, String s2="", String s3="", String s4="");

void setup()
{
//  lcd.clear();
  lcd.begin();
  lcd.backlight();
//  lcd.setCursor(4, 0);
//  lcd.print("Welcome to");
//  lcd.setCursor(5, 1);
//  lcd.print("Teknik Elektro");
//  lcd.setCursor(2, 2);
//  lcd.print("Universitas");
//  lcd.setCursor(8, 3);
//  lcd.print("Pertamina");
  tampilLcd("HALLO", "Kamu Siapa?");
}
void loop()
{
  // Do nothing here...
}


void tampilLcd(String s1, String s2, String s3, String s4){
  lcd.clear();
   lcd.setCursor(0, 0);
   lcd.print(s1);
   lcd.setCursor(0, 1);
   lcd.print(s2);
   lcd.setCursor(0, 2);
   lcd.print(s3);
   lcd.setCursor(0, 3);
   lcd.print(s4);
}
