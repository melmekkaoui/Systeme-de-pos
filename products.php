<?php 
    require 'init.php';
    
    use App\Controllers\ProduitController;
    use App\Controllers\CategorieController;
    use App\Controllers\UniteController;
    use App\Controllers\FornisseurController;
    use App\Helpers\Alert;


    $produitObj     = new ProduitController($pdo);
    $categorieObj   = new CategorieController($pdo);
    $uniteObj       = new UniteController($pdo);
    $suplierObj     = new FornisseurController($pdo);
    
    $page = "قسم المنجات";

?>





    <?php include "template/includes/head.php"; ?>    
    <!--section content-->
    <?php include "template/includes/sidebar.php"; ?>
    <?php 
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            $request = $_GET['request'];

            if($request == "products"){
               
            ?>
                 <section class="content-section">
                        <?php include $inc.'/navbar.php' ;?>
                        <div class="product-page">
                            <div class="product-page-title">
                                <h3>مخزن المنتجات</h3>
                                <a href="products.php?request=create" class="btn btn-green">إضافة منتج للمخزن</a>
                            </div>
                        </div>
                </section>

                <section class="content-section">
                    <div class="table-data">
                        <?php 
                            $products = $produitObj->getAllProducts();
                        ?>
                    <table id="example" class=" display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>الكود</th>
                                    <th>اسم المنتج</th>
                                    <th>تاريخ انتهاء الصلاحية</th>
                                    <th>الثمن</th>
                                    <th>الكمية</th>
                                    <th>تحديث/حدف</th>
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($products as $item){
                                        ?>
                                <tr>
                                    <td><?php echo $item['code_produit']; ?></td>
                                    <td><?php echo $item['designation'];?></td>
                                    <td><?php echo $item['date_exp'] ; ?></td>
                                    <td><?php echo $item['prix_vente'] ; ?> درهم</td>
                                    <td><?php echo $item['quantite_stock'] ; ?></td>
                                    <td> <a href="products.php?request=edit&id=<?php echo $item['id'] ; ?>"><i class="fa-solid fa-pen-to-square btn btn-blue" ></i></a> / <a href="products.php?request=delete&id=<?php echo $item['id'] ; ?>"><i class="fa-solid fa-trash btn btn-red"></i></a></td>
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
             * check if the request is create
             */
            elseif($request=='create'){
                ?>
                 <section class="content-section">
                        <?php include $inc.'/navbar.php' ;?>
                        <div class="product-page">
                            <div class="product-page-title">
                                <h3>إضافة منتج جديد</h3>
                                <a href="products.php?request=products" class="btn btn-green">عودة للمنتجات</a>
                            </div>
                        </div>
                </section>
                <section class='content-section'>
                    
                        <div class='product-details'>
                            <h5>تفاصيل المنتج</h5>
                                <form  method="POST" action="products.php">
                                    
                                    <div class="form-groupe">
                                        <label for="" class="form-label"> القسم</label>
                                        <select class='input-select' name='categorie'>
                                            <option >اختر قسم المنتج</option>
                                            <?php
                                                $categories = $categorieObj->getAllCategories();
                                                foreach($categories as $item){
                                                    ?>
                                                    <option value="<?php echo $item['id']?>"><?php echo $item['nom_categorie']?></option>
                                                    <?php
                                                }
                                            ?>       
                                         </select>
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">وحدة القياس</label>
                                        <select class='input-select' name='unite'>
                                            <option >اختر الوحدة</option>
                                            
                                            <?php
                                                $unites = $uniteObj->getAllunites();
                                                foreach($unites as $item){
                                                    ?>
                                                    <option value="<?php echo $item['id']?>"><?php echo $item['nom_unite']?></option>
                                                    <?php
                                                }
                                            ?>      
                                        </select>
                                    </div>




                                    <div class="form-groupe">
                                        <label for="" class="form-label">تسمية المنتج</label>
                                        <input type="text" class="input-label" name="designiation" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">الكمية في المخزن</label>
                                        <input type="text" class="input-label" name="quantite" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">تاريخ انتهاء الصلاحية</label>
                                        <input type="date" class="input-label" name="experation" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">ثمن الشراء</label>
                                        <input type="text" class="input-label" name="prix_achat" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">ثمن البيع</label>
                                        <input type="text" class="input-label" name="prix_vente" >
                                    </div>
                                   
                                    <div class="form-groupe">
                                        <label for="" class="form-label">كود المنتج</label>
                                        <input type="text" class="input-label" name="code_produit" onkeypress="return (event.key!='Enter')">
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">الكمية الحرجة</label>
                                        <input type="text" class="input-label" name="critical_quantite">
                                    </div>
                                    <div  style="display: flex; justify-content: center; align-items: end;">
                                    <button type="submit" class="submit-btn">اضافة</button>                              
                                    </div>
                                    
                                    
                                        
                                </form>
                            </div>
                </section>


            <?php
            /**
             * edit the product 
             * data 
             */
            }
            elseif($request == 'edit'){
                $produitObj->setId($_GET['id']);
                $product = $produitObj->getSingleProduct();
               ?>
                    <section class="content-section">
                        <?php include $inc.'/navbar.php' ;?>
                        <div class="product-page">
                            <div class="product-page-title">
                                <h3>تحديث المنتج</h3>
                                <a href="products.php?request=products" class="btn btn-green">عودة للمنتجات</a>
                            </div>
                        </div>
                    </section>



                    <section class='content-section'>
                    
                        <div class='product-details'>
                            <h5>تفاصيل المنتج</h5>
                                <form  method="POST" action="products.php">
                                    
                                    

                                    <input type="hidden" value="<?php echo $product['id'] ?>" name='id'>


                                    <div class="form-groupe">
                                        <label for="" class="form-label">تسمية المنتج</label>
                                        <input type="text" value="<?php echo $product['designation'] ?>" class="input-label" name="designation" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">الكمية في المخزن</label>
                                        <input type="text" value="<?php echo $product['quantite_stock'] ?>" class="input-label" name="quantite" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">تاريخ انتهاء الصلاحية</label>
                                        <input type="text" value="<?php echo $product['date_exp'] ?>" class="input-label" name="experation" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">ثمن الشراء</label>
                                        <input type="text" value="<?php echo $product['prix_achat'] ?>" class="input-label" name="prix_achat" >
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">ثمن البيع</label>
                                        <input type="text" value="<?php echo $product['prix_vente'] ?>" class="input-label" name="prix_vente" >
                                    </div>
                                    
                                    <div class="form-groupe">
                                        <label for="" class="form-label">كود المنتج</label>
                                        <input type="text" class="input-label" value="<?php echo $product['code_produit'] ?>"  name="code_produit" onkeypress="return (event.key!='Enter')">
                                    </div>
                                    <div class="form-groupe">
                                        <label for="" class="form-label">الكمية الحرجة</label>
                                        <input type="text" class="input-label" value="<?php echo $product['critical_number'] ?>" name="critical_quantite">
                                    </div>
                                    <div  style="display: flex; justify-content: center; align-items: end;">
                                    <button type="submit" class="submit-btn">تحديث</button>                              
                                    </div>
                                    
                                    
                                        
                                </form>
                            </div>
                </section>
                


                <?php
                
            }
            elseif($request == 'delete'){
                $produitObj->setId($_GET['id']);
                if($produitObj->dropeProduct()){
                    echo '<script type="text/javascript">

                                $(document).ready(function(){
                                
                                new swal("تمت العملية بنجاح") .then((value) => {
                                    window.location.href = "products.php?request=products";
                                });
                                
                                });
                        
                        </script>
                        ';
                }
            }
            
            
        }

        elseif($_SERVER['REQUEST_METHOD'] == 'POST'){

            if(isset($_POST['id'])){
                $produitObj->setId($_POST['id']);
                $produitObj->setNom($_POST['designation']);
                $produitObj->setQuant($_POST['quantite']);
                $produitObj->setExp($_POST['experation']);
                $produitObj->setAchat($_POST['prix_achat']);
                $produitObj->setVente($_POST['prix_vente']);
                $produitObj->setCode($_POST['code_produit']);
                $produitObj->setCrtQ($_POST['critical_quantite']);
                if($produitObj->updateProduct()){
                    echo '<script type="text/javascript">

                                $(document).ready(function(){
                                
                                new swal("تمت العملية بنجاح") .then((value) => {
                                    window.location.href = "products.php?request=products";
                                });
                                
                                });
                        
                        </script>
                        ';
                }

            }else{

                if(($_POST['prix_vente']) > ($_POST['prix_achat']) ){
                    

                    $produitObj->setCat($_POST['categorie']);
                    $produitObj->setUni($_POST['unite']);
                    $produitObj->setNom($_POST['designiation']);
                    $produitObj->setQuant($_POST['quantite']);
                    $produitObj->setExp($_POST['experation']);
                    $produitObj->setAchat($_POST['prix_achat']);
                    $produitObj->setVente($_POST['prix_vente']);
                    $produitObj->setCode($_POST['code_produit']);
                    $produitObj->setCrtQ($_POST['critical_quantite']);

        
                    /***send the store the data  */
        
                    if($produitObj->createProduct()){
                        echo '<script type="text/javascript">

                                $(document).ready(function(){
                                
                                new swal({
                                
                                icon: "success",
                                title:"تمت العملية بنجاح",
                                text: "تمت اضافة المنتج بنجاح",
                                showConfirmButton: false,
                                timer: 1500
                                }).then((value) => {
                                    window.location.href = "products.php?request=create";
                                });
                                
                                });
                        
                        </script>
                        ';
                    }




                }
                else{
                    echo '<script type="text/javascript">

                                $(document).ready(function(){
                                
                                new Swal({
                                    icon: "error",
                                    title: "خطأ...",
                                    text: "ثمن الشراء أكبر من ثمن البيع",
                                    
                                  }).then((value) => {
                                    window.location.href = "products.php?request=create";
                                });
                                
                                });
                        
                        </script>
                        ';
                }

            }

        }
    
    
    
    ?>

<?php
 include "template/includes/footer.php";



?> 