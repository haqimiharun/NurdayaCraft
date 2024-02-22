<?php
include('../../applications/mainframe.php');
extract($_POST);

//action for login
if($action_flag=='login'){
    //echo '<script>alert("Login")</script>';

    $query = "SELECT a.user_type_id, a.user_name, a.user_id FROM user a, user_type b WHERE a.user_type_id=b.user_type_id AND a.user_name='$username' AND a.user_password='$password' AND a.user_status='Y'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result)==1){
        session_start();
        while($row=mysqli_fetch_assoc($result)){
            $_SESSION["user_type"] = $row["user_type_id"];
            $_SESSION["user_name"] = $row["user_name"];
            $_SESSION["user_id"] = $row["user_id"];
            if($row["user_type_id"]==1){
                echo "<script type='text/javascript'>window.location='../orders/orders.php'</script>";
            }else if($row["user_type_id"]==2){
                echo "<script type='text/javascript'>window.location='../../'</script>";
            }else{
                echo '<script language="javascript">';
                echo 'alert("Login Successfully")';
                echo '</script>';
                echo "<script type='text/javascript'>window.location='login.php'</script>";
            }
        }
        
        
        
    }else{
        echo "<script type='text/javascript'>window.location='login.php?status=f'</script>";
    }
}elseif($action_flag=='logout'){

    session_start();
    session_destroy();
    session_unset();
    echo '<script language="javascript">';
    echo 'alert("Logout")';
    echo '</script>';
    echo "<script type='text/javascript'>window.location='login.php'</script>";
}
?>