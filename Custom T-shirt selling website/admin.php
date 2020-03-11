<?php
session_start(); //start the PHP_session function 

if(isset($_SESSION['access_id']))
{
	if($_SESSION['access_id'] == 1)
	{
		header("location:customer.php");
	}
}
else
{
	header("location:gallery.php");
}

function fetch_data()  
 {  
 	//require 'databaseConn.php';
 	$value = $_GET['pol'];
 	$statement= '';
 	//echo "$value";
 	if ($value==1) 
 	{
 		// echo "weekly";
 		//echo "$value";
 		$statement="select * from order_table where date between date_sub(now(),INTERVAL 1 WEEK) and now()";
 	}
 	elseif ($value==2) {
 		// echo "monthly";
 		//echo "$value";
 		$statement="select * from order_table where date between date_sub(now(),INTERVAL 1 MONTH) and now()";
 	}
 	elseif ($value==3) {
 		// echo "yearly";
 		//echo "$value";
 		$statement="select * from order_table where date between date_sub(now(),INTERVAL 1 YEAR) and now()";
 	}

      require 'databaseConn.php';
      
		 //$statement="select * from shopping_cart";
        //$statement="select * from shopping_cart where sell_date between date_sub(now(),INTERVAL 1 year) and now()";
        
		$result = mysqli_query($conn, $statement);
		$output = '';

		if (mysqli_num_rows($result) > 0)
			{
				while($row = mysqli_fetch_assoc($result))
					{
						$output .='<tr>
									<td>'.$row["order_id"].'</td>
									<td>'.$row["order_status"].'</td>
									<td>'.$row["cart_id"].'</td>
									<td>'.$row["cost"].'</td>
									<td>'.$row["date"].'</td>
									</tr>';
					}	
			}
		else
			{
				echo "Nothing found in db";
			}
		mysqli_close($conn); 
		return $output;
 }

 if(isset($_GET["create_pdf"]))  
 {   
      require_once('tcpdf/tcpdf.php');
      //$val = $_POST['pol'];
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      $obj_pdf->SetCreator(PDF_CREATOR);  
      $obj_pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('helvetica');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(TRUE, 10);  
      $obj_pdf->SetFont('helvetica', '', 12);  
      $obj_pdf->AddPage();  
      $content = '';  
      $content .= '  
      <h3 align="center">Sales Report</h3><br /><br />  
      <table border="1" cellspacing="0" cellpadding="5">  
           <tr>  
                <th width="15%">Order ID</th>  
                <th width="15%">Order Status</th>  
                <th width="15%">Cart Id</th>  
                <th width="15%">Cost (Tk)</th>
                <th width="20%">Date</th>
           </tr>  
      ';
      $content .= fetch_data();  
      $content .= '</table>'; 
     // ob_start(); 
      $obj_pdf->writeHTML($content);
      ob_end_clean();  
      $obj_pdf->Output('sample.pdf', 'I');  
 } 
?>



<html>
	<head>
		<title>Admin</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="gallery.css">
		<link rel="stylesheet" type="text/css" href="admin.css">
		<link rel="stylesheet" type="text/css" href="salesReport.css">
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
				<button class="tablinks" onclick="openTab(event, 'Add_Product')" id="defaultOpen">Add Product</button>
				<button class="tablinks" onclick="openTab(event, 'Customer_Products')">Customer Products</button>
				<button class="tablinks" onclick="openTab(event, 'Order_List')">Order List</button>
				<button class="tablinks" onclick="openTab(event, 'User_Info')">User Info</button>
				<button class="tablinks" onclick="openTab(event, 'Sales_report')">Sales Report</button>
				<button class="tablinks" onclick="openTab(event, 'Product_Info')">ProductInfo</button>
			</div>

			<div id="Add_Product" class="tabcontent" >
				<div class="col-12">
					<form name="addProduct" method="post" action="uploadProduct.php" id="product_detail" enctype="multipart/form-data">
						<table>
						<tr>
							<td>Product Name :<br><br></td>
							<td>
								<input type="text" name="pName" style="width: 200px;" required><br><br>
							</td>
							<td rowspan="4">
								<img src="" id="profile-img-tag" width="200px" name="pic"/><br>
								<input type="file" name="image" id="profile-img" onchange="readURL(this);"  style="margin-top: 15px;" required>
							</td>
						</tr>
						<tr>
							<td>Product price :<br><br></td>
							<td>
								<input type="number" name="pPrice" min="0" max="5000" style="width: 80px;" required><br><br>
							</td>
						</tr>
						<tr>
							<td>Product Detail :<br><br><br><br><br></td>
							<td>
								<textarea rows="4" cols="40" name="pDetail" form="product_detail" required></textarea>
								<br><br>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="submit" value="Submit" class="button">
								<input type="reset" value="Reset" style="margin-left: 20px;" class="button">
							</td>
						</tr>
						</table>
					</form> 
				</div>
			</div>

			<div id="Customer_Products" class="tabcontent">
				<div class="ex1">
					<?php
						require 'databaseConn.php';

						$statement="select * from product order by product_id desc";
						$result = mysqli_query($conn, $statement);

						if (mysqli_num_rows($result) > 0)
						{
							while($row = mysqli_fetch_assoc($result))
							{
								echo '<div id="box">';
								echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'" id="img"/>';
								echo '	<div class="box-text">';
								echo '		<br><a href="#news">View other products</a>';
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
							<th width="10%">Cart Id</th>
							<th width="15%">Date</th>
							<th width="10%">Cost</th>
							<th width="25%">Address</th>
							<th width="10%">Customer Id</th>
							<th width="10%">Action</th>
						</tr>
							
						<?php
							/*<img src="img/<?php echo $values["item_id"];?>.jpg" style="width: 180px; height: 200px;">*/
							require 'databaseConn.php';

							$statement="select * from order_table";
							$result = mysqli_query($conn, $statement);

								if (mysqli_num_rows($result) > 0)
								{
									while($row = mysqli_fetch_assoc($result))
									{
										echo '<tr>';
											echo '<td width="10%" >'.$row['order_id'].'</td>';
											echo '<td width="10%" >'.$row['order_status'].'</td>';
											echo '<td width="10%" >'.$row['cart_id'].'</td>';
											echo '<td width="15%" >'.$row['date'].' </td>';
											echo '<td width="10%" >'.$row['cost'].'</td>';
											echo '<td width="25%" >'.$row['address'].' </td>';
											echo '<td width="10%" >'.$row['customer_id'].'</td>';
											
											echo '<td width="10%" >';	
												echo '<a href="updatestatus.php?id='.$row["order_id"].'">';
												echo '<span>Completed</span></a>';
											echo '</td>';
										echo '</tr>';
												
									
									}
								}
								else
								{
									echo "Nothing found in db";
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
					<br><div id="return" align="center"></div><br>
					<input type="submit" value="Update" class="navbutton" style="width:40%; margin-left:-10px;">
				</form>
			</div>
			
			<div id="Sales_report" class="tabcontent">
				<div class="ex1">
					
					<table class="tablecontent">
						<tr>
							<th>Order Id </th>
							<th>Order Status</th>
							<th>Cart Id</th>
							<th>Cost (৳)</th>
							<th>Date</th>
						</tr>
						<?php  
							echo fetch_data();  
						?>
					</table>
				</div>
				
				<form method="get">
					<select name="pol" style="margin-left: 40%;">
						<option value="1">Weekly</option>
						<option value="2">Monthly</option>
						<option value="3">Yearly</option>
					</select>
					<input type="submit" name="go" class="" value="GO" />
					<input type="submit" name="create_pdf" class="buttonp" value="Create PDF" />
				</form>
				
			</div>
			
			<div id="Product_Info" class="tabcontent">
				<?php
					if(!isset($_GET['update']))
					{
				?>
				<br>
				<select id="orderPSearch" style="margin-left:40%;">
					<option value="1">Name</option>
					<option value="2">Price</option>
					<option value="3">Product detail</option>
					<option value="5">Date</option>
					<option value="6">Added By</option>
				</select>
				
				<input type="text" id="searchPInput" onkeyup="searchProduct()" placeholder="Search for ..">
				
				<div class="ex1">
					<table style="text-align:center;" id="searchPTable">
						<tr>
							<th width="5%">Product Id</th>
							<th width="10%">Product Name</th>
							<th width="5%">Price</th>
							<th width="15%">Product Detail</th>
							<th width="25%">Image</th>
							<th width="15%">Added Date</th>
							<th width="15%">Added By</th>
							<th width="10%">Action</th>
						</tr>
							
						<?php
							/*<img src="img/<?php echo $values["item_id"];?>.jpg" style="width: 180px; height: 200px;">*/
							require 'databaseConn.php';

							$statement="select * from product";
							$result = mysqli_query($conn, $statement);

								if (mysqli_num_rows($result) > 0)
								{
									while($row = mysqli_fetch_assoc($result))
									{
										echo '<tr>';
											echo '<td width="5%" >'.$row['product_id'].'</td>';
											echo '<td width="10%" >'.$row['product_name'].'</td>';
											echo '<td width="5%" >'.$row['price'].'</td>';
											echo '<td width="15%" >'.$row['product_detail'].' </td>';
											echo '<td width="25%" ><img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'" id="img"/></td>';
											echo '<td width="15%" >'.$row['added_date'].' </td>';
											echo '<td width="15%" >'.$row['added_by'].'</td>';
											
											echo '<td width="10%" >';	
												echo '<a href="admin.php?pol=1&update='.$row["product_id"].'">';
												echo '<span>Update</span></a>';
											echo '</td>';
										echo '</tr>';
												
									
									}
								}
								else
								{
									echo "Nothing found in db";
								}
								mysqli_close($conn);
						
						
						?>	
					</table>
				</div>
				<?php
					}
					else
					{
				?>
				<div class="col-12">
					<?php
						
						if(isset($_GET['update']))
						{
							$id = $_GET['update'];
							
							echo '<form name="addProduct" method="post" action="productUpdate.php?task=update&id='.$id.'" id="productdetail" enctype="multipart/form-data">';
								echo '<table><tr>';
							echo '<td>Product Name :<br><br></td>';
						
							require 'databaseConn.php';
							
							
							$statement="select * from product where product_id='$id'";
							$result = mysqli_query($conn, $statement);
						
							if (mysqli_num_rows($result) > 0)
								{
									while($row = mysqli_fetch_assoc($result))
									{
											echo '<input type="hidden" id="getid" value="'.$id.'">';
											echo '<td><input type="text" name="pName" style="width: 200px;" value="'.$row['product_name'].'" required><br><br></td>';
											echo '<td rowspan="4">';
												echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'" id="profile-img-tag" width="200px" name="pic"/><br>';
												echo '<input type="file" name="image" id="profile-img" onchange="readURL(this);"  style="margin-top: 15px;">';
											echo '</td></tr><tr>';
											echo '<td>Product price :<br><br></td>';
											echo '<td>';
												echo '<input type="number" name="pPrice" min="0" max="5000" style="width: 80px;" value="'.$row['price'].'" required><br><br>';
											echo '</td>';
										echo '</tr><tr>';
											echo '<td>Product Detail :<br><br><br><br><br></td>';
											echo '<td>';
												echo '<textarea rows="4" cols="40" name="pDetail" form="productdetail" required>'.$row['product_detail'].'</textarea>';
									}
								}
								else
								{
									echo "Nothing found in db";
								}
							mysqli_close($conn);
						}
						
						?>
								<br><br>
							</td>
						</tr>
						<tr>
							<td colspan="2" >
								<input type="submit" value="Update" style="margin-left:40%;" class="button">
							</td>
						</tr>
						</table>
					</form> 
					<button style="margin-top:15%; background-color:red;" onclick="goto()" class="button">Delete</button>
				</div>
				<?php
					}
				?>
			</div>
		
			<script>
				function searchProduct() {
					  var input, filter, table, tr, td, i, searchFor;
					  
					  input = document.getElementById("searchPInput");
					  filter = input.value.toUpperCase();
					  table = document.getElementById("searchPTable");
					  tr = table.getElementsByTagName("tr");
					  
					  searchFor = document.getElementById("orderPSearch").value;
					  
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
					
				function goto(){
						var id = document.getElementById("getid").value;
						self.location = "productUpdate.php?task=delete&id="+id;
					}
			</script>
		
		</div>
		
		
		<script>
			document.getElementById("defaultOpen").click();
		</script>
	</body>
</html>
