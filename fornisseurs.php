<?php

require 'init.php';
use App\Controllers\FornisseurController;

$suplierObj = new FornisseurController($pdo);
     
 
    
$page = "الموردين";
?>
<?php include "template/includes/head.php"; ?>    
<!--section content-->
<?php include "template/includes/sidebar.php"; ?>
<?php 
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            $request = $_GET['request'];

            if($request == "index"){
            ?>
                 <section class="content-section">
                        <?php include $inc.'/navbar.php' ;?>
                        <div class="product-page">
                            <div class="product-page-title">
                                <h3>سجل الموردين</h3>
                                <a href="fornisseurs.php?request=create" class="btn btn-green">إضافة مورد جديد</a>
                            </div>
                        </div>
                </section>
                <section class="content-section">
                    <div class="table-data">
                        <?php 
                            $supliers = $suplierObj->getFornisseursListe();
                        ?>
                    <table id="example" class=" display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>الإسم الكامل</th>
                                    <th>رقم الهاتف</th>
                                    <th>العنوان</th>
                                    <th>السلعة</th>
                                    <th>البريد</th>
                                    <th>الكود</th>
                                    <th>تحديث/حدف</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($supliers as $item){
                                        ?>
                                <tr>
                                    <td><?php echo $item['nom_complet']; ?></td>
                                    <td><?php echo $item['tel'] ; ?></td>
                                    <td><?php echo $item['adresse'] ; ?> درهم</td>
                                    <td><?php echo $item['product'] ; ?></td>
                                    <td><?php echo $item['email'] ; ?></td>
                                    <td><?php echo $item['code'] ; ?></td>


                                    <td>
                                        <a href="fornisseurs.php?request=edit&id=<?php echo $item['id']; ?>" class="btn btn-blue" style="margin:5px">تحديث</a> / 
                                        <a href="fornisseurs.php?request=delete&id=<?php echo $item['id']; ?>" class="btn btn-red " style="margin:5px"> حدف</a>
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
            elseif($request == "create"){
                ?>
                     <section class="content-section">
                        <?php include $inc.'/navbar.php' ;?>
                        <div class="product-page">
                            <div class="product-page-title">
                                <h3>إضافة مورد جديد</h3>
                                <a href="fornisseurs.php?request=index" class="btn btn-red">عودة لسجل الموردين</a>
                            </div>
                        </div>
                    </section>

                    <section class='content-section'>
                    
                        <div class='product-details'>
                            <h5>معلومات الزبون</h5>
                                <form  method="POST" action="fornisseurs.php">

                                    <div class="form-groupe">
                                        <label for="" class="form-label">اسم المورد الكامل</label>
                                        <input type="text" class="input-label" name="nom_complet" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">رقم الهاتف</label>
                                        <input type="text"  class="input-label" name="tel" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label"> البريد الاليكتروني</label>
                                        <input type="text"  class="input-label" name="email" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">العنوان</label>
                                        <input type="text" class="input-label" name="adresse" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">السلعة</label>
                                        <input type="text" class="input-label" name="product" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">كود المورد</label>
                                        <input type="text" class="input-label" name="code" >
                                    </div>
                                    <div class="form-groupe">
                                        
                                        <input type="submit" class="submit-btn" value="حفظ معلومات المورد">                          
                                    </div>
                                    
                                    
                                        
                                </form>
                            </div>
                </section>


                <?php
            }
            /**
             * display edit form
             */
            elseif($request == "edit"){
                $suplierObj->setId($_GET['id']);
                $suplier = $suplierObj->fetchSingleFornisseur();
                ?>
                 <section class="content-section">
                        <?php include $inc.'/navbar.php' ;?>
                        <div class="product-page">
                            <div class="product-page-title">
                                <h3>تحديث معلومات المورد</h3>
                                <a href="fornisseurs.php?request=index" class="btn btn-red">عودة لسجل الموردين</a>
                            </div>
                        </div>
                </section>

                <section class='content-section'>
                    
                        <div class='product-details'>
                            <h5>معلومات الزبون</h5>
                                <form  method="POST" action="fornisseurs.php">
                                <input type="hidden" value="<?php echo $suplier['id']; ?>" name="id" >

                                    <div class="form-groupe">
                                        <label for="" class="form-label">اسم المورد الكامل</label>
                                        <input type="text" class="input-label" value="<?php echo $suplier['nom_complet']; ?>" name="nom_complet" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">رقم الهاتف</label>
                                        <input type="text"  class="input-label" value="<?php echo $suplier['tel']; ?>" name="tel" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label"> البريد الاليكتروني</label>
                                        <input type="text"  class="input-label" value="<?php echo $suplier['email']; ?>" name="email" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">العنوان</label>
                                        <input type="text" class="input-label" value="<?php echo $suplier['adresse']; ?>" name="adresse" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">السلعة</label>
                                        <input type="text" class="input-label" value="<?php echo $suplier['product']; ?>" name="product" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">كود المورد</label>
                                        <input type="text" class="input-label" value="<?php echo $suplier['code']; ?>" name="code" >
                                    </div>
                                    <div class="form-groupe">
                                        
                                        <input type="submit" class="submit-btn" value="تحديث معلومات المورد">                          
                                    </div>
                                    
                                    
                                        
                                </form>
                            </div>
                </section>




                <?php
            }
            elseif($request == "delete"){
                $suplierObj->setId($_GET['id']);
                if($suplierObj->dropFornisseur()){
                    echo '<script type="text/javascript">

                                $(document).ready(function(){
                                
                                new swal("تمت العملية بنجاح") .then((value) => {
                                    window.location.href = "fornisseurs.php?request=index";
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
                $suplierObj->setId($_POST['id']);
                $suplierObj->setName($_POST['nom_complet']);
                $suplierObj->setTel($_POST['tel']);
                $suplierObj->setEmail($_POST['email']);
                $suplierObj->setAdr($_POST['adresse']);
                $suplierObj->setPrd($_POST['product']);
                $suplierObj->setCode($_POST['code']);

                if($suplierObj->updateFonisseur()){
                    echo '<script type="text/javascript">

                                $(document).ready(function(){
                                
                                new swal("تمت العملية بنجاح") .then((value) => {
                                    window.location.href = "fornisseurs.php?request=index";
                                });
                                
                                });
                        
                        </script>
                        ';
               }



            }
            else{
                $suplierObj->setName($_POST['nom_complet']);
                $suplierObj->setTel($_POST['tel']);
                $suplierObj->setEmail($_POST['email']);
                $suplierObj->setAdr($_POST['adresse']);
                $suplierObj->setPrd($_POST['product']);
                $suplierObj->setCode($_POST['code']);

                if($suplierObj->CreateFornisseur()){
                    echo '<script type="text/javascript">

                                $(document).ready(function(){
                                
                                new swal("تمت العملية بنجاح") .then((value) => {
                                    window.location.href = "fornisseurs.php?request=index";
                                });
                                
                                });
                        
                        </script>
                        ';
                }


            }
        }
?>
        <?php include "template/includes/footer.php"; ?> 