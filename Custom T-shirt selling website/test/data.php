<?php
session_start(); //start the PHP_session function 

		include("databaseConn.php");
		
		$text="oo";
		
		$statement="select product_id from product where product_name like '%$text%' or product_detail like '%$text%' order by product_id desc";
	
		$result = mysqli_query($conn, $statement);
		
		if (mysqli_num_rows($result) > 0)
		{
			$data = array();
			
			while($row = mysqli_fetch_assoc($result))
			{
				$data[] = $row;
			}
			
			echo json_encode($data);
			//echo "searched";
		}
		else
		{
			echo "Wrong email or password";
		}
		mysqli_close($conn);

?>









