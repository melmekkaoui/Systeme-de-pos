<?php

    namespace App\Controllers;
    use App\Helpers\DateH;
    use App\Helpers\Validator;
    use App\Models\Produit;

    class ProduitController {
        /**
        * class attributes
        */
        private $produit;
        private $id;
        private $categorie;
        private $unite;
        private $nom_produit;
        private $quantite;
        private $crtQuant;
        private $date_exp;
        private $prix_achat;
        private $prix_vente;
        private $fornisseur;
        private $code;
        private $created_at;
        private $updated_at;
        
        /**
         * constructor
         */
        public function __construct($pdo){
            $this->produit      = new Produit($pdo);
            $this->id           = $this->getId();
            $this->categorie    = $this->getCat();
            $this->unite        = $this->getUni();
            $this->nom_produit  = $this->getNom();
            $this->quantite     = $this->getQuant();
            $this->crtQuant     = $this->getCrtQuant();
            $this->date_exp     = $this->getExp();
            $this->prix_achat   = $this->getAchat();
            $this->prix_vente   = $this->getVente();
            $this->code         = $this->getCode();
            $this->created_at   = DateH::current();
            $this->updated_at   = DateH::current();
        }

        /**
         * Method to 
         * insert
         * new product 
         */

         public function createProduct(){
            $inserted = false;
            $productData = [
               
                    
                    "code_produit"          => $this->code,
                    "id_categorie"          => $this->categorie,
                    'designation'          => $this->nom_produit,
                    "unite_id"              => $this->unite,
                    "quantite_stock"        => $this->quantite,
                    "critical_number"       => $this->crtQuant,
                    "date_exp"              => $this->date_exp,
                    "prix_vente"            => $this->prix_vente,
                    "prix_achat"            => $this->prix_achat,
                    "marge"	                => ($this->prix_vente - $this->prix_achat),                   
                    "created_at"	        => $this->created_at,
                    
                
            ];

            ($this->produit->create($productData)) ? $inserted = true : $inserted = false;
        
            return $inserted;
        
         }
         /**
          * get products
          */
          public function getAllProducts(){
            $allproducts = $this->produit->all();
            return $allproducts;
        } 
        /**
         * get single product
         */
        public function getSingleProduct(){
            $product = $this->produit->Where('id',$this->id);
            return $product;
        }
        /**
         * update products
         * 
         */

        public function updateProduct(){
            $updated = false;
            $productData = [
               
                    
                    "code_produit"          => $this->code,
                    'designation'           => $this->nom_produit,
                    "quantite_stock"        => $this->quantite,
                    "critical_number"       => $this->crtQuant,
                    "date_exp"              => $this->date_exp,
                    "prix_vente"            => $this->prix_vente,
                    "prix_achat"            => $this->prix_achat,
                    "updated_at"	        => $this->updated_at,
                    
                
            ];

            ($this->produit->update($productData,$this->id)) ? $updated = true : $updated = false;
        
            return $updated;
        }
        public function dropeProduct(){
            $deleted = false;
            ($this->produit->delete($this->id)) ? $deleted = true : $deleted = false;
            return $deleted;
        }
















        /**
         * Getters
         * 
         */


         private function getId(){
            return $this->id;
        }
        private function getCat(){
            return $this->categorie;
        }
        private function getUni(){
            return $this->unite;
        }
        private function getNom(){
            return $this->nom_produit;
        }
        private function getQuant(){
            return $this->quantite;
        }
        private function getCrtQuant(){
            return $this->crtQuant;
        }
        private function getExp(){
            return $this->date_exp;
        }
        private function getAchat(){
            return $this->prix_achat;
        }
        private function getVente(){
            return $this->prix_vente;
        }
        private function getForn(){
            return $this->fornisseur;
        }
        private function getCode(){
            return $this->code;
        }



















        /**
         * setters
         * 
         */
        public function setId($arg){
            $result=$arg;
            if(!empty($result)){
                $this->id = $result;
            }
        }
        public function setCat($arg){
            $result=$arg;
            if(!empty($result)){
                $this->categorie = $result;
            }
        }
        public function setUni($arg){
            $result=$arg;
            if(!empty($result)){
                $this->unite = $result;
            }
        }
        public function setNom($arg){
            $result=$arg;
            if(!empty($result)){
                $this->nom_produit = $result;
            }
        }
        public function setQuant($arg){
            $result=$arg;
            if(!empty($result)){
                $this->quantite = $result;
            }
        }
        public function setCrtQ($arg){
            $result=$arg;
            if(!empty($result)){
                $this->crtQuant =  $result;
            }
        }
        public function setExp($arg){
            /*$result=Validator::text($arg);
            if(!empty($result)){
                $this->date_exp = $result;
            }*/
            $this->date_exp = $arg;
        }
        public function setAchat($arg){
            $result=$arg;
            if(!empty($result)){
                $this->prix_achat = $result;
            }
        }
        public function setVente($arg){
            $result=$arg;
            if(!empty($result)){
                $this->prix_vente = $result;
            }
        }
        public function setForn($arg){
            $result=$arg;
            if(!empty($result)){
                $this->fornisseur = $result;
            }
        }
        public function setCode($arg){
            $result=$arg;
            if(!empty($result)){
                $this->code = $result;
            }
        }
    }