

<?php  
 function fetch_data()  
 {  
 	
		$value = $_POST['pol'];
		
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

 if(isset($_POST["create_pdf"]))  
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


<!DOCTYPE html> 
<html>
	<head>
		<title>Sales Report</title>
		<link rel="stylesheet" type="text/css" href="salesReport.css">
	</head>
	
	<body>

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
		<br />
		<form method="post">
			<select name="pol">
				<option value="1">Weekly</option>
				<option value="2">Monthly</option>
				<option value="3">Yearly</option>
			</select>
			<input type="submit" name="go" class="" value="GO" />
			<input type="submit" name="create_pdf" class="buttonp" value="Create PDF" />
		</form>
		
	</body>
</html>