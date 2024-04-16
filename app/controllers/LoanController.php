<?php 

namespace App\Controllers;
use App\Helpers\DateH;
use App\Helpers\Validator;
use App\Models\Carte;
use App\Models\Loan;
use App\Models\Client;

class LoanController{
    private $loan;
    private $client;

    private $created_at;
    private $updated_at;
    
    public function __construct($pdo){
        $this->loan        = new Loan($pdo);
        $this->client      = new Client($pdo);
        $this->created_at  = DateH::current();
        $this->updated_at  = DateH::current();
    }

    public function insertLoan($id,$price){
        $inserted = false;
        ($this->loan->incrementLoan($price,$id)) ? $inserted = true : $inserted = false;
        return $inserted;
    }
    public function getAllLoans(){
        $loans = $this->loan->all();
        
        $allloans =[];
            foreach($loans as $item){
                $data = [
                    'id'            => $item['id'],
                    'client'        => ($this->client->getAttr('nom_complet',$item['client_id'])),
                    'price'         => $item['price'],
                    'client_id'     => $item['client_id'],
                    'updated_at'    => $item['updated_at'],
                    
                    
                ];
                array_push($allloans,$data);
            }
            return $allloans;
    }
    public function updateLoan($id,$price){
        $inserted = false;
        ($this->loan->decrementLoan($price,$id)) ? $inserted = true : $inserted = false;
        return $inserted;
    }


}