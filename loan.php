<?php
     require 'init.php';
     use App\Controllers\CarteController;
     use App\Controllers\ClientController;
     use App\Controllers\LoanController;
     use App\Helpers\Alert;
     $carteObj = new CarteController($pdo);
     $clientsObj = new ClientController($pdo);
     $loanObj    = new LoanController($pdo);
    
     $page = "سجل الديون";
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
                               <h3>سجل الديون</h3>
                              
                           </div>
                       </div>
               </section>

               <section class='content-section'>
                    
                        <div class='product-category'>
                            <h5>زيادة دين</h5>
                                <form method='post' action='loan.php'>
                                    
                                    <div class="form-groupe">
                                        <label for="" class="form-label">الثمن</label>
                                        <input type="text" class="input-label" name="price" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label"> الزبون</label>
                                        <select class='input-select' name='client'>
                                            <option>اختر الزبون</option>
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
                                    <button type="submit" class="btn btn-blue submit">اضافة</button>
                                </form>
                            </div>
                </section>


                <section class='content-section'>
                    
                    <div class='product-category'>
                        <h5>اضافة أداء</h5>
                            <form method='post' action='loan.php?request=payment'>
                                <input type="hidden" name='payment' value='true'>
                                <div class="form-groupe">
                                    <label for="" class="form-label">الثمن</label>
                                    <input type="text" class="input-label" name="price" >
                                </div>
                                <div class="form-groupe">
                                    <label for="" class="form-label"> الزبون</label>
                                    <select class='input-select' name='client'>
                                        <option>اختر الزبون</option>
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
                                <input type="submit" class="btn btn-green submit" value='تسجيل الدفع'>
                            </form>
                        </div>
            </section>

               <section class="content-section">
                   <div class="table-data">
                       <?php 
                           $loans = $loanObj->getAllLoans();
                           $i = 0;
                       ?>
                   <table id="example" class=" display nowrap" style="width:100%;text-align:center">
                           <thead>
                               <tr>
                                   <th>#</th>
                                   <th>الزبون</th>
                                   <th>ثمن الدين الباقي</th>
                                   <th>تاريخ اخر تحديث</th>
                                   <th>ازالة كل الدين</th>
                                 
                                   
                               </tr>
                           </thead>
                           <tbody>
                               <?php 
                                   foreach($loans as $item){
                                    $i++;
                                       ?>
                               <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $item['client']; ?></td>
                                   <td><?php echo $item['price']; ?></td>
                                   <td><?php echo $item['updated_at'] ; ?></td>
                                   <td>
                                        <a href="orderItems.php?request=index&id=<?php echo $item['client_id'];?>"><i class="fa-solid fa-eye btn btn-blue"></i></a> 
                                       
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
            
            
        }
        /**------------------------Post --------------------------------- */
        elseif($_SERVER['REQUEST_METHOD'] == "POST"){
            if(isset($_POST['id'])){
                
            }
            if(isset($_POST['payment'])){
                if($loanObj->updateLoan($_POST['client'],$_POST['price'])){
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
            else{
                
                     if($loanObj->insertLoan($_POST['client'],$_POST['price'])){
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
        }
?>

<?php include "template/includes/footer.php"; ?>
