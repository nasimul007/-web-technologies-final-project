<?php
session_start(); //start the PHP_session function 

include("databaseConn.php");

    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
	$code = $_POST['code'];
	$id = $_SESSION['id'];
	
	$statement="update customer set contact='$mobile', address='$address', postal_code='$code' where customer_id=$id";
	
    if(mysqli_query($conn, $statement))
    {
		echo "Updated";
    }
    else
    {
        echo "Update Failed";
	}
    mysqli_close($conn);
?>