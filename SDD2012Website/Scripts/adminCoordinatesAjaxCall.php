<?php
include "../Config/configServer.php";
include "../Config/connectServer.php";

$lotId = $_POST['lotId'];
$error = $_POST['error'];
$errorKey = $_POST['errorKey'];


	//We are printing table with edit and delete buttons


	$sqlSelect = "select * from coordinates where ParkingLot_lotId='$lotId' order by drawOrder asc;";
	$resultSelect = mysql_query($sqlSelect);

	if(!$resultSelect)
		die("Invalid select query:" . mysql_error());


	//Set up table
	echo "<table id='preEditTableCoordinates'>";
	echo "<tr><th>Parking Lot ID</th><th>Coordinates</th><th>Draw Order</th><th>Action</th><th>Delete</th></tr>";
	
	//Set up the very first row to be a row for adding lots
	echo "<form style='margin:0px' id='editForm' name='edit' action='$PHP_SELF?>' method='post'>";
	if(isset($error) && $errorKey == "New")
	{
		echo "<tr style='background-color: red'>";
		$errorKey = NULL;
	
	}
	else
		echo "<tr>";
	echo "<td><input type='hidden' name='ParkingLot_lotId' value='$lotId'>New</td>";
	echo "<td><input type='hidden' name='coordinates' value='new'>New</td>";
	echo "<td><input type='hidden' name='drawOrder' value='new'>New</td>";
	echo "<td><input id='edit' type='submit' name='edit' value='Add'/></form></td>";
	echo "<td></td>";
	echo "</tr>";
	
	while ($row = mysql_fetch_array($resultSelect))
	{
		//Edit Form
		echo "<form style='margin:0px; id='editForm' name='edit' action='$PHP_SELF?>' method='post'>";
		if(isset($error) && $errorKey == $row['ParkingLot_lotId'])
		{
			echo "<tr style='background-color: red'>";
			$errorKey = NULL;
	
		}
		else
		echo "<tr>";

		echo "<td><input type='hidden' name='ParkingLot_lotId' value='$row[ParkingLot_lotId]'/>$row[ParkingLot_lotId]</td>";
		echo "<td><input type='hidden' name='coordinates' value='$row[coordinates]'/>$row[coordinates]</td>";
		echo "<td><input type='hidden' name='drawOrder' value='$row[drawOrder]'/>$row[drawOrder]</td>";
		echo "<td><input id='edit' type='submit' name='edit' value='Edit'/></form></td>";

		//Delete Form
		echo "<form style='margin:0px' id='deleteForm' name='delete' action='$PHP_SELF?>' method='post'>";
		echo "<input type='hidden' name='ParkingLot_lotId' value='$row[ParkingLot_lotId]'/>";
		echo "<input type='hidden' name='coordinates' value='$row[coordinates]'/>";
		echo "<input type='hidden' name='drawOrder' value='$row[drawOrder]'/>";
		echo "<td><input id='delete' type='submit' name='delete' value='Delete'/></form></td>";
		echo "</tr>";
	}

	echo "</table>";




?>
