<?php 
     require 'init.php';
     use App\Controllers\ClientController;
     use App\Controllers\OrderItemController;
     use App\Controllers\LoanController;
     


     $clientsObj = new ClientController($pdo);
     $page = "ارجاع منتوج للمخزن";
     ?>
     <?php include "template/includes/head.php"; ?>    
    <!--section content-->
    <?php include "template/includes/sidebar.php"; ?>

    <?php include "template/includes/head.php"; ?>    
    <!--section content-->
    <?php include "template/includes/sidebar.php"; ?>
    
    <?php

        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $request = $_GET['request'];
            if($request == "index"){
                        ?>
                        <section class="content-section">
                        <?php include $inc.'/navbar.php' ;?>
                        <div class="product-page">
                            <div class="product-page-title">
                                <h3>تسجيل منتج عائد</h3>
                                <a href="sales.php?request=index" class="btn btn-red">السلة</a>
                            </div>
                        </div>
                </section>

                <section class='content-section'>
                    
                        <div class='product-details'>
                            <h5>معلومات الزبون</h5>
                                <form  method="POST" action="returns.php" style="display:grid;grid-template-columns: auto auto;">

                                    <div class="form-groupe">
                                        <label for="" class="form-label">كود المنتج</label>
                                        <input type="text" class="input-label" name="code" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">الكمية العائدة</label>
                                        <input type="text"  class="input-label" name="qty" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">الثمن</label>
                                        <input type="text" class="input-label" name="price" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label"> الزبون</label>
                                        <select class='input-select' name='client'>
                                            <option value='0'>زائر</option>
                                            <?php
                                                $clients = $clientsObj->getAllClients();
                                                foreach($clients as $item){
                                                    ?>
                                                    <option value="<?php echo $item['id']?>"><?php echo $item['nom_complet']?></option>
                                                    <?php
                                                }
                                            ?>       
                                         </select>
                                    </div>
                                    

                                    <div class="form-groupe">
                                        <button type="submit" class="submit-btn">حفظ </button>                              
                                    </div>
                                    
                                    
                                        
                                </form>
                            </div>
                </section>
            <?php
            }
        }
        elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
            



        }

     





?>