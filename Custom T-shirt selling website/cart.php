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
						echo '<script>window.location="cart.php"</script>';
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
		<script src="gallery.js"></script>
		<script src="singleview.js"></script>
		<script src="ajax.js"></script>
	</head>
	
	<body>	
	
		<div class="header">
			<div class="topnav">
				<a class="active" href="admin.php?pol=1">Home</a>
				<a href="gallery.php">Gallery</a>
				<?php
					if(isset($_SESSION['access_id']))
					{
						echo '<a href="#">Welcome, '.$_SESSION['name'].'</a>';
						echo '<a href="logout.php">Log Out</a>';
					}
					else
					{
				?>
					<a class="tablinks" onclick="openTab(event, 'Log_in')">Log in</a>
					<a class="tablinks" onclick="openTab(event, 'Register')">Register</a>
				<?php
					}
				?>
				<div class="search-container">
					<form id="searchForm" method="get" action="gallery.php">
						<input type="text" onkeyup="Javascript:forsearch(this.value)" placeholder="Search.." name="search">
						<button id="submitsearch" type="submit"><img src="img/search.png" style="height:20px;"></button>
					</form>
				 </div>
			</div>
		</div>

		
		<div id="Log_in" class="logtab" >
			<div class="col-12">
				<form action="Javascript:forlog()" id="product_detail">
					<table>
					<tr>
						<td>
							<input id="email" type="email" name="pEmail" style="width: 220px;" placeholder="Email" required><br><br>
						</td>
					</tr>
					<tr>
						<td>
							<input id="pass" type="password" name="pPassword" style="width: 220px;" placeholder="Password" required><br><br>
						</td>
					</tr>
					<tr>
						<td>
							<div id="return" align="center"></div><br>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" value="Log In" class="navbutton">
							<input type="reset" value="Cancel" style="margin-left: 20px;" class="navbutton" onclick="closeTab(event,'Log_in')">
						</td>
					</tr>
					</table>
				</form> 
			</div>
		</div>
		
		<div id="Register" class="regtab" >
			<div class="col-12">
				<form action="Javascript:forreg()" id="product_detail">
					<table>
					<tr>
						<td>
							<input id="pName"  type="text" name="pName" style="width: 220px;" placeholder="Name" required><br><br>
						</td>
					</tr>
					<tr>
						<td>
							<input id="pEmail"  type="email" name="pEmail" style="width: 220px;" placeholder="Email" required><br><br>
						</td>
					</tr>
					<tr>
						<td>
							<input id="pMobile"  type="text" name="pMobile" style="width: 220px;" placeholder="Mobile Number" required><br><br>
						</td>
					</tr>
					<tr>
						<td>
							<input id="pPassword"  type="password" name="pPassword" style="width: 220px;" placeholder="Password" required><br><br>
						</td>
					</tr>
					<tr>
						<td>
							<input id="pCPassword"  type="password" name="pCPassword" style="width: 220px;" placeholder="Confirm Password" required><br><br>
						</td>
					</tr>
					<tr>
						<td>
							<div id="rreturn" align="center"></div><br>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" value="Log In" class="navbutton">
							<input type="reset" value="Cancel" style="margin-left: 20px;" class="navbutton" onclick="closeTab(event,'Register')">
						</td>
					</tr>
					</table>
				</form> 
			</div>
		</div>
		
		<div id="Size" class="sizetab" >
			
		</div>
		
		<div class="row">
			<div class="col-4">
				<div class="boxleft">
					<img class="sizeimg" src="img/size.png">
					<table class="forTable" align="center">
						<tr>
							<th id="t1">Size</th><th id="t1">Length</th><th id="t1">Width</th><th id="t1">Sleeve</th>
						</tr>
						<tr>
							<th id="t1">S</th><td id="t1">68 cm (26.77″)</td><td id="t1">48 cm (18.9″)</td><td id="t1">20 cm (7.87″)</td>
						</tr>
						<tr>
							<th id="t1">M</th><td id="t1">70 cm (27.56″)</td><td id="t1">50 cm (19.69″)</td><td id="t1">21 cm (8.27″)</td>
						</tr>
						<tr>
							<th id="t1">L</th><td id="t1">72 cm (28.35″)</td><td id="t1">52 cm (20.47″)</td><td id="t1">22 cm (8.66″)</td>
						</tr>
						<tr>
							<th id="t1">XL</th><td id="t1">74 cm (29.13″)</td><td id="t1">55 cm (21.65″)</td><td id="t1">23 cm (9.06″)</td>
						</tr>
						<tr>
							<th id="t1">XXL</th><td id="t1">76 cm (29.92″)</td><td id="t1">58 cm (22.83″)</td><td id="t1">24 cm (9.45″)</td>
						</tr>
						<tr>
							<th id="t1">3XL</th><td id="t1">78 cm (30.71″)</td><td id="t1">61 cm (24.02″)</td><td id="t1">25 cm (9.84″)</td>
						</tr>
					</table>
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
					<?php
						
						if(isset($_SESSION['name']))
						{
							require 'databaseConn.php';
							
							$email = $_SESSION['email'];
							
							$statement="select * from sign_in where email='$email'";
							$result = mysqli_query($conn, $statement);
						
							if (mysqli_num_rows($result) > 0)
								{
									while($row = mysqli_fetch_assoc($result))
									{
										echo '<a class="navbutton" href="order.php?id='.$row['sign_id'].'" style="float:right; margin-top:1%; text-decoration:none;">Submit cart</a>';
									}
								}
								else
								{
									echo "Nothing found in db";
								}
							mysqli_close($conn);
						}
						else
							echo '<br>Please Sign in to order Thank you';
						
						
					?>
				</div>	
			</div>
		</div>
	</body>
</html>