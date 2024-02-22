<?php
include '../../applications/mainframe.php';
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
    <title>Checkout</title>
    <script language="javascript" src="checkout.js"></script>
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
        <?php
            extract($_POST);
            $total = $product_price*$product_qty;
            $total = number_format((float)$total,2,'.','');
        ?>
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
            
            <div class="container pt-5">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row py-5">
                            <h3>Shipping Address</h3>
                        </div>
                        <!-- Shipping Address Form -->
                        <form action="bgprocess.php" method="post" name="checkout" id="checkout" class="needs-validation" novalidate>
                            <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id ?>">
                            <input type="hidden" id="product_qty" name="product_qty" value="<?php echo $product_qty ?>">
                            <input type="hidden" id="subtotal" name="subtotal" value="<?php echo $total ?>">
                            <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                            <div class="row py-1">
                                <div class="col">
                                    <input type="email" class="form-control" placeholder="Email" id="email validationCustom01" name="email" required>
                                </div>
                            </div>
                            <div class="row py-1">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="First Name" id="fname validationCustom02" name="fname" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Last Name" id="lname validationCustom03" name="lname" required>
                                </div>
                            </div>
                            <div class="row py-1">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Address" id="address validationCustom04" name="address" required>
                                </div>
                            </div>
                            <div class="row py-1">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Apartment, suite, etc (optional)" id="address2" name="address2">
                                </div>
                            </div>
                            <div class="row py-1">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="City" id="city validationCustom0" name="city" required>
                                </div>
                            </div>
                            <div class="row py-1">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Postcode" id="postcode validationCustom05" name="postcode" pattern="[0-9]*" required>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" id="state validationCustom06" name="state" required>
                                        <option value="" >Select State</option>
                                        <option value="Johor" >Johor</option>
                                        <option value="Kedah" >Kedah</option>
                                        <option value="Kelantan" >Kelantan</option>
                                        <option value="Malacca" >Malacca</option>
                                        <option value="Negeri Sembilan" >Negeri Sembilan</option>
                                        <option value="Pahang" >Pahang</option>
                                        <option value="Penang" >Penang</option>
                                        <option value="Perlis" >Perlis</option>
                                        <option value="Sabah" >Sabah</option>
                                        <option value="Sarawak" >Sarawak</option>
                                        <option value="Selangor" >Selangor</option>
                                        <option value="Terengganu" >Terengganu</option>
                                        <option value="W.P. Kuala Lumpur" >W.P. Kuala Lumpur</option>
                                        <option value="W.P. Labuan" >W.P. Labuan</option>
                                        <option value="W.P. Putrajayaa" >W.P. Putrajayaa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row py-1">
                                <div class="col">
                                    <input type="tel" class="form-control" placeholder="Phone Number" id="phone validationCustom07" name="phone" required>
                                </div>
                            </div>
                            <div class="row py-5">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary" id="checkoutBtn" name="checkoutBtn">Checkout</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class="row py-5">
                            <h3>Product Detail</h3>
                        </div>
                        <!-- Display Product Detail Information -->
                        <div class="row py-1">
                            <div class="col-md-6">
                        <?php
                            $query = "SELECT product_image, product_name FROM product WHERE product_id={$product_id}";
                            $result = mysqli_query($conn, $query);
                            while($rows=mysqli_fetch_assoc($result)){
                                if ($rows["product_image"]!=''){
                                ?>
                                    <img src="../product/uploads/<?php echo $rows["product_image"] ?>" class="" width="150px" style="border-radius: 10px;">
                                <?php
                                }else{
                                    ?>
                                    <img src="../../images/image-not-found-icon.png" width="150px" style="border-radius: 10px;">
                                    <?php
                                }
                                ?>
                            </div>
                                <div class="col-md-6">
                                    <div class="row py-2">
                                        <h4><?php echo $rows["product_name"] ?></h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            Price:
                                        </div>
                                        <div class="col-md-6">
                                            RM <?php echo $product_price ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            Quantity: 
                                        </div>
                                        <div class="col-md-6">
                                            <?php echo $product_qty ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            Total:
                                        </div>
                                        <div class="col-md-6">
                                            RM <?php echo $total ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                            
                        
                            
                        </div>
                    </div>
                </div>
            </div>
                
            
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