<?
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
 
?>
