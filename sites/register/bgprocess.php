<?php
include('../../applications/mainframe.php');
extract($_POST);

//action for insert data to db
if($action_flag=='register'){
    $query = "INSERT INTO user (user_type_id, user_name, user_email, user_password, user_status) VALUES ('2', '$username', '$email', '$pwd', 'Y')";

    if(mysqli_query($conn, $query)){
        echo "<script type='text/javascript'>window.location='../login/login.php'</script>";
    }else{
        echo "Error : " . $query. "<br>" . mysqli_error($conn);
    }
}

?>