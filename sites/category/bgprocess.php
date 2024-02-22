<?php

include('../../applications/dbaseconnection.php');

extract($_POST);
if($action_flag=='getEditData'){
    $query = "SELECT category_id, category_name, category_status FROM category WHERE category_id='$category_id'";
    $result2 = mysqli_query($conn,$query);
    $json_array = array();
    $data = mysqli_fetch_assoc($result2);
    
    
    //echo "<script type='text/javascript'>alert()</script>";
    echo json_encode($data);

//action for add product to database
}else if($action_flag=='add'){
    //if product contain promotion
    
    $query = "INSERT INTO category(category_name, category_status) VALUES ('$category_name','$category_status')";
    
    if(mysqli_query($conn, $query)){
        echo "<script type='text/javascript'>window.location='category.php'</script>";
    }else{
        $error = mysqli_error($conn);
        echo $error;
        //echo "<script type='text/javascript'>alert($error)</script>";
        echo "<script type='text/javascript'>window.location='category.php'</script>";
    }

//action to edit product
}else if($action_flag=='edit'){
    $query="UPDATE category SET category_name='$edit_category_name',category_status='$edit_category_status' WHERE category_id='$edit_category_id'";

    if(mysqli_query($conn, $query)){
        echo "<script type='text/javascript'>window.location='category.php'</script>";
    }else{
        echo "<script type='text/javascript'>alert(mysqli_error($conn))</script>";
        echo "<script type='text/javascript'>window.location='product.php'</script>";
    }

//action to delete product
}else if($action_flag=='delete'){
    $status='';
    $query="UPDATE category SET category_status='D' WHERE category_id='$category_id'";

    if(mysqli_query($conn,$query)){
        $status=1;
    }else{
        $status=2;
    }
    echo $status;
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
    $query="SELECT 1 FROM category WHERE category_name LIKE '$name' AND category_status!='D'";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result)>0){
        $status=1;
    }else{
        $status=0;
    }
    echo $status;

}



?>