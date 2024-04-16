<?php 


    namespace App\Controllers;
    use App\Helpers\DateH;
    use App\Helpers\Validator;
    use App\Models\Carte;
    use App\Models\Produit;
    use Exception;


    class CarteController {
        private $carte ;
        private $produit;
        private $id;
        private $product_id;
        private $product_code;
        private $product_name;
        private $product_price;
        private $product_qty;
        public function __construct($pdo){
            $this->produit = new Produit($pdo);
            $this->carte = new Carte($pdo);
            $this->product_code = $this->getPrdCode();
            $this->product_qty  = $this->getQty();
            $this->product_price = $this->getPrice();
            $this->id            = $this->getId();
        
            
        }
        /**
         * insert a product in the carte
         */
        public function createCarte(){
            $inserted = false;

            $productdata = $this->produit->Where('code_produit',$this->product_code);
            if(empty($productdata)){
                return false;
            }elseif(($productdata['quantite_stock'] <= $this->product_qty) or ($productdata['quantite_stock'] <= 0) ){
                throw new Exception('الكمية المطلوبة غير موجودة');

            }
            else{
                $id    = $productdata['id'];
                $price = $productdata['prix_vente'];
                $name  = $productdata['designation'];
                $code  = $this->product_code;
                $qty   = $this->product_qty;
                $purchase_price = $productdata['prix_achat'];


                $carteData = [
                    'product_id'     => $id,
                    'product_price'  => $price,
                    'product_name'   => $name,
                    'product_code'   => $code,
                    'product_qty'    => $qty,
                    'purchase_price' => $purchase_price,

                ];
                
                ($this->carte->create($carteData))? $inserted =true : $inserted=false;
                return $inserted;  
            }
            

        }
        public function createCarteByid($id){
            $inserted = false;

            $productdata = $this->produit->Where('id',$id);
            if(empty($productdata)){
                return false;
            }elseif(($productdata['quantite_stock'] <= $this->product_qty) or ($productdata['quantite_stock'] <= 0) ){
                throw new Exception('الكمية المطلوبة غير موجودة');

            }
            else{
                $id    = $productdata['id'];
                $price = $productdata['prix_vente'];
                $name  = $productdata['designation'];
                $code  = $productdata['code_produit'];
                $qty   = 1;
                $purchase_price = $productdata['prix_achat'];


                $carteData = [
                    'product_id'     => $id,
                    'product_price'  => $price,
                    'product_name'   => $name,
                    'product_code'   => $code,
                    'product_qty'    => $qty,
                    'purchase_price' => $purchase_price,

                ];
                
                ($this->carte->create($carteData))? $inserted =true : $inserted=false;
                return $inserted;  
            }
        }

        /**
         * 
         * 
         */
        public function getCarteItems(){
            $carteItems = $this->carte->all();
            return $carteItems;
        }
        public function getTotalPrice(){
            $cartitems = $this->carte->all();
            $TotalPrice = 0;
            foreach($cartitems as $item){
                $TotalPrice += $item['product_price'] * $item['product_qty'];
                
            }
            return $TotalPrice;
            
        }

        /**
         * 
         * 
         */
        
         public function updateCarte(){
             $inserted = false;
             $carteData = [
                 'product_price'    => $this->product_price,
                 'product_qty'      => $this->product_qty,
             ];

             ($this->carte->update($carteData,$this->id))? $inserted =true : $inserted=false;
                return $inserted;  

         }

         /**
          * 
          *
          *
          */

        public function dropeItem($id){
            $deleted = false;
            ($this->carte->delete($id)) ? $deleted = true : $deleted = false;
            return $deleted;
        }






        private function getId(){
            return $this->id;
        }
        private function getPrdCode(){
            return $this->product_code;
        }
        private function getQty(){
            return $this->product_qty;
        }
        private function getPrice(){
            return $this->product_price;
        }
        






        public function setId($arg){
            $this->id = $arg;
        }
        public function setCode($arg){
            $this->product_code = $arg;
        }
        public function setQty($arg){
            $this->product_qty = $arg;
        }
        public function setPrice($arg){
            $this->product_price = $arg;
        }











    }