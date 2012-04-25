function updateCoordinates(lotId, coordinates, drawOrder, count)
{
       document.getElementById("test").innerHTML="Balls ..."+count;
if (lotId=="")
  {
  document.getElementById("test").innerHTML="Testies<br>";
  return;
  }
if (document.getElementById("update"+count).value == 'Updated!')
{
    document.getElementById("test").innerHTML='Everything is Ok to insert<br>';
    document.getElementById("ParkingLot_lotId"+count).disabled=false;
    document.getElementById("coordinates"+count).disabled=false;
    document.getElementById("drawOrder"+count).disabled=false;
    document.getElementById("update"+count).value='Update';
    document.getElementById("update"+count).value='Re-enabled';
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
       var response = xmlhttp.responseText;
       if(response =='yes')
       {	
	  document.getElementById("test").innerHTML='Everything is Ok to insert<br>';
          document.getElementById("ParkingLot_lotId"+count).disabled='disabled';
          document.getElementById("coordinates"+count).disabled='disabled';
          document.getElementById("drawOrder"+count).disabled='disabled';
	  document.getElementById("update"+count).value='Updated!';
       }
       else
        document.getElementById("test").innerHTML='There was some kind of error<br>';
    }
  else 
    {
    document.getElementById("test").innerHTML='Internal Server Error Bitch<br>';
    
    }
  }
xmlhttp.open("POST","Scripts/adminUpdateCoordinatesAjaxCall.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("lotId="+lotId+"&coordinates="+coordinates+"&drawOrder="+drawOrder+"&count="+count);
}
