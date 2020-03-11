<?php
session_start(); //start the PHP_session function 

?>

<html>
	<head>
		<title>Gallery</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="gallery.css">
		<link rel="stylesheet" type="text/css" href="admin.css">
		<script src="gallery.js"></script>
		<script src="ajax.js"></script>
	</head>
	
	<body>	
	
		<div class="header">
			<div class="topnav">
				<a href="admin.php?pol=1">Home</a>
				<a class="active" href="gallery.php">Gallery</a>
				<a href="design.php">Design</a>
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
				<a class="tablinks" onclick="openTab(event, 'Size')">Sizes</a>
				<div class="cartContainer">
				<?php
					if(isset($_SESSION["shopping_cart"]))
					{
						$count = count($_SESSION["shopping_cart"]);
					}
					else
						$count=0;
					
					echo '<a class="navcart" href="cart.php"><img src="img/cart.png" style="width: 22px; height: 22px;"><b id="cartq" style="display:inline; color:red;">'.$count.'</b></a>';
					echo '<input id="count" type="hidden" value="'.$count.'" />';
				?>
				</div>
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
			<div class="col-12">
				<table class="forTable" align="center" border="1">
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
				<table>
					<tr>
						<td align="center">
							<input type="reset" value="Ok" style="margin-left: 20px;" class="navbutton" onclick="closeTab(event,'Size')">
						</td>
					</tr>
				</table>
			</div>
		</div>
		
		<div id="searchBox" class="searchBox">
			<div id="searchBox" class="searchResult">
				
				<tbody id="data">
				
				<tbody>
				
			</div>
			<a onclick="Javascript:forclose()" href="#" style="float:left; margin-left:5%;">Close</a>
			<a onclick="Javascript:forsubmit()" href="#">View More</a>
		</div>
		
		
		<div class="row">
			<div class="col-3 menu">
				<ul>
					<li>
						<span>Search by keyword</span>
						<div class="dropdown-content">
							<a href="gallery.php?search=bangla">Bangla</a><br><br>
							<a href="gallery.php?search=character">Character</a><br><br>
							<a href="gallery.php?search=english">English</a>
						</div>
					</li>
				</ul>
				
				<table id="sizeTable" align="center" border="1">
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
				
				<button onclick="topFunction()" id="topBtn" title="Go to top">Top</button>
				<button onclick="sizeFunction()" id="sizeBtn" title="sizes">Sizes</button>
			</div>

			<script>
				window.onscroll = function() {scrollFunction()};
			</script>
			
			<div class="col-9">
			
			<?php
				
				require 'databaseConn.php';
					
					if(isset($_GET['search']))
					{
						$text = $_GET['search'];
						$statement="select * from product where product_name like '%$text%' or product_detail like '%$text%' order by product_id desc";
					}
					else
					{
						$statement="select * from product order by product_id desc";
					}
					
					
					$result = mysqli_query($conn, $statement);

					if (mysqli_num_rows($result) > 0)
					{
						while($row = mysqli_fetch_assoc($result))
						{
							echo '<div class="box">';
							echo '	<b style="margin-left:2%;">'.$row['price'].' Tk</b><a target="_blank" href="singleview.php?id='.$row['product_id'].'"><img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'" class="img"/></a>';
							
							echo '	<div class="box-text">';
							echo '		<form action="Javascript:forcart('.$row['product_id'].')" id="product_detail">';

							echo '			<br><a target="_blank" href="singleview.php?id='.$row['product_id'].'">View</a>';
							echo '			<input id="'.$row['product_id'].'name" type="hidden" name="hidden_name" value="'.$row['product_name'].'" />';
							echo '			<input id="'.$row['product_id'].'price" type="hidden" name="hidden_price" value="'.$row['price'].'" />';
							echo '			<input type="submit" name="add_to_cart" value="Add to Cart" /><br>';
							
							echo '			<select id="'.$row['product_id'].'size" name="size" required>';
							echo '				<option value=""></option>';
							echo '				<option value="S">S</option>';
							echo '				<option value="M">M</option>';
							echo '				<option value="L">L</option>';
							echo '				<option value="XL">XL</option>';
							echo '				<option value="XXL">XXL</option>';
							echo '				<option value="3XL">3XL</option>';
							echo'			</select>';
							
							echo '			<select id="'.$row['product_id'].'quantity" name="quantity" required>';
							echo '				<option value=""></option>';
													for($i=1; $i<11; $i++)
													{
														echo '<option value="'.$i.'">'.$i.'</option>';
													}
							echo'			</select>';
							echo '</form></div></div>';
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
		
	</body>
</html>