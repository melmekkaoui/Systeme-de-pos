<?php

    namespace App\Models;
    use App\Models\Model;

    class Carte extends Model{
        /**
         * PDO object
         * @var \PDO
         */

         public function __construct($pdo){
            parent::__construct($pdo);
            $this->table = "carte";
        }
        public function empty(){
            $table = $this->table;
            $deleted = false;
            $statement = $this->pdo->exec("DELETE FROM $table");
            if($statement){
                $deleted = true;
            }
            else{
                $deleted = false;
            }
            return $deleted;
        }
    }