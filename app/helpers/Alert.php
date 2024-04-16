<?php
     namespace App\Helpers;
     use Exception;

     class Alert{


        public static function msg($arg){
            echo "<script>
                    Swal.fire('hekko ');
                </script>";
        }
     }