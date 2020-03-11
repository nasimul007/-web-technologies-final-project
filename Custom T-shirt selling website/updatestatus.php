<?php
session_start(); //start the PHP_session function 

include("databaseConn.php");

	$id = $_GET['id'];

	$statement="update order_table set order_status='Completed' where order_id=$id";
		
	if(mysqli_query($conn, $statement))
	{
		echo "Updated info";
		header("location:admin.php");
	}
	else
	{
		echo "Update Failed";
	}
	mysqli_close($conn);
?>