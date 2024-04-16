<?php

   namespace App\Models;
   use App\Models\Model;
    class Fornisseur extends Model{
        /**
         * PDO object
         * @var \PDO
         */

         public function __construct($pdo){
            parent::__construct($pdo);
            $this->table = "fornisseurs";
        }


    }



