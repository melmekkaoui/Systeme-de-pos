<?php
    namespace App\Helpers;

    class DateH{



        public static function current(){
            $t=time();
            return date("Y-m-d",$t);
        }
    }