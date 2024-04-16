<?php 

namespace App\Models;
use App\Models\Model;
use App\Helpers\DateH;

class Loan extends Model{
    /**
         * PDO object
         * @var \PDO
         */
        private $current;

         public function __construct($pdo){
            parent::__construct($pdo);
            $this->table = "loans";
            $this->current = DateH::current();
            
            
        }
        /**
         * Model Method to increment 
         * loan value
         */
        public function incrementLoan($value,$id){
            $sql = "UPDATE $this->table SET price=price+'$value', updated_at = '$this->current' WHERE client_id=$id";
            //$sql="UPDATE dossier WHERE id=$id SET $implodeArray";
            $stmt = $this->pdo->exec($sql) or die(print_r($this->pdo->errorInfo(), true));
            return $stmt; 
        }
        public function decrementLoan($value,$id){
            $sql = "UPDATE $this->table SET price=price-'$value', updated_at = '$this->current' WHERE client_id=$id";
            //$sql="UPDATE dossier WHERE id=$id SET $implodeArray";
            $stmt = $this->pdo->exec($sql) or die(print_r($this->pdo->errorInfo(), true));
            return $stmt; 
        }
        public function loanCalc(){
            $table=$this->table;
            $statement = $this->pdo->query("SELECT SUM(price) FROM loans WHERE created_at BETWEEN DATE('now', 'start of month','-1 month','+1 day') AND DATE('now')");
            $row = $statement->fetchColumn();
            $data = $row;
            return $data;
        }
}