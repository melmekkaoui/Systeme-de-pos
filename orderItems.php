<?php 
    require 'init.php';
    use App\Controllers\CarteController;
    use App\Controllers\ClientController;
    use App\Helpers\Alert;
    use App\Controllers\OrderItemController;
    $carteObj = new CarteController($pdo);
    $clientsObj = new ClientController($pdo);
    $orderItemsObj = new OrderItemController($pdo);
   
    $page = "معاينة منتجات مشتريات";

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

            if($request == "index"){
                /**--------------------- order index------------------------- */
                ?>
                     <section class="content-section">
                       <?php include $inc.'/navbar.php' ;?>
                       <div class="product-page">
                           <div class="product-page-title">
                               <h3>تصفح مشتريات</h3>
                               <a href="orderItems.php?request=empty&id=<?php echo $_GET['id']; ?>" class="btn btn-red">مسح الكل</a>
                           </div>
                       </div>
                    </section>


                    <section class="content-section">
                   <div class="table-data">
                       <?php 
                           $items = $orderItemsObj->getClientItems($_GET['id']);
                           $i = 0;
                       ?>
                   <table id="example" class=" display nowrap" style="width:100%">
                           <thead>
                               <tr>
                                   <th>#</th>
                                   <th>اسم المنتج</th>
                                   <th>الثمن</th>
                                   <th>الكمية</th>
                                   <th>المجموع</th>
                                   <th>تاريخ الشراء</th>
                                   <th>ازالة</th>
                                   
                               </tr>
                           </thead>
                           <tbody>
                               <?php 
                                   foreach($items as $item){
                                    $i++;
                                       ?>
                               <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $item['product_name']; ?></td>
                                   <td><?php echo $item['product_price']; ?></td>
                                   <td><?php echo $item['product_qty'] ; ?></td>
                                   <td><?php echo ($item['product_qty']*$item['product_price']); ?></td>
                                   <td><?php echo $item['created_at'] ; ?></td>
                                   <td><a href="orderItems.php?request=delete&id=<?php echo $item['id'] ; ?>&clientid=<?php echo $item['client_id'] ; ?>"><i class="fa-solid fa-trash btn btn-red"></i></a>
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
            elseif($request == 'delete'){
                $client = ((isset($_GET['client_id'])) && (!empty($_GET['client_id']) )) ? $_GET['client_id'] : 0 ;
                if($orderItemsObj->deleteFromOrder($_GET['id'],$client)){
                    echo '<script type="text/javascript">

                                $(document).ready(function(){
                                
                                new swal("تمت العملية بنجاح") .then((value) => {
                                    window.location.href = "order.php?request=index";
                                });
                                
                                });
                        
                        </script>
                        ';
                }
                
            }
            elseif($request == 'empty'){
                if($orderItemsObj->emptyItemsByclient($_GET['id'])){
                    echo '<script type="text/javascript">

                                $(document).ready(function(){
                                
                                new swal("تمت العملية بنجاح") .then((value) => {
                                    window.location.href = "loan.php?request=index";
                                });
                                
                                });
                        
                        </script>
                        ';
                }
            }
            elseif($request == 'deleteItemFromOrder'){
                if($orderItemsObj->deleteItemFromOrder($_GET['id'])){
                    echo '<script type="text/javascript">

                                $(document).ready(function(){
                                
                                new swal("تمت العملية بنجاح") .then((value) => {
                                    window.location.href = "order.php?request=index";
                                });
                                
                                });
                        
                        </script>
                        ';
                    }   
                }
            }







?>

<?php include "template/includes/footer.php"; ?>    
