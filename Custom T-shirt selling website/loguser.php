<?php
session_start(); //start the PHP_session function 

include("databaseConn.php");

    $email = $_POST['pEmail'];
	$pass = $_POST['pPassword'];
	
	$statement="select * from sign_in where email='$email'";
	
    $result = mysqli_query($conn, $statement);
    if (mysqli_num_rows($result) > 0)
    {
		$login = false;
        while($row = mysqli_fetch_assoc($result))
        {
			if($row['password']==$pass)
			{
				$_SESSION['name']=$row['name'];
				$_SESSION['email']=$row['email'];
				$_SESSION['id']=$row['sign_id'];
				$_SESSION['access_id']=$row['access_id'];
				$login = true;
				
				echo "success";
				
				continue;
			}
        }
		if($login == false)
			echo "Wrong email or password";
    }
    else
        {
            echo "Wrong email or password";
        }
    mysqli_close($conn);
?>