<?php 
    namespace App\Controllers;

    use App\Helpers\DateH;
    use App\Helpers\Validator;
    use App\Models\Order;
    use App\Models\OrderItem;
    use App\Models\Client;
    use App\Models\Produit;
    use App\Models\Loan;
    use App\Controllers\CarteController;

    class OrderItemController {
        private $client;
        private $orderItems;
        private $product;
        private $loan;
        private $created_at;
        private $updated_at;

        public function __construct($pdo){
            $this->client       = new Client($pdo);
            $this->orderItems   = new OrderItem($pdo);
            $this->product      = new Produit($pdo);
            $this->loan         = new Loan($pdo);
            $this->created_at  = DateH::current();
            $this->updated_at  = DateH::current();
        }

        public function getClientItems($client_id){
            $orderItem = $this->orderItems->Find('client_id',$client_id);
            return $orderItem;
        }
        public function emptyItemsByclient($client_id){
            $empty = $this->orderItems->empty($client_id);
            return $empty;
        }
        public function deleteFromOrder($id,$client){
            $stock = $this->orderItems->Where('id',$id);
            
                $loanPrice = $stock['product_qty'] * $stock['product_price'];
                $this->loan->decrementLoan($loanPrice,$stock['client_id']);
            
            if($this->product->increment('quantite_stock',$stock['product_qty'],$stock['product_id'])){
                $this->orderItems->delete($id);

            }
            
            return true;
        }

        public function deleteItemFromOrder($id){
            $stock = $this->orderItems->Where('id',$id);
            
            
            if($this->product->increment('quantite_stock',$stock['product_qty'],$stock['product_id'])){
                $this->orderItems->delete($id);

            }
            
            return true;
        }







    }
