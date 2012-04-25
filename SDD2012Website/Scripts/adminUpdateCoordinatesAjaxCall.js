function updateCoordinates(lotId, coordinates, drawOrder, count)
{
       document.getElementById("errorDiv").innerHTML="Updating...<br>";
if (lotId=='' || coordinates=='' || drawOrder=='')
  {
  document.getElementById("errorDiv").innerHTML="One or more textboxes where left blank<br>";
  return;
  }
if (document.getElementById("update"+count).value == 'Re-enable')
{	
	document.getElementById("errorDiv").innerHTML= 'Re enabled row with these values<br>Lot Id: '+lotId +' Coordinates: '+ coordinates +' Draw Order: '+ drawOrder;
	document.getElementById('tableRow'+count).style.background ='None';
    document.getElementById("ParkingLot_lotId"+count).disabled=false;
    document.getElementById("coordinates"+count).disabled=false;
    document.getElementById("drawOrder"+count).disabled=false;
    document.getElementById("update"+count).value='Update';    
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
       var response = xmlhttp.responseText.toString().toLowerCase();
       var trimResponse= trim ( response );
       if(trimResponse == 'updated')
       {    	   
    	   document.getElementById("errorDiv").innerHTML='Updated Database with these values<br>Lot Id: '+lotId +' Coordinates: '+ coordinates +' Draw Order: '+ drawOrder;
    	   document.getElementById("tableRow"+count).style.background ='green';
    	   document.getElementById("ParkingLot_lotId"+count).disabled='disabled';
    	   document.getElementById("coordinates"+count).disabled='disabled';
    	   document.getElementById("drawOrder"+count).disabled='disabled';
    	   document.getElementById("update"+count).value='Re-enable';
       }
       else
       {   
    	   document.getElementById("errorDiv").innerHTML=response;
    	   document.getElementById('errorDiv').style.fontColor ='red';
    	   document.getElementById("tableRow"+count).style.background ='red';
       }
    }  
  }
xmlhttp.open("POST","Scripts/adminUpdateCoordinatesAjaxCall.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("lotId="+lotId+"&coordinates="+coordinates+"&drawOrder="+drawOrder+"&count="+count);
}

function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}
