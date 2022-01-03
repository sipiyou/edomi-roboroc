<?
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
?>
