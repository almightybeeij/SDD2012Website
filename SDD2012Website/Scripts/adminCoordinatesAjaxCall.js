function showParkingSpaces(lotId,errorKey,error)
{
	document.getElementById("tableDiv").innerHTML="Fetching Data From Database ...";
if (lotId=="")
  {
  document.getElementById("tableDiv").innerHTML="Error Will Robinson<br>";
  return;
  } 
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
    document.getElementById("tableDiv").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("POST","Scripts/adminCoordinatesAjaxCall.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("lotId="+lotId+"&errorKey="+errorKey+"&error="+error);
}