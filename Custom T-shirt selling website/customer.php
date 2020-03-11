<?php
session_start(); //start the PHP_session function 

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
						echo '<script>window.location="customer.php"</script>';
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
		<title>Customer</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="gallery.css">
		<link rel="stylesheet" type="text/css" href="admin.css">
		<script src="admin.js"></script>
		<script src="ajax.js"></script>
		<script src="jquery-3.3.1.js"></script>
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

		<div class="row">
			<div class="tab">
				<button class="tablinks" onclick="openTab(event, 'Cart')" id="defaultOpen">Cart</button>
				<button class="tablinks" onclick="openTab(event, 'Previous_Products')">Previous Products</button>
				<button class="tablinks" onclick="openTab(event, 'Address_Details')">Address Details</button>
				<button class="tablinks" onclick="openTab(event, 'User_Info')">User Info</button>
				<button class="tablinks" onclick="openTab(event, 'Order_List')">Order List</button>
			</div>

			<div id="Cart" class="tabcontent" >
				<div class="col-12">
					<div class="customercart" >
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
									echo '<a href="customer.php?action=delete&id='.$values["item_id"].'&size='.$values["item_size"].'">';
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
						
						
					?>
				</div>
			</div>

			<div id="Previous_Products" class="tabcontent">
				<div class="ex1">
					<?php
						require 'databaseConn.php';

						$email=$_SESSION['email'];
						
						$statement="select * from product where added_by='".$email."' order by product_id desc";
						$result = mysqli_query($conn, $statement);

						if (mysqli_num_rows($result) > 0)
						{
							while($row = mysqli_fetch_assoc($result))
							{
								echo '<div id="box">';
								echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'" id="img"/>';
								echo '	<div class="box-text">';
								echo '		<br><a href="singleview.php?id='.$row['product_id'].'">Order again</a>';
								echo '</div></div>';
							}
						}
						else
						{
							echo "Nothing found in db";
						}
						mysqli_close($conn);
					?>
				</div>
			</div>
			
			<div id="Address_Details" class="tabcontent">
				<h2 style="margin-left:40%; ">Address </h2>
				<form align="center" action="Javascript:foraddress()">
					
					<?php
						
						if(isset($_SESSION['name']))
						{
							require 'databaseConn.php';
							
							$id = $_SESSION['id'];
							
							$statement="select * from customer where customer_id='$id'";
							$result = mysqli_query($conn, $statement);
						
							if (mysqli_num_rows($result) > 0)
								{
									while($row = mysqli_fetch_assoc($result))
									{
										echo '<input id="cMobile"  type="text" name="cMobile" style="width: 280px;" value="'.$row['contact'].'" placeholder="Contact Number" required><br><br>';
										echo '<input id="cAddress"  type="text" name="cAddress" style="width: 280px;" value="'.$row['address'].'" placeholder="Detailed Address" required><br><br>';
										echo '<input id="cCity"  type="text" name="cCity" style="width: 280px;" value="Dhaka" disabled><br><br>';
										echo '<input id="cCode"  type="number" name="cCode" style="width: 280px;" value="'.$row['postal_code'].'" placeholder="Postal code" required><br><br>';
									}
								}
								else
								{
									echo '<input id="cMobile"  type="text" name="cMobile" style="width: 280px;" placeholder="Contact Number" required><br><br>';
									echo '<input id="cAddress"  type="text" name="cAddress" style="width: 280px;" placeholder="Detailed Address" required><br><br>';
									echo '<input id="cCity"  type="text" name="cCity" style="width: 280px;" value="Dhaka" disabled><br><br>';
									echo '<input id="cCode"  type="number" name="cCode" style="width: 280px;" placeholder="Postal code" required><br><br>';
								}
							mysqli_close($conn);
						}
						
					?>
					<br><div id="return" align="center"></div><br>
					<input type="submit" value="Update" class="navbutton" style="width:40%; margin-left:-10px;">
				</form>
			</div>
			
			<div id="User_Info" class="tabcontent">
				<h2 style="margin-left:40%; ">User Info </h2>
				<form align="center" action="Javascript:foruser()">
					
					<?php
						
						if(isset($_SESSION['name']))
						{
							require 'databaseConn.php';
							
							$id = $_SESSION['id'];
							
							$statement="select * from sign_in where sign_id='$id'";
							$result = mysqli_query($conn, $statement);
						
							if (mysqli_num_rows($result) > 0)
								{
									while($row = mysqli_fetch_assoc($result))
									{
										echo '<input id="uName"  type="text" name="cName" style="width: 280px;" placeholder="Name" value="'.$row['name'].'" required><br><br>';
										echo '<input id="uemail" type="email" name="cEmail" style="width: 280px;" placeholder="Email" value="'.$row['email'].'" required><br><br>';
										echo '<input id="upassword" type="password" name="cPass" style="width: 280px;" placeholder="Old password"  required><br><br>';
										echo '<input id="unpassword" type="password" name="cCPass" style="width: 280px;" placeholder="new password"  required><br><br>';
										$_SESSION['pass']=$row['password'];
									}
								}
								else
								{
									echo "Nothing found in db";
								}
							mysqli_close($conn);
						}
						
					?>
					<br><div id="rreturn" align="center"></div><br>
					<input type="submit" value="Update" class="navbutton" style="width:40%; margin-left:-10px;">
				</form>
			</div>
			
			<div id="Order_List" class="tabcontent">
			
				<br>
				<select id="orderSearch" style="margin-left:40%;">
					<option value="1">Order Status</option>
					<option value="2">Cart Id</option>
					<option value="3">Date</option>
				</select>
				
				<input type="text" id="searchInput" onkeyup="searchOrder()" placeholder="Search for ..">
			
				<div class="ex1">
					<table style="text-align:center;" id="searchTable">
						<tr>
							<th width="10%">Order Id</th>
							<th width="10%">Order Status</th>
							<th width="15%">Cart Id</th>
							<th width="20%">Date</th>
							<th width="10%">Cost</th>
							<th width="25%">Address</th>
							<th width="10%">Customer Id</th>
						</tr>
							
						<?php
							/*<img src="img/<?php echo $values["item_id"];?>.jpg" style="width: 180px; height: 200px;">*/
							require 'databaseConn.php';

							$id = $_SESSION['id'];
							
							$statement="select * from order_table where customer_id=$id";
							$result = mysqli_query($conn, $statement);

								if (mysqli_num_rows($result) > 0)
								{
									while($row = mysqli_fetch_assoc($result))
									{
										echo '<tr>';
											echo '<td width="10%" >'.$row['order_id'].'</td>';
											echo '<td width="10%" >'.$row['order_status'].'</td>';
											echo '<td width="15%" >'.$row['cart_id'].'</td>';
											echo '<td width="20%" >'.$row['date'].' </td>';
											echo '<td width="10%" >'.$row['cost'].'</td>';
											echo '<td width="25%" >'.$row['address'].' </td>';
											echo '<td width="10%" >'.$row['customer_id'].'</td>';
										echo '</tr>';
												
									
									}
								}
								else
								{
									echo "You didn't order anything";
								}
								mysqli_close($conn);
						
						
						?>	
					</table>
				</div>
			</div>
			
			<script>
				function searchOrder() {
					  var input, filter, table, tr, td, i, searchFor;
					  
					  input = document.getElementById("searchInput");
					  filter = input.value.toUpperCase();
					  table = document.getElementById("searchTable");
					  tr = table.getElementsByTagName("tr");
					  
					  searchFor = document.getElementById("orderSearch").value;
					  
					  for (i = 0; i < tr.length; i++) 
					  {
						td = tr[i].getElementsByTagName("td")[searchFor];
						if(td)
						{
						  if(td.innerHTML.toUpperCase().indexOf(filter) > -1) 
						  {
							tr[i].style.display = "";
						  }
						  else 
						  {
							tr[i].style.display = "none";
						  }
						}       
					  }
					}
			</script>
		
		</div>
		<script>document.getElementById("defaultOpen").click();</script>
	</body>
</html>