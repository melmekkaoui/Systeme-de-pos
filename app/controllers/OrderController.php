<?php

    namespace App\Controllers;
    use Exception;
    use App\Helpers\DateH;
    use App\Helpers\Validator;
    use App\Models\Carte;
    use App\Models\Order;
    use App\Models\OrderItem;
    use App\Models\Produit;
    use App\Models\Client;
    use App\Models\Loan;
    use App\Controllers\CarteController;


    class OrderController {
        private $order;
        private $client;
        private $loan;
        private $conn;
        private $orderitem;
        private $product;
        private $id;
        private $user;
        private $created_at;
        private $updated_at;
        private $carte;
        private $cartePrice;
        public function __construct($pdo){

            $this->order      = new Order($pdo);
            $this->client     = new Client($pdo);
            $this->carte      = new Carte($pdo);
            $this->orderitem  = new OrderItem($pdo);
            $this->loan       = new Loan($pdo);
            $this->product    = new Produit($pdo);


            $this->conn = $pdo;
         
            $this->id       = $this->getId();
            $this->user    = $this->getUser();
            $this->cartePrice = (new CarteController($pdo))->getTotalPrice();
            $this->created_at = DateH::current();
            $this->updated_at = DateH::current();

            

        }
        /**
         * Methode to create 
         * an order
         */
        public function createOrder($cartePrice,$payedprice){

            $inserted = false;
            
            $orderdata = [
                'user'       => $this->user,
                'is_payed'   => ($this->user == 0) ? 1 : 0,
                'order_price'=> $cartePrice,
                'created_at'    => $this->created_at,
                'track_number'  => 'Commande_000'.rand(1,9999999999),
                'payed_price'   => $payedprice,

            ];
            $carteData = $this->carte->all();
           
            if($this->order->create($orderdata)){
                $order_id = $this->conn->lastInsertId();
                
                foreach($carteData as $item){
                    $singleItem = [
                        'order_id'      => $order_id,
                        'product_id'    => $item['product_id'],
                        'product_code'  => $item['product_code'],
                        'product_name'  => $item['product_name'],
                        'product_price' => $item['product_price'],
                        'purchase_price'=> $item['purchase_price'],
                        'product_qty'   => $item['product_qty'],
                        'created_at'    => $this->created_at,
                        'client_id'     => $this->user,
                    ];

                        if($setItem = $this->orderitem->create($singleItem)){
                            $this->product->decrement('quantite_stock',$item['product_qty'],$item['product_id']);
                            
                        }
                   
                    
                    

                }
                
                $this->carte->empty();
                

                $inserted = true;
            }
            return $inserted;
        }
        /**
         * Method to fetch 
         * all the Orders
         */
        public function getAllOrders(){
            $orders = $this->order->all();
            $allOrders =[];
            foreach($orders as $item){
                $data = [
                    'id'            => $item['id'],
                    'client'        => ($item['user'] == 0) ? ' زائر ': ($this->client->getAttr('nom_complet',$item['user'])),
                    'totalPrice'    => $this->getTotalPrice($item['id']),
                    'is_payed'      => ($item['is_payed'] == 0) ? 'غير خالص':' خالص ' ,
                    'created_at'    => $item['created_at'],
                    'track_number'  => $item['track_number'],
                    
                ];
                array_push($allOrders,$data);
            }
            return array_reverse($allOrders);
        }
        /**
         * Method to get Total
         * Price
         */
        public function getTotalPrice($id){
            $orderItems = $this->orderitem->Find('order_id',$id);
            $TotalPrice = 0;
            foreach($orderItems as $item){
                $TotalPrice += $item['product_price'] * $item['product_qty'];
                
            }
            return $TotalPrice;
        }
        
        public function countProducts($id){
            $countOrderItems = $this->orderitem->countItems($id);
            return $countOrderItems;
        }
        public function getSingleOrder(){
            $order = $this->produit->Where('id',$this->id);
            return $order;
            
        }
        public function getOneOrder(){
            $order = $this->order->Where('id',$this->id);
            $data = [
                'created_at' => $order['created_at'],
                'client'     => ($order['user'] == 0) ? ' زائر ': ($this->client->getAttr('nom_complet',$order['user'])),
                'order_price'=> $order['order_price'],
                'payed_price'=> $order['payed_price']
            ];
            return $data;
            
        }
        public function getOrderItems(){
            $items = $this->orderitem->Find('order_id',$this->id);
            return $items;
        }

        public function getOrderName($id){
            $name =$this->order->getAttr('track_number',$id);
            return $name;

        }
        public function dropeOrder($id){
            $deleted = false;
            ($this->order->delete($this->id)) ? $deleted = true : $deleted = false;
            return $deleted;
        }
        public function emptyOrders(){
            $deleted = false;
            ($this->order->empty()) ? $deleted = true : $deleted = false;
            return $deleted;
        }

        public function dropeItemFromOrder(){

        }


        private function getId(){
            return $this->id;
        }
        private function getUser(){
            return $this->user;
        }


        public function setId(int $arg){
            $this->id = $arg;
        }
        public function setUser(int $arg){
            $this->user = $arg;
        }


    }
