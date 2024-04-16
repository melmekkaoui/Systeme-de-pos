<?php
    require 'init.php';
    use App\Controllers\DashboardController;
    use App\Connections\SQLConnection;
    use App\Controllers\CategorieController;
    $pdo = (new SQLConnection())->connect();
    $categorie = new CategorieController($pdo);
    $dashboardobj = new DashboardController($pdo);

    $page = "لوحة التحكم";

?>


    <?php include "template/includes/head.php"; ?>
    

    <!--section content-->
    <?php include "template/includes/sidebar.php"; ?>
    <section class="content-section">
            <nav>
                <i class='bx bx-menu' ></i>
                <a href="#" class="nav-link"> لوحة التحكم</a>
            </nav>

            <div class="states-section">
                <div class="card">
                    <div class="data">
                        <span>الاقسام</span>
                        <span class="state"><?php echo $dashboardobj->calculateCategories();?></span>
                    </div>
                    <div style="background-color: #1f910873; color:#045c30 ; padding: 20px; border-radius: 10px;">
                        <i class="fa-solid fa-table-cells-large"></i>
                    </div>
                    
                </div>
                <div class="card">
                    <div>
                        <div class="data">
                            <span>المنتجات</span>
                            <span class="state"><?php echo $dashboardobj->calculateProducts();?></span>
                        </div>
                    </div>
                    <div style="background-color: #91880873; color:#a78800 ; padding: 20px; border-radius: 10px;">
                        <i class="fa-solid fa-box"></i>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <div class="data">
                            <span>مبيعات الشهر</span>
                            <span class="state"><?php echo $dashboardobj->calculateOrders() ?? "0 ";?></span>
                        </div>
                    </div>
                    <div style="background-color: #04e2ab73; color:#02573d ; padding: 20px; border-radius: 10px;">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    
                </div>
                <div class="card">
                    <div>
                        <div class="data">
                            <span>نفقات</span>
                            <span class="state"><?php echo $dashboardobj->calculateExpenses() ?? "0";?> درهم</span>
                        </div> 
                    </div>
                    <div style="background-color: #4b008873; color:#250069 ; padding: 20px; border-radius: 10px;">
                        <i class="fa-solid fa-money-bill-transfer"></i>
                    </div>
                 </div>
                 <div class="card">
                    <div>
                        <div class="data">
                            <span>أرباح اليوم</span>
                            <span class="state"><?php echo $dashboardobj->fetchDailySells() ??"0" ?> درهم</span>
                        </div>
                    </div>
                    <div style="background-color: #0c029973; color:#0300b9 ; padding: 20px; border-radius: 10px;">
                        <i class="fa-solid fa-money-bill-trend-up"></i>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <div class="data">
                            <span>أرباح الشهر</span>
                            <span class="state"><?php echo $dashboardobj->calculateGains() ??"0" ?> درهم</span>
                        </div>
                    </div>
                    <div style="background-color: #0c029973; color:#0300b9 ; padding: 20px; border-radius: 10px;">
                        <i class="fa-solid fa-money-bill-trend-up"></i>
                    </div>
                </div>
                
                <div class="card">
                    <div>
                        <div class="data">
                            <span>الديون</span>
                            <span class="state"><?php echo $dashboardobj->calculateLoans();?> درهم</span>
                        </div>
                    </div>
                    <div style="background-color: #965a0073; color:#ffee00 ; padding: 20px; border-radius: 10px;">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                 </div>
            </div>
            
            <!--critical products section-->

            <section class="critical-products" >
                <div class="out-of-stock" style="background-color:#ffcc269a;">
                    <h3 class="title">إنتهى من المخزن</h3>
                    <?php $outofStock = $dashboardobj->fetchOutOfstockProducts(); ?>
                    <table>
                        <thead>
                            <tr>
                                <td>التسمية</td>
                                <td>الثمن</td>
                                <td>الكمية الباقية</td>
                                <td>تحديث</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($outofStock as $item){
                            
                            ?>
                            <tr>
                                <td><?php echo $item['designation'] ?></td>
                                <td><?php echo $item['prix_vente'] ?></td>
                                <td><?php echo $item['quantite_stock'] ?></td>
                                <td>
                                    <a href="products.php?request=edit&id=<?php echo $item['id']; ?>">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                }
                         ?>
                        </tbody>
                    </table>



                </div>
                <div class="Expired-products" style="background-color: #fd733869;">
                    <h3 class="title">انتهاء الصلاحية</h3>
                    <?php $outofStock = $dashboardobj->fetchOutOfDate(); ?>
                    <table>
                        <thead>
                            <tr>
                                <td>التسمية</td>
                                <td>الثمن</td>
                                <td>اخر اجل</td>
                                <td>تحديث</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($outofStock as $item){ ?>
                            <tr>
                             
                                <td><?php echo $item['designation'] ?></td>
                                <td><?php echo $item['prix_vente'] ?></td>
                                <td><?php echo $item['date_exp'] ?></td>
                                <td>
                                    <a href="products.php?request=edit&id=<?php echo $item['id']; ?>">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                            
                        </tbody>
                    </table>


                </div>

            </section>
        </section>



    <!---end content-->