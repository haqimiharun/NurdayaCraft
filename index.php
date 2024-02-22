<?php
include 'applications/mainframe.php';
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Nurdaya Store</title>
    <script language="javascript" src="index.js"></script>
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
            <a href="index.php" style="font-family: 'Sulphur Point', sans-serif; text-decoration: none; color: #4D4D4D; font-size:32 ;">NurDaya Store</a>
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
                    <div class="col"><button type="button" class=""><img src="images/search.png"></button></div>
                </div>
            </div>
            <div>
                <a href="#"><img src="images/bookmark.png" width="25px"></a>
                <a href="#"><img src="images/cart.png" width="25px"></a>
                
                <?php
                    if (!isset($_SESSION['user_id'])) {
                ?>
                <a href="sites/login/login.php"><button type="submit" class="btn btn-primary registerButton">Sign In</button></a>
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

            <div class="row bg-lighter pt-5">
                <div class="col-md-6">
                    <img src="images/mainproduct.png" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <div class="row" style="font-size: 48px;">40% Discount</div>
                    <div class="row" style="font-size: 128px;">New Year Collection</div>
                    <div class="row" style="font-size: 32px;">Art is never finished, only abandoned</div>
                    <div class="row"><a type="button" class="btn btn-primary w-25" style="border-radius: 42px" href="#product">Shop Now</a></div>
                </div>
            </div>
            <?php
                $catQuery = "SELECT * FROM category a WHERE EXISTS (SELECT category_id FROM product b WHERE b.product_status='Y' AND a.category_id=b.category_id) AND a.category_status='Y'";
                $result2 = mysqli_query($conn, $catQuery);
                if(mysqli_num_rows($result2)>0){
                    while($rows2=mysqli_fetch_assoc($result2)){
                        ?>
            <section id="product">
            <div class="container">
                <div class="row text-center"><h1><?php echo $rows2["category_name"]?></h1></div>
            </div>
            </section>
            <div style="width: 100%; display: flex; flex-wrap: wrap; padding: 0 50px 0 50px">
            <?php
            $query ="SELECT product_id, product_image, product_name, product_price FROM product WHERE product_status='Y' AND category_id={$rows2['category_id']}";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result)>0){
                while($rows=mysqli_fetch_assoc($result)){
?>
                
                    <div class="product-container" style="flex-basis: 25%;">
                    <?php
                        if ($rows["product_image"]!=''){
                    ?>
                        <a href="sites/showcase/index.php?product=<?php echo $rows["product_id"]?>"><img src="sites/product/uploads/<?php echo $rows["product_image"] ?>" height="250px" style="border-radius: 10px;"></a>

                        <?php

                        }else{
                            ?>
                        <a href="sites/showcase/index.php?product=<?php echo $rows["product_id"]?>"><img src="images/image-not-found-icon.png" height="250px" style="border-radius: 10px;"></a>
                        <?php
                        }
                        ?>
                        <div class="col" style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 60%;">
                            <p style="margin-top: 10px;"><?php echo $rows["product_name"]?></p>
                            <p>RM <?php echo $rows["product_price"] ?></p>
                        </div>
                    </div>
                
                <?php
                }
            }
            
            //echo count(mysqli_fetch_assoc($result));

            ?>
            
            
            </div>
                        <?php
                    }
                }
            ?>
            
            
            <div class="row" style="height: 300px;"></div>
            
        </main>
        <footer class="site-footer bg-lighter" style="height: 300px;">
        <div class="jumbotron py-3 jumbotron-fluid bg-main text-center">
            Follow Us: 
            <a href="https://www.facebook.com/Zadagiftshop"><img src="images/fbicon.png"></a>
            <a href="https://www.instagram.com/nurdayacraft/"><img src="images/igicon.png"></a>
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