<?php
define("DATABASE_HOST", "localhost");
define("DATABASE_USER", "root");

$conn = mysqli_connect(DATABASE_HOST, DATABASE_USER);

if (mysqli_connect_errno()){
	echo "Failed to connect to database : ". mysqli_connect_error();
}

mysqli_select_db($conn,"Nurdaya") or die("Could not opened product database");

date_default_timezone_set('Asia/Kuala_Lumpur');
?>