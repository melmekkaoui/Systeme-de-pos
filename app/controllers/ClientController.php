<?php 
    namespace App\Controllers;
    use App\Helpers\DateH;
    use App\Helpers\Validator;
    use App\Models\Client;
    use App\Models\Loan;

    
    class ClientController {
        /**
         * class
         * properties
         */
        private $conn;
        private $client;
        private $loan;
        private $id;
        private $name;
        private $tel;
        private $adress;
        private $created_at;
        private $updated_at;

        public function __construct($pdo){
            $this->conn                 = $pdo;
            $this->client               = new Client($pdo);
            $this->loan                 = new Loan($pdo);
            $this->id                   = $this->getId();
            $this->name                 = $this->getName();
            $this->tel                  = $this->getTel();
            $this->adress               = $this->getAdr();
            $this->created_at           = DateH::current();
            $this->updated_at           = DateH::current();

        }
        /**
         * Methode to Create 
         * new client
         */
        public function createClient(){
            $inserted = false;
            $clientData = [
                'nom_complet' => $this->name,
                'tel'         => $this->tel,
                'adresse'     => $this->adress,
                'created_at'  => $this->created_at
            ];

           
            ($this->client->create($clientData)) ? $inserted = true : $inserted = false;
            
            $client_id = $this->conn->lastInsertId();

            $loanData = [
                'client_id'     => $client_id,
                'price'         => 0,
                'created_at'    => DateH::current()
            ];
            ($this->loan->create($loanData));

            return $inserted;
        }
        /**
         * method to fetch all the 
         * clients
         */
        public function getAllClients(){
            $allClient = $this->client->all();
            return $allClient;
        }
        /**
         * fetch single client
         */
        public function getSingleClient(){
            $singleClient = $this->client->Where('id',$this->id);
            return $singleClient;
        }
        /**
         * Method to update 
         * a client data
         */
        public function updateClient(){
            $updated = false;
            $clientData = [
                'nom_complet' => $this->name,
                'tel'         => $this->tel,
                'adresse'     => $this->adress,
                'updated_at'  => $this->updated_at
            ];
            ($this->client->update($clientData,$this->id)) ? $updated = true : $updated = false;
        
            return $updated;
        }
        /**
         * Method to 
         * [Delete] client
         */

         public function dropClient(){
            $deleted = false;
            ($this->client->delete($this->id)) ? $deleted = true : $deleted = false;
            return $deleted;
         }


        /**
         * 
         * class getters
         */

         private function getId(){
            return $this->id;
         }
         private function getName(){
            return $this->name;
         }
         private function getTel(){
            return $this->tel;
         }
         private function getAdr(){
            return $this->adress;
         }




        /**
         * class setters
         */

        public function setId($arg){
            $result=$arg;
            if(!empty($result)){
                $this->id = $result;
            }
        }
        public function setName($arg){
            if(!empty($arg)){
                $this->name = $arg;
            }
        }
        public function setTel($arg){
            if(!empty($arg)){
                $this->tel = $arg;
            }
        }
        public function setAdresse(string $arg){
            if(!empty($arg)){
                $this->adress = $arg;
            }
        }
       
    }



?>