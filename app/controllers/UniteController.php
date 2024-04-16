<?php

    namespace App\Controllers;
    use App\Helpers\DateH;
    use App\Helpers\Validator;
    use App\Models\Unite;

    class UniteController {
        /**
        * class attributes
        */
        private $unite; // Model
        private $id;
        private $nom;
        private $created_at;
        private $updated_at;

        public function __construct($pdo){
            $this->unite        = new Unite($pdo);
            $this->id           = $this->getId();
            $this->nom          = $this->getNom();
            $this->created_at   = DateH::current();
            $this->updated_at   = DateH::current();
        }
        /**
         * create Unite
         */


        public function createUnite(){
            $inserted = false;
            $uniteData = [
                'nom_unite'     => $this->nom,
                'created_at'    => $this->created_at,
            ];
            ($this->unite->create($uniteData)) ? $inserted = true : $inserted = false;
        
            return $inserted;
        }

    /**
     * Method to get 
     * all categories 
     */
    public function getAllUnites(){
        $unites = $this->unite->all();
        return $unites;
    } 









        /**
         * class attributes
         * getters
         */
        private function getId(){
            return $this->id;
        }

        private function getNom(){
            return $this->nom;
        }







    /**
     * class attributes 
     * setters
     */
    public function setId($arg){
        $result=Validator::number($arg);
        if(!empty($result)){
            $this->id = $result;
        }
    }

    public function setNom($arg){
        $result = $arg;
        if(!empty($result)){
            $this->nom = $result;
        }
    }
    }