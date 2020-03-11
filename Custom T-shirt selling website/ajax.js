function postRequest(strURL) 
	{
		var xmlHttp;
				
		if (window.XMLHttpRequest) // Mozilla, Safari, ...
		{ 
			var xmlHttp = new XMLHttpRequest();
		} 
		else if (window.ActiveXObject) // IE 
		{ 
			 var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		else
		{
			alert("your browser does not support AJAX");
			return;
		}
				
		xmlHttp.open('POST', strURL, true);
		xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				
		xmlHttp.onreadystatechange = function() 
		{
					
			if (xmlHttp.readyState == 4) 
			{
				updatepage(xmlHttp.responseText);
			}
		}
				
		xmlHttp.send(strURL);
	}
function updatepage(str)
	{
		if(str == "success")
			self.location = "admin.php?pol=1";
		else if(str == "same")
			document.getElementById("rreturn").innerHTML = 	"<font color='red' size='2'>Email address exits<br>please give another one</font><br>";
		else if(str == "updated")
			document.getElementById("return").innerHTML = 	"<font color='red' size='2'>Updated Address</font><br>";
		else if(str == "updated info")
			document.getElementById("return").innerHTML = 	"<font color='red' size='2'>Updated Info</font><br>";
		else if(str == "Registration failed")
			document.getElementById("rreturn").innerHTML = 	"<font color='red' size='2'>" + str + "<br> Password Missmatch</font><br>";
		else if(str == "added")
		{
			alert("Product Added to the Cart");
			var count = document.getElementById("count").value;			
			document.getElementById("cartq").innerHTML = 	+count + 1;
			document.getElementById("count").value = +count + 1;
		}
		else
		{
			document.getElementById("return").innerHTML = 	"<font color='red' size='2'>" + str + "</font><br>";
			document.getElementById("rreturn").innerHTML = 	"<font color='red' size='2'>" + str + "</font><br>";
		}
	}
function forlog()
	{
		var rnd = Math.random();
				
		var email = document.getElementById("email").value;
		var pass = document.getElementById("pass").value;
				
		var url="loguser.php?id="+rnd+"&pEmail="+email+"&pPassword="+pass;
				
		postRequest(url);
		
	}
	
function forreg()
	{
		var rnd = Math.random();
				
		var name = document.getElementById("pName").value;
		var email = document.getElementById("pEmail").value;
		var mobile = document.getElementById("pMobile").value;
		var pass = document.getElementById("pPassword").value;
		var cpass = document.getElementById("pCPassword").value;
				
		var url="reguser.php?id="+rnd+"&pName="+name+"&pEmail="+email+"&pMobile="+mobile+"&pPassword="+pass+"&pCPassword="+cpass;
				
		postRequest(url);
	}
	
function forcart(id)
	{
		var name = document.getElementById(id+"name").value;
		var price = document.getElementById(id+"price").value;
		var size = document.getElementById(id+"size").value;
		var quantity = document.getElementById(id+"quantity").value;
		
				
		var url= "addtocart.php?action=add&id="+ id +"&hidden_name="+name+"&hidden_price="+price+"&quantity="+quantity+"&size="+size+"&add_to_cart=set";
				
		postRequest(url);
	}

function foraddress()
	{
		var rnd = Math.random();
		
		var contact = document.getElementById("cMobile").value;
		var address = document.getElementById("cAddress").value;
		var code = document.getElementById("cCode").value;
		
				
		var url= "updateaddress.php?id="+ rnd +"&mobile="+ contact +"&address="+ address +"&code="+code;
				
		postRequest(url);
	}
	
function foruser()
	{
		var rnd = Math.random();
		
		var name = document.getElementById("uName").value;
		var email = document.getElementById("uemail").value;
		var pass = document.getElementById("upassword").value;
		var npass = document.getElementById("unpassword").value;
		
				
		var url= "updateuser.php?id="+ rnd +"&name="+ name +"&email="+ email +"&pass="+pass+"&npass="+npass;
				
		postRequest(url);
	}
	
function forsearch(text)
	{
		var url= "search.php?id="+ rnd +"&search="+ text;
	
		postRequest(url);
	}
	
function forclose()
	{
		document.getElementById("searchBox").style.display = "none";
	}
function forsubmit()
	{
		document.getElementById("searchForm").submit();
	}