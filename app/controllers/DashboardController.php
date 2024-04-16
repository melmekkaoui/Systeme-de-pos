<?php 



     namespace App\Controllers;
     use App\Helpers\DateH;
     use App\Helpers\Validator;
     use App\Models\Carte;
     use App\Models\Produit;
     use App\Models\Loan;
     use App\Models\Fornisseur;
     use App\Models\Client;
     use App\Models\Categorie;
     use App\Models\Order;
     use App\Models\Returns;
     use App\Models\OrderItem;

     
     class DashboardController {
          private $analytics;
          private $carte;
          private $category;
          private $client;
          private $fornisseur;
          private $loan;
          private $order;
          private $produit;
          private $orderItem;
          private $return;

          public function __construct($pdo){
               $this->carte = new Carte($pdo);
               $this->category = new Categorie($pdo);
               $this->client   = new Client($pdo);
               $this->fornisseur = new Fornisseur($pdo);
               $this->loan       = new Loan($pdo);
               $this->order      = new Order($pdo);
               $this->produit    = new Produit($pdo);
               $this->orderItem  = new OrderItem($pdo);
               $this->return     = new Returns($pdo);
          }
          public function calculateCategories(){
               $count = $this->category->count();
               return $count;
          }
          public function calculateProducts(){
               $count = $this->produit->count();
               return $count;
          }
          public function calculateOrders(){
               $count = $this->order->countByData();
               return count($count);
          }
          public function calculateExpenses(){
               $price = $this->orderItem->expenses();
               return $price;
          }
          public function calculateGains(){
               $gains =  $price = $this->orderItem->gains();
               return $gains;
          }
          public function calculateLoans(){
               $loans = $this->loan->loanCalc();
               return $loans;
          }
          public function fetchOutOfstockProducts(){
               $products = $this->produit->outOfStock();
               return $products;
          }
          public function fetchOutOfDate(){
               $products = $this->produit->outOfDate();
               return $products;
          }
          public function fetchDailySells(){
               $sales = $this->orderItem->dailysellings();
               return $sales;
          }


     }


?>