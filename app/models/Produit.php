<?php

    namespace App\Models;
    use App\Models\Model;

    class Produit extends Model{
        /**
         * PDO object
         * @var \PDO
         */

        public function __construct($pdo){
            parent::__construct($pdo);
            $this->table = "produits";
        }
        public function incrementByCode($field,$value,$code){
            $sql = "UPDATE $this->table SET $field=$field+'$value', updated_at = '$this->current' WHERE code_produit=$code";
            //$sql="UPDATE dossier WHERE id=$id SET $implodeArray";
            $stmt = $this->pdo->exec($sql) or die(print_r($this->pdo->errorInfo(), true));
            return $stmt; 
        }
        public function outOfStock(){
            $statement = $this->pdo->query(" SELECT * FROM $this->table WHERE critical_number >= quantite_stock");
            $row = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $data = $row;
            return $data;
        }
        public function outOfDate(){
            $table=$this->table;
            $statement = $this->pdo->query("SELECT * FROM produits WHERE date_exp < DATE('now')");
            $row = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $data = $row;
            return $data;
        }

    }