<?php
    namespace App\Controllers;
    use App\Helpers\DateH;
    use App\Helpers\Validator;
    use App\Models\Fornisseur;

    class FornisseurController{
        /**
         * class
         * properties
         */
        private $fornisseur;
        private $id;
        private $name;
        private $tel;
        private $email;
        private $adresse;
        private $product;
        private $code;
        private $created_at;
        private $updated_at;
    
        public function __construct($pdo){
            $this->fornisseur           = new Fornisseur($pdo);
            $this->id                   = $this->getId();
            $this->name                 = $this->getName();
            $this->tel                  = $this->getTel();
            $this->email                = $this->getEmail();
            $this->adresse              = $this->getAdr();
            $this->product              = $this->getPrd();
            $this->code                 = $this->getCode();
            $this->created_at           = DateH::current();
            $this->updated_at           = DateH::current();
        }
        /**
         * Methode to create
         * New Supplier
         */
        public function CreateFornisseur(){
            $inserted = false;
            $suplierData = [
                'nom_complet'       => $this->name,
                'tel'               => $this->tel,
                'email'             => $this->email,
                'adresse'           => $this->adresse,
                'product'           => $this->product,
                'code'              => $this->code,
                'created_at'        => $this->created_at
            ];
            ($this->fornisseur->create($suplierData))? $inserted =true : $inserted=false;
            return $inserted;
        }
        /**
         * Method to fetch 
         * all the supliers in list
         */
        public function getFornisseursListe(){
            $data = $this->fornisseur->all();
            return $data;
        }
        /**
         * Method to fetch 
         * single Suplier data
         */
        public function fetchSingleFornisseur(){
            $data = $this->fornisseur->Where('id',$this->id);
            return $data;
        }
        /**
         * Method to update
         * suplier data
         */
        public function updateFonisseur(){
            $updated = false;
            $suplierData = [
                'nom_complet'       => $this->name,
                'tel'               => $this->tel,
                'email'             => $this->email,
                'adresse'           => $this->adresse,
                'product'           => $this->product,
                'code'              => $this->code,
                'updated_at'        => $this->updated_at
            ];
            ($this->fornisseur->update($suplierData,$this->id)) ? $updated = true : $updated = false;
        
            return $updated;
        }

        /**
         * Method to 
         * [Delete] suplier
         */

         public function dropFornisseur(){
            $deleted = false;
            ($this->fornisseur->delete($this->id)) ? $deleted = true : $deleted = false;
            return $deleted;
         }








        /**
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
         private function getEmail(){
            return $this->email;
         }
         private function getAdr(){
            return $this->adresse;
         }

         private function getPrd(){
            return $this->product;
         }
         private function getCode(){
            return $this->code;
         }

        /**
         * class setters
         */

         public function setId($arg){
            $result=Validator::number($arg);
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
        public function setEmail($arg){
            if(empty($arg)){
                $this->email = '' ;
            }
            else{
                $this->email= $arg;
            }
        }
        public function setAdr(string $arg = " ")
        {
            $this->adresse= $arg;
        }
        public function setPrd($arg){
                if(!empty($arg)){
                    $this->product = $arg;
                }
        }
        public function setCode($arg){
            if(!empty($arg)){
                $this->code = $arg;
            }
        }

















    }
?>