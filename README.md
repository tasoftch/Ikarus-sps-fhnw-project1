## Ikarus SPS Simulation
### Project 1 FHNW: Escape from Liama Raja

Dieses Startup Projekt soll aufzeigen, wie ihr euer Vorschlag der Zeitmaschine testen könnt. 

##### WLAN Verbindung
Ihr müsst euer System zuerst via WLAN mit der Steuerung Verbinden.  
````bin
$ sudo raspi-config
````
Das zeigt euch ein Interface an, wo ihr SSID und PSK eingeben könnt.  
Nach einem Neustart sollte euer System mit der Ikarus SPS Simulation verbunden sein.  

Gebt ```http://192.168.200.1``` in einem Browser ein.  
Damit gelangt ihr auf die Hauptseite der Steuerung, von wo aus ihr euer System testen könnt.




##### PHP installieren
Sofern ihr PHP verwenden wollt, könnt ihr gleich mit diesem Template starten.
```bin
$ sudo apt-get install php
$ php -v
PHP 8.2.24 (cli) (built: Sep 24 2024 22:12:40) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.2.24, Copyright (c) Zend Technologies
    with Xdebug v3.3.1, Copyright (c) 2002-2023, by Derick Rethans
    with Zend OPcache v8.2.24, Copyright (c), by Zend Technologies
```
Die Ausgabe von ````php -v```` wird ungefähr so aussehen.  
````php
php beispiel.php
````
Führt das Beispiel Projekt aus. Das funktioniert natürlich nur, wenn ihr im WLAN der Steuerung angemeldet seid.


##### Python
Es steht euch natürlich frei, eine andere Sprache als PHP zu verwenden, zum Beispiel Python.  
Damit müsst ihr aber die Schnittstelle implementieren.  
````
1.  Ihr müsst die Access-Methoden aus folgender Datei implementieren
    AbstractCommonMemoryRegister.php
    Es gibt eine Python-Library phpserialize, welche die serialize und unserialize Funktion in PHP implementiert.
    
2.  TCP Verbindung nach 192.168.200.1 auf Port 9090
3.  Dann könnt ihr Kommandos, Werte und Status lesen und schreiben.

Eure System - Domain ist: ZM
Also ZM.WERT_1 wäre ein korrekter Zugriffsname.
````