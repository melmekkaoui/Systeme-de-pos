<?php 
     require 'init.php';
     use App\Controllers\CategorieController;
     use App\Controllers\UniteController;

     $categorieObj = new CategorieController($pdo);
     $uniteObj     = new UniteController($pdo);
 
     $page = "صفحة الاقسام والوحدات";
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
                                <h3>الاقسام والوحدات</h3>
                            </div>
                        </div>
                    </section>

                    <section class='content-section'>
                    
                        <div class='product-category'>
                            <h5>القسم والوحدة</h5>
                                <form method='post' action='Categories.php'>
                                    
                                    <div class="form-groupe">
                                        <label for="" class="form-label">تسمية القسم</label>
                                        <input type="text" class="input-label" name="nom_categorie" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">وحدة القياس</label>
                                        <input type="text" class="input-label" name="nom_unite" >
                                    </div>
                                    <button type="submit" class="btn btn-blue submit">اضافة</button>
                                </form>
                            </div>
                        </section>



                <?php
            }
        
        }


        ?>












    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $categorieObj->setNom($_POST['nom_categorie']);
        $uniteObj->setNom($_POST['nom_unite']);
        
        (!empty($_POST['nom_categorie'])) ? $insertCat = $categorieObj->createCategorie() : false;
        (!empty($_POST['nom_unite'])) ? $insertUni = $uniteObj->createUnite() :false;

        if($insertCat or $insertUni){
            echo '<script type="text/javascript">

            $(document).ready(function(){
            
            new swal("تمت العملية بنجاح") .then((value) => {
                window.location.href = "products.php?request=products";
            });
            
            });
    
            </script>';
        }

        
         
       


    }


?>