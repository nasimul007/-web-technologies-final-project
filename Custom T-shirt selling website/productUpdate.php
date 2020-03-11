<?php
session_start(); //start the PHP_session function 

include("databaseConn.php");

    if(isset($_GET['task']))
	{
		$task = $_GET['task'];
		$id = $_GET['id'];
		
		if($task == "update")
		{
			$productName = $_POST['pName'];
			$productPrice = $_POST['pPrice'];
			$productDetail = $_POST['pDetail'];
			$email = $_SESSION['email'];
		
			$statement = "update product set product_name='$productName',price='$productPrice',product_detail='$productDetail',added_by='$email' where product_id=$id";
			
			if(!$result = mysqli_query($conn,$statement))
			{
				echo "success";
				mysqli_error($conn);
			}
			else
			{
				header('location:admin.php?pol=1');
			
			}
		}
		else if($task == "delete")
		{
			$statement = "delete from product where product_id=$id";
			
			if(!$result = mysqli_query($conn,$statement))
			{
				echo "success";
				mysqli_error($conn);
			}
			else
			{
				header('location:admin.php?pol=1');
			
			}
		}
	}
?>









