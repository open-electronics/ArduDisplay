/*
    ArduDisplay
    
    Versione: 1.0
    Autore: Luca Bellan

*/


#include <Process.h>
#include <HT1632.h> 
#include <font_8x4.h>

//Setup PIN per display Sure 3208
byte numero_display=2;
byte wr =3;
byte data = 5;
byte cs1 = 6;
byte cs2 = 9;//Solo con 2 display
byte cs3 = 0;//Solo con 3 display
byte cs4 = 0;//Solo con 4 display


/*-------------------------------*/

int larghezzaTesto;
unsigned char* fraseCorrente =(unsigned char*) "";
unsigned char* fraseVecchia =(unsigned char*) "";
int translazione=0;
byte tempoDisplay;
int tempoDelay;
String id_frase="-1";
int iterazioni;
int cont=0;

/*
Tengo acceso il PIN 13 fino a quando Bridge non si inizializza
Inizializzo display
Pulisco i display
Aspetto 40 secondi prima di fare partire il programma
*/
void setup() {
  pinMode(13, OUTPUT);
  digitalWrite(13, HIGH);
  Bridge.begin();
  digitalWrite(13, LOW);
  switch(numero_display){
    case 1:
      HT1632.begin(cs1,wr,data);
      break;
    case 2:
      HT1632.begin(cs1,cs2,wr,data);
      break;
    case 3:
      HT1632.begin(cs1,cs2,cs3,wr,data);
      break;
    case 4:
      HT1632.begin(cs1,cs2,cs3,cs4,wr,data);
      break;
    default:
      break;
  }
  for(int i=0;i<numero_display;i++){
    HT1632.renderTarget(i);
    HT1632.clear();
    HT1632.render();
  }
  delay(40000);
}

/*
Se il contatore arriva a zero: pulisco i display, carico impostazioni e nuova frase da PHP
Mando avanti il text-scrolling sul display (controlliDisplay())
Mando avanti iterazioni
*/
void loop() {
  if(cont==0){
    for(int i=0;i<numero_display;i++){
      HT1632.renderTarget(i);
      HT1632.clear();
      HT1632.render();
    }
    caricaImpostazioni();
    cambiaFrase();
  }
  controlliDisplay();
  cont=(cont+1)%iterazioni;
}

/*
Trasmetto la frase ai display, facendola scorrere e creando l'effetto text-scrolling
*/
void controlliDisplay(){
  for(int i=0;i<numero_display;i++){
    HT1632.renderTarget(i);
    HT1632.clear();
    HT1632.drawText(fraseCorrente, OUT_SIZE * (numero_display-i)-translazione , 0, FONT_8X4, FONT_8X4_END, FONT_8X4_HEIGHT);
    HT1632.render();
  }
  translazione = (translazione+1)%(larghezzaTesto + OUT_SIZE * numero_display);
  delay(tempoDelay);
}

/*
Carico impostazioni chiamando il file PHP (velocità text-scrolling e tempo di visualizzazione per ogni messaggio
*/
void caricaImpostazioni(){
  Process p;
  String temp;
  
  p.begin("/usr/bin/php-cgi");
  p.addParameter("-q");
  p.addParameter("/mnt/sda1/arduino/www/ritorna_impostazioni.php");
  p.run();
  while (p.available()>0) {
    char c = p.read();
      if(c!='|'){
        temp += c;
      } else {
        tempoDisplay=temp.toInt();
        temp="";
      }
  }
  tempoDelay=temp.toInt();
  iterazioni=tempoDisplay*1000/tempoDelay;
}

/*
Carico una nuova frase chiamando il file PHP (che mi restituisce IDFrase|Frase) e passandogli l'ID della frase corrente
Calcolo la lunghezza della frase per creare l'effetto text-scrolling sui display
*/
void cambiaFrase(){
    Process p;
    String temp="";
    p.begin("/usr/bin/php-cgi");
    p.addParameter("-q");
    p.addParameter("/mnt/sda1/arduino/www/ritorna_frasi.php");
    p.addParameter(id_frase);
    p.run();
    while (p.available()>0) { 
      char c = p.read();
      if(c!='|'){
        temp += c;
      } else {
        id_frase=temp;
        temp="";
      }
    }
    fraseVecchia=fraseCorrente;
    unsigned char b[temp.length()+1];
    temp.getBytes(b,temp.length()+1);
    fraseCorrente = b;
    if(fraseCorrente!=fraseVecchia){
      translazione=0;
      larghezzaTesto = HT1632.getTextWidth(fraseCorrente, FONT_8X4_END, FONT_8X4_HEIGHT);
    }
}
