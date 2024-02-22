<?php
    include '../../applications/mainframe.php';
    session_start();
    if (!isset($_SESSION['user_id'])) {
        echo "<script type='text/javascript'>window.location='../login/login.php'</script>";
    }
    
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Seller Page</title>
    <script language="javascript" src="orders.js"></script>



    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>

    
    <!-- Custom styles for this template -->
  </head>
  <body>
    


<main class="d-flex flex-nowrap">
    <!-- Sidebar Navigation -->
  <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;">
    <a href="" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
      <span class="fs-4">Admin</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li>
        <a href="#" class="nav-link text-white active">
          <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"/></svg>
          Orders
        </a>
      </li>
      <li>
        <a href="../product/product.php" class="nav-link text-white">
          <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#grid"/></svg>
          Products
        </a>
      </li>
      <li>
        <a href="../user/user.php" class="nav-link text-white">
          <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"/></svg>
          User
        </a>
      </li>
      <li>
        <a href="../category/category.php" class="nav-link text-white">
          <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg>
          Category
        </a>
      </li>
    </ul>
    <hr>
    <div class="dropdown">
      <?php
      $user=$_SESSION['user_id'];
      $query = "SELECT UPPER(user_name) AS name FROM `user` WHERE user_id=$user";
      $result = mysqli_query($conn, $query);
      if (mysqli_num_rows($result)==1){
        
      ?>
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <strong><?php echo mysqli_fetch_assoc($result)["name"];}?></strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
        <li><a class="dropdown-item" href="#">Profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" id="signOutBtn" href="">Sign out</a></li>
      </ul>
    </div>
  </div>

  <div class="b-example-divider b-example-vr"></div>

  <div class="container pt-5">
    <div class="row">
        <div class="col">
            <h1>Orders</h1>
        </div>
    </div>
    <div class="row">
      <div class="col-md-10">

      </div>
    </div>
    <div class="row">
    <table id="datagrid" class="display" title="News List">
      <thead>
          <tr>
              <th>Edit</th>
              <th>Product Name</th>
              <th>Product Category</th>
              <th>Quantity</th>
              <th>Subtotal</th>
              <th>Customer</th>
              <th>Status</th>
          </tr>
      </thead>
      <tbody>
        <?php
        $query4 = "SELECT a.order_id, b.product_name, c.category_name, a.subtotal, a.product_qty, CASE WHEN a.user_id=0 THEN 'Guest' ELSE (SELECT c.user_name FROM user c WHERE a.user_id=c.user_id) END AS 'Buyer', CASE WHEN a.status='P' THEN 'Pending' WHEN a.status='S' THEN 'Shipped' END AS Status FROM orders a, product b, category c WHERE a.product_id=b.product_id AND b.category_id=c.category_id AND a.status!='D'";
        $result4 = mysqli_query($conn,$query4);
        if(mysqli_num_rows($result4)>0){
          while($row2=mysqli_fetch_assoc($result4)){
            ?>
            <tr>
              <td><?php echo $row2["order_id"]?></td>
              <td><?php echo $row2["product_name"]?></td>
              <td><?php echo $row2["category_name"]?></td>
              <td><?php echo $row2["product_qty"]?></td>
              <td>RM <?php echo $row2["subtotal"]?></td>
              <td><?php echo $row2["Buyer"]?></td>
              <td><?php echo $row2["Status"]?></td>
            </tr>
            <?php
          }
        }
        ?>
      </tbody>
    </table>
    </div>
  </div>

    <!-- Edit Modal Form -->
    <div class="modal fade modal-lg" id="edit_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
      <div class="modal-dialog" role="document">
        <div class="modal-content" >
            	<div class="modal-header">
                  <span class="modal-title" >Edit Product</span>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          		</div>
                <div class="modal-body">
                	<form action="bgprocess.php" name="editForm" id="editForm" method="post" class="edit-needs-validation" enctype="multipart/form-data" novalidate autocomplete="off">
                      <input type="hidden" name="action_flag" value="edit" />
                      <input type="hidden" name="edit_order_id" id="edit_order_id"/>
                      <div class="container">
                        <div class="row">
                          <div class="col">Customer Name</div>
                          <div class="col">
                            <input type="text" class="input form-control" name="fname" id="fname" disabled>
                          </div>
                          <div class="col">
                            <input type="text" class="input form-control" name="lname" id="lname" disabled>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">Customer Address</div>
                          <div class="col-8"><input type="text" class="input form-control" name="addresses" id="addresses" disabled></div>
                        </div>
                        <div class="row">
                          <div class="col"></div>
                          <div class="col-8"><input type="text" class="input form-control" name="address2" id="address2" disabled></div>
                        </div>
                        <div class="row">
                          <div class="col"></div>
                          <div class="col-8"><input type="text" class="input form-control" name="city" id="city" disabled></div>
                        </div>
                        <div class="row">
                          <div class="col"></div>
                          <div class="col"><input type="text" class="input form-control" name="postcode" id="postcode" disabled></div>
                          <div class="col"><input type="text" class="input form-control" name="state" id="state" disabled></div>
                        </div>
                        <div class="row">
                          <div class="col">Customer Phone No.</div>
                          <div class="col-8"><input type="text" class="input form-control" name="phone_no" id="phone_no" disabled></div>
                        </div>
                        <div class="row">
                          <div class="col">Tracking No</div>
                          <div class="col-8"><input type="text" class="input form-control" name="tracking_no" id="tracking_no" required></div>
                        </div>
                      </div>
                    </form>
                </div>
                
                 	<div class="modal-footer">
            			<button type="button" class="btn btn-primary" id="editSaveBtn"  data-toggle="confirmation">Save</button>
                  <button type="button" class="btn btn-danger" id="deleteOrder"  data-toggle="confirmation">Delete</button>
            			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          			</div>
            </div>
        </div>
    </div>

  

  

  
    
</main>
  </body>
</html>
