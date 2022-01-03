<?
/*   original Crypt_Rc4 lib comes from 
  *   https://pear.php.net/reference/Crypt_RC4-latest/__filesource/fsource_Crypt__Crypt_RC4-1.0.3CryptRc4.php.html
  *   
  *   added iteration an minor modification to the main code
  *
  */
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
?>
