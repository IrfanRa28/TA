#include <Wire.h>
#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x27, 20, 4);
void setup()
{
  lcd.begin();
  lcd.backlight();
  lcd.setCursor(4, 0);
  lcd.print("Welcome to");
  lcd.setCursor(5, 1);
  lcd.print("Teknik Elektro");
  lcd.setCursor(2, 2);
  lcd.print("Universitas");
  lcd.setCursor(8, 3);
  lcd.print("Pertamina");
}
void loop()
{
  // Do nothing here...
}
