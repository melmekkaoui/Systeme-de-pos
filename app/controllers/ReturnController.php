<?php 
    
    namespace App\Controllers;
    use App\Helpers\DateH;
    use App\Models\Client;
    use App\Models\Loan;
    use App\Models\orderItem;
    use App\Models\Produit;
    use App\Models\Returns;

    class ReturnsController{
        private $loan;
        private $client;
        private $orderItem;
        private $product;
        private $created_at;
        private $return;
        public function __constructor($pdo){
            $this->loan         = new Loan($pdo);
            $this->client       = new Client($pdo);
            $this->orderItem    = new OrderItem($pdo);
            $this->product      = new Produit($pdo);
            $this->created_at   = DateH::current();
            $this->return       = new Returns($pdo);
        }

        public function insertReturn($client_id,$qty,$price,$code){
            $inserted = false;
            $thePrice  = $price *  $qty;
            $returnData = [
                'client_id' => $client_id,
                'product_code' => $price,
                'qty'           => $qty,
                'price'         => $price,
                'created_at'    => $this->created_at
            ];

            if($client_id != 0){
                $this->loan->decrementLoan($thePrice,$client_id);
                $this->product->incrementByCode('quantite_stock',$qty,$code);
                $this->return->create($returnData);
            }
        }




    }