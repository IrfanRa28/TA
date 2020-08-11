void printAll(){
  int x = analogRead(A0);
    if(x>700 && x<800){
      tampilLcd("", "", "    Loading...");
      if(hal>=2){
        hal = 0;
      }
      else{
        hal++;
      }
      delay(500);
    }
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

  switch(hal){
    case 0:
      tampilLcd((String)SuhuAir+" C - " + (String)SuhuUdara + " C", (String)TekananUdara + " hPa ", (String)Kelembapan+" %", (String)mass+" gram");
      break;

    case 1:
      tampilLcd("Jumlah Jungkit : "+(String)jmlhJungkitan, "Baris 2");
      break;

    case 2:
      rata2TU = (float)sumTudara/n;
      if(mass>730){
        rata2TA = (float)sumTair/n;
      }
      rata2PU = (float)sumP/n;
      rata2RH = (float)sumRH/n;
      tampilLcd((String) rata2TU, (String) rata2TA, (String) rata2PU, (String) rata2RH);
      break;
  }
//  if (hal==0){
//    tampilLcd((String)SuhuAir+" C - " + (String)SuhuUdara + " C", (String)TekananUdara + " hPa ", (String)Kelembapan+" %", (String)mass+" gram");
//  }
//  else{
//    tampilLcd("Jumlah Jungkit : "+(String)n, "Baris 2");
//  }
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
 mass = abs(mass);
}

void Tare(){
  tampilLcd("Tare");
  x0=0L;
  for (int ii=0;ii<int(avg_size);ii++){
    delay(10);
    x0+=hx711.read();
  }
  x0/=long(avg_size);
}

void Kalibrasi(){
  tampilLcd("Kalibrasi");
  x1 = 0L;
  for (int jj=0;jj<int(avg_size);jj++){
        x1+=hx711.read();
      }
      x1/=long(avg_size);
}

void ReedSwitch(){
  int RS = digitalRead(A1);

  if(RS==0){
    delay(3000);
    jmlhJungkitan++;
    Serial.println(jmlhJungkitan);
  }
}

void PengaturanAliran(){
  float selisih = massaAwal - mass;
  Serial.println(selisih);
  if(selisih>960){
    //massa lebih dari 960 yang sudah netes
    tampilLcd(" Kalibrasi Selesai");
    Running = false;
    digitalWrite(A3, HIGH);
  }else if(selisih>640){
    digitalWrite(A3, HIGH);
    //massa lebih dari 640 yang sudah netes
    int lastNow = 0;
    while (true){
      int Now = millis();
      if((Now - lastNow)>3000){
        digitalWrite(A3, LOW);
        break;
      }
    }
  }else if(selisih>320){
    //massa lebih dari 320 yang sudah netes
    digitalWrite(A3, HIGH);
    int lastNow = 0;
    while (true){
      int Now = millis();
      if((Now - lastNow)>3000){
        digitalWrite(A3, LOW);
        break;
      }
    }
  }
}

void RecordSum(){
  int Nw = millis();
  if((Nw-lsNow)<0){
    lsNow = Nw;
  }
  else if((Nw - lsNow)>1000){
    lsNow = Nw;
    if(Running){
      sumTudara += SuhuUdara;
      sumTair += SuhuAir;
      sumP += TekananUdara;
      sumRH += Kelembapan;
      n++;
    }
    
  }
}
