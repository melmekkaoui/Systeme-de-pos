<?php

    namespace App\Controllers;
    use App\Helpers\DateH;
    use App\Helpers\Validator;
    use App\Models\Categorie;

    class CategorieController {
        /**
        * class attributes
        */
        private $categorie; // Model
        private $id;
        private $nom;
        private $desc;
        private $created_at;
        private $updated_at;

        public function __construct($pdo){
            $this->categorie    = new Categorie($pdo);
            $this->id           = $this->getId();
            $this->nom          = $this->getNom();
            $this->desc         = $this->getDesc();
            $this->created_at   = DateH::current();
            $this->updated_at   = DateH::current();

        }

    /**
     * Method to create 
     * new category in db
     */
    public function createCategorie(){
        $inserted = false;

        $categorieData = [
            'nom_categorie'     => $this->nom,
            'desc_categorie'     => $this->desc,
            'created_at'=> $this->created_at,
        ];

        ($this->categorie->create($categorieData)) ? $inserted = true : $inserted = false;
        
        return $inserted;
        
    }
    /**
     * Method to get 
     * all categories 
     */
    public function getAllCategories(){
        $allCategories = $this->categorie->all();
        return $allCategories;
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
        private function getDesc(){
            return $this->desc;
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
    public function setDesc($arg){
        $result = $arg;
        if(!empty($result)){
            $this->desc = $result;
        }
    }



        
    }


