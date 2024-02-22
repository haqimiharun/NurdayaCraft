<?php 
include '../../applications/mainframe.php';
session_start();
?>
<!DOCTYPE html>
<html>
    <header>
    <title>Login</title>
        <script language="javascript" src="login.js"></script>
    </header>
    <body>
        <main>
        <div class="navbar"> 
            <a href="../../" style="font-family: 'Sulphur Point', sans-serif; text-decoration: none; color: #4D4D4D; font-size:32 ;">NurDaya Store</a>
            <div class="NavBarOption">
                <a href="../../" style="margin-right: 10px;">Home</a>
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
            </form></div>
            <div>
                <a href="#"><img src="../../images/bookmark.png" width="25px"></a>
                <a href="#"><img src="../../images/cart.png" width="25px"></a>
                <button type="submit" class="btn btn-primary registerButton">Sign In</button>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="row text-center"><h1>Login</h1></div>
                    <form action="bgprocess.php" method="post" class="needs-validation" novalidate>
                        <input type="hidden" value="login" name="action_flag" id="action_flag">
                        <div class="row">
                            Username
                            <input type="text" class="form-control" id="username validationCustom01" name="username" required>
                        </div>
                        <div class="row">
                            Password
                            <input type="password" class="form-control" id="password validationCustom02" name="password" required>
                        </div>
                        <?php
                        if(isset($_GET['status'])){
                            ?>
                        <div style="color: #C50808;">Wrong username or password</div>

                        <?php
                        }
                        ?>
                        <div class="row py-4 ">
                            <div class="col-md-3 p-0">
                                <button type="submit" class="btn btn-secondary rounded-0 w-100" id="submitBtn" name="submitBtn">Submit</button>
                            </div>
                            <div class="col-md-3 p-0">
                                <a href="../register/register.php" class="btn btn-outline-dark rounded-0 w-100">Register</a>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                        </div>
                        <?php
                        if (isset($_SESSION['user_id'])) {
                            ?>
                        <a href="" id="logoutBtn">Logout</a>
                        <?php
                        }
                        ?>
                        <br>
                        <?php
                        if (isset($_SESSION['user_id'])) {
                            echo $_SESSION['user_type'];
                            echo $_SESSION['user_name'];
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>

        </main>
        <footer class="site-footer fixed-bottom bg-lighter" style="height: 300px;">
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
        <script>
        </script>
    </body>
</html>