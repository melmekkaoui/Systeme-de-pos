<?php
    namespace App\Models;

    /**
     * PHP General Model 
     */
    use App\Helpers\DateH;
    abstract class Model{
         /**
         * PDO object
         * @var \PDO
         */
        protected $pdo;
        protected $table;
        private $current;
        
        /**
         * init Db connection 
         */
        public function __construct($pdo){
            $this->pdo = $pdo;
            $this->current = DateH::current();
            
        }
        /**
         * abstract method to 
         * insert object in database;
         */
        public function create($args){

            /**
             * split the args into key value array
             */
            $attr = implode(', ' ,array_keys($args));
            $values = "'" .implode("','" ,array_values($args))."'";
            $table = $this->table; 
            //insert statement 
                $statement = $this->pdo->exec("INSERT INTO $table ($attr)VALUES($values)")  or die(print_r($this->pdo->errorInfo(), true)) ;
                if($statement){
                    return true;
                }
            }
        /**
         * function to fetch all the Data
         */
        public function all(){

            $table = $this->table;
            $statement = $this->pdo->query(" SELECT * FROM $table ");
            $row = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $row;
        }
        public function Where($column,$value){
            $statement = $this->pdo->query(" SELECT * FROM $this->table WHERE $column = '$value'");
            $row = $statement->fetch(\PDO::FETCH_ASSOC);
            $data = $row;
            return $data;
        }
        public function Find($column,$value){
            $statement = $this->pdo->query(" SELECT * FROM $this->table WHERE $column = '$value'");
            $row = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $data = $row;
            return $data;
        }
        /**
         * get an attribute from db by id
         */
        public function getAttr($attr,$id){
            $table=$this->table;
            $statement = $this->pdo->query(" SELECT * FROM $table WHERE id = '$id'");
            $row = $statement->fetch(\PDO::FETCH_ASSOC);
            $data = $row[$attr];
            return $data;
        }
        /**
         * Dynamic
         * Update Method
         */

        public function update($args,$id){
            $cols = array();
            foreach($args as $key=>$val) {
                $cols[] = "$key = '$val'";
            }
            $sql = "UPDATE $this->table SET " . implode(', ', $cols) . " WHERE id=$id";
            //$sql="UPDATE dossier WHERE id=$id SET $implodeArray";
            $stmt = $this->pdo->exec($sql) or die(print_r($this->pdo->errorInfo(), true));
            return $stmt; 
        }
        
        /**
         * The delete Method
         */

        public function delete($id){
            $table = $this->table;
            $deleted = false;
            $statement = $this->pdo->exec("DELETE FROM $table
            WHERE id='$id'");
            if($statement){
                $deleted = true;
            }
            else{
                $deleted = false;
            }
            return $deleted;
        }
        
        /**
         * Method to
         * Increment data
         */
        public function increment($field,$value,$id){
            $sql = "UPDATE $this->table SET $field=$field+'$value', updated_at = '$this->current' WHERE id=$id";
            //$sql="UPDATE dossier WHERE id=$id SET $implodeArray";
            $stmt = $this->pdo->exec($sql) or die(print_r($this->pdo->errorInfo(), true));
            return $stmt; 
        }
        /**
         * Method to 
         * Decrement data
         */
        public function decrement($field,$value,$id){
            $sql    = "UPDATE $this->table SET $field=$field - '$value', updated_at='$this->current' WHERE id=$id";
            $stmt   = $this->pdo->exec($sql) or die(print_r($this->pdo->errorInfo(),true));
            return $stmt;

        }
        public function count(){
            $table=$this->table;
            $statement = $this->pdo->query(" SELECT count(*) FROM $table ");
            $row = $statement->fetchColumn();
            $data = $row;
            return $data;
        }
        

    }
