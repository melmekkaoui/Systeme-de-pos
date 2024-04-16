<?php 
    require 'init.php';
    
    use App\Controllers\ProduitController;
    use App\Controllers\CategorieController;
    use App\Controllers\UniteController;
    use App\Controllers\FornisseurController;
    use App\Controllers\CarteController;
    use App\Helpers\Alert;

    $page = "نافذة البحث";

    $produitObj     = new ProduitController($pdo);
    
    $carteObj = new CarteController($pdo);
    
   

?>





    <?php include "template/includes/head.php"; ?>    
    <!--section content-->
    <?php 
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            $request = $_GET['request'];

            if($request == "index"){
               
            ?>
                 
                <section class="content-section">
                    <div class="table-data">
                        <?php 
                            $products = $produitObj->getAllProducts();
                        ?>
                    <table id="example" class=" display nowrap" style="width:100%;text-align:center">
                            <thead>
                                <tr>
                                    <th>الكود</th>
                                    <th>اسم المنتج</th>
                                    
                                    <th>الثمن</th>
                                    
                                    <th>اضافة للسلة</th>
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($products as $item){
                                        ?>
                                <tr>
                                    <td><?php echo $item['code_produit']; ?></td>
                                    <td><?php echo $item['designation'];?></td>
                                    
                                    <td><?php echo $item['prix_vente'] ; ?> درهم</td>
                                    
                                    <td> 
                                        <a href="salesmodel.php?request=index&id=<?php echo $item['id'] ; ?>"><i class="fa-solid fa-cart-shopping btn btn-blue" style="font-size: 20px;"></i></a> 
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
                if(isset($_GET['id'])){
                    if($carteObj->createCarteByid($_GET['id'])){

                        echo '<script type="text/javascript">

                                    $(document).ready(function(){
                                    
                                    new swal({
                                        
                                        icon: "success",
                                        title: "تمت العملية",
                                        text:"تم إضافة المنتج إلى السلة",
                                        showConfirmButton: false,
                                        timer: 1000
                                      }).then((value) => {
                                        window.location.href = "sales.php?request=index";
                                    });
                                    
                                    });
                            
                            </script>';
                    }
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