#include <LiquidCrystal.h>
#include <Bridge.h>
#include <Process.h>
#include <SoftwareSerial.h>
#include <SPI.h>
/*
to send data to library the data type shud be a array and not a pointer
*/
char *server = "riot4.azure-mobile.net";//*/"myiot.azure-mobile.net";
char *table_name_otp = "env";//*/"iotarduino_data";
char *table_name_data = "env_settings";
char *ams_key = "pDTJmShRzBgzhPDJQhQrkHSRKTlsCp39"; //*/"mhvusfpprlFQcZEgByItejyhdNKOLw24";
char *pri_key_value = "1315";
char *buff;
char buffer1[200];
char query[100];
int i;
int otp;
int temperature;
int intensity;

char str[10];

LiquidCrystal lcd(12, 11, 5, 4, 3, 2);
Process p1, p2;
SoftwareSerial mySerial(9, 10);
boolean toggle = false;
char ch;

int otpPin = 7;
void setup() {
  // Starting USB Serial, Bluetooth Serial, Initialize Bridge Connection
  Serial.begin(9600);
  mySerial.begin(9600);
  temperature = 25;
  intensity = 50;
  toggle = false;
  Bridge.begin();
  while (!Serial);
  Serial.println("Starting Bridge...");
  lcd.begin(16, 2);
  lcd.clear();
  lcd.setCursor(1, 0);
  lcd.print("IoT DEVICE");
  lcd.setCursor(1, 1);
  lcd.print("CHIP ID 1315");
  delay(3000);
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("MICROSOFT IoT");
  lcd.setCursor(5, 1);
  lcd.print("TEAM A");
  pinMode(otpPin, INPUT);
  pinMode(8, OUTPUT);
  digitalWrite(8, HIGH);
  pinMode(A0, OUTPUT);
  pinMode(A2, OUTPUT);
  pinMode(A1, INPUT);
  digitalWrite(A0, HIGH);
  digitalWrite(A2, LOW);
}

void loop() {
  // put your main code here, to run repeatedly:
  boolean pin = digitalRead(otpPin);
  if (pin)
  {
    toggle = !toggle;
    Serial.println("Reseting OTP...");
    if (temperature < 0)
      temperature = -1 * temperature;
    intensity=45;
    lcd.clear();
    lcd.setCursor(3, 0);
    lcd.print("Setting Up");
    lcd.setCursor(0, 1);
    lcd.print("  New OTP ");
    otp = millis() % 10000;
    if (otp < 1000)
      otp = (random(8) + 1) * 1000 + otp;
    //DO not Change the Below LINE...
    sprintf(query, "{\\\"Temp\\\" : %d,\\\"Intensity\\\" : %d}",temperature,intensity);
    sprintf(buffer1, "curl -H \"Content-type:application/json\" -H X-ZUMO-APPLICATION:%s -X PATCH -d \"%s\" http://%s/tables/%s/%s", ams_key, query, server, table_name_otp, pri_key_value);
    Serial.println(buffer1);
    p1.runShellCommand(buffer1);
    while (p1.running());
    Serial.println("Reading Value: ");
    while (p1.available())
    {
      ch = p1.read();
      Serial.print(ch);
    }
    p1.flush();
    p1.close();
    sprintf(query, "{\\\"OTP\\\" : %d}",otp);
    sprintf(buffer1, "curl -H \"Content-type:application/json\" -H X-ZUMO-APPLICATION:%s -X PATCH -d \"%s\" http://%s/tables/%s/%s", ams_key, query, server, table_name_otp, pri_key_value);
    Serial.println(buffer1);
    p1.runShellCommand(buffer1);
    while (p1.running());
    Serial.println("Reading OTP Value: ");
    while (p1.available())
    {
      ch = p1.read();
      Serial.print(ch);
    }
    p1.flush();
    p1.close();
    lcd.print(otp);
    lcd.setCursor(1, 0);
    lcd.print("CHIP ID - 1315");
    while (digitalRead(otpPin));
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("MS TEAM A");
    lcd.setCursor(0, 1);
    lcd.print("Temp ");
    lcd.print(temperature);
    lcd.print("`C  ");
    lcd.print(intensity);
    lcd.print("%");
  }
  else
  {
    toggle = !toggle;
    Serial.println("Making HTTP Request...");
    sprintf(buffer1, "curl --header X-ZUMO-APPLICATION:%s \"http://%s/tables/%s\"", ams_key, server, table_name_data);
    Serial.println(buffer1);
    p2.runShellCommand(buffer1);
    while (p2.running());
    Serial.println("Reading Values: ");
    while (p2.available())
    {
      ch = p2.read();
      mySerial.write(ch);
    }
    p2.flush();
    p2.close();
    Serial.println("Received Values From Server");
    temperature = (analogRead(A1) * 500) / 1023;
    intensity = analogRead(A4);
    delay(10);
  }
  Serial.println("--------------DONE------------------");
}
