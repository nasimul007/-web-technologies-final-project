<?php
session_start();
	//connect to data base 
	require 'databaseConn.php';
	
	
	// requires php5
	define('UPLOAD_DIR', 'images/');
	$img = $_POST['image'];
	$x=$img;
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = UPLOAD_DIR . uniqid() . '.png';

	$success = file_put_contents($file, $data);
	 $success ? $file : 'Unable to save the file.';
				$email=$_SESSION['email'];
		$productPrice = $_POST['price'];
	//$ProductImage = file_get_contents($file);
	$ProductImage = addslashes(file_get_contents($file));
	$statement = "insert into product(price,image,added_by) values ('$productPrice','$ProductImage','$email')";
		if(!$result = mysqli_query($conn,$statement))
			{
				//echo "problem";
				mysqli_error($conn);
			}
			else
			{
				$statement="select * from product order by product_id desc limit 1";
				$result = mysqli_query($conn, $statement);
				
				$id=0;
				
				if (mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_assoc($result))
							{
								$id=$row['product_id'];
								
							}
						}
						else
						{
							echo "Nothing found in db";
						}
						mysqli_close($conn);
				header("location:singleview.php?id=".$id);
			}
?>