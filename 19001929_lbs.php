###[DEF]###
[name	    = Xiaomi Roboroc 1.0]

[e#1	    trigger= Abfragen]
[e#2	    = Xiaomi-Cloud user ]
[e#3	    = Xiaomi-Cloud password]
[e#4        = Xiaomi-Server #init=de]
[e#5        = Xiaomi-Geräte-ID#init=0]

[e#7        = Xiaomi Cloud Token]

[e#9        = DEBUG#init=0]

[e#10       = IP]
[e#11       = Token]
[e#12       = valetudo#init=0]

[e#14       = Steuer-Kommando #init=0]

[e#18       = lade Karte]
[e#19       = Ziel-Koordinaten]
[e#20       = Segment-Reinigung]

[e#23       = Wartungsrückstellung]
[e#24       = Saugstufe]
 
[e#30       = Roboter automatisch befreien #init=3]
[e#40       = Gültigkeit Statistiken #init=24]
[e#41       = LiveMap Aktualisierungsintervall#init=1]
 
[a#1        = Reinigung beendet]
[a#2		= Batterie %]
[a#3	    = Fehlermeldung]
[a#4        = Status]
[a#5        = Reinigung aktiv]
[a#6        = Wischeinheit verbunden]
[a#7        = Saugmodus]

[a#10       = Xiaomi Cloud Token]

[a#12       = verfügbare Karten]
[a#13       = aktive Karte (Index)]
 
[a#18       = letzte Reinigungsdauer]
[a#19       = letzte Reinigungsfläche]

[a#20       = bisherige Reinigungszeit]
[a#21       = bisherige Fläche]
[a#22       = bisherige Reinigungen]

[a#24       = Filter]
[a#25       = Seitenbürste]
[a#26       = Hauptbürste]
[a#27       = Sensoren]
[a#28       = Filter Wassertank]
[a#29       = Signalstärke ]

[a#34       = Baustein Aktiv]
[a#40       = RR-Map URL]
 
[v#1   = 0] // Exec
[v#2   = 0] // Roborock-Befehl
[v#3   = 0] // ssecurity (aus cloud-login)
[v#4   = 0] // userId (aus cloud-login)
[v#5   = 0] // serviceToken (aus cloud-login)
[v#6   = 0] // Roboter IP
[v#7   = 0] // Roboter Token
[v#8   = 0] // letzter Reinigungs-Status
[v#9   = 0] // Sequenzzähler lowlevel
[v#10  = 0] // Nächste Aktualisierung der Statistiken
[v#11  = 0] // letzter Fehler
[v#12  = 0] // Gültigkeit der Reinigungsmap
[v#13  = 0] // nächstes Update-Intervall der Reinigungsmap, wenn der Roboter aktiv ist
[v#14  = 0] // Anzahl der Versuche den Roboter im aktuellen Zyklus zu befreien
###[/DEF]###


###[HELP]###
 E1  : Trigger
 E2  : Benutzername aus der Xiaomi-App (E-Mail Adresse)
 E3  : Passwort aus der Xiaomi-App
 E4  : Xiaomi-Server-Region: (de, us, ru, sg).
       Das Feld muss leer gelassen werden wenn der Roboter bei "Mainland China" angemeldet ist.
       Das ist insbesondere bei mi robot vacuum v1 der Fall.
 
 E5  : Xiaomi Geräte-ID (0...n). Falls mehere Xiaomi-Geräte in der Cloud aktiv sind, muss hier
       die entsprechende ID für den Roboter angegeben werden. Hierzu Debug-Level auf 2 setzen und
       den Roboter aus der Log raussuchen. Falls nur 1 Roboter verfügbar, dann "0"

 E7  : Xiaomi Cloud Token - leer lassen, wenn nur <b>ein</b> Xiaomi-Gerät im Einsatz ist. Ansonsten Hinweise bei A 10 beachten.
 
 E9  : Debug: [0..2], 0= aus, 2 = maximal

 E10 und E11 sind Optional, wenn die Xiaomi-Cloud nicht benutzt werden soll. Nur für gehackte Roboter!
 E10 : Roboroc- IP-Adresse (WLAN)
 E11 : Roboroc- Token
 E12 : valetudo. Falls auf dem Roboter valetudo installiert ist, muss hier eine 1 angegeben werden.
       Der Baustein gibt auf A40 die URL für die Reinigungskarten von valetudo aus.

 Bitte keine komplexen Trigger-Logiken an diese Eingänge hängen:
 Einfach nur eine '1' senden. Der Eingang <b>darf</b> nicht zurückgesetzt werden!

 E14 : Kommando-ID:
        1 = Reinigung starten / fortsetzen
        2 = Stopp
        3 = Pause
        4 = Spot Reinigung
        5 = Zur Basis
        6 = 'finde mich' - Roboter sagt 'hier bin ich'
        10 = Segmentreinigung fortsetzen

 E18 : Lade Karte. ID aus Liste A12.
       Der Roboter stellt die Reinigungskarte um.
 
 E19 : Ziel-Koordinaten
       X,Y-Position in der Karte, wo der Roboter hinfahren soll
 
 E20 : Komma separierte Segment-IDs. Dieser Eingang wird vom VSE_1015 Ko2 gesetzt. Datentyp: Variant
       Wenn die Zonen bekannt sind, kann hier auch eine Liste manuell eingefügt werden, Beispiel: 1,3,4

 E23 : Wartung zurücksetzen. Eingangswert ist ein String:
        Filter: filter_work_time
        Seitenbürste: side_brush_work_time
        Hauptbürste: main_brush_work_time
        Sensoren: sensor_dirty_time
        Wasserfilter: filter_element_work_time
 E24 : Entweder 1..100 (Angabe in Prozent)
       oder bei Roborock S5 / S6:
        101 = Leise
        102 = Balanciert
        103 = Turbo
        104 = Max
        105 = Schonend
 
 E30 : Roboter automatisch befreien. Die Funktion ist aktuell nicht implementiert,
       dient aber dazu, dass wenn dieser sich irgendwo festfährt, dass der Baustein versucht diesen
       erneut zu starten. So kann in einigen Fällen der Roboter automatisch weitermachen.
       Dieser Wert gibt die Anzahl der Versuche wieder. Default = 3

 E40 : Gültigkeitsdauer der Statistiken in Stunden. Nach ablauf dieser Zeit wird die Statistik
       erneut vom Roboter abgerufen. Default: Alle 24 Stunden.
 E41 : Intervall Livemap Aktualisierung. Die Zeitangabe ist in 20 Sekunden-Schritten. Achtung, der Baustein wird weitehrin
       per E1-Trigger ausgeführt, d.h. wenn hier eine niedrigere Zeit angegeben ist, ,wie der E1 auslöst, dann gibt E1
       das Intervall vor.
 
 A1  : Reinigung beendet
 A2  : Batterie [%]
 A3  : Aktuelle Fehlermeldung
 A4  : Aktueller Status
 A5  : Reinigung aktiv
 A6  : Wischeinheit verbunden
 A7  : Saugmodus: [mögliche Werte: Spezifisch, Wischen, Max, Turbo, Balance, Leise]

 Cloud-Informationen

 A10 : Xiaomi Cloud Token
       Nur verwenden, wenn mehere Geräte im Einsatz sind. Dieser Wert muss in einer Variable abgespeichert werden, die dann mit dem Eingang E7 verbunden ist.

 A12 : Verfügbare Karten
       Ausgabeformat:
 
       ID,Bezeichnung

       Sind mehere Ebenen angelegt, so werden diese dann mit einem Semikolon separiert. Beispiel:
       0;Erdgeschoss,1;Obergeschoss

       Wenn die ID an E18 übermittelt wird, dann lädt der Roboter die entsprechende Karte

 A13 : aktive Karte. Hier wird die Index-Nummer der aktiven Karte ausgegeben, z.B. "0"
 
 Aktuelle Statistik
 A18 : letzte Reinigungsdauer [min]
 A19 : letzte Reinigungsfläche [m²]

 Statistiken über bisherige Reinigungen:
 A20 : Gesamtzeit [h]
 A21 : Gereinigte Fläche [m²]
 A22 : Anzahl Reinigungen

 Instandhaltungszeiten:
 A24 : Laufzeit Filter. Max: 150 Stunden
 A25 : Laufzeit Seitenbürste. Max. 200 Stunden
 A26 : Laufzeit Hauptbürste. Max 300 Stunden
 A27 : Laufzeit Sensoren. Max 30 Stunden
 A28 : Laufzeit Wassertankfilter. Max. 100 Stunden
 A29 : RSSI - WIFI-Signalstärke

 A34 : Debug-Info. Wird später entfernt, wenn der Baustein stabil läuft.

 A40 : URL zur RR-Datei für die weiterverarbeitung
###[/HELP]###


###[LBS]###
 <?
 function LB_LBSID_debug($robotID,$debugLevel,$thisTxtDbgLevel, $str) {
     if ($thisTxtDbgLevel <= $debugLevel) {
         $dbgTxts = array("Kritisch","Info","Debug");
         writeToCustomLog("LBS_XIAOMI_LBSID_$robotID", $dbgTxts[$thisTxtDbgLevel], $str);
     }
 }

 function LB_LBSID($id) {
    if ($E=logic_getInputs($id)) {
        if (logic_getVar($id, 1) == 0)  {
            if (
                ($E[7]['refresh'] && $E[7]['value'])
            ) {
                $cloudToken = $E[7]['value'];
                
                LB_LBSID_debug($E[5]['value'],$E[9]['value'], 1, "Xiaomi cloud token=" . $cloudToken);
                
                if (strlen ($cloudToken) > 10) {
                    list ($serviceToken, $ssecurity, $userId) = explode ("\n",$cloudToken);
                    
                    logic_setVar($id, 3, $serviceToken);
                    logic_setVar($id, 4, $ssecurity);
                    logic_setVar($id, 5, $userId);
                } else {
                    LB_LBSID_debug($E[5]['value'],$E[9]['value'], 1, "wird ignoriert.");
                }
            } else {
                if (
                    ($E[1]['refresh'] && $E[1]['value']) ||
                    ($E[14]['refresh'] && $E[14]['value']) || // Kommando-ID
                    ($E[18]['refresh']) || // Lade Reinigungskarte x
                    ($E[19]['refresh'] && $E[19]['value']) || // X,Y-Position
                    ($E[20]['refresh'] && $E[20]['value']) || // Segment-Reinigung
                    ($E[23]['refresh'] && $E[23]['value']) || // Wartung zurücksetzen
                    ($E[24]['refresh'] && $E[24]['value'])    // Saugleistung
                ){
                    $myRobotCommand = 0;
                    /*
                      0 = Do nothing
                      1 = Start/Continue
                      2 = Stop
                      3 = Pause
                      4 = Spot cleaning
                      5 = Return to Base
                      6 = findMe
                      7 = resetConsumable
                      8 = Segment-Reinigung
                      9 = Saugleistung einstellen
                      10 = Segmentreinigung fortsetzen
                      11 = Fahre zu Position aus E[19]
                      12 = Lade Reinigungskarte aus E[18]
                    */

                    if ($E[14]['refresh'] && $E[14]['value']) {
                        if (in_array ($E[14]['value'], array (1,2,3,4,5,6,10,11,12))) {
                            $myRobotCommand = $E[14]['value'];
                        } else {
                            LB_LBSID_debug($E[5]['value'],$E[9]['value'], 0, "Kommando-ID ist ungültig (".$E[14]['value'].")");
                        }
                    } else if ($E[23]['refresh'] && $E[23]['value']) {
                        $myRobotCommand = 7;
                    } else if ($E[20]['refresh'] && $E[20]['value']) {
                        $myRobotCommand = 8;
                    } else if ($E[24]['refresh'] && $E[24]['value']) {
                        $myRobotCommand = 9;
                    } else if ($E[19]['refresh'] && $E[19]['value']) {
                        $myRobotCommand = 11;
                    } else if ($E[18]['refresh'] && $E[18]['value'] != '') {
                        $myRobotCommand = 12;
                    }
             
                    logic_setVar($id,2,$myRobotCommand);
            
                    //if (logic_getVar($id, 1) == 0)  {
                    logic_setVar($id, 1, 1);					//setzt V1=1, um einen mehrfachen Start des EXEC-Scripts zu verhindern
                    logic_setOutput($id, 34, 1);  //Exec aktiv
                    logic_callExec(LBSID,$id);				//EXEC-Script starten
                }
            }
        } else {
            LB_LBSID_debug($E[5]['value'],$E[9]['value'], 1, "Exec ist bereits aktiv. Aufruf Intervall prüfen");
        }
    }
 }
 ?>
 ###[/LBS]###


 ###[EXEC]###
 <?
 require(dirname(__FILE__)."/../../../../main/include/php/incl_lbsexec.php");
 //require('wrapper.php');
 sql_connect();

 $totalRunTime = getMicrotime();
 
 $E=logic_getInputs($id);
 $V=logic_getVars($id);

 $xiaomiDeviceID = $E[5]['value'];

 $dbgTxts = array("Kritisch","Info","Debug");
 $debugLevel = $E[9]['value'];

 $refreshCleaningStats = ((getMicrotime()>=$V[10]));
 
 $cloud = new xiaomiCloud ($E[2]['value'],$E[3]['value'],$E[4]['value'],$xiaomiDeviceID);

 $ip = '';
 $token = '';
 
 if (!empty($E[2]['value'])) {
     if (strlen($V[5]) > 3) {
         // cloud login values exist. ReUse them
         exec_debug(2, "Cloud-Daten aus Cache verwenden. Kein Login!");
         exec_debug (2, "V3=".$V[3]."V4=".$V[4]."V5=".$V[5]);
         $cloud->restoreCloudCredentials ($V[3], base64_decode($V[4]), $V[5]);
     } else {
         list ($serviceToken, $ssecurity, $userId) = $cloud->cloudLogin();

         if ($cloud->isAccessible) {
             exec_debug (1, "Login erfolgreich!");
             exec_debug (2, "uid=$userId; ssecurity=".$ssecurity."; serviceToken= $serviceToken");
         } else {
             exec_debug (0, "Login fehlgeschlagen!");
         }
     }

     if ($cloud->isAccessible) {

         if ($V[6] != 0) {
             $ip = $V[6];
             $token = $V[7];
         }
        
         if (empty ($ip) || empty ($token)) {
             exec_debug (2, "ip: $ip bzw. token : $token sind leer. Cloud->getDeviceStatus()");
             if ($cloud->getDeviceStatus()) {
                 exec_debug (1, "DeviceStatus ok\n");
                 list ($ip, $token) = $cloud->cloudDeviceStatus->getIPToken();
       
                 if (!empty($ip) && !empty($token)) {
                     $V[6] = $ip;
                     $V[7] = $token;

                     logic_setVar($id, 6, $ip);
                     logic_setVar($id, 7, $token);
                     exec_debug (2, "ip = $ip; token = $token\n");	 
                 }
             
                 if (!$cloud->cloudDeviceStatus->isOnline())
                     exec_debug (0, "Roboter ist nicht Erreichbar!\n");

                 exec_debug (2, outputDebug ("CloudStateInformation",$cloud->cloudDeviceStatus->arrStateInformation));
             } else {
                 exec_debug (0, "Geräte-Status konnte nicht aus der Cloud ermittelt werden!\n");
             }
         }
     }

 } else {
     exec_debug (1, "Keine Benutzerdaten eingegeben! Lokale IP erforderlich");
 }

 exec_debug(2,"cloud->isAccessible:".($cloud->isAccessible ? 'Y' : 'N')."-E10=".$E[10]['value']."-E11=".$E[11]['value']);
 
 if ((empty($ip) || empty($token) ) && (empty($E[10]['value']) || empty($E[11]['value']))) {
     exec_debug (0, "IP/Token leer! Baustein muss richtig konfiguriert werden! Abbruch");
 } else {

     if ($cloud->isAccessible) {
         if ($V[6] != 0) {
             $ip = $V[6];
             $token = $V[7];
         }
     } else {
         $ip = $E[10]['value'];
         $token = $E[11]['value'];
     }

     exec_debug (2, "RoborockMe:: ip = $ip; token = $token; SequenceID: ".$V[9]);

     if ($roboroc = new RoborockMe ($ip,54321,$token, $V[9])) {
         exec_debug(2,"roborocMe:: ok");
             
         if ($roboroc->heloReceived) {

             exec_debug (2, outputDebug ("miIO.Info",$roboroc->Info_miIOInfo->Info));
  
             $refreshCleaningMap = ($V[12] < time());
             
             switch ($V[2]) {
             case 1: // start / continue after pause
                 $roboroc->startCleaning();
                 break;
             case 2: // stopp
                 $roboroc->stopCleaning();
                 break;
             case 3: // pause
                 $roboroc->pauseCleaning();
                 break;
             case 4: // spotCleaning
                 $roboroc->spotCleaning();
                 break;
             case 5: // startCharging
                 $roboroc->startCharging();
                 break;
             case 6:
                 $roboroc->findMe();
                 break;
             case 7:
                 exec_debug (2, "Wartung zurücksetzen für ".$E[23]['value']);
                 // Wartung zurücksetzen
                 $ret =$roboroc->resetConsumables ($E[23]['value']);
                 if ($ret == FALSE) {
                     exec_debug (0, "Reset fehlgeschlagen für ".$E[23]['value']);
                 } else {
                     exec_debug (2, outputDebug ("result:",$ret));
                 }
                 $refreshCleaningStats = 1;
                 break;
             case 8:
                 $subCmds = explode ("!!:",$E[20]['value']);
                 if (!empty ($subCmds[0])) {
                     $segmentID = $subCmds[0];
                     exec_debug(2, "Segment-Reinigung ".$segmentID);
                     $roboroc->segmentCleaning($segmentID);
                 }
                 if (!empty ($subCmds[1])) {
                     switch ($subCmds[1]) {
                     case "refreshMap":
                         $V[13] = time(); // trigger refreshCleaningMap
                         //$refreshCleaningMap = 1;
                         break;
                     }
                 }
                 break;
             case 9:
                 $roboroc->setFanSpeed ($E[24]['value']);
                 exec_debug(2, "Saugleistung ".$E[24]['value']);
                 break;
             case 10:
                 $roboroc->resumeSegmentCleaning();
                 exec_debug(2, "Segmentreinigung fortsetzen");
                 break;
             case 11:
                 $val = $E[19]['value'];
                 if (!empty ($val) && (strstr($val, ",")) ) {
                     //$position = explode (",",$val);
                     $roboroc->gotoTarget ($val);
                     exec_debug(2, "Gehe zu Position ($val)");
                 } else {
                     exec_debug(0,"Ziel-Position fehlerhaft. Wert an E[19] = $val");
                 }
                 break;
             case 12:
                 $val = $E[18]['value'];
                 if ($val != '') {
                     $roboroc->setMultiMap ($val);
                     $refreshCleaningMap = 1;
                     exec_debug(2, "Lade Karte $val");
                 } else {
                     exec_debug(0, "Fehler parameter E18, Wert ist leer: '$val'");
                 }

                 break;
             }

             $lastRobotCleaningState = $V[8];
             $currentRoboCleaningState = ($roboroc->Info_Status->inReturning()*10) + $roboroc->Info_Status->inCleaning();

             /*
               inCleaning = 3 bei Raumreinigung
             */
   
             exec_debug (2, outputDebug ("Info_Status",$roboroc->Info_Status->Info_Status));
             exec_debug (2, "Aktueller Status: $currentRoboCleaningState");

             if ($currentRoboCleaningState) {
                 exec_debug (2, "next-upd: ".$V[13]." time:".time());

                 if (time() >= $V[13]) {
                     $V[13] = time() + $E[41]['value']*20;
                     logic_setVar($id, 13, $V[13]); // save map expire time
                     $refreshCleaningMap = 1;
                 }
             }
             
             if (($lastRobotCleaningState != 0) && ($currentRoboCleaningState == 0)) {
                 $refreshCleaningStats = 1;

                 // nicht sofort die Karte aktualisieren, da der Roboter einige Zeit nach dem andocken zum übertragen der Map benötigt.
                 logic_setVar($id, 12, time() + 30);
                 $refreshCleaningMap = 0; // damit auf keinen Fall in diesem Lauf ein Map-Refresh erfolgt, ansonsten wird $V[12] überschrieben.
                 
                 logic_setOutput($id, 1, 1);
                 exec_debug (2, "Reinigung beendet: $currentRoboCleaningState / $lastRobotCleaningState");
             }
             logic_setVar($id,8,$currentRoboCleaningState);
             
             logic_setOutput($id,2 ,$roboroc->Info_Status->getBatteryLevel());

             $errorCode = $roboroc->Info_Status->errorCode();
             exec_debug (2, "error-code: ".$errorCode);
             if ($V[11] != $errorCode) {
                 // sicher stelle, dass der gleiche Fehlercode nicht mehrfach ausgegeben wird
                 logic_setOutput($id, 3, $roboroc->getTranslatedStringFromArray($roboroc->errorCodes, $errorCode));
                 logic_setVar($id, 11, $errorCode);
             }
             if ($errorCode == 0) {
                 if ($V[14] != 0) {
                     exec_debug (2, "Rettungs-Zähler (=".$V[14].") zurücksetzen");
                     $V[14] = 0;
                     logic_setVar($id, 14, $V[14]); // Zähler für Rettungsversuche zurücksetzen, Roboter ist fehlerfrei
                 }
             }

             if (($errorCode > 0) && (isset ($E[30]['value']) && is_int($E[30]['value']))) {
                 if ($V[14] < $E[30]['value']) {
                     if ($roboroc->tryToFreeRobot()) {
                         $V[14]++;
                         exec_debug (1,"Versuche Roboter zu befreien. Versuch-Nr:".$V[14]);
                         logic_setVar($id, 14, $V[14]); // Zähler für Rettungsversuche zurücksetzen, Roboter ist fehlerfrei
                     }
                 }
             }
             
             logic_setOutput($id, 4, $roboroc->getTranslatedStringFromArray($roboroc->stateCodes, $roboroc->Info_Status->getState()));

             logic_setOutput($id, 5, $currentRoboCleaningState);
             logic_setOutput($id, 6, $roboroc->Info_Status->waterBoxStatus());
             logic_setOutput($id, 7, $roboroc->getFanPowerText());
             //logic_setOutput($id, 7, $roboroc->getTranslatedStringFromArray($roboroc->translatedFanCodes, $roboroc->Info_Status->fanPowerLevel()));

             logic_setOutput($id, 29, $roboroc->Info_miIOInfo->getRSSI());
             

             // Statistiken

             if ($refreshCleaningStats) {
                 if ($roboroc->getCleanSummary() != FALSE) {

                     list ($_area, $_time) = $roboroc->Info_Status->getCleanAreaTime();
                     logic_setOutput($id, 18, $_time);
                     logic_setOutput($id, 19, $_area);

                     logic_setOutput($id, 20, $roboroc->Info_CleaningSummary->totalTime());
                     logic_setOutput($id, 21, $roboroc->Info_CleaningSummary->totalArea());
                     logic_setOutput($id, 22, $roboroc->Info_CleaningSummary->totalCleanups());

                     logic_setVar($id, 10, getMicrotime() + ($E[40]['value']*60*60)); // Nächsten refresh merken
                 }
                 
                 if ($roboroc->getConsumables() != FALSE) {

                     logic_setOutput($id, 24, $roboroc->getRestLifeTime ($roboroc->Info_Consumables->filterWorkTime(), 150) ); // Max: 300 Stunden
                     logic_setOutput($id, 25, $roboroc->getRestLifeTime ($roboroc->Info_Consumables->sideBrushWorkTime(), 200) ); // Max: 200 Stunden
                     logic_setOutput($id, 26, $roboroc->getRestLifeTime ($roboroc->Info_Consumables->mainBrushWorkTime(), 300)); // Max: 150 Stunden
                     logic_setOutput($id, 27, $roboroc->getRestLifeTime ($roboroc->Info_Consumables->sensorDirtyTime(), 30)); // Max: 30 Stunden
                     logic_setOutput($id, 28, $roboroc->getRestLifeTime ($roboroc->Info_Consumables->filterElementWorkTime(), 100)); // Max: 100 Stunden

                     exec_debug(2,outputDebug ("getConsumables",$roboroc->Info_Consumables->Info_Consumables));
                 }
             }
             exec_debug (2,"sequenceID ".$roboroc->getSequenceID(). " V9 =".$V[9]);

             if ($refreshCleaningMap) {
                 if ($roboroc->getMultiMaps() != FALSE) {
                     exec_debug (2,outputDebug ("multimaps ",$roboroc->Info_MultiMaps->Info));

                     logic_setOutput($id, 12, $roboroc->Info_MultiMaps->getAllMaps());
                     logic_setOutput($id, 13, $roboroc->Info_Status->getActiveMapIndex());
                 }

                 $mapAvailable = 0;
                 // Map is no longer valid. Refresh
                 if ( $roboroc->Info_Status->isMapPresent()) {
                     if ($cloud->isAccessible) {
                         $url = $roboroc->getMapV1();

                         $retryGetMap = 0;

                         if ($url != "retry") {
                             exec_debug (2, "map-url: $url");
                             RetryMapGet:
                             $retryGetMap++;

                             if ($cloud->getMap ($url)) {
                                 exec_debug (2, "mapv1 url= $url");
                                 
                                 list ($ret,$exp) = $cloud->cloudMap->getURLToMap ();
                                 if ($ret) {
                                     logic_setVar($id, 12, $exp); // save map expire time
                                     $mapAvailable = 1;
                                 } else {
                                     exec_debug (1, "url ist nicht gültig!");
                                 }
                             } else {
                                 if ($cloud->credentialsChanged && $retryGetMap < 3)
                                     goto RetryMapGet;
                             }
                         } else {
                             exec_debug (1, "getMapV1: fehlgeschlagen. Roboter nicht online ?");
                         }
                     } else if (!empty($E[12]['value']) && $E[12]['value'] == 1 /*&& !empty($E[10]['value'])*/) {
                         //$url = parse_url ($E[10]['value']);
                         //$ret = "http://".$url['host']."/api/map/latest";
                         $ret = "http://".$ip."/api/map/latest";

                         $mapAvailable = 1;                        
                     }
                 }
                 
                 if ($mapAvailable) {
                     if ($currentRoboCleaningState != 0) {
                         $ret .= "!!:"."isCleaning";
                     }
                     logic_setOutput($id, 40, $ret);
                     
                     exec_debug (2, "url to map= $ret");
                 } else {
                     exec_debug (2, "keine Map vorhanden");
                 }
             }
             
             if ($roboroc->getSequenceID() != $V[9])
                 logic_setVar($id, 9, $roboroc->getSequenceID());
         } else {
             exec_debug(1,"Roboter reagiert nicht.");
         }
         
     } else {
         exec_debug(0,"Objekt RoborocMe konnte nicht erstellt werden IP ($ip) / Token($token) prüfen.");
     }
 }

 if ($cloud->credentialsChanged) {
     list ($serviceToken, $ssecurity, $userId) = $cloud->getAllCredentials();

     logic_setVar($id, 3, $serviceToken);
     logic_setVar($id, 4, $ssecurity);
     logic_setVar($id, 5, $userId);

     $cloudToken = $serviceToken."\n".$ssecurity."\n".$userId;

     logic_setOutput($id, 10, $cloudToken);
 }
 
 logic_setVar($id, 1, 0);  //Sperre entfernen
 logic_setOutput($id, 34, 0);  //Exec inaktiv

 $totalRunTime = getMicrotime() - $totalRunTime;
 exec_debug (2, "Ausführungszeit: $totalRunTime [s]");
 
 sql_disconnect();


 function outputDebug ($customTxt, $myArr = null) {
     $content = '';
     if ($myArr != null) {
         ob_start();
         var_dump($myArr);
         $content = ob_get_contents();
         
         ob_end_clean();
     }
     return $customTxt . ":" . $content;
 }

 function exec_debug ($thisTxtDbgLevel, $str) {
     global $debugLevel;
     global $dbgTxts;
     global $xiaomiDeviceID;
     
     if ($thisTxtDbgLevel <= $debugLevel) {
         writeToCustomLog("LBS_XIAOMI_LBSID_$xiaomiDeviceID", $dbgTxts[$thisTxtDbgLevel], $str);
     }
 }

class Crypt_Rc4 {
    var $s= array();
    var $i= 0;
    var $j= 0;
 
    function Crypt_RC4($key = null) {
        if ($key != null) {
            $this->setKey($key);
        }
    }
 
    function setKey($key) {
        if (strlen($key) > 0) {
            $this->key($key);
        }
    }
 
    function key($key) {
        $len= strlen($key);

        for ($this->i = 0; $this->i < 256; $this->i++) {
            $this->s[$this->i] = $this->i;
        }
 
        $this->j = 0;
        for ($this->i = 0; $this->i < 256; $this->i++) {
            $this->j = ($this->j + $this->s[$this->i] + ord($key[$this->i % $len])) % 256;
            $t = $this->s[$this->i];
            $this->s[$this->i] = $this->s[$this->j];
            $this->s[$this->j] = $t;
        }
        $this->i = $this->j = 0;
    }
 
    /**
     * Encrypt function
     *
     * @param  string paramstr     - string that will encrypted
     * @return void 
     * @access public
     */
    function iterate ($len) {
        for ($c= 0; $c < $len; $c++) {
            $this->i = ($this->i + 1) % 256;
            $this->j = ($this->j + $this->s[$this->i]) % 256;
            $t = $this->s[$this->i];
            $this->s[$this->i] = $this->s[$this->j];
            $this->s[$this->j] = $t;
        }
    }
    function crypt($paramstr) {
        $output = '';
 
        $len= strlen($paramstr);
        for ($c= 0; $c < $len; $c++) {
            $this->i = ($this->i + 1) % 256;
            $this->j = ($this->j + $this->s[$this->i]) % 256;
            $t = $this->s[$this->i];
            $this->s[$this->i] = $this->s[$this->j];
            $this->s[$this->j] = $t;
 
            $t = ($this->s[$this->i] + $this->s[$this->j]) % 256;
 
            $output .= chr(ord($paramstr[$c]) ^ $this->s[$t]);
        }
        return ($output);
    }
}    //end of RC4 class

 /*
  * (w) 2020 by Nima Ghassemi Nejad (sipiyou@hotmail.com)
  *
  *  01.05.2020 - v 0.1 - NGN initial release
  *  05.05.2020 -   0.2 -     added support for xiaomi cloud login+authentification
  *  16.05.2020 -   0.3 -     bugfixes, code cleanups & token-/login-cache
  *  17.05.2020 -   0.4       added support for consumables and reset of consumables
  *                 0.5       bugfix in cleaning finished. Additional outputs for states
  *  22.05.2020 -   0.6       modifications to support older devices than S5
  *                           fetch RR-map url
  *			      code cleanups & enhancements
  *                 0.7       bugfix in map fetch
  *  22.05.2020 -   0.71      bugfix in restLifeTime calculation
  *  23.05.2020 -   0.72      close socket upon object udpHandler::__destruct
  *  26.05.2020 -   0.8       cloudMap must be refreshed before expire. Set expire-= 2 Minutes before real expire
  *                           reduced cloudDeviceStatus requests. Only call this service if no ip/token is available
  *                           minor bugfixes
  *  27.05.2020 -   0.81      added some hints for v1 robots
  *  28.05.2020 -   0.82      new object cmdInfoConsumables
  *  29.05.2020 -             new object cmdGetLocale
  *                           new object cmdGetCleaningSummary
  *                           getCleanRecord()
  *  31.05.2020 -   0.83      E41 - Updateintervall for Mapupdates while Robot is cleaning
  *                           + segmentCleaning(..)
  *                           E20 - set ID's for segment cleaning
  *                           bugfix inCleaning-state.
  *  03.06.2020 -   0.84      added support for miIO.Info
  *                           fanlevel processing extended for gen1/2 and s5+ robots
  *  05.06.2020 -   0.85      fanLevelText
  *                           bugfix "undefined index ap"
  *                           bugfix "undefined offset: xxx"
  *                           + setFanSpeed()
  *                           min map-update Interval = 20 sec (before: 60 seconds)
  *  13.06.2020 -   0.86      added more german translations
  *  19.06.2020 -   0.87      valetudo support
  *                           + inReturning(). cleaning is finished after inCleaning & inReturning == 0
  *  28.06.2020 -   0.88      + tryToFreeRobot(). free robot if it's stuck. Handled errorcodes = 3 & 8
  *  13.07.2020 -   0.89      + resumeSegmentCleaning()
  *                           E14 - Control-Command. Removed E15..E19, E21.
  *                 0.90      bugfix valetudo url. php-parse_url does not output host if only ip is specified.
  *                 0.91      Added errormessages if miio.info / get_status is not supported
  *  01.08.2020 -   0.92      special commands for internal communication. Seperator: "!!::". Used on A40 & E20
  *  23.08.2020 -   0.93      bugfix for Valetudo-RE map update
  *  25.08.2020 -   0.94      RoborockMe returns false if miIoInfo or getStatus is not supported or does not receive data.
  *                           this happens sometimes due to poor wifi signal                              
  *  11.09.2020 -   ----      udp-retryCount
  *  12.09.2020 -   0.95      gotoTarget Position
  *                           use timestamp from robot for communication.
  *  03.10.2020 -   0.96a     debug supports robot-id
  *  07.10.2020 -   0.96b     Try to re-authorisate if cached credentials were used and cloud login fails
                              getMap will be retriggered if credentials are updated
  *  04.04.2021 -   0.97      Roboroc S7 bugfix
  *  05.04.2021 -   0.98      Roboroc S7 bugfix
  *  16.05.2021 -   0.99      Support for MultiMap
  *  03.06.2021 -   0.991     Bugfix for valetudo
  *  14.06.2021 -   0.992     getActiveMapIndex
  *  12.10.2021 -   0.994     Bugfix in help
  *  03.01.2022 -   0.999     support for new RC4 encrypted api calls
  *  14.01.2022 -   1.0       bugfix for getmapurl + deadlock upon getmap

  * This project uses informations retrived from these sources:
  * 
  * https://github.com/marcelrv/XiaomiRobotVacuumProtocol
  * https://python-miio.readthedocs.io/en/latest/vacuum.html
  * https://github.com/iobroker-community-adapters/ioBroker.mihome-vacuum
  */

 class udpHandler {
     private $destPort = 54321;
     private $destIP   = "";
     private $sendSocket;
     private $commTimeOut;
     private $retryCount;
     
     public function setRemoteHost ($ip, $port) {
         $this->destIP = $ip;
         $this->destPort = $port;
     }

     public function connect () {
         $this->sendSocket = fsockopen("udp://".$this->destIP, $this->destPort, $errno, $errstr);

         stream_set_timeout ($this->sendSocket, $this->commTimeOut);

         if (!$this->sendSocket) {
             //printf ("connect failed!\n");
             return (FALSE);
         }
         //print "socket connected\n";
         return (TRUE);
     }

     public function disconnect () {
         if ($this->sendSocket)
             fclose ($this->sendSocket);
     }
     
     public function __construct ($ip,$port, $retryCount=3, $timeOut = 5) {
         $this->setRemoteHost ($ip, $port);
         $this->commTimeOut = $timeOut;
         $this->retryCount = $retryCount;
     }
     
     function __destruct () {
         $this->disconnect();
     }

     public function send ($data, $len) {
         $cnt = fwrite ($this->sendSocket, $data);
         if ($cnt !== FALSE) {
             return (TRUE);
         }
         return (FALSE);
     }

     public function sendRcv ($data,$len) {
         $currentRetryCnt = 0;

         sendRcvRetry:
         if ($this->send ($data, $len)) {
             $rcv_data = '';

             $rcv_data .= fread($this->sendSocket,32000);
             $result = stream_get_meta_data ($this->sendSocket);
             if ($result['timed_out'] === TRUE) {
                 if ($currentRetryCnt++ < $this->retryCount) {
                     goto sendRcvRetry;
                 } else {
                     return (FALSE);
                 }
                 return (FALSE);
             }
             return ($rcv_data);
         } else {
             return (FALSE);
         }
     }

 }

 class cloudDeviceStatus {
     private $deviceIndex;

     public $cloudSettingsAvailable;

     public $arrStateInformation;
   
     public function __construct ($deviceIndex) {
         $this->cloudSettingsAvailable = false;
         $this->deviceIndex = $deviceIndex;
     }

     public function processResult ($res) {
         //print_r ($res);

         if (isset ($res[$this->deviceIndex]['did'])) {
             $this->cloudSettingsAvailable = true;
             $this->arrStateInformation = $res;
             return (true);
         }
         return (false);

     }

     public function getIPToken () {
         $ret = array ('','');
         if ($this->cloudSettingsAvailable) {
             $ret = array ($this->arrStateInformation[$this->deviceIndex]['localip'],$this->arrStateInformation[$this->deviceIndex]['token']);
         }
         return ($ret);
     }

     public function isOnline() {
         $ret = false;
         if ($this->cloudSettingsAvailable) {
             $ret = ($this->arrStateInformation[$this->deviceIndex]['isOnline'] == 1) ? true: false;
         }
         return ($ret);
     }
     
     /*
       Array
       (
       [0] => Array
       (
       [did] => [..]
       [token] => [...]
       [longitude] => 0.00000000
       [latitude] => 0.00000000
       [name] => Roborock S6
       [pid] => 0
       [localip] => 192.168.1.136
       [mac] => xx:xx:xx:xx:xx:xx
       [ssid] => WLAN-SSID
       [bssid] => xx:xx:xx:xx:xx:xx
       [parent_id] => 
       [parent_model] => 
       [show_mode] => 1
       [model] => roborock.vacuum.s6
       [adminFlag] => 1
       [shareFlag] => 0
       [permitLevel] => 16
       [isOnline] => 1
       [desc] => Voll aufgeladen
       [extra] => Array
       (
       [isSetPincode] => 0
       [fw_version] => 3.5.4_1558
       [needVerifyCode] => 0
       [isPasswordEncrypt] => 0
       )

       [event] => Array
       (
       [event.back_to_dock] => {"timestamp":1589566988,"value":[0]}
       [event.back_to_origin_fail] => {"timestamp":1589552079,"value":[0]}
       [event.back_to_origin_succ] => {"timestamp":1589472930,"value":[0]}
       [event.bin_full] => {"timestamp":1589471994,"value":[0]}
       [event.clean_complete] => {"timestamp":1589566959,"value":[0]}
       [event.consume_material_notify] => {"timestamp":1589566959,"value":[4]}
       [event.error_code] => {"timestamp":1589566988,"value":[0]}
       [event.low_power_back] => {"timestamp":1589561357,"value":[0]}
       [event.power_resume_clean] => {"timestamp":1589566583,"value":[0]}
       [event.relocate_failed_back] => {"timestamp":1588749154,"value":[0]}
       [event.segment_map_done] => {"timestamp":1589566996,"value":[0]}
       [event.spot_with_disable_map] => {"timestamp":1588496014,"value":[0]}
       [event.start_with_disable_map] => {"timestamp":1589014793,"value":[0]}
       [event.start_without_map] => {"timestamp":1588764711,"value":[0]}
       [event.status] => {"timestamp":1589570060,"value":[{"battery":100,"clean_area":68425000,"clean_time":5045,"dnd_enabled":0,"error_code":0,"fan_power":104,"in_cleaning":0,"in_fresh_state":1,"in_returning":0,"lab_status":1,"lock_status":0,"map_present":1,"map_status":3,"msg_seq":1153,"msg_ver":2,"state":8,"water_box_status":0}]}
       [event.zoned_clean_succ] => {"timestamp":1589135001,"value":[0]}
       [prop.battery] => 100
       [prop.fan_power] => 104
       [prop.filter_life] => 74
       [prop.main_brush_life] => 35
       [prop.ota_state] => idle
       [prop.ota_state_ts] => 1589519723
       [prop.s_mixxx] => {"StorageKeys_UserSelectedCountryServerCode_xxxxxxxx_[uid]_MI_3":"de"}
       [prop.scene_check_pre_battery] => 99
       [prop.side_brush_life] => 2
       [prop.state] => 8
       )

       [uid] => [...]
       [pd_id] => 65600
       [password] => 
       [p2p_id] => 
       [rssi] => -84
       [family_id] => 0
       [reset_flag] => 0
       )
     */
     
 }

 class cloudMap {
     private $mapURL;
     private $mapExpires;

     public function __construct () {
         $this->invalidateMap();
     }

     public function invalidateMap () {
         $this->mapURL = '';
         $this->mapExpires = time();
     }

     public function processResult ($res) {
         /*
           [url] => https://awsde0.fds.api.xiaomi.com/[...]
           [obj_name] => key/robotid/id
           [method] => GET
           [expires_time] => 1590011401
           [ok] => 1
         */
         if (isset($res['url'])) {
             $this->mapURL = $res['url'];
             $this->mapExpires = $res['expires_time']-60*2;

             //printf ("got url = %s, expires= %d\n", $this->mapURL, $this->mapExpires);
             return (true);
         }
         return (false);
     }

     public function isMapValid () {
         if ($this->mapExpires > time()) {
             return (true);
         }
         return (false);
     }
     
     public function getURLToMap () {
         //printf ("expires: %d, time: %d\n",$this->mapExpires , time());

         if ($this->mapExpires > time()) {
             return (array ($this->mapURL, $this->mapExpires));
         } else {
             return (array (false, 0));
         }
     }
 }


 class xiaomiCloud {
     public $isAccessible;

     private $userName;
     private $password;
     private $serverLocation;
     private $clientID;
     private $resultCookies;

     /*
       this section is filled after successfull login to xiaomi cloud service
     */

     private $ssecurity;
     private $userId;
     private $serviceToken;
     private $xiaomiDeviceID;
     private $sessionUsesRestoredCredentials;
     private $useRC4;
     private $signed_nonce;
  
     public $cloudStateInformation;  // this array is used for reponse replies

     public $cloudDeviceStatus; // object containing cloudDeviceStatus
     public $cloudMap; // object containing mapdata
     public $credentialsChanged; //  this state is used to notify external class if credentials have changed

     public function __construct ($eMail, $password, $serverLocation, $xiaomiDeviceID) {
         $this->useRC4 = true;

         $this->userName = $eMail;
         $this->password = $password;
         $this->clientID = str_shuffle("xiaomi");;
         $this->isAccessible = false;
         $this->sessionUsesRestoredCredentials = false;
         $this->credentialsChanged = false;

         $this->serverLocation = $serverLocation . (!empty($serverLocation) ? '.' : '');

         $this->xiaomiDeviceID = $xiaomiDeviceID;
         $this->cloudMap = new cloudMap();
         $this->cloudDeviceStatus = new cloudDeviceStatus($xiaomiDeviceID);
     }

     private function getSessionCookie () {
         $cookie = 'userId='. $this->userId . '; yetAnotherServiceToken=' . $this->serviceToken . '; serviceToken=' . $this->serviceToken . '; locale=de_DE; timezone=GMT%2B01%3A00; is_daylight=1; dst_offset=3600000; channel=MI_APP_STORE';
         return ($cookie);
     }
  
       
     public function restoreCloudCredentials ($serviceToken, $ssecurity, $userId ) {
         $this->serviceToken = $serviceToken;
         $this->ssecurity = $ssecurity;
         $this->userId = $userId;
         $this->isAccessible = true;
         $this->sessionUsesRestoredCredentials = true;
     }

     public function curlReadHeader($ch, $header) {
         if (preg_match('/^Set-Cookie:\s*([^;]*)/mi', $header, $cookie) == 1) {
             list ($a,$b) = explode ("=",$cookie[1],2);
             $this->resultCookies[$a] = $b;
         }
         return strlen($header);
     }
     
     public function request($url, $payload, $method, $headers, $cookies, $crypted) {
         $this->resultCookies = array();
         $ch = curl_init($url);

         $requestHeaders = array("Accept:",
                                 "Content-Type: application/x-www-form-urlencoded",
         );
         
         if(count($headers) > 0) {
             $requestHeaders = array_merge($requestHeaders, $headers);
         }

         $fields_string = http_build_query($payload);

         curl_setopt_array($ch, array(
             CURLOPT_USERAGENT => "Android-7.1.1-1.0.0-ONEPLUS A3010-136-9D28921C354D7 APP/xiaomi.smarthome APPV/62830",
             CURLOPT_RETURNTRANSFER => true,
             CURLOPT_SSL_VERIFYHOST => 0,
             CURLOPT_SSL_VERIFYPEER => 0,
             CURLOPT_CUSTOMREQUEST => $method,
             CURLOPT_HTTPHEADER => $requestHeaders,
             CURLOPT_COOKIE => $cookies,
             CURLOPT_POSTFIELDS => $fields_string,
             CURLOPT_HEADERFUNCTION => "xiaomiCloud::curlReadHeader"
         )
         );

         $result = curl_exec($ch);
         curl_close($ch);

         if ($result !== FALSE) {
             if ($crypted === TRUE) {
                 $result = $this->localRC4Decode($result);
                 $ret = json_decode($result,true);
             } else {
                 $ret = json_decode(str_replace ("&&&START&&&","", $result),true);
             }

             if (isset ($ret['message'])) {
                 $res = strtolower($ret['message']);

                 if ($res == 'auth err') {
                     if ($this->sessionUsesRestoredCredentials == true) {
                         exec_debug (0, "auth error. Refresh login.");
                         $this->cloudLogin();
                     }
                 }
             }
             return ($ret);
         } else {
             return (FALSE);
         }
     }


     public function convertArrayToString ($arr) {
         $ret = '';

         foreach ($arr as $byte) {
             $ret .= sprintf ("%02x",$byte);
         }
         $ret = pack("H*",$ret);
         return ($ret);
     }

     private function randomBytes ($count) {
         $ret = '';
         for ($i=0;$i<$count;$i++) {
             $ret .= chr (rand(0,255));
         }
         return ($ret);
     }

     private function HashHmacSHA256 ($data, $secret) {
         $ret = hash_hmac('sha256', $data, $secret, true);
         return (base64_encode($ret));
     }

     private function generateEncodedSignature ($path, $method, $signed_nonce, &$params) {
         $postArray = array ();
         array_push ($postArray, strtoupper($method));
         if (!empty($path)) 
             array_push ($postArray, $path);

         foreach ($params as $k => $v)
             array_push ($postArray,"$k=".$v);

         array_push ($postArray, $signed_nonce);

         //printf ("Signstring: %s\n", utf8_encode(implode ("&",$postArray)));

         $signString = base64_encode(sha1(utf8_encode(implode ("&",$postArray)),true));
         //print "Encoded Signstring: $signString\n";
         return ($signString);
     }

     private function localRC4Encode ($data) {
         $myRC4 = new Crypt_Rc4 (base64_decode($this->signed_nonce));
         $myRC4->iterate(1024);
         $output = base64_encode($myRC4->crypt ($data));
         return ($output);
     }

     private function localRC4Decode ($data) {
         $myRC4 = new Crypt_Rc4 (base64_decode($this->signed_nonce));
         $myRC4->iterate(1024);
         $output = $myRC4->crypt (base64_decode($data));
         return ($output);
     }

     private function generateSignature ($path, &$params) {
         $nonce = $this->randomBytes(8) . pack('N', intval(round(time()/60)));

         // REMOVE THIS FOR LIVE TESTING:
         //$this->ssecurity = base64_decode("tEV6dhfQXfv3gdLaQ2nIjw==");
         //$nonce = base64_decode ("KTyoHMpDe2cBoWKO");

         $this->signed_nonce = base64_encode(hash ("sha256",$this->ssecurity. $nonce, true));

         // printf ("path: %s signed nonce: $this->signed_nonce , sec: %s  - %s\n",$path, $this->ssecurity, base64_encode ($nonce));
         $postArray = array ();
         
         if ($this->useRC4) {
             $params['rc4_hash__'] = $this->generateEncodedSignature ($path, "POST",$this->signed_nonce, $params);

             foreach ($params as $k => $v) {
                 $params[$k] = $this->localRC4Encode($v);
             }

             $params['signature'] = $this->generateEncodedSignature ($path, "POST",$this->signed_nonce, $params);
             $params['ssecurity'] = base64_encode($this->ssecurity);
             $params["_nonce"] = base64_encode($nonce);

             /*
             foreach ($params as $k => $v) {
                 print "$k => $v\n";
             }
             */
         } else {
             if (!empty($path)) 
                 array_push ($postArray, $path);

             array_push ($postArray, base64_encode ($this->signed_nonce));
             array_push ($postArray, base64_encode ($nonce));
             array_push ($postArray, "data=". $params["data"]);

             $postParam = implode ("&",$postArray);

             $params["_nonce"] = base64_encode($nonce);
             $params["signature"] = $this->HashHmacSHA256 ($postParam, $this->signed_nonce);
         }
     }

     public function getDeviceStatus () {
         if ($this->isAccessible) {
             $url = 'https://'.$this->serverLocation.'api.io.mi.com/app/home/device_list';

             $cookie = $this->getSessionCookie();

             $requestHeaders = array (
                 "x-xiaomi-protocal-flag-cli: PROTOCAL-HTTP2"
             );

             if ($this->useRC4)
                 array_push ($requestHeaders, "Accept-Encoding: identity","MIOT-ENCRYPT-ALGORITHM: ENCRYPT-RC4");

             $payload = array (
                 "data" => '{"getVirtualModel":true,"getHuamiDevices":1,"get_split_device":false,"support_smart_home":true}'
//'{"getVirtualModel":false,"getHuamiDevices":0}'
                 
			 );

             $this->generateSignature ("/home/device_list", $payload);

             $result = $this->request ($url,
                                       $payload, "POST", $requestHeaders, $cookie, $this->useRC4);

             print "result = $result\n";

             if (strtolower($result['message']) == 'ok')
                 return ($this->cloudDeviceStatus->processResult ($result['result']['list']));
         }
         return (false);
     }

     public function getMap ($mapURL) {
         if ($this->isAccessible) {
             $url = 'https://'.$this->serverLocation.'api.io.mi.com/app/home/getmapfileurl';

             $cookie = $this->getSessionCookie();

             $requestHeaders = array (
                 "x-xiaomi-protocal-flag-cli: PROTOCAL-HTTP2",
             );

             if ($this->useRC4)
                 array_push ($requestHeaders, "Accept-Encoding: identity","MIOT-ENCRYPT-ALGORITHM: ENCRYPT-RC4");

             $payload = array (
                 "data" => '{"obj_name":"'.$mapURL.'"}'
			 );

             $this->generateSignature ("/home/getmapfileurl", $payload);

             $result = $this->request ($url,
                                       $payload, "POST", $requestHeaders, $cookie, $this->useRC4);

             $res = strtolower($result['message']);

             if ($res == 'ok') {
                 $ret = $this->cloudMap->processResult ($result['result']);
                 return ($ret);
             }
         }
         return (false);
     }

     public function cloudLogin () {
         $this->sessionUsesRestoredCredentials = false;
         $cookies = "sdkVersion=accountsdk-18.8.15; userId=".$this->userName."; deviceId=".$this->clientID;

         // get callback & sid from login page
         $result = $this->request ("https://account.xiaomi.com/pass/serviceLogin?sid=xiaomiio&_json=true",
                                   array(), "GET", array(), $cookies, false);

         if ($result !== FALSE) {
             //var_dump ($result);
             $cookies = "sdkVersion=accountsdk-18.8.15; deviceId=".$this->clientID;

             $payload = array('sid' => $result['sid'],
                              'hash' => strtoupper(md5($this->password)),
                              'callback' => $result['callback'],
                              'qs' => $result['qs'],
                              'user' => $this->userName,
                              '_sign' => $result['_sign'],
                              '_json' => "true",
             );

             // authenticate user with credentials
             $result = $this->request ("https://account.xiaomi.com/pass/serviceLoginAuth2",
                                       $payload, "POST", array(), $cookies, false);
      
             $this->ssecurity = base64_decode($result['ssecurity']);
             $this->userId = $result['userId'];

             // get serviceToken from location-server
             $result = $this->request ($result['location'], array(), "GET", array(), $cookies, false);

             if (isset($this->resultCookies['serviceToken'])) {
                 $this->serviceToken = $this->resultCookies['serviceToken'];
                 $this->isAccessible = true;
                 $this->credentialsChanged = true;
             }

             //var_dump ($this->resultCookies);
             return (array ($this->serviceToken, base64_encode($this->ssecurity), $this->userId));
         }
     }

     public function getAllCredentials () {
         $this->credentialsChanged = false; // reset state as

         return (array ($this->serviceToken, base64_encode($this->ssecurity), $this->userId));
     }
 }

 class RoborockPacketHandler {
     /* byte  0, 1 */ private $magic = array (0x21,0x31); 
     /* byte  2, 3 */ public $length = 0x20;
     /* byte  4, 5, 6, 7 */ private $unknown1 = array (0xFF, 0xFF, 0xFF, 0xFF);
     /* byte  8, 9,10,11 */ private $deviceID = array (0xFF, 0xFF, 0xFF, 0xFF);
     /* byte 12,13,14,15 */ private $stamp = array (0xFF, 0xFF, 0xFF, 0xFF);
     /* byte 16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31 */ private $md5 = array (0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF);
     /* byte 32..n Payload[n]*/

     private $hello = "21310020ffffffffffffffffffffffffffffffffffffffffffffffffffffffff";
     private $token = array();

     private $key;
     private $iv;

     public $sequenceID;
   
     public function __construct ($token, $restoreSequenceId) {
         $this->sequenceID = (intval($restoreSequenceId) == 0) ? rand (1,1000) : $restoreSequenceId; // in order to use a unique number. Otherwise robot will not respond if the same id has been used shortly before.

         $t = pack("H*",$token);
         if (strlen($t) != 16) {
             exec_debug (0, "WARNING!!!! TOKEN INVALID!");
         }
         $this->token = unpack("C*",$t);

         $this->key = md5($t, true);
         $this->iv  = md5($this->key . $t, true);

         //printf ("key = %s, iv = %s, token = $t\n",$this->strtohex($this->key), $this->strtohex($this->iv));
     }

     function strtohex($x)
     {
         $s='';
         foreach (str_split($x) as $c) 
             $s.=sprintf("%02X",ord($c));
         return($s);
     } 

     public function convertArrayToString ($arr) {
         $ret = '';

         foreach ($arr as $byte) {
             $ret .= sprintf ("%02x",$byte);
         }
         $ret = pack("H*",$ret);
         return ($ret);
     }

     public function getHelloData () {
         //$data = array_merge ($this->magic, array (0,0x20), $this->unknown1,$this->deviceID,$this->stamp,$this->md5);
         //$hStr = $this->toString($data);
         $hStr = pack ("H*",$this->hello);
         return ($hStr);
     }

     public function getCurrentTimestamp () {
         /*
         $time = time()+10;
         $val = ($this->stamp[0] << 24) + ($this->stamp[1] << 16) + ($this->stamp[2] << 8) + $this->stamp[3];

         exec_debug (0, "tstamp: $val :: $time");


         $this->stamp[0] = ($time >> 24) & 0xFF;
         $this->stamp[1] = ($time >> 16) & 0xFF;
         $this->stamp[2] = ($time >> 8) & 0xFF;
         $this->stamp[3] = $time & 0xFF;
         //$time = pack ("H*", sprintf("%4X",time()));
         */
     }

     public function composeData ($payload) {
         $payload['id'] = ++$this->sequenceID;

         $payload = json_encode($payload);

         $this->getCurrentTimestamp();

         $cryptedPayload = unpack ("C*",openssl_encrypt ( $payload."\0" , "AES-128-CBC", $this->key,$options=1, $this->iv)); // $options = OPENSSL_RAW_DATA

         $size = 32 + sizeof ($cryptedPayload);

         $data = array_merge ($this->magic,    // 2
                              array ($size >>8, $size),     // 2
                              array (0,0,0,0), // 4
                              $this->deviceID, // 4
                              $this->stamp,    // 4
                              $this->token,
                              $cryptedPayload);

         $packed = $this->convertArrayToString ($data);

         $md5 = md5($packed,true);
         $md5 = unpack ("C*",$md5);

         for ($i=0;$i<16;$i++) {
             $data[$i+16] = $md5[$i+1];
         }
         $packed = $this->convertArrayToString ($data);
     
         //print "Transmit: ".$this->strtohex($packed);

         return $packed;
     }
  
     public function getLen () {
         return $this->length;
     }

     /*
       read specific fields from response packet and store them to $toArr
     */
     public function readDeviceID ($arr, &$toArr) {
         for ($i=0;$i<4;$i++) {
             $toArr[$i] = $arr[$i+9];
         }
     }

     public function readStamp ($arr, &$toArr) {
         for ($i=0;$i<4;$i++) {
             $toArr[$i] = $arr[$i+13];
         }
     }

     public function readMD5 ($arr, &$toArr) {
         for ($i=0;$i<16;$i++) {
             $this->md5[$i] = $arr[$i+17];
         }
     }

     public function endsWith($haystack, $needle) {
         $length = strlen($needle);
         return $length > 0 ? substr($haystack, -$length) === $needle : true;
     }
     
     public function processResponse ($responseString) {
         if ($responseString != FALSE) {
             $dataArr = unpack ("C*",$responseString);

             $msgLen = ($dataArr[3] << 8) | ($dataArr[4]);

             if ($msgLen == 32) {
                 // Received response to Hello
                 $this->readDeviceID ($dataArr, $this->deviceID);
                 $this->readStamp ($dataArr, $this->stamp);
                 $this->readMD5 ($dataArr, $this->md5);

                 //print_r ($dataArr);
             } else {
                 // Received data with extra payload. Payload starts at byte 33
                 $payLoadDataLen = $msgLen - 32;
                 $payload = array ();
                 for ($i=0;$i<$payLoadDataLen;$i++) {
                     $payload[$i] = $dataArr[33+$i];
                 }

                 $payload = $this->convertArrayToString ($payload);
                 $decryptedPayload = openssl_decrypt ( $payload , "AES-128-CBC", $this->key,$options=1, $this->iv); // $options = OPENSSL_RAW_DATA

                 // remove trailing zero from payload. Otherwise php json_decode will fail
                 $decryptedPayload = substr ($decryptedPayload, 0, strlen($decryptedPayload)-1);
                 if (!$this->endsWith ($decryptedPayload, "}"))
                     $decryptedPayload .= "}";
      
                 $result = json_decode($decryptedPayload, true);
                 //var_dump ($res);

                 return ($result);
             }

             /*
               print_r ($dataArr);

               print_r ($this->md5);
               print_r ($this->stamp);
               print_r ($this->deviceID);

               for ($i=1;$i<32;$i++) {
               printf ("[%d]=%X\n",$i,$dataArr[$i]);
               }
             */

         } else {
             return (FALSE);
         }
     }
 }

 class generalHelpers {
     public function normalize (&$val, $div) {
         if ($val > 0)
             $val /= $div;
     }
   
     public function get01StateFromArray ($array, $key) {
         $ret = false;
         if (isset ($array[$key])) {
             if ($array[$key] === 1) {
                 $ret = true;
             }
         }

         return ($ret);
     }

     public function getStateFromArray ($array, $key,$subkey = null) {
         $ret = '';
         if (isset($subkey)) {
             if (isset ($array[$key][$subkey]))
                 $ret = $array[$key][$subkey];
             
         } else {
             if (isset ($array[$key]))
                 $ret = $array[$key];
         }
         return ($ret);
     }

     public function getIntStateFromArray ($array, $key) {
         $ret = 0;
         if (isset ($array[$key]))
             $ret = intval ($array[$key]);
     
         return ($ret);
     }
 }

 class cmdInfoStatus extends generalHelpers {
     public $available;

     public $fanCodes = array (
         1 => array ("Quiet","Leise"),
         2 => array ("Balanced","Balanciert"),
         3 => array ("Turbo"),
         4 => array ("Max"),
         
         101 => array ("Quiet","Leise"),
         102 => array ("Balanced","Balanciert"),
         103 => array ("Turbo"),
         104 => array ("Max"),
         105 => array ("Mob","Schonend"),
         106 => array ("Custom","Spezifisch"),

         0   => array ("Unknown","Unbekannt"),
     );
     
     public $Info_Status = array (
         "msg_ver"=> 0,
         "msg_seq"=>0,
         "state"=> 0,
         "battery"=> 0,
         "clean_time"=> 0,
         "clean_area"=> 0,
         "error_code"=> 0,
         "map_present"=> 0,
         "in_cleaning"=> 0,
         "in_returning"=> 0,
         "in_fresh_state"=> 0,
         "lab_status"=> 0,
         "water_box_status"=> 0,
         "fan_power"=> 0,
         "dnd_enabled"=> 0,
         "map_status"=> 0,
         "lock_status"=> 0,
     );

     public function __construct () {
         $this->available = false;
     }

     public function processResult ($res) {
         if (isset($res['state'])) {
             //if (isset($res['msg_ver'])) { // 
             $this->available = true;
             $this->Info_Status = $res;

             $this->normalize ($this->Info_Status['clean_time'], 60);  // Return time in minutes
             $this->normalize ($this->Info_Status['clean_area'], 1000*1000); // return area in m²

             return (true);
         }
         return (false);
     }
   
     public function isMapPresent () {
         return ($this->get01StateFromArray ($this->Info_Status, "map_present"));
     }
       
     public function getBatteryLevel () {
         return ($this->getIntStateFromArray ($this->Info_Status, "battery"));
     }

     public function getState() {
         return ($this->getStateFromArray ($this->Info_Status, "state"));
     }

     public function errorCode() {
         return ($this->getStateFromArray ($this->Info_Status, "error_code"));
     }

     public function inCleaning() {
         //printf ("in cleaning: ".$this->Info_Status["in_cleaning"]);
         return ($this->getIntStateFromArray ($this->Info_Status, "in_cleaning"));
     }

     public function inReturning() {
         return ($this->getIntStateFromArray ($this->Info_Status, "in_returning"));
     }

     public function waterBoxStatus() {
         return ($this->getStateFromArray ($this->Info_Status, "water_box_status"));
     }

     public function fanPowerLevel() {
         return ($this->getIntStateFromArray ($this->Info_Status, "fan_power"));
     }

     public function getCleanAreaTime () {
         return (array (
             $this->getIntStateFromArray($this->Info_Status, "clean_area"), 
             $this->getIntStateFromArray($this->Info_Status, "clean_time")
         )
	     );
     }
     public function getActiveMapIndex() {
         return ($this->getIntStateFromArray($this->Info_Status, "map_status") >> 2);
     }
 }

 class cmdInfoConsumables extends generalHelpers {
     public $available;
     
     public $Info_Consumables = array (
         "main_brush_work_time"=> 0,
         "side_brush_work_time"=> 0,
         "filter_work_time"=>  0,
         "filter_element_work_time"=> 0, // Watertank
         "sensor_dirty_time"=> 0,
     );
     
     public function __construct () {
         $this->available = false;
     }
     
     public function processResult ($res) {
         if (isset($res['main_brush_work_time'])) {
             $this->available = true;
             //if (isset($res['msg_ver'])) { // 
             $this->Info_Consumables = $res;

             return (true);
         }
         return (false);
     }

     public function mainBrushWorkTime () {
         return ($this->getIntStateFromArray ($this->Info_Consumables, "main_brush_work_time"));
     }
     
     public function sideBrushWorkTime () {
         return ($this->getIntStateFromArray ($this->Info_Consumables, "side_brush_work_time"));
     }

     public function filterWorkTime () {
         return ($this->getIntStateFromArray ($this->Info_Consumables, "filter_work_time"));
     }

     public function filterElementWorkTime () {
         return ($this->getIntStateFromArray ($this->Info_Consumables, "filter_element_work_time"));
     }

     public function sensorDirtyTime () {
         return ($this->getIntStateFromArray ($this->Info_Consumables, "sensor_dirty_time"));
     }
 }

 class cmdGetLocale extends generalHelpers {
     public $available;
     
     public $Info_Local = array (
         "name"=> '',
         "bom"=> '',
         "location"=> '',
         "language"=> '',
         "wifiplan"=> '',
         "timezone"=> '',
         "logserver"=> '',
         "featureset"=> '',
     );
     
     public function __construct () {
         $this->available = false;
     }
     
     public function processResult ($res) {
         $this->available = true;
         if (isset($res['name'])) {
             $this->Info_Consumables = $res;

             return (true);
         }
         return (false);
     }

     public function name() {
         return ($this->getStateFromArray($this->Info_Local, "name"));
     }
 }
 
 class cmdGetCleaningSummary extends generalHelpers {
     public $available;
     
     public $Info_CleaningSummary = array (
         "totalTime" => 0,
         "totalArea" => 0,
         "totalCleanups" => 0,
         "cleaningRecordIDs" => array(),
     );
     
     public function __construct () {
         $this->available = false;
     }
     
     public function processResult ($res) {
         if (isset($res[0])) {
             $this->available = true;
             $this->Info_CleaningSummary["totalTime"] = $res[0];
             $this->Info_CleaningSummary["totalArea"] = $res[1];
             $this->Info_CleaningSummary["totalCleanups"] = $res[2];
             $this->Info_CleaningSummary["cleaningRecordIDs"] = $res[3];

             $this->normalize($this->Info_CleaningSummary["totalTime"], (60*60)); // store value in [h]
             $this->normalize($this->Info_CleaningSummary["totalArea"], (1000*1000)); // store value in m²
             return (true);
         } else if (isset($res['clean_time'])) {
             $this->available = true;

             $this->Info_CleaningSummary["totalTime"] = $res['clean_time'];
             $this->Info_CleaningSummary["totalArea"] = $res['clean_area'];
             $this->Info_CleaningSummary["totalCleanups"] = $res['clean_count'];
             $this->Info_CleaningSummary["cleaningRecordIDs"] = $res['records'];
             
             $this->normalize($this->Info_CleaningSummary["totalTime"], (60*60)); // store value in [h]
             $this->normalize($this->Info_CleaningSummary["totalArea"], (1000*1000)); // store value in m²
         }
         return (false);
     }

     public function totalTime() {
         return ($this->getIntStateFromArray($this->Info_CleaningSummary, "totalTime"));
     }
     public function totalArea() {
         return ($this->getIntStateFromArray($this->Info_CleaningSummary, "totalArea"));
     }
     public function totalCleanups() {
         return ($this->getIntStateFromArray($this->Info_CleaningSummary, "totalCleanups"));
     }
     public function cleaningRecordIDs() {
         /*
           Array
           (
           [0] => 1590773176
           [1] => 1590771730
           [...] => ...
           )
         */
         return ($this->getStateFromArray($this->Info_CleaningSummary, "cleaningRecordIDs"));
     }
 }

 class cmdMultiMap extends generalHelpers {
     /*
  ["max_multi_map"]=>
  int(4)
  ["max_bak_map"]=>
  int(0)
  ["multi_map_count"]=>
  int(2)
  ["map_info"]=>
  array(2) {
    [0]=>
    array(5) {
      ["mapFlag"]=>
      int(0)
      ["add_time"]=>
      int(1597992006)
      ["length"]=>
      int(2)
      ["name"]=>
      string(2) "EG"
      ["bak_maps"]=>
      array(0) {
      }
    }
    [1]=>
    array(5) {
      ["mapFlag"]=>
      int(1)
      ["add_time"]=>
      int(1620498819)
      ["length"]=>
      int(2)
      ["name"]=>
      string(2) "OG"
      ["bak_maps"]=>
      array(0) {
      }
    }
  }
}
      */

     public $available;

     public $Info = array (
         "max_multi_map" => 0,
         "max_bak_map" => 0,
         "multi_map_count" => 0,
         "map_info" => array(),
     );

     public function __construct () {
         $this->available = false;
     }
     
     public function processResult ($res) {
         if (isset($res['max_multi_map'])) {
             $this->available = true;
             $this->Info = $res;
             return (true);
         }
         return (false);
     }

     public function getMaxMultiMaps () {
         return ($this->getIntStateFromArray ($this->Info,"max_multi_map"));
     }

     public function getMaxBackupMaps () {
         return ($this->getIntStateFromArray ($this->Info,"max_bak_map"));
     }

     public function getAvailableCount () {
         return ($this->getIntStateFromArray ($this->Info,"multi_map_count"));
     }

     public function getAllMaps () {
         $ret = '';
         for ($i=0; $i< $this->getAvailableCount(); $i++) {
             $ret .= (($ret == '') ? "" : ",") . $this->getMapInfo ($i);
         }
         return ($ret);
     }
     public function getMapInfo ($cnt) {
         if (isset ($this->Info["map_info"][$cnt])) {
             $id = $this->getIntStateFromArray ($this->Info["map_info"][$cnt],"mapFlag");

             $name = preg_replace ( "/[;,]/", "", $this->getStateFromArray ($this->Info["map_info"][$cnt],"name"));
             if ($name == '') $name = sprintf ("Karte %d",$id+1);
             return ("$id;$name");
         }
     }
 }
 
 class cmdGetmiIOInfo extends generalHelpers {
     public $available;
     
     public $Info = array (
         /*
           [hw_ver] => Linux
           [fw_ver] => 3.5.8_1708
           [ap] => Array
           (
           [ssid] => xxxx
           [bssid] => xx:xx:xx:xx:xx:xx
           [rssi] => -55
           )
			   
           [netif] => Array
           (
           [localIp] => 192.168.x.xxx
           [mask] => 255.255.255.0
           [gw] => 192.168.x.xxx
           )
			   
           [miio_ver] => miio-client 3.5.8
           [model] => roborock.vacuum.s6
           [mac] => xx:xx:xx:xx:xx:xx
           [token] => xxx
           [life] => 60121
         */
     );
     
     public function __construct () {
         $this->available = false;
     }

     public function processResult ($res) {
         if (isset($res['model'])) {
             $this->available = true;
             $this->Info = $res;
             return (true);
         }
         return (false);
     }

     public function getModel () {
         return ($this->getStateFromArray ($this->Info,"model"));
     }
     public function getRSSI () {
         return ($this->getStateFromArray ($this->Info,"ap","rssi"));
     }
 }
 
 
 class RoborockMe extends udpHandler {
     private $udpHandler;
     private $packetHandler;
     protected $langID;

     public $heloReceived;
     
     public $serialNumber;

     public $pollFrequently; // =1 if roboter is working. Tell application to check status of robot more frequently

     public $stateCodes = array (0 => array ("Unknown","unbekannt"),
                                 1 => array ("Initiating","initialisiere"),
                                 2 => array ("Sleeping","Schläft"),
                                 3 => array ("Idle","Bereit"),
                                 4 => array ("Remote Control"),
                                 5 => array ("Cleaning","Saugen"),
                                 6 => array ("Returning Dock","Zurück zur Station"),
                                 7 => array ("Manual Mode"),
                                 8 => array ("Charging","Lade Akku"),
                                 9 => array ("Charging Error","Ladefehler"),
                                 10 => array ("Paused","Pausiert"),
                                 11 => array ("Spot Cleaning","Spot Reinigung"),
                                 12 => array ("In Error"),
                                 13 => array ("Shutting Down"),
                                 14 => array ("Updating","Update"),
                                 15 => array ("Docking"),
                                 16 => array ("Go To","Fahre zum Zielpunkt"),
                                 17 => array ("Zone Clean","Zonenreinigung"),
                                 18 => array ("Room Clean","Raumreinigung"),
                                 100 => array ("Fully Charged","Voll geladen"),
     );
     public $errorCodes = array (0 => array ("No error","Keine Fehler"),
                                 1 => array ("Laser sensor fault"),
                                 2 => array ("Collision sensor fault"),
                                 3 => array ("Wheel floating","Räder nicht auf dem Boden"),
                                 4 => array ("Cliff sensor fault"),
                                 5 => array ("Main brush blocked","Hauptbürste blockiert"),
                                 6 => array ("Side brush blocked","Seitebürste blockiert"),
                                 7 => array ("Wheel blocked"),
                                 8 => array ("Device stuck","Gerät steckt fest"),
                                 9 => array ("Dust bin missing","Staubbehälter einsetzen"),
                                 10 => array ("Filter blocked"),
                                 11 => array ("Magnetic field detected","Starkes Magnetfeld erkannt"),
                                 12 => array ("Low battery"),
                                 13 => array ("Charging problem"),
                                 14 => array ("Battery failure"),
                                 15 => array ("Wall sensor fault"),
                                 16 => array ("Uneven surface"),
                                 17 => array ("Side brush failure"),
                                 18 => array ("Suction fan failure"),
                                 19 => array ("Unpowered charging station"),
                                 20 => array ("Unknown Error"),
                                 21 => array ("Laser pressure sensor problem"),
                                 22 => array ("Charge sensor problem"),
                                 23 => array ("Dock problem"),
                                 24 => array ("No-go zone or invisible wall detected"),
                                 254 => array ("Bin full","Staubbehälter voll"),
                                 255 => array ("Internal error","Interner Fehler"),
                                 -1 => array ("Unknown Error","Unbekannter Fehler"),
     );
     public $Info_Status; // object cmdInfoStatus
     public $Info_Consumables; // object cmdInfoConsumables
     public $Info_Local; // object cmdGetLocale
     public $Info_miIOInfo; // object cmdGetmiIOInfo
     
     public $Info_CleaningSummary; // object cmdGetCleaningSummary
     public $Info_MultiMaps;

     private $activeMapIndex;
     
     public function __construct ($ip,$port, $token, $restoreSequenceId, $languageID=1) {
         parent::__construct($ip, $port);
         $this->pollFrequently = 0;
         
         $this->langID = $languageID;

         $this->Info_Status = new cmdInfoStatus();
         $this->Info_Consumables = new cmdInfoConsumables();
         $this->Info_Local = new cmdGetLocale();
         $this->Info_CleaningSummary = new cmdGetCleaningSummary();
         $this->Info_miIOInfo = new cmdGetmiIOInfo();
         $this->Info_MultiMaps = new cmdMultiMap();
         
         $this->packetHandler = new RoborockPacketHandler($token,$restoreSequenceId);
         if (parent::connect()) {
             $this->sayHello();
 
             if ($this->heloReceived) {
                 //$this->getInitStatus();
                 if ($this->getmiIOInfo() == FALSE) {
                     exec_debug (0, "miIO.Info not supported!!");
                     return (FALSE);
                 }

                 if ($this->getStatus() == FALSE) { // InitStatus does not output all information which are supported by getStatus.
                     exec_debug (0, "getStatus not supported!!");
                     return (FALSE);
                 }
                 return (TRUE);
             }
         }
         return (FALSE);
     }
         
     public function getRestLifeTime ($current, $max) {
         $current = intval ($current / 3600);
         
         if ($current > $max)
             return (0);
         return ($max-$current);
     }
     
     public function getSequenceID () {
         return ($this->packetHandler->sequenceID);
     }
     
     public function getTranslatedStringFromArray ($arr, $index) {
         if (isset ($arr[$index][$this->langID])) {
             return ($arr[$index][$this->langID]);
         } else {
             return ($arr[$index][0]);
         }
     }

     public function stringToIntArray ($val) {
         $arr = explode(",", $val);
         
         foreach ($arr as &$value) {
             $value = intval($value);
         }
         return ($arr);
     }

     public function getSendCmd ($cmd, $returnElement= '') {
         if (!is_array ($cmd)) {
             if (is_string($cmd)) {
                 $cmd = array ("method" => $cmd);
             }
         }
         $data = $this->packetHandler->composeData ($cmd);
         
         $rcv = $this->sendRcv ($data, strlen($data));
         if ($rcv == FALSE) {
             exec_debug (0, "sendRcv failed!".$data);
             return (FALSE);
         }
         $resp = $this->packetHandler->processResponse ($rcv);

         if (isset ($resp['error'])) {
             // Function should never get to this point!
             exec_debug (0, outputDebug ("cmd:",$cmd));
             exec_debug (0, json_encode($cmd));
             exec_debug (0, outputDebug ("resp:",$resp));
             return (FALSE);
         }

         if (isset($resp['result']) && ($resp['result'] == "unknown_method")) // bugfix for valetudo
             return (FALSE);
         
         if (sizeof ($resp['result']) == 1) {
             $resp = $resp['result'][0];
         } else {
             $resp = $resp['result'];
         }

         if (!empty($returnElement)) {
             $resp = $resp[$returnElement];
         }
         return ($resp);
     }

     public function sayHello () {
         $data = $this->packetHandler->getHelloData();
         $rcv = $this->sendRcv ($data, strlen($data));
         if ($rcv != FALSE) {
             $this->heloReceived = 1;
             $this->packetHandler->processResponse ($rcv);
         }
     }

     public function getStatus () {
         $ret = $this->getSendCmd ("get_status");
         if ($ret != FALSE) {
             $ret = $this->Info_Status->processResult ($ret);
         }
         return ($ret);
     }

     public function findMe () {
         return ($this->getSendCmd ("find_me"));
     }

     public function getLocale () {
         $ret = $this->getSendCmd ("app_get_locale");
         if ($ret != FALSE)
             $this->Info_Local->processResult ($ret);
         return ($ret);
     }

     public function getFWFeatures () {
         return ($this->getSendCmd ("get_fw_features"));
     }

     public function getInitStatus () { // combines app_get_locale, get_fw_features, get_status
         // several result messages are missing. Use getStatus instead
         $res = $this->getSendCmd ("app_get_init_status");
         if ($res != FALSE) {
             $this->Info_Status->processResult ($res['status_info']);
             $this->Info_Local->processResult ($res['local_info']);
         }
         return ($res);
     }

     public function getSerialNumber () {
         $ret = $this->getSendCmd ("get_serial_number","serial_number");
         if ($ret != FALSE)
             $this->SerialNumber = $ret;
         return ($ret);
     }

     public function getConsumables () {
         $ret = $this->getSendCmd ("get_consumable");
         if ($ret != FALSE)
             $this->Info_Consumables->processResult($ret);
         
         return ($ret);
     }

     public function resetConsumables ($consumable) {
         $ret = $this->getSendCmd (array ("method" => "reset_consumable",
                                          "params" => array($consumable)));
         return ($ret);
     }

     public function getCleanSummary () {
         $res = $this->getSendCmd ("get_clean_summary");
         if ($res != FALSE) {
             $this->Info_CleaningSummary->processResult($res);
         }
         return ($res);
     }

     public function getCleanRecord ($cleaningID) {
         $ret = $this->getSendCmd (array ("method" => "get_clean_record",
                                          "params" => array($cleaningID)));
         return ($ret);
     }

     public function startCleaning() {
         $res = $this->getSendCmd ("app_start");
         return ($res);
     }

     public function stopCleaning() {
         $res = $this->getSendCmd ("app_stop");
         return ($res);
     }

     public function pauseCleaning() {
         $res = $this->getSendCmd ("app_pause");
         return ($res);
     }

     public function spotCleaning() {
         $res = $this->getSendCmd ("app_spot");
         return ($res);
     }

     public function startCharging() {
         $res = $this->getSendCmd ("app_charge");
         return ($res);
     }
       
     public function getMapV1() {
         $retryCount = 0;

         while ($retryCount++ < 3) {
             $ret = $this->getSendCmd ("get_map_v1");
             if ($ret != "retry") {
                 break;
             } else {
                 sleep (1);
             }
         }
         return ($ret);
     }

     public function resumeSegmentCleaning() {
         $ret = $this->getSendCmd ("resume_segment_clean");
         return ($ret);
     }
     
     public function segmentCleaning ($segments) {
         $ret = $this->getSendCmd (array ("method" => "app_segment_clean",
                                          "params" => $this->stringToIntArray($segments)));
         return ($ret);
     }
          
     public function getRoomMapping() {
         // tbd
         $res = $this->getSendCmd ("get_room_mapping");
         return ($res);
     }

     public function getmiIOInfo() {
         $res = $this->getSendCmd ("miIO.info");
         if ($res != FALSE) {
             if ($this->Info_miIOInfo->processResult($res)) {
                 /*
                   $model = $this->Info_miIOInfo->getModel();
                   if (preg_match('/(\.s5|\.s6)/i', $model)) {
                   $this->translatedFanCodes = $this->fanCodesExtendedMode; // S5+S6 have extended fan_power codes
                   }
                 */
             }
         }
         return ($res);
     }

     public function getFanPowerText() {
         $returnIndex = $level = $this->Info_Status->fanPowerLevel();
         if ($level > 0) {
             if ($level <= 38) {
                 $returnIndex = 1;
             } else if ($level <= 60) {
                 $returnIndex = 2;
             } else if ($level <= 75) {
                 $returnIndex = 3;
             } else if ($level <= 100) {
                 $returnIndex = 4;
             } else {
                 /*
                   this section is currently not required
                   $model = $this->Info_miIOInfo->getModel();
                   if (preg_match('/(\.s5|\.s6)/i', $model)) {
                   }
                 */
             }
         }
         return ($this->getTranslatedStringFromArray ($this->Info_Status->fanCodes, $returnIndex));
     }

     public function setFanSpeed ($val) {
         $ret = $this->getSendCmd (array ("method" => "set_custom_mode",
                                          "params" => $this->stringToIntArray($val)));
         if ($ret == 'ok') {
             // refresh status
             $this->getStatus();
         }
         return ($ret);
     }

     public function tryToFreeRobot() {
         switch ($this->Info_Status->errorCode()) {
         case 3: // Wheel floating
         case 8: // Device is stuck
             $this->startCleaning();
             return (true);
             break;
         }
         return (false);
     }

     public function gotoTarget ($position) {
         $ret = $this->getSendCmd (array ("method" => "app_goto_target",
                                          "params" => $this->stringToIntArray($position)));
         return ($ret);
     }

     public function getMultiMaps() {
         $ret = $this->getSendCmd ("get_multi_maps_list");
         if ($ret != FALSE) {
             $this->Info_MultiMaps->processResult ($ret);
         }
                      
         return ($ret);
     }

     public function setMultiMap ($mapIndex) {
         $ret = $this->getSendCmd (array ("method" => "load_multi_map",
                                          "params" => $this->stringToIntArray($mapIndex)));
         return ($ret);
     }
 }

 ?>
###[/EXEC]###
