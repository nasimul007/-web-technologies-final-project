<?php 
session_start();


if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		$remove=false;
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($remove == false)
			{
				if($values["item_id"] == $_GET["id"])
				{
					if($values["item_size"] == $_GET["size"])
					{
						unset($_SESSION["shopping_cart"][$keys]);
						echo '<script>alert("Item Removed")</script>';
						echo '<script>window.location="admin.php"</script>';
						$remove = true;
					}
				}
			}
		}
	}
}

?>

<html>
	<head>
		<title>Cart</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="gallery.css">
		<link rel="stylesheet" type="text/css" href="admin.css">
		<link rel="stylesheet" type="text/css" href="singleview.css">
		<script src="admin.js"></script>
		<script src="ajax.js"></script>
	</head>
	
	<body>	
	
		<div class="header">
			<div class="topnav">
				<a class="active" href="admin.php?pol=1">Home</a>
				<a href="gallery.php">Gallery</a>
				<a href="design.php">Design</a>
				<?php
					echo '<a href="#">Welcome, '.$_SESSION['name'].'</a>';
				?>
				<a href="logout.php">Log Out</a>
				<div class="search-container">
					<form id="searchForm" method="get" action="gallery.php">
						<input type="text" onkeyup="Javascript:forsearch(this.value)" placeholder="Search.." name="search">
						<button id="submitsearch" type="submit"><img src="img/search.png" style="height:20px;"></button>
					</form>
				 </div>
			</div>
		</div>

		
		<div id="Size" class="sizetab" >
			
		</div>
		
		<div class="row">
			<div class="col-4">
				<div class="boxleft" >
				<br>
					<h2 style="margin-left:40%; ">Address <h5 style="margin-left:20%; ">Cart ID: <?php echo $_SESSION['cart_id']=uniqid(); ?></h5></h2>
					<form align="center" method="post" action="updateorder.php">
					
					<?php
						
						if(isset($_SESSION['name']))
						{
							require 'databaseConn.php';
							
							$id = $_GET['id'];
							
							$statement="select * from sign_in where sign_id='$id'";
							$result = mysqli_query($conn, $statement);
						
							if (mysqli_num_rows($result) > 0)
								{
									while($row = mysqli_fetch_assoc($result))
									{
										echo '<input id="cName"  type="text" name="cName" style="width: 280px;" placeholder="Name" value="'.$row['name'].'" required><br><br>';
										echo '<input id="email" type="email" name="cEmail" style="width: 280px;" placeholder="Email" value="'.$row['email'].'" required><br><br>';
									}
								}
								else
								{
									echo "Nothing found in db";
								}
						
							$statement="select * from customer where customer_id='$id'";
							$result = mysqli_query($conn, $statement);
						
							if (mysqli_num_rows($result) > 0)
								{
									while($row = mysqli_fetch_assoc($result))
									{
										echo '<input id="cMobile"  type="text" name="cMobile" style="width: 280px;" value="'.$row['contact'].'" placeholder="Contact Number" required><br><br>';
										echo '<input id="cAddress"  type="text" name="cAddress" style="width: 280px;" value="'.$row['address'].'" placeholder="Detailed Address" required><br><br>';
										echo '<input id="cCity"  type="text" name="cCity" style="width: 280px;" value="Dhaka" disabled><br><br>';
										echo '<input id="cCode"  type="text" name="cCode" style="width: 280px;" value="'.$row['postal_code'].'" placeholder="Postal code" required><br><br>';
									}
								}
								else
								{
									echo "Nothing found in db";
								}
							mysqli_close($conn);
							echo '<input type="hidden" name="hidden_id" value="'.$id.'" />';
						}
						
					?>
					
					<input type="submit" value="Submit" class="navbutton" style="width:60%; margin-left:-10px;">
					</form>
				</div>
			</div>
			
			<div class="col-7">
				<div class="boxright" style="margin-left: 0px; margin-top: -16px;" align="center">
				<br/>
					<div class="cartbox" >
						
						<table>
							<tr>
								<th width="30%">Product</th>
								<th width="15%">Name</th>
								<th width="10%">Quantity</th>
								<th width="5%">Size</th>
								<th width="10%">Price</th>
								<th width="15%">Total</th>
								<th width="15%">Action</th>
							</tr>
							<?php
							if(!empty($_SESSION["shopping_cart"]))
							{
								$total = 0;
								foreach($_SESSION["shopping_cart"] as $keys => $values)
								{
							?>
							<tr>
								<td width="30%" align="center">
									
									<?php
										/*<img src="img/<?php echo $values["item_id"];?>.jpg" style="width: 180px; height: 200px;">*/
										require 'databaseConn.php';
										
										$id = $values["item_id"];

										$statement="select * from product where product_id=$id";
										$result = mysqli_query($conn, $statement);

										if (mysqli_num_rows($result) > 0)
										{
											while($row = mysqli_fetch_assoc($result))
											{
												echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'" style="width: 180px; height: 200px;"/>';
											}
										}
										else
										{
											echo "Nothing found in db";
										}
										mysqli_close($conn);
									?>
								</td>
								<td width="15%" ><?php echo $values["item_name"]; ?></td>
								<td width="10%" ><?php echo $values["item_quantity"]; ?></td>
								<td width="5%" ><?php echo $values["item_size"]; ?></td>
								<td width="10%" > <?php echo $values["item_price"]; ?> Tk</td>
								<td width="15%" > <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?> Tk</td>
								<td width="15%" >
								<?php
									echo '<a href="cart.php?action=delete&id='.$values["item_id"].'&size='.$values["item_size"].'">';
								?>
									<span>Remove</span></a>
								</td>
							</tr>
							<?php
									$total = $total + ($values["item_quantity"] * $values["item_price"]);
								}
							?>
							<tr>
								<td colspan="6" style="text-align: right;">Total :</td>
								<td align="right"><?php echo number_format($total, 2); ?> Tk</td>
								<td></td>
							</tr>
							<?php
							}
							?>
								
						</table>
					</div>
				</div>	
			</div>
		</div>
	</body>
</html>