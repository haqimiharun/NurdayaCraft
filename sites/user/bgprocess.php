<?php
extract($_POST);
include('../../applications/dbaseconnection.php');

if($action_flag=='getEditData'){
    $query = "SELECT a.user_id, b.user_type_name, a.user_name, a.user_email, a.user_status FROM user a, user_type b WHERE user_id='$user_id' AND a.user_type_id = b.user_type_id";
    $result2 = mysqli_query($conn,$query);
    $json_array = array();
    $data = mysqli_fetch_assoc($result2);
        //$json_array[] = $data;
    
    
    //echo "<script type='text/javascript'>alert()</script>";
    echo json_encode($data);

//action for add product to database
}else if($action_flag=='add'){
    //if product contain promotion
    
    $query = "INSERT INTO user (user_name, user_email, user_password, user_status, user_type_id) VALUES ('$user_name', '$user_email', '$user_password', 'Y', '1')";
    
    if(mysqli_query($conn, $query)){
        echo "<script type='text/javascript'>window.location='category.php'</script>";
    }else{
        $error = mysqli_error($conn);
        echo $error;
        //echo "<script type='text/javascript'>alert($error)</script>";
        echo "<script type='text/javascript'>window.location='user.php'</script>";
    }
//action to edit product
}else if($action_flag=='edit'){
    if($edit_user_password==''){
        $query="UPDATE user SET user_name='$edit_user_name', user_email='$edit_user_email', user_status='$edit_user_status' WHERE user_id='$edit_user_id'";
    }else{
        $query="UPDATE user SET user_name='$edit_user_name', user_email='$edit_user_email', user_status='$edit_user_status', user_password='$edit_user_password' WHERE user_id='$edit_user_id'";
    }
    if(mysqli_query($conn, $query)){
        echo "<script type='text/javascript'>window.location='user.php'</script>";
    }else{
        echo "<script type='text/javascript'>alert(mysqli_error($conn))</script>";
        echo "<script type='text/javascript'>window.location='user.php'</script>";
    }


}else if($action_flag=='logout'){

    session_start();
    session_destroy();
    session_unset();
    echo '<script language="javascript">';
    echo 'alert("Logout")';
    echo '</script>';
    echo "<script type='text/javascript'>window.location='../login/login.php'</script>";

//Delete user
}else if($action_flag=='delete'){
    $status='';
    $query="UPDATE user SET user_status='D' WHERE user_id='$user_id'";

    if(mysqli_query($conn,$query)){
        $status=1;
    }else{
        $status=2;
    }
    echo $status;
}else if($action_flag=='checkExist'){
    $status='';
    $query="SELECT 1 FROM user WHERE user_email LIKE '$email' AND user_status!='D'";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result)>0){
        $status=1;
    }else{
        $status=0;
    }
    echo $status;

}



?>