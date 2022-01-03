<?
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
