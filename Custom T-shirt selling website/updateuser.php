<?php
session_start(); //start the PHP_session function 

include("databaseConn.php");

	$id = $_SESSION['id'];
	
    $name = $_POST['name'];
    $email = $_POST['email'];
	$pass = $_POST['pass'];
	$npass = $_POST['npass'];
	
	if($pass == $_SESSION['pass'])
	{
		$statement="update sign_in set name='$name', email='$email', password='$npass' where sign_id=$id";
		
		if(mysqli_query($conn, $statement))
		{
			echo "Updated info";
		}
		else
		{
			echo "Update Failed";
		}
		mysqli_close($conn);
	}
	else
		echo "Password missmatch";
?>