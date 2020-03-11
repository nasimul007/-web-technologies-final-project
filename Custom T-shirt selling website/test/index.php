<table>
<?php
	echo '<tbody id="data">';
		
	echo '</tbody>';
?>
</table>

<script>

	var ajax = new XMLHttpRequest();
	var method = "GET";
	var url = "data.php";
	var asy = true;
	
	
	ajax.open(method, url, asy);
	
	ajax.send();
	
	
	ajax.onreadystatechange = function()
	{
		if(this.readyState == 4 && this.status == 200)
		{
			//alert(this.responseText);
			
			var data = JSON.parse(this.responseText);
			console.log(data);
			
			var html = "";
			
			for(var a = 0; a < data.length; a++)
			{
				var id = data[a].product_id;
				var name = data[a].product_name;
				
/////////////////////////////////////////////////////////////////////////////////
			html += "<tr>";
					html += "<td>"+id+"</td>";
				
				html += "<td>";
				
					html +="include('databaseConn.php');";
		
				
					html +="$statement='select * from product where product_id='"+id+";";
				
					html +="$result = mysqli_query($conn, $statement);";
					
					html +="if (mysqli_num_rows($result) > 0)";
					html +="{";
						html +="while($row = mysqli_fetch_assoc($result))";
						html +="{";
							html +="$row ;";
					html +=	"}";
					
					html +="}";
					
				html += "<td>"
			html += "<tr>";
			
			
////////////////////////////////////////////////////////////////////////////////////
			
			
			}
			
			document.getElementById("data").innerHTML = html;
		}
	}
	
</script>