#include <ESP8266WiFi.h>
#include <WiFiClient.h>
//--------------------Implementacion de bmp180---------------------------


//------------------------Implementacion de bme 280------------------------

#include <Wire.h>
#include <Adafruit_Sensor.h>
#include <Adafruit_BME280.h>
#define SEALEVELPRESSURE_HPA (1013.25)
Adafruit_BME280 bme;


//-------------------VARIABLES GLOBALES--------------------------
int contconexion = 0;

const char *ssid = "Familia";
const char *password = "naci200187";




unsigned long previousMillis = 0;

char host[48];
String strhost = "192.168.1.101";
String strurl = "/redes/Arduino/enviardatos.php";
String chipid = "";


//-------Función para Enviar Datos a la Base de Datos SQL--------

String enviardatos(String datos) {
  String linea = "error";
  WiFiClient client;
  strhost.toCharArray(host, 49);
  if (!client.connect(host, 80)) {
    Serial.println("Fallo de conexion");
    return linea;
  }

  client.print(String("POST ") + strurl + " HTTP/1.1" + "\r\n" +
               "Host: " + strhost + "\r\n" +
               "Accept: */*" + "*\r\n" +
               "Content-Length: " + datos.length() + "\r\n" +
               "Content-Type: application/x-www-form-urlencoded" + "\r\n" +
               "\r\n" + datos);
  delay(10);

  Serial.print("Enviando datos a SQL...");

  unsigned long timeout = millis();
  while (client.available() == 0) {
    if (millis() - timeout > 5000) {
      Serial.println("Cliente fuera de tiempo!");
      client.stop();
      return linea;
    }
  }
  // Lee todas las lineas que recibe del servidro y las imprime por la terminal serial
  while (client.available()) {
    linea = client.readStringUntil('\r');
  }
  Serial.println(linea);
  return linea;
}

//-------------------------------------------------------------------------

void setup() {

  // Inicia Serial
  Serial.begin(115200);
  //--------------------------------------------------------------------------------
  Serial.println(F("BME280 test"));
  bool status;
  status = bme.begin(0x76);
  if (!status) {
    Serial.println("Could not find a valid BME280 sensor, check wiring!");
    while (1);
  }

  Serial.println("-- Default Test --");


  Serial.println();

  //---------Inicializar sensor bmp180-----------------------------------------------

  //---------fin  sensor------------------------------------------------------------

  Serial.println("");

  Serial.print("chipId: ");
  chipid = String(ESP.getChipId());
  Serial.println(chipid);

  // Conexión WIFI
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED and contconexion < 50) { //Cuenta hasta 50 si no se puede conectar lo cancela
    ++contconexion;
    delay(500);
    Serial.print(".");
  }
  if (contconexion < 50) {
    //para usar con ip fija
    IPAddress ip(192, 168, 1, 156);
    IPAddress gateway(192, 168, 1, 1);
    IPAddress subnet(255, 255, 255, 0);
    WiFi.config(ip, gateway, subnet);

    Serial.println("");
    Serial.println("WiFi conectado");
    Serial.println(WiFi.localIP());
  }
  else {
    Serial.println("");
    Serial.println("Error de conexion");
  }
}


void printValues() {
  double T, P, A, H;
  Serial.print("Temperature = ");
  Serial.print(bme.readTemperature());
  T = bme.readTemperature();
  Serial.println(" *C");

  // Convert temperature to Fahrenheit
  /*Serial.print("Temperature = ");
    Serial.print(1.8 * bme.readTemperature() + 32);
    Serial.println(" *F");*/

  Serial.print("Pressure = ");
  Serial.print(bme.readPressure() / 100.0F);
  P = bme.readPressure() / 100.0F;
  Serial.println(" hPa");

  Serial.print("Approx. Altitude = ");
  Serial.print(bme.readAltitude(SEALEVELPRESSURE_HPA));
  A = bme.readAltitude(SEALEVELPRESSURE_HPA);
  Serial.println(" m");

  Serial.print("Humidity = ");
  Serial.print(bme.readHumidity());
  H = bme.readHumidity();
  Serial.println(" %");

  Serial.println();
  enviardatos("chipid=" + chipid + "&humedad=" + String(H, 2) + "&temperatura=" + String(T, 2) + "&presion=" + String(P, 2) + "&altitud=" + String(A,2));
}


//--------------------------LOOP--------------------------------
void loop() {
  char status;


  unsigned long currentMillis = millis();

  if (currentMillis - previousMillis >= 60000) { //envia la temperatura cada 10 segundos
    previousMillis = currentMillis;

    printValues();
  }
}
