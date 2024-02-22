<?php
include('../../applications/mainframe.php');
extract($_POST);
if($action_flag=='logout'){

    session_start();
    session_destroy();
    session_unset();
    echo '<script language="javascript">';
    echo 'alert("Logout")';
    echo '</script>';
    echo "<script type='text/javascript'>window.location='index.php'</script>";
}
?>