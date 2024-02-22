<?php

include('../../applications/dbaseconnection.php');
extract($_POST);

if($action_flag=='getEditData'){
    $query = "SELECT a.product_id, a.product_name, a.product_description, a.category_id, a.product_price, (CASE WHEN ISNULL(a.promotion_id)THEN '' ELSE (SELECT promotion_id FROM promotion WHERE a.promotion_id=promotion_id)END) AS promotion_type, (CASE WHEN ISNULL(a.promotion_id)THEN '' ELSE (SELECT a.promotion_rate FROM promotion WHERE a.promotion_id=promotion_id)END) AS rate, a.product_qty, a.product_status FROM product a, category b WHERE b.category_id=a.category_id AND a.product_id='$product_id'";
    $result2 = mysqli_query($conn,$query);
    $json_array = array();
    $data = mysqli_fetch_assoc($result2);
        //$json_array[] = $data;
    
    
    //echo "<script type='text/javascript'>alert()</script>";
    echo json_encode($data);

//action for add product to database
}else if($action_flag=='add'){
    $targetDir = "uploads/";
    $fileName = basename($_FILES["product_image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    //if product contain promotion
    if(move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFilePath)){
        if($product_promotion_type==''){
            $query = "INSERT INTO product (category_id, product_name, product_description, product_price, product_qty, product_status, product_image) VALUES ('$product_category', '$product_name', '$product_desc', '$product_price', '$product_qty', '$product_status','".$fileName."')";
        }else{
            $query = "INSERT INTO product (category_id, promotion_id, promotion_rate, product_name, product_description, product_price, product_qty, product_status, product_image) VALUES ('$product_category', '$product_promotion_type', '$promotion_rate', '$product_name', '$product_desc', '$product_price', '$product_qty', '$product_status','".$fileName."')";
        }
    }else{
        echo "<script type='text/javascript'>alert('Sorry, there was an error uploading your file.')</script>";
    }

    if(mysqli_query($conn, $query)){
        echo "<script type='text/javascript'>window.location='product.php'</script>";
    }else{
        $error = mysqli_error($conn);
        echo $error;
        //echo "<script type='text/javascript'>alert($error)</script>";
        echo "<script type='text/javascript'>window.location='product.php'</script>";
    }

//action to edit product
}else if($action_flag=='edit'){
    if($edit_product_promotion_type==''){
        $query="UPDATE product SET category_id='$edit_product_category', product_name='$edit_product_name', product_description='$edit_product_desc', product_price='$edit_product_price', product_qty='$edit_product_qty', product_status='$edit_product_status', promotion_id='', promotion_rate='' WHERE product_id='$edit_product_id'";
    }else{
        $query="UPDATE product SET category_id='$edit_product_category', product_name='$edit_product_name', product_description='$edit_product_desc', product_price='$edit_product_price', product_qty='$edit_product_qty', product_status='$edit_product_status', promotion_id='$edit_product_promotion_type', promotion_rate='$edit_promotion_rate' WHERE product_id='$edit_product_id'";
    }

    if(mysqli_query($conn, $query)){
        $query2 = "SELECT MAX(product_id) AS latest FROM product";
        $result = mysqli_query($conn,$query2);
        $product_id = mysqli_fetch_assoc($result)["latest"];
        echo "<script type='text/javascript'>window.location='product.php'</script>";
        //echo "<script type='text/javascript'>alert($product_id)</script>";
    }else{
        echo "<script type='text/javascript'>alert(mysqli_error($conn))</script>";
        echo "<script type='text/javascript'>window.location='product.php'</script>";
    }

//action to delete product
}else if($action_flag=='delete'){
    $status='';
    $query="UPDATE product SET product_status='D' WHERE product_id='$product_id'";

    if(mysqli_query($conn,$query)){
        $status=1;
    }else{
        $status=2;
    }
    echo $status;
}else if($action_flag=='getImage'){
    $query = "SELECT product_id, product_name, product_image FROM product WHERE product_id='$product_id'";
    $result2 = mysqli_query($conn,$query);
    if(mysqli_query($conn,$query)){
        $data = mysqli_fetch_assoc($result2);
        echo json_encode($data);
    }
}else if($action_flag=='deleteImage'){
    $status='';
    $query = "UPDATE product SET product_image='' WHERE product_id='$product_id'";
    if (mysqli_query($conn,$query)){
        $status=1;
    }else{
        $status=mysqli_error($conn);
    }
    echo $status;
}else if($action_flag=='edit_image'){
    $status='';
    $targetDir = "uploads/";
    $fileName = basename($_FILES["edit_product_image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    if(move_uploaded_file($_FILES["edit_product_image"]["tmp_name"], $targetFilePath)){
        $query="UPDATE product SET product_image='".$fileName."' WHERE product_id='$edit_image_product_id'";
    }else{
        $status='Images cannot be saved to files';
    }
    if(mysqli_query($conn,$query)){
        echo "<script type='text/javascript'>window.location='product.php'</script>";
    }else{
        echo mysqli_error($conn);
    }
}else if($action_flag=='logout'){

    session_start();
    session_destroy();
    session_unset();
    echo '<script language="javascript">';
    echo 'alert("Logout")';
    echo '</script>';
    echo "<script type='text/javascript'>window.location='../login/login.php'</script>";
}else if($action_flag=='checkExist'){
    $status='';
    $query="SELECT 1 FROM product WHERE product_name='$name' AND product_status!='D'";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result)>0){
        $status=1;
    }else{
        $status=0;
    }
    echo $status;

}



?>