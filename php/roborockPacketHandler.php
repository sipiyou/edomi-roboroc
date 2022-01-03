<?
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
?>
