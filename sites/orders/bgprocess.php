<?php

include('../../applications/dbaseconnection.php');

extract($_POST);
if($action_flag=='getEditData'){
    $query = "SELECT order_id, first_name, last_name, addresses, address2, city, postcode, states, phone_number, tracking_no FROM orders WHERE order_id='$order_id'";
    $result2 = mysqli_query($conn,$query);
    $json_array = array();
    $data = mysqli_fetch_assoc($result2);
        //$json_array[] = $data;
    
    
    //echo "<script type='text/javascript'>alert()</script>";
    echo json_encode($data);
//action to update tracking no
}else if($action_flag=='edit'){
    $query="UPDATE orders SET status='S', tracking_no='$tracking_no' WHERE order_id=$edit_order_id";

    if(mysqli_query($conn, $query)){
        echo "<script type='text/javascript'>window.location='orders.php'</script>";
    }else{
        $error = mysqli_error($conn);
        echo $error;
        // echo "<script type='text/javascript'>window.location='orders.php'</script>";
    }
//action to logout
}else if($action_flag=='logout'){
    session_start();
    session_destroy();
    session_unset();
    echo '<script language="javascript">';
    echo 'alert("Logout")';
    echo '</script>';
    echo "<script type='text/javascript'>window.location='../login/login.php'</script>";
//action to delete order
}else if($action_flag=='delete'){
    $query = "UPDATE orders SET status='D' WHERE order_id=$edit_order_id";
    $result = mysqli_query($conn,$query);
    if(mysqli_query($conn,$query)){
        $status=1;
    }else{
        $status=2;
    }
    echo $status;
}



?>