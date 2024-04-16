<?php
    namespace App\Helpers;
    class Hash {
        public $password;
        
       public static function makeHash($Upassword){
           $HashedPassword = password_hash($Upassword, PASSWORD_DEFAULT);
           return $HashedPassword;
       }
       public static function verifyHash($Upassword,$DbPassword){
            if(password_verify($Upassword, $DbPassword)){
                
                return true;
            }
            else{
                
                return false;
            }
       }
    }

   
    

?>