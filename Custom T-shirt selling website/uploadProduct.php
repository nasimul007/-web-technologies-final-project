<?php
session_start();
	//connect to data base 
	require 'databaseConn.php';
	
	//file properties
	if(isset($_FILES['image']))
	{
		$productName = $_POST['pName'];
		$productPrice = $_POST['pPrice'];
		$productDetail = $_POST['pDetail'];
		$name = $_SESSION['name'];
		
		$productImage = addslashes(file_get_contents($_FILES['image']['tmp_name']));
		$image_size = getimagesize($_FILES['image']['tmp_name']); 
		
		if ($image_size == False) //to check if it is image or not
			echo "That is not an image";
		else
		{
			$statement = "insert into product(product_name,price,product_detail,image,added_by) values ('$productName','$productPrice','$productDetail','$productImage','$name')";
			
			if(!$result = mysqli_query($conn,$statement))
			{
				echo "problem";
				mysqli_error($conn);
			}
			else
			{
				header('location:admin.php');
			}
		}
	}
	else
	{
		echo "Please select an image";
	}
?>