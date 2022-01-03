<?
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
         $this->useRC4 = 1;

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

         $signString = base64_encode(sha1(utf8_encode(implode ("&",$postArray)),true));

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

         $this->signed_nonce = base64_encode(hash ("sha256",$this->ssecurity. $nonce, true));

         $postArray = array ();
         
         if ($this->useRC4) {
             $params['rc4_hash__'] = $this->generateEncodedSignature ($path, "POST",$this->signed_nonce, $params);

             foreach ($params as $k => $v) {
                 $params[$k] = $this->localRC4Encode($v);
             }

             $params['signature'] = $this->generateEncodedSignature ($path, "POST",$this->signed_nonce, $params);
             $params['ssecurity'] = base64_encode($this->ssecurity);
             $params["_nonce"] = base64_encode($nonce);
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
                 "x-xiaomi-protocal-flag-cli: PROTOCAL-HTTP2",
                 "Accept-Encoding: identity",
                 "MIOT-ENCRYPT-ALGORITHM: ENCRYPT-RC4",
             );
             $payload = array (
                 "data" => '{"getVirtualModel":true,"getHuamiDevices":1,"get_split_device":false,"support_smart_home":true}'
//'{"getVirtualModel":false,"getHuamiDevices":0}'
                 
			 );

             $this->generateSignature ("/home/device_list", $payload);

             $result = $this->request ($url,
                                       $payload, "POST", $requestHeaders, $cookie, true);

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
             $payload = array (
                 "data" => '{"obj_name":"'.$mapURL.'"}'
			 );

             $this->generateSignature ("/home/getmapfileurl", $payload);

             $result = $this->request ($url,
                                       $payload, "POST", $requestHeaders, $cookie, true);

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
?>
