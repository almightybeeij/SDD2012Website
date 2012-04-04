function emailTempPassword(var1,var2,var3)
{
	document.getElementById("status").innerHTML="Please Wait ...";
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
		  document.getElementById("status").innerHTML=xmlhttp.responseText;
	    }
	  }
	
	xmlhttp.open("POST","email.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("question="+var1+"&answer="+var2+"&email="+var3);
}

function updatePassword(var1, var2, var3)
{
	document.getElementById("passwordStatus").innerHTML="Please Wait ...";
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
		  document.getElementById("passwordStatus").innerHTML=xmlhttp.responseText;
	    }
	  }
	
	xmlhttp.open("POST","updatePassword.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("email="+var1+"&password="+var2+"&password2="+var3);
}