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
    <script language="javascript" src="product.js"></script>



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
    <a href="../orders/orders.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
      <span class="fs-4">Admin</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li>
        <a href="../orders/orders.php" class="nav-link text-white">
          <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"/></svg>
          Orders
        </a>
      </li>
      <li>
        <a href="product.php" class="nav-link text-white active">
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
            <h1>Products</h1>
        </div>
    </div>
    <div class="row">
      <div class="col-md-10">

      </div>
      <div class="col-md-2">
        <div class="row ">
          <button type="" class="btn justify-content-right" id="addBtn" name="addBtn">Add New Product</button>
        </div>
      </div>
    </div>
    <div class="row">
    <table id="datagrid" class="display" title="News List">
      <thead>
          <tr>
              <th>Edit</th>
              <th>Image</th>
              <th>Name</th>
              <th>Category</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Status</th>
          </tr>
      </thead>
      <tbody>
        <?php
        $query4 = "SELECT a.product_id, a.product_name, b.category_name, a.product_price, a.product_qty, CASE WHEN a.product_status='Y' THEN 'ACTIVE' ELSE 'INACTIVE' END status FROM product a, category b WHERE a.category_id=b.category_id AND a.product_status!='D'";
        $result4 = mysqli_query($conn,$query4);
        if(mysqli_num_rows($result4)>0){
          while($row2=mysqli_fetch_assoc($result4)){
            ?>
            <tr>
              <td><?php echo $row2["product_id"]?></td>
              <td></td>
              <td><?php echo $row2["product_name"]?></td>
              <td><?php echo $row2["category_name"]?></td>
              <td><?php echo $row2["product_price"]?></td>
              <td><?php echo $row2["product_qty"]?></td>
              <td><?php echo $row2["status"]?></td>
            </tr>
            <?php
          }
        }
        ?>
      </tbody>
    </table>
    </div>
  </div>
<?php
$query2 = "SELECT category_id, category_name FROM category WHERE category_status='y'";
$result2 = mysqli_query($conn,$query2);
?>
  <!-- Add Modal Form -->
  <div class="modal fade modal-lg" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
      <div class="modal-dialog" role="document">
        <div class="modal-content" >
            	<div class="modal-header">
                  <span class="modal-title" >Add New Product</span>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          		</div>
                <div class="modal-body">
                	<form action="bgprocess.php" name="addForm" id="addForm" method="post" class="needs-validation" enctype="multipart/form-data" novalidate autocomplete="off">
                      <input type="hidden" name="action_flag" value="add" />
                      <div class="container">
                        <div class="row">
                          <div class="col">Product Name</div>
                          <div class="col"><input type="text" class="input form-control" name="product_name" id="product_name" required></div>
                        </div>
                        <div class="row">
                          <div class="col">Product Description</div>
                          <div class="col"><textarea class="form-control" name="product_desc" id="product_desc" rows="5" required></textarea></div>
                        </div>
                        <div class="row">
                          <div class="col">Product Category</div>
                          <div class="col">
                            <select class="form-control" name="product_category" id="product_category" required>
                              <option selected disabled value="">Choose Category</option>
                              <?php
                              if(mysqli_num_rows($result2)>0){
                                while($row=mysqli_fetch_assoc($result2)){
                              ?>
                              <option value="<?php echo $row["category_id"]?>"><?php echo $row["category_name"]?></option>
                              <?php
                                }
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">Product Price</div>
                          <div class="col">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text form-control">RM</div>
                              </div>
                              <input type="tel" class="form-control" name="product_price" id="product_price" pattern="[0-9]+([\.][0-9]+)" required>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col">Promotion</div>
                          <div class="col">
                            <div class="row">
                            <div class="col-md-3">
                              <select class="form-control" name="product_promotion_type" id="product_promotion_type">
                                <option value=""></option>
                              <?php
                              $query3 = "SELECT promotion_id, promotion_type FROM promotion";
                              $result3 = mysqli_query($conn,$query3);
                              if(mysqli_num_rows($result3)>0){
                                while($row=mysqli_fetch_assoc($result3)){
                                  ?>
                                  <option value="<?php echo $row["promotion_id"]?>"><?php echo $row["promotion_type"]?></option>
                                  <?php
                                }
                              }
                              ?>
                              </select>
                            </div>
                            <div class="col-md-9"><input type="tel" class="form-control" name="promotion_rate" id="promotion_rate" pattern="[0-9]+" disabled></div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">Quantity</div>
                          <div class="col"><input type="number" step="1" min="1" value="10" max="100" id="product_qty" name="product_qty" class="form-control"></div>
                        </div>
                        <div class="row">
                          <div class="col">Status</div>
                          <div class="col">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="product_status" id="flexRadioDefault1" value="Y" checked>
                            <label class="form-check-label" for="flexRadioDefault1">
                              Active
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="product_status" id="flexRadioDefault2" value="N">
                            <label class="form-check-label" for="flexRadioDefault2">
                              Deactivate
                            </label>
                          </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">Images</div>
                          <div class="col"><input type="file" id="product_image" name="product_image" accept="image/png, image/gif, image/jpeg" required></div>
                        </div>
                      </div>
                      
                    </form>
                </div>
                
                 	<div class="modal-footer">
            			<button type="button" class="btn btn-primary" id="addSaveBtn"  data-toggle="confirmation">Save</button>
            			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          			</div>
            </div>
        </div>
    </div>

    <!-- Edit Modal Form -->
    <div class="modal fade modal-lg" id="edit_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false" autocomplete="off">
      <div class="modal-dialog" role="document">
        <div class="modal-content" >
            	<div class="modal-header">
                  <span class="modal-title" >Edit Product</span>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          		</div>
                <div class="modal-body">
                	<form action="bgprocess.php" name="editForm" id="editForm" method="post" class="edit-needs-validation" enctype="multipart/form-data" novalidate>
                      <input type="hidden" name="action_flag" value="edit" />
                      <input type="hidden" name="edit_product_id" id="edit_product_id"/>
                      <div class="container">
                        <div class="row">
                          <div class="col">Product Name</div>
                          <div class="col"><input type="text" class="input form-control" name="edit_product_name" id="edit_product_name" required></div>
                        </div>
                        <div class="row">
                          <div class="col">Product Description</div>
                          <div class="col"><textarea class="form-control" name="edit_product_desc" id="edit_product_desc" rows="5" required></textarea></div>
                        </div>
                        <div class="row">
                          <div class="col">Product Category</div>
                          <div class="col">
                            <select class="form-control" name="edit_product_category" id="edit_product_category" required>
                              <option selected disabled value="">Choose Category</option>
                              <?php
                              $query3 = "SELECT category_id, category_name FROM category WHERE category_status='y'";
                              $result3 = mysqli_query($conn,$query3);
                              if(mysqli_num_rows($result3)>0){
                                while($row=mysqli_fetch_assoc($result3)){
                              ?>
                              <option value="<?php echo $row["category_id"]?>"><?php echo $row["category_name"]?></option>
                              <?php
                                }
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">Product Price</div>
                          <div class="col">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text form-control">RM</div>
                              </div>
                              <input type="tel" class="form-control" name="edit_product_price" id="edit_product_price" pattern="[0-9]+([\.][0-9]+)" required>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col">Promotion</div>
                          <div class="col">
                            <div class="row">
                            <div class="col-md-3">
                              <select class="form-control" name="edit_product_promotion_type" id="edit_product_promotion_type">
                                <option value=""></option>
                              <?php
                              $query5 = "SELECT promotion_id, promotion_type FROM promotion";
                              $result5 = mysqli_query($conn,$query5);
                              if(mysqli_num_rows($result5)>0){
                                while($row=mysqli_fetch_assoc($result5)){
                                  ?>
                                  <option value="<?php echo $row["promotion_id"]?>"><?php echo $row["promotion_type"]?></option>
                                  <?php
                                }
                              }
                              ?>
                              </select>
                            </div>
                            <div class="col-md-9"><input type="tel" class="form-control" name="edit_promotion_rate" id="edit_promotion_rate" pattern="[0-9]+" disabled></div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">Quantity</div>
                          <div class="col"><input type="number" step="1" min="1" max="100" id="edit_product_qty" name="edit_product_qty" class="form-control"></div>
                        </div>
                        <div class="row">
                          <div class="col">Status</div>
                          <div class="col">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="edit_product_status" id="edit_flexRadioDefault1" value="Y">
                            <label class="form-check-label" for="edit_flexRadioDefault1">
                              Active
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="edit_product_status" id="edit_flexRadioDefault2" value="N">
                            <label class="form-check-label" for="edit_flexRadioDefault2">
                            Deactivate
                            </label>
                          </div>
                          </div>
                        </div>
                      </div>
                      
                    </form>
                </div>
                
                 	<div class="modal-footer">
            			<button type="button" class="btn btn-primary" id="editSaveBtn"  data-toggle="confirmation">Save</button>
                  <button type="button" class="btn btn-danger" id="deleteProduct"  data-toggle="confirmation">Delete</button>
            			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          			</div>
            </div>
        </div>
    </div>
    <!-- Edit Image Modal -->
    <div class="modal fade modal-lg" id="edit_image_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false" autocomplete="off">
      <div class="modal-dialog" role="document">
        <div class="modal-content" >
            	<div class="modal-header">
                  <span class="modal-title" >Edit Product Image</span>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          		</div>
                <div class="modal-body">
                	<form action="bgprocess.php" name="editImageForm" id="editImageForm" method="post" class="edit-image-needs-validation" enctype="multipart/form-data" novalidate>
                      <input type="hidden" name="action_flag" value="edit_image" />
                      <input type="hidden" name="edit_image_product_id" id="edit_image_product_id"/>
                      <div class="container">
                        <div class="row">
                          <div class="col">Product Name</div>
                          <div class="col"><input type="text" class="input form-control" name="edit_image_product_name" id="edit_image_product_name" disabled></div>
                        </div>
                        <div class="row">
                          <div class="col">Images</div>
                          <div class="col"><input type="file" id="edit_product_image" name="edit_product_image" accept="image/png, image/gif, image/jpeg" required></div>
                        </div>
                    </form>
                </div>
                <div class="row"><img class="img-fluid w-50 rounded" id="preview_image"></div>
                
                 	<div class="modal-footer">
            			<button type="button" class="btn btn-primary" id="editImageSaveBtn"  data-toggle="confirmation">Save</button>
                  <button type="button" class="btn btn-danger" id="deleteImageProduct"  data-toggle="confirmation">Delete</button>
            			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          			</div>
            </div>
        </div>
    </div>

  

  

  
    
</main>
  </body>
</html>
