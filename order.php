<?php
     require 'init.php';
     use App\Controllers\CarteController;
     use App\Controllers\ClientController;
     use App\Controllers\OrderController;
     use App\Controllers\LoanController;
     use App\Helpers\Alert;

        $orderObj       = new OrderController($pdo);
        $clientsObj     = new ClientController($pdo);
        $carteObj       = new CarteController($pdo);
        $loanObj        = new LoanController($pdo);
     
     
        $page = "المبيعات";
?>
    <?php include "template/includes/head.php"; ?>    
    <!--section content-->
    <?php include "template/includes/sidebar.php"; ?>

    <?php include "template/includes/head.php"; ?>    
    <!--section content-->
    <?php include "template/includes/sidebar.php"; ?>
    <?php 
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            $request = $_GET['request'];
            if($request == 'index'){
                /**--------------------- order index------------------------- */
                ?>
                <section class="content-section">
                       <?php include $inc.'/navbar.php' ;?>
                       <div class="product-page">
                           <div class="product-page-title">
                               <h3>سجل المبيعات</h3>
                              <div>
                                <a href="order.php?request=empty" class="btn btn-red">حدف كل الطلبيات</a>
                                <a href="sales.php?request=index" class="btn btn-blue">إلى سلة التسوق</a>
                              </div>

                           </div>
                       </div>
               </section>

               <section class="content-section">
                   <div class="table-data">
                    
                       <?php 
                           $orders = $orderObj->getAllOrders();
                           $i = 0;
                       ?>
                   <table id="example" class=" display nowrap" style="width:100%">
                           <thead>
                               <tr>
                                   <th>#</th>
                                   <th>الزبون</th>
                                   <th>رقم التتبع</th>
                                   <th>عدد المنتجات</th>
                                   <th>الثمن</th>
                                   <th>الاداء</th>
                                   <th>تاريخ التسجيل</th>
                                   <th>طباعة / معاينة / حدف</th>
                                   
                               </tr>
                           </thead>
                           <tbody>
                               <?php 
                                   foreach($orders as $item){
                                    $i++;
                                       ?>
                               <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $item['client'] ?? 'زائر' ?></td>
                                   <td><?php echo $item['track_number']; ?></td>
                                   <td><?php echo $orderObj->countProducts(($item['id'])); ?></td>
                                   <td><?php echo $item['totalPrice'] ; ?> درهم</td>
                                   <td><?php echo $item['is_payed'] ; ?> </td>
                                   <td><?php echo $item['created_at'] ; ?></td>
                                   <td>
                                        <a href="order.php?request=print&id=<?php echo $item['id']?>"><i class="fa-solid fa-print btn btn-green"></i></a>/
                                        <a href="order.php?request=fetch&id=<?php echo $item['id'];?>"><i class="fa-solid fa-eye btn btn-blue"></i></a> /
                                        <a href="order.php?request=delete&id=<?php echo $item['id'] ; ?>"><i class="fa-solid fa-trash btn btn-red"></i></a>
                                       
                               </td>

                               </tr>

                                       <?php
                                   }
                               
                               ?>
                           
                           </tbody>
                           
                       </table>


                   </div>
               </section>
           <?php


                /**---------------order index------------------------------ */
            }
            elseif($request == 'fetch'){
                $orderObj->setId($_GET['id']);
                ?>

                <section class="content-section">
                       <?php include $inc.'/navbar.php' ;?>
                       <div class="product-page">
                           <div class="product-page-title">
                               <h3>سجل المبيعات</h3>
                               <a href="order.php?request=index" class="btn btn-blue">إلى سجل المبيعات</a>
                           </div>
                       </div>
               </section>

               <section class="content-section">
                   <div class="table-data">
                       <?php 
                           $orderItems = $orderObj->getOrderItems();
                           $i = 0;
                       ?>
                   <table id="example" class=" display nowrap" style="width:100%">
                           <thead>
                               <tr>
                                   <th>#</th>
                                   <th>كود المنتج</th>
                                   <th>اسم المنتج</th>
                                   <th>الكمية</th>
                                   <th>الثمن</th>
                                  
                                   <th>حدف</th>
                                   
                               </tr>
                           </thead>
                           <tbody>
                               <?php 
                                   foreach($orderItems as $item){
                                    $i++;
                                       ?>
                               <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $item['product_code']; ?></td>
                                   <td><?php echo $item['product_name']; ?></td>
                                   <td><?php echo $item['product_qty']; ?></td>
                                   <td><?php echo $item['product_price'] ; ?> درهم</td>
                                   
                                   <td>
                                        
                                        <a href="orderItems.php?request=deleteItemFromOrder&id=<?php echo $item['id'] ; ?>"><i class="fa-solid fa-trash btn btn-red"></i></a>
                                       
                               </td>

                               </tr>

                                       <?php
                                   }
                               
                               ?>
                           
                           </tbody>
                           
                       </table>


                   </div>

               </section>






                <?php
            }
            elseif($request == 'print' ){
                echo "<script>window.addEventListener('load',(event)=>{
                    window.print();
                })</script>"
                ?>
                
                <section class="content-section">
                       <?php include $inc.'/navbar.php' ;?>
                       <div class="product-page">
                           <div class="product-page-title">
                               <h3>فاتورة الطلبية </h3>
                               <button onclick="window.print();" class="btn btn-blue" >طباعة <i class="fa-solid fa-print"></i></button>
                           </div>
                       </div>
               </section>


               <section class="invoice-content">
                 <?php 
                        $orderObj->setId($_GET['id']);
                        $order= $orderObj->getOneOrder();
                        $orderItems = $orderObj->getOrderItems();
                           $i = 0;
                       ?>
                <div id="invoice-POS">
                    <div class="center-title">
                        <i class="fa-solid fa-cart-shopping icon-store"></i>
                        <span>TAZI-SHOP</span>
                    </div>
                    <div class="order-top">
                        <div>
                            <span>رقم الطلبية :</span><span><?php echo $orderObj->getOrderName($_GET['id']) ?></span>
                        </div>
                        <div>
                            <span>التاريخ :</span><span> <?php echo $order['created_at'] ?></span>
                        </div>
                        
                        <div>
                            <span>الزبون :</span><span> <?php echo $order['client'] ?> </span>
                        </div>
                    </div>

                    <div class="order_content_table">
                    <table class="center">
                            <tr>
                                <th>المنتج</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>المجموع</th>
                            </tr>
                            <?php foreach($orderItems as $itm){ ?>
                            <tr>
                                <td><?php echo $itm['product_name']; ?></td>
                                <td><?php echo $itm['product_qty']; ?></td>
                                <td><?php echo $itm['product_price']; ?></td>
                                <td><?php echo ($itm['product_qty'] * $itm['product_price']); ?> د.م </td>
                            </tr>
                            <?php } ?>
                          
                            </table> 
                    </div>

                    <div class="order-bottom" style="margin-top:10px">
                        <div style='font-weight:bold;font-size:20px;'>
                            <span>المجموع :</span><span> <?php echo $order['order_price'] ?> درهم</span>
                        </div>
                        <div>
                            <span> الدفع نقدا:</span><span> <?php echo $order['payed_price'] ?> درهم</span>
                        </div>
                        <div>
                            <span>الباقي :</span><span><?php echo ($order['order_price']-$order['payed_price']) ;?> درهم</span>
                        </div>
                        
                    </div>
                            
                    <div class="center-title">
                       
                        <span>سعداء بخدمتكم وشكرا على زيارتكم <i class="fa-solid fa-face-smile-beam"></i></span>
                    </div>


                </div>
                

               </section>
               

                <?php
            }
            elseif($request == 'delete'){
                $orderObj->setId($_GET['id']);
                if($orderObj->dropeOrder($_GET['id'])){
                    echo '<script type="text/javascript">
 
                        $(document).ready(function(){
                        
                        new swal("تم حدف الطلبية بنجاح") .then((value) => {
                            window.location.href = "order.php?request=index";
                        });
                        
                        });
                        
                        </script>
                    ';
 
                }
            }
            elseif($request== 'empty'){
                if($orderObj->emptyOrders()){
                    echo '<script type="text/javascript">
 
                        $(document).ready(function(){
                        
                        new swal("تم حدف الطلبيات بنجاح") .then((value) => {
                            window.location.href = "order.php?request=index";
                        });
                        
                        });
                        
                        </script>
                    ';
 
                }
            }

        }
        elseif($_SERVER['REQUEST_METHOD'] == "POST"){

            $cartePrice = $carteObj->getTotalPrice();

           if($_POST['client'] !=0){
                $laoningPrice = ($cartePrice - $_POST['payment_price']);
                $orderObj->setUser($_POST['client']);
                $loanObj->insertLoan($_POST['client'],$laoningPrice);
           }



           try{

            if($orderObj->createOrder($cartePrice,$_POST['payment_price'])){
                echo '<script type="text/javascript">
 
                $(document).ready(function(){
                
                    new swal({
                        icon: "success",
                        title: "تمت العملية",
                        text:"تم حدف المنتج من السلة",
                        showConfirmButton: false,
                        timer: 1000
                      }).then((value) => {
                     window.location.href = "order.php?request=index";
                  });
                 
                });
                
                </script>
                ';
 
             }
           }
           catch(Exception $e){
            echo '<script type="text/javascript">
 
            $(document).ready(function(){
            
              new swal("'.$e->getMessage().'").then((value) => {
                 window.location.href = "order.php?request=index";
              });
             
            });
            
            </script>
            ';
           }
            
    }

?>
        <?php include "template/includes/footer.php"; ?> 