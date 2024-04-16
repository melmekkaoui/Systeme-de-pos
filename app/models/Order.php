<?php 

namespace App\Models;
use App\Models\Model;

class Order extends Model{
    /**
         * PDO object
         * @var \PDO
         */

         public function __construct($pdo){
            parent::__construct($pdo);
            $this->table = "orders";
        }
        public function countByData(){
            $table=$this->table;
            $statement = $this->pdo->query("SELECT * FROM orders WHERE created_at BETWEEN DATE('now', 'start of month','-1 month','+1 day') AND DATE('now')");
            $row = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $data = $row;
            return $data;
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