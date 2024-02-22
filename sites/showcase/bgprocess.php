<?php
include('../../applications/dbaseconnection.php');
extract($_POST);

// Create new order and update product quantity
$query = "INSERT INTO orders(product_id, product_qty, subtotal, user_id, email, first_name, last_name, addresses, address2, city, postcode, states, phone_number) VALUES ('$product_id', '$product_qty', '$subtotal', '$user_id', '$email', '$fname', '$lname', '$address', '$address2', '$city', '$postcode', '$state', '$phone')";
$query2 = "UPDATE product SET product_qty=product_qty-$product_qty WHERE product_id={$product_id}";
if(mysqli_query($conn,$query)&&mysqli_query($conn,$query2)){
    echo "<script type='text/javascript'>window.location='confirmation.php'</script>";
}else{
    $error = mysqli_error($conn);
    echo $error;
}
?>