<?php 
    namespace App\Helpers;
    use Exception;


    class Validator{
        

        /**
         * function to validate the email
         */
        public static function email($Uemail){
            // sanitize the email and remove all ellegal chars
            $newEmail = filter_var($Uemail, FILTER_SANITIZE_EMAIL);
            //validating the email
            if(filter_var($newEmail, FILTER_VALIDATE_EMAIL)){
                return $newEmail;
            }
            else{
                throw new Exception("Error the Email you submited is not valid");

            }

        }
        /**
         * validate names
         * 
         */
        public static function text($text){
           if(!preg_match ("/^[a-zA-Z\s]+$/", $text)){
                throw new Exception("Error Just Characters and spaces are allowed");
           }
           else{
               return $text;
           }
        }
        /**
         * validate the numbers
         */
        public static function number($Unumber)
        {
            if(!empty($Unumber)){
                if (!preg_match ("/^[0-9]*$/", $Unumber) ){  
                    throw new Exception("Error juste numbers are allowed");
                 } else {  
                     return $Unumber;  
                 }  
            }
            else{
                throw new Exception('nulls are not allowed');
            }
        }

    }


   

?>
