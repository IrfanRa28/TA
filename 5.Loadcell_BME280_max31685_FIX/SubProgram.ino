void printAll(){
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

  tampilLcd((String)SuhuAir+" C - " + (String)SuhuUdara + " C", (String)TekananUdara + " hPa "+ (String)Kelembapan+" %", (String)mass+" gram");
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
//  delay(1000); 
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
