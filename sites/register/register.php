<?php
include '../../applications/mainframe.php';

session_start();
if (isset($_SESSION['user_id'])) {
    echo "<script type='text/javascript'>window.location='../login/login.php'</script>";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Register Account</title>
        <script language="javascript" src="register.js"></script>
    </head>
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
                <a href="../login/login.php"><button type="submit" class="btn btn-primary registerButton">Sign In</button></a>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="row text-center"s>
                        <h1>Create Account</h1>
                    </div>
                    <form action="bgprocess.php" method="POST" name="registerForm" id="registerForm" class="needs-validation" autocomplete="off" novalidate>
                        <input type="hidden" value="register" name="action_flag" id="action_flag">
                        <div class="row">
                            USERNAME
                            <input type="text" id="username validationCustom01" name="username" class="form-control" required>
                        </div>
                        <div class="row">
                            EMAIL
                            <input type="email" id="email validationCustom02" name="email" class="form-control" required>
                        </div>
                        <div class="row">
                            PASSWORD
                            <input type="password" id="pwd" name="pwd" class="form-control" required>
                        </div>
                        <div class="row">
                            CONFIRMATION PASSWORD
                            <input type="password" id="pwd2" name="pwd2" class="form-control" required>
                            <!-- <div class="invalid-feedback">Password Does Not Match</div> -->
                        </div>
                        <div class="row py-4 ">
                            <div class="col-md-3 p-0">
                                <button type="submit" class="btn btn-secondary rounded-0 w-100" id="submitBtn" name="submitBtn">Register</button>
                            </div>
                            <div class="col-md-3 p-0">
                                <button type="button" class="btn btn-outline-dark rounded-0 w-100" id="loginBtn">Login</button>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                        </div>
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
                        <div class="center-block text-center" >
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