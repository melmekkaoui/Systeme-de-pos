<?php
     require 'init.php';
     use App\Controllers\ClientController;
     use App\Helpers\Alert;
     
     $clientObj = new ClientController($pdo);
 
    
     $page = "الزبائن";
?>
<?php include "template/includes/head.php"; ?>    
<!--section content-->
<?php include "template/includes/sidebar.php"; ?>
<?php 
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            $request = $_GET['request'];
          /**
          * display all clients
          */
            if($request == "index"){
                
              ?>
                 <section class="content-section">
                        <?php include $inc.'/navbar.php' ;?>
                        <div class="product-page">
                            <div class="product-page-title">
                                <h3>سجل الزبائن</h3>
                                <a href="clients.php?request=create" class="btn btn-blue">إضافة زبون جديد </a>
                            </div>
                        </div>
                </section>

                <section class="content-section">
                    <div class="table-data">
                        <?php 
                            $clients = $clientObj->getAllClients();
                        ?>
                    <table id="example" class=" display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>الإسم الكامل</th>
                                    <th>رقم الهاتف</th>
                                    <th>الغنوان</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>تحديث/حدف</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($clients as $item){
                                        ?>
                                <tr>
                                    <td><?php echo $item['nom_complet']; ?></td>
                                    <td><?php echo $item['tel'] ; ?></td>
                                    <td><?php echo $item['adresse'] ; ?> درهم</td>
                                    <td><?php echo $item['created_at'] ; ?></td>
                                    <td>
                                        <a href="clients.php?request=edit&id=<?php echo $item['id']; ?>" class="btn btn-blue" style="margin:5px">تحديث</a> / 
                                        <a href="clients.php?request=delete&id=<?php echo $item['id']; ?>" class="btn btn-red " style="margin:5px"> حدف</a>
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
            /**
             * display the form 
             * to create new client
             */
            elseif($request == "create"){
              ?>
                 <section class="content-section">
                        <?php include $inc.'/navbar.php' ;?>
                        <div class="product-page">
                            <div class="product-page-title">
                                <h3>إضافة زبون جديد</h3>
                                <a href="clients.php?request=index" class="btn btn-red">عودة لسجل الزبائن</a>
                            </div>
                        </div>
                </section>

                <section class='content-section'>
                    
                        <div class='product-details'>
                            <h5>معلومات الزبون</h5>
                                <form  method="POST" action="clients.php">

                                    <div class="form-groupe">
                                        <label for="" class="form-label">اسم الزبون كامل</label>
                                        <input type="text" class="input-label" name="nom_complet" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">رقم الهاتف</label>
                                        <input type="text"  class="input-label" name="tel" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">العنوان</label>
                                        <input type="text" class="input-label" name="adresse" >
                                    </div>
                                    
                                    
                                    <button type="submit" class="submit-btn">حفظ معلومات الزبون</button>                              
                                    
                                    
                                    
                                        
                                </form>
                            </div>
                </section>








              <?php
            }
            /**
             * display edit form
             */
            elseif($request == "edit"){
                $clientObj->setId($_GET['id']);
                $client = $clientObj->getSingleClient();
                
              ?>
                 <section class="content-section">
                        <?php include $inc.'/navbar.php' ;?>
                        <div class="product-page">
                            <div class="product-page-title">
                                <h3>تحديث معلومات الزبون</h3>
                                <a href="clients.php?request=index" class="btn btn-red">عودة لسجل الزبائن</a>
                            </div>
                        </div>
                </section>

                <section class='content-section'>
                    
                        <div class='product-details'>
                            <h5>معلومات الزبون</h5>
                                <form  method="POST" action="clients.php">
                                    <input type="hidden" value="<?php echo $client['id']; ?>" name="id" >
                                    <div class="form-groupe">
                                        <label for="" class="form-label">اسم الزبون كامل</label>
                                        <input type="text" class="input-label"  value="<?php echo $client['nom_complet']; ?>" name="nom_complet" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">رقم الهاتف</label>
                                        <input type="text"  class="input-label" value="<?php echo $client['tel']; ?>" name="tel" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">العنوان</label>
                                        <input type="text" class="input-label" value="<?php echo $client['adresse']; ?>" name="adresse" >
                                    </div>
                                    
                                    
                                    <button type="submit" class="submit-btn">حفظ معلومات الزبون</button>                              
                                    
                                    
                                    
                                        
                                </form>
                            </div>
                </section>








              <?php
            }
            /**
             * delete the client
             */
            elseif($request == "delete"){
                $clientObj->setId($_GET['id']);
                if($clientObj->dropClient()){
                    echo '<script type="text/javascript">

                    $(document).ready(function(){
                    
                    new swal("تمت العملية بنجاح") .then((value) => {
                        window.location.href = "clients.php?request=index";
                    });
                    
                    });
            
            </script>
            ';
                }
            }
        }
        /**
         * check if the request 
         * is post request
         */
        elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
          /**
           * check if it is 
           * update request
           */
          if(isset($_POST['id'])){
            $clientObj->setId($_POST['id']);
            $clientObj->setName($_POST['nom_complet']);
            $clientObj->setTel($_POST['tel']);
            $clientObj->setAdresse($_POST['adresse']);
            
            if($clientObj->updateClient()){
                echo '<script type="text/javascript">

                                $(document).ready(function(){
                                
                                new swal("تمت العملية بنجاح") .then((value) => {
                                    window.location.href = "clients.php?request=index";
                                });
                                
                                });
                        
                        </script>
                        ';
          }
          }
          else{
            $clientObj->setName($_POST['nom_complet']);
            $clientObj->setTel($_POST['tel']);
            $clientObj->setAdresse($_POST['adresse']);
            
            if($clientObj->createClient()){
                echo '<script type="text/javascript">

                                $(document).ready(function(){
                                
                                new swal("تمت العملية بنجاح") .then((value) => {
                                    window.location.href = "clients.php?request=index";
                                });
                                
                                });
                        
                        </script>
                        ';
          }
          }
        }

        ?>

          
        <?php include "template/includes/footer.php"; ?> 