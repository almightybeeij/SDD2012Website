<?php
include "../Config/configServer.php";
include "../Config/connectServer.php";

$lotId = $_POST['lotId'];
$coordinates = $_POST['coordinates'];
$drawOrder = $_POST['drawOrder'];

$error = NULL;

if ( !empty($lotId) && !empty($coordinates) && !empty($drawOrder))
{
	//Check if data is numeric or not
	if(!is_numeric($lotId))
		$error = $error . 'Parking Lot('.$drawOrder.') Id must be an integer:<br> ';
	if(!is_numeric($drawOrder))
		$error = $error . 'Draw Order(' .$drawOrder. ') must be an integer:<br> ';
	
	list($coordinates01,$coordinates11) = explode(",",$coordinates);
	if(!is_numeric($coordinates01))
		$error = $error . 'Coordinate 1(' .$coordinates01. ') must be an integer:<br> ';
	if(!is_numeric($coordinates11))
		$error = $error . 'Coordinate 2(' .$coordinates11. ') must be an integer:<br> ';
	
	
	
	if(empty($error))
	{
		$sqlCheck = "select * from coordinates where ParkingLot_lotId=$lotId and coordinates='$coordinates';";
		$resultCheck = mysql_query($sqlCheck);
		
		if(!$resultCheck)
			die('Oh No ... Invalid Query: ' . mysql_error());
		
		$num_results = mysql_num_rows($resultCheck);
		
		//Check to see if updating or deleting
		if ($num_results <= 0)
		{
			$sqlInsert = "insert into coordinates values ($lotId,'$coordinates',$drawOrder);";
			$resultInsert = mysql_query($sqlInsert);
			if(!$resultInsert)
				die('Uhh Ohh '. mysql_error());
		}
		else
		{
			$sqlUpdate = "update coordinates set drawOrder = '$drawOrder' where ParkingLot_lotId='$lotId' and coordinates='$coordinates';";
			$resultUpdate = mysql_query($sqlUpdate);
			if(!resultUpdate)
				die('Uhh Ohh ' . mysql_error());
			
		}
		$error = $error. 'updated';
		
	}
	
	
	echo $error;
	
}
else
	echo $error = $error . 'One or more text boxes were left blank<br>';

include "../Config/closedbServer.php";


?>
