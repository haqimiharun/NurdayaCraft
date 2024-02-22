<?php
include '../../applications/mainframe.php';
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Nurdaya Store</title>
    <script language="javascript" src="">
        $("#")
    </script>
        <style>

            .navbar{
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 15px 30px;
                background-color: #FCD5CE;
            }

            .navbar a {
                text-decoration: none;
                color: #000;
                font-family: 'Sura', serif;
                font-size: 17px;
            }

            .searchNav input[type=text]{
                padding: 8px;
                margin-top: 7px;
                font-size: 17px;
                border: #868686;
                color: #868686;
                border-radius: 12px;
            }

            .searchNav button{
                padding: 8px;
                margin-top: 7px;
                margin-right: 16px;
                background: white;
                font-size: 17px;
                border: none;
                cursor: pointer;
                border-radius: 12px;
            }

            .registerButton{
                margin-left: 20px;
                padding: 8px 20px;
                font-size: 17px;
                border-radius: 12px;
            }
        </style>
    </head>
    <body>
        <main>
            <div class="navbar"> 
            <a href="../../index.php" style="font-family: 'Sulphur Point', sans-serif; text-decoration: none; color: #4D4D4D; font-size:32 ;">NurDaya Store</a>
            <div class="NavBarOption">
                <a href="#" style="margin-right: 10px;">Home</a>
                <a href="#" style="margin-right: 10px;">Categories</a>
                <a href="#" style="margin-right: 10px;">Latest</a>
                <a href="#" style="margin-right: 10px;">Blog</a>
                <a href="#" style="margin-right: 10px;">Pages</a>
                <a href="#">Contact</a>
            </div>
            <div class="searchNav">
                <div class="row">
                    <div class="col"><input type="text" placeholder="Search" name="search" class="form-control shadow-none" autocomplete="off"></div>
                    <div class="col"><button type="button" class=""><img src="../../images/search.png"></button></div>
                </div>
            </div>
            <div>
                <a href="#"><img src="../../images/bookmark.png" width="25px"></a>
                <a href="#"><img src="../../images/cart.png" width="25px"></a>
                
                <?php
                    if (!isset($_SESSION['user_id'])) {
                ?>
                <a href="../login/login.php"><button type="submit" class="btn btn-primary registerButton">Sign In</button></a>
                <?php
                    }else{

                ?>
                <select class="dropDown btn" id="dropDown">
                    <option value="name"><?php echo $_SESSION['user_name']?></option>
                    <option value="signin">My Order</option>
                    <option value="logout"><button type="" id="logout">Logout</button></option>
                </select>
                <?php
                    }
                ?>
            </div>
            </div>
            <?php
            $product_id = $_GET["product"];
            $query = "SELECT product_image, product_price, product_name, product_description, promotion_id, promotion_rate, product_qty FROM product WHERE product_id={$product_id}";
            $result = mysqli_query($conn,$query);
            while($rows=mysqli_fetch_assoc($result)){
                ?>
            <div class="row bg-lighter py-5">
                <div class="col-md-6 text-center">
                    <?php
                    if ($rows["product_image"]!=''){
                    ?>
                    <img src="../product/uploads/<?php echo $rows["product_image"] ?>" class="" width="550px" style="border-radius: 10px;">
                    <?php
                    }else{
                        ?>
                    <img src="../../images/image-not-found-icon.png" width="550px" style="border-radius: 10px;">
                    <?php
                    }
                    ?>
                </div>
                <div class="col-md-6">
                    <form action="checkout.php" method="post" name="checkout" id="checkout">
                    <div class="row" style="font-size: 48px;"><?php echo $rows["product_name"]?><?php
                        if($rows["product_qty"]==0){
                            ?>
                        Out of Stock
                            <?php
                        }
                    ?></div>
                    
                    <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id ?>">
                    <?php 
                        $query2 = "SELECT CASE WHEN b.promotion_type='-' THEN a.product_price-a.promotion_rate WHEN b.promotion_type='%' THEN a.product_price-(a.product_price*a.promotion_rate/100) END AS discounted, CASE WHEN b.promotion_type='-' THEN CONCAT('RM ', a.promotion_rate, ' OFF') WHEN b.promotion_type='%' THEN CONCAT(a.promotion_rate, b.promotion_type, ' OFF') END AS label, a.product_price, b.promotion_type FROM product a, promotion b WHERE a.promotion_id=b.promotion_id AND a.product_id={$product_id}";
                        $result2 = mysqli_query($conn,$query2);
                        if(mysqli_num_rows($result2)>0){
                        while($rows2=mysqli_fetch_assoc($result2)){
                            ?>
                    <div class="row" style="font-size: 24px;">
                        <div class="col-md-2"><s>RM <?php echo $rows2["product_price"]?></s></div>
                        <div class="col-md-2">RM <?php echo number_format((float)$rows2["discounted"],2,'.','')?></div>
                        <div class="col-md-2"><?php echo $rows2["label"]?></div>
                        <input type="hidden" id="product_price" name="product_price" value="<?php echo number_format((float)$rows2["discounted"],2,'.','')  ?>">
                    </div>
                            <?php
                        }
                    }else{
                        ?>
                        <div class="col" style="font-size: 24px;">RM <?php echo $rows["product_price"]?></div>
                        <input type="hidden" id="product_price" name="product_price" value="<?php echo $rows["product_price"] ?>">
                        <?php
                    }
                    ?>
                    
                    <div class="row h-50" style="font-size: 32px;"><?php echo $rows["product_description"]?></div>
                    <div class="row" style="font-size: 24px;">Quantity Left: <?php echo $rows["product_qty"]?></div>
                    <div class="row" style="font-size: 24px;"><input type="number" value="1" min="1" max="<?php echo $rows["product_qty"]?>" class="form-control" style="width: 10%;" name="product_qty" id="product_qty" required></div>
                    <?php
                        if($rows["product_qty"]!=0){
                            ?>
                        <div class="row py-3"><button type="submit" class="btn btn-primary w-25" style="border-radius: 42px" id="buyBtn" name="buyBtn">Buy</button></div>
                            <?php
                        }else{
                            ?>
                        <div class="row py-3"><button type="button" class="btn btn-primary w-25" style="border-radius: 42px" id="buyBtn" name="buyBtn" disabled>Buy</button></div>
                            <?php
                        }
                    ?>
                </div>
                </form>
            </div>
                <?php
                
            }
            ?>
            
        </main>
        <footer class="site-footer bg-lighter" style="height: 300px;">
        <div class="jumbotron py-3 jumbotron-fluid bg-main text-center">
            Follow Us: 
            <a href="https://www.facebook.com/Zadagiftshop"><img src="../../images/fbicon.png"></a>
            <a href="https://www.instagram.com/nurdayacraft/"><img src="../../images/igicon.png"></a>
        </div>
            <div class="container pt-3">
            <div class="row">
                <div class="col">
                    <div class="row pt-2">Connect with US</div>
                    <div class="row pt-2">Subscribe to our newsletter</div>
                    <div class="row pt-2">Email Address<input type="text" class="subscribe-border subscribe-input form-control shadow-none"></div>
                    <div class="row pt-2"><button type="button" class="btn subscribe-border subscribe-btn w-25">Subscribe</button></div>
                </div>
                <div class="col">
                    <div class="row pt-2">
                        <div class="center-block text-center" style="color: #C50808;">
                            NurDayah Store
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="center-block text-center">
                            Malaysian Crafter CLIPART & VECTOR ARTWORK
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row pt-3">Customer Care</div>
                    <div class="row">Contact Us</div>
                    <div class="row">Return Policy</div>
                    <div class="row">Order Tracking</div>
                    <div class="row">Find Us</div>
                </div>
            </div>
            </div>
           
        </footer>
    </body>
</html>