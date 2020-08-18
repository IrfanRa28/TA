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
