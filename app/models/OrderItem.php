<?php 

namespace App\Models;
use App\Models\Model;

class OrderItem extends Model{
    /**
         * PDO object
         * @var \PDO
         */

         public function __construct($pdo){
            parent::__construct($pdo);
            $this->table = "orderItems";
        }
        public function countItems($id){
            $table=$this->table;
            $statement = $this->pdo->query(" SELECT count(*) FROM $table WHERE order_id = '$id'");
            $row = $statement->fetchColumn();
            $data = $row;
            return $data;
        }
        public function empty($id){
            $table = $this->table;
            $deleted = false;
            $statement = $this->pdo->exec("DELETE FROM $table where client_id='$id'");
            if($statement){
                $deleted = true;
            }
            else{
                $deleted = false;
            }
            return $deleted;
        }
        public function expenses(){
            $table=$this->table;
            $statement = $this->pdo->query("SELECT SUM(purchase_price * product_qty) FROM orderItems WHERE created_at BETWEEN DATE('now', 'start of month','-1 month','+1 day') AND DATE('now')");
            $row = $statement->fetchColumn();
            $data = $row;
            return $data;
        }
        public function gains(){
            $table=$this->table;
            $statement = $this->pdo->query("SELECT (SUM(product_price * product_qty) - SUM(purchase_price * product_qty)) FROM orderItems WHERE created_at BETWEEN DATE('now', 'start of month','-1 month','+1 day') AND DATE('now')");
            $row = $statement->fetchColumn();
            $data = $row;
            return $data;
        }
        public function dailysellings(){
            $table = $this->table;
            $statement = $this->pdo->query("SELECT sum(product_price) From orderItems");
            $row = $statement->fetchColumn();
            $data = $row;
            return $data;
        }
        
}