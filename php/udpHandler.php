<?
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
?>
