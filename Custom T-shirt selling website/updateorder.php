<?php
session_start(); //start the PHP_session function 

include("databaseConn.php");

    if(!empty($_SESSION["shopping_cart"]))
	{
		$total = 0;
		$eachtotal = 0;
		$cartid = $_SESSION['cart_id'];
		
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			
			echo $id = $values["item_id"]; 
			echo $quantity = $values["item_quantity"];
			echo $size = $values["item_size"];
			echo $eachtotal = $values["item_quantity"] * $values["item_price"];
			
			$statement="insert into shopping_cart(cart_id,item_id,item_quantity,item_size,total_cost) values ('$cartid',$id,$quantity,'$size',$eachtotal)";
			
			if(mysqli_query($conn, $statement))
				echo "Updated";
			else
				echo "Update Failed";
			
			$total = $total + ($values["item_quantity"] * $values["item_price"]);
		
		}
		
		echo $id = $_POST['hidden_id'];
		echo $address = $_POST['cAddress'];
		
		
		$statement="insert into order_table(order_status,cart_id,cost,address,customer_id) values ('Ordered','$cartid',$total,'$address',$id)";
		
		
		
		if(mysqli_query($conn, $statement))
		{
			echo "Updated";
			unset($_SESSION["shopping_cart"]);
			header("location:admin.php");
		}
		else
			echo "Update Failed";
		
		mysqli_close($conn);
		
		
	}
?>









