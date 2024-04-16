<?php
     require 'init.php';
     use App\Controllers\CarteController;
     use App\Controllers\ClientController;
     use App\Helpers\Alert;
     $carteObj = new CarteController($pdo);
     $clientsObj = new ClientController($pdo);
    
     $page = "سلة التسوق";
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
                $carteItems = array_reverse($carteObj->getCarteItems());
                ?>
                 <section class="content-section">
                        <?php include $inc.'/navbar.php' ;?>
                        <div class="sales-page">
                            <div class="sales-page-title">
                                <h3>سلة التسوق</h3>
                            </div>
                        </div>
                </section>

                <section class="content-section">
                    <div class="sales-page">
                            <form method='post' action='sales.php'>
                                    
                                   
                                    <div class="form-groupe">
                                        <label for="" class="form-label">الكود</label>
                                        <input type="text" class="input-label" name="code" autofocus>
                                    </div>
                                    <div class="form-groupe">
                                        <input type="hidden" class="input-label" name="qty" value="1" required>
                                    </div>
                                    <button type="submit" class="btn btn-blue submit">إضافة إلى السلة</button>
                            </form>
                    </div>
                </section>

                <section class="content-section">
                    <div class="sales-page-second">
                        <div class="sales-page-title-second d-flex">
                                <h3> محتوى سلة التسوق</h3>
                                <a href="salesmodel.php?request=index"><i class="fa-solid fa-barcode"></i></a>

                        </div>
                            <table class="carte-table">
                                <thead>
                                    <tr>
                                        <th>اسم المنتج</th>
                                        <th>كود المنتج</th>
                                        <th>الكمية</th>
                                        <th>الثمن</th>
                                        <th>تحديث</th>
                                        <th>ازالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach($carteItems as $item){
                                            ?>
                                                <tr>
                                                    <td><?php echo $item['product_name'];?></td>
                                                    <td><?php echo $item['product_code'];?></td>

                                                    <form method='post' action='sales.php'>
                                                        <input type="hidden" value="<?php echo $item['id']?>" name="id">
                                                        <td>
                                                            <input type="text" class="carte-input" value="<?php echo $item['product_qty']?>" name="qty">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="carte-input" value="<?php echo $item['product_price']?>" name="price">
                                                        </td>

                                                        <td>
                                                            <button class="btn btn-green"><i class="fa-solid fa-check" style="font-size:26px; color:#fff"></i></button>
                                                        </td>
                                                    </form>




                                                   




                                                    <td>
                                                        <a href="sales.php?request=delete&id=<?php echo $item['id']; ?>" class="btn btn-red " style="margin:5px;text-center"> حدف</a>
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                            
                    </div>
                   
                </section>

                <section class="content-section">
                    <div class="sales-page" style="padding:20px; background-color:#005DFF;">
                        <div class="sales-page-title">
                            <h3 style="color:#FFA200">اتمام الشراء</h3>
                        </div>
                    </div>
                </section>
                <section class='content-section'>
                    
                        <div class='sales-page' style="padding:20px;">
                            <h3>المجموع : <?php echo $carteObj->getTotalPrice(); ?> درهم</h3>
                                <form method='post' action='order.php'>
                                    
                                    
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
                                        <label for="" class="form-label">المبلغ المدفوع</label>
                                        <input type="text" class="input-label" value=" <?php echo $carteObj->getTotalPrice(); ?>" name="payment_price" >
                                    </div>
                                    <button type="submit" class="btn btn-blue submit">حفظ</button>
                                </form>
                            </div>
                </section>


                

                
                
            <?php
            }
            elseif($request == "delete"){
                try{
                    if($carteObj->dropeItem($_GET['id'])){
                        echo '<script type="text/javascript">

                                    $(document).ready(function(){
                                    
                                    new swal({
                                        
                                        icon: "success",
                                        title: "تمت العملية",
                                        text:"تم حدف المنتج من السلة",
                                        showConfirmButton: false,
                                        timer: 1500
                                      }).then((value) => {
                                        window.location.href = "sales.php?request=index";
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
                         window.location.href = "sales.php?request=index";
                      });
                     
                    });
                    
                    </script>
                    ';
                   }
                
            }

            }

            elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(isset($_POST['id'])){
                    $carteObj->setId($_POST['id']);
                    $carteObj->setPrice($_POST['price']);
                    $carteObj->setQty($_POST['qty']);

                    if($carteObj->updateCarte()){

                        echo '<script type="text/javascript">

                                $(document).ready(function(){
                                
                                new swal({
                                    icon: "success",
                                    title: "تمت العملية",
                                    text:  "تم تحديث الكمية",
                                    showConfirmButton: false,
                                    timer: 1500
                                  }) .then((value) => {
                                    window.location.href = "sales.php?request=index";
                                });
                                
                                });
                        
                        </script>
                        ';

                    }
                    


                }else{


                $carteObj->setCode($_POST['code']);
                $carteObj->setQty($_POST['qty']);
                    try{
                        if($carteObj->createCarte()){
                            echo "<script>
                                    window.location.href = 'sales.php?request=index';
                                </script>";
                            echo "<script>alert('تمت العملية بنجاح')</script>";
                        }
                        else{
                            echo "<script>
                            window.location.href = 'sales.php?request=index';
                           
                            </script>";
                            
                        }
                    }
                    catch(Exception $e){
                        echo '<script type="text/javascript">
             
                        $(document).ready(function(){
                        
                          new swal("'.$e->getMessage().'").then((value) => {
                             window.location.href = "sales.php?request=index";
                          });
                         
                        });
                        
                        </script>
                        ';
                       }
                    

                }


            }
        
           

?>

<?php include "template/includes/footer.php"; ?>
