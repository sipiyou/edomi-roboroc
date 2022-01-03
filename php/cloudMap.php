<?
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
?>
