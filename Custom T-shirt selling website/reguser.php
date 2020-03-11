<?php
	session_start();
	
	require 'databaseConn.php';
	
	$name=$_POST['pName'];
	$email=$_POST['pEmail'];
	$mobile=$_POST['pMobile'];
	$pass=$_POST['pPassword'];
	$cpassword=$_POST['pCPassword'];
	
	$statement="select * from sign_in where email='$email'";
	
    $result = mysqli_query($conn, $statement);
    
	if (mysqli_num_rows($result) > 0)
    {
		echo "same";
	}
	else if($pass == $cpassword)
	{
		$statement = "insert into sign_in(password,name,email,access_id) values ('$pass','$name','$email','1')";
			
		if(mysqli_query($conn,$statement))
		{	
			$statement="select * from sign_in where email='$email'";
	
			$result = mysqli_query($conn, $statement);
			
			if (mysqli_num_rows($result) > 0)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$_SESSION['name']=$row['name'];
					$_SESSION['email']=$row['email'];
					$_SESSION['id']=$row['sign_id'];
					$_SESSION['access_id']=$row['access_id'];
					$login = true;
					
					$id=$_SESSION['id'];
					
					$statement = "insert into customer(customer_id) values ($id)";
					if(mysqli_query($conn,$statement))
					{
						echo "success";
						continue;
					}
				}
			}
		}
		else
			echo "Registration failed";
	}
	else
	{
		echo "Registration failed";
	}
 
?>