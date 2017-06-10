#include <Bridge.h>
#include <HttpClient.h>

String url = "0";
int sessionID = 0;

String reading;

int weight;


void setup() {
  Serial.begin(9600);
  while (!Serial);
  
  Serial.println("Starting Bridge...");
  pinMode(13, OUTPUT);
  digitalWrite(13, LOW);
  Bridge.begin();
  digitalWrite(13, HIGH);
  Serial.println("Bridge started!");
}

void loop() {
  HttpClient client;
  //We are using this reading variable so we can add up the characters from the clients get
  reading = "";
  weight = analogRead(A0);
  //if the session id is not set or is not correct we need to sign in once again. 
  if(sessionID == 0)
  {
    Serial.println("Login Attempt");
    url = "http://studenthome.hku.nl/~gijs.bakker/Kernmodule%20IAD4/thingLogin.php?thingName=thermostaat&password=1234";
    client.get(url);
    while (client.available()) 
    {
      char c = client.read();
      reading += c; 
      Serial.println(reading);
    }
    //set the sessionID to what the reading came up with.
    sessionID = reading.toInt();
  }
  else
  {
    Serial.println(sessionID);  
  }

  //Here we can insert a reading into our database.
  if(sessionID != 0)
  {
    url = "http://studenthome.hku.nl/~gijs.bakker/Kernmodule%20IAD4/thingInsert.php?sessionID=" + String(sessionID) + "&weight=" + String(weight);
    if(weight > 100)
    {
      client.get(url);
      while (client.available()) 
      {
        char c = client.read();
        reading += c; 
      }
      Serial.println(String(weight));
      Serial.println(reading);
    }
    else
    {
      Serial.println("The reading was to low. nobody is on the god damn scale");
    }
  }
  
  Serial.flush();
  delay(2000);
}
