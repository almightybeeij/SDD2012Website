<?php
include "../Config/configServer.php";
include "../Config/connectServer.php";

$lotId = $_POST['lotId'];
$error = $_POST['error'];
$errorKey = $_POST['errorKey'];


	//We are printing table with edit and delete buttons


	$sqlSelect = "select * from parkingspace where ParkingLot_lotId='$lotId';";
	$resultSelect = mysql_query($sqlSelect);

	if(!$resultSelect)
		die("Invalid select query:" . mysql_error());


	//Set up table
	echo "<table id='preEditTableSpaces' style='font-size:10px'>";
	echo "<tr><th>Space ID</th><th>Lot #</th><th>Client Email</th><th>Open</th><th>Handicap</th><th>Corner 1</th><th>Corner 2</th><th>Corner 3</th><th>Corner 4</th><th>Action</th><th>Delete</th></tr>";
	
	//Set up the very first row to be a row for adding lots
	echo "<form style='margin:0px' class='smallFont' id='editForm' name='edit' action='$PHP_SELF?>' method='post'>";
	echo "<input type='hidden' name='lotId' value='$lotId'/>";
	if(isset($error) && $errorKey == "New")
	{
		echo "<tr style='background-color: red'>";
		$errorKey = NULL;
	
	}
	else
		echo "<tr>";
	echo "<td><input type='hidden' name='spaceId' value='new'>New</td>";
	echo "<td><input type='hidden' name='parkingLotId' value='new'>New</td>";
	echo "<td><input type='hidden' name='clientEmail' value='new'>New</td>";
	echo "<td><input type='hidden' name='available' value='new'>New</td>";
	echo "<td><input type='hidden' name='handicap' value='new'>New</td>";
	echo "<td><input type='hidden' name='corner1' value='new'>New</td>";
	echo "<td><input type='hidden' name='corner2' value='new'>New</td>";
	echo "<td><input type='hidden' name='corner3' value='new'>New</td>";
	echo "<td><input type='hidden' name='corner4' value='new'>New</td>";
	echo "<td><input id='edit' type='submit' name='edit' value='Add'/></form></td>";
	echo "<td></td>";
	echo "</tr>";
	
	while ($row = mysql_fetch_array($resultSelect))
	{
		//Edit Form
		echo "<form style='margin:0px; class='smallFont' font-size:10px' id='editForm' name='edit' action='$PHP_SELF?>' method='post'>";
		echo "<input type='hidden' name='lotId' value='$lotId'/>";
		if(isset($error) && $errorKey == $row['spaceId'])
		{
			echo "<tr style='background-color: red'>";
			$errorKey = NULL;
	
		}
		else
		echo "<tr>";

		echo "<td><input type='hidden' name='spaceId' value='$row[spaceId]'/>$row[spaceId]</td>";
		echo "<td><input type='hidden' name='parkingLotId' value='$row[ParkingLot_lotId]'/>$row[ParkingLot_lotId]</td>";
		echo "<td><input type='hidden' name='clientEmail' value='$row[Client_email]'/>$row[Client_email]</td>";
		echo "<td><input type='hidden' name='available' value='$row[available]'/>$row[available]</td>";
		echo "<td><input type='hidden' name='handicap' value='$row[handicap]'/>$row[handicap]</td>";
		echo "<td><input type='hidden' name='corner1' value='$row[corner1]'/>$row[corner1]</td>";
		echo "<td><input type='hidden' name='corner2' value='$row[corner2]'/>$row[corner2]</td>";
		echo "<td><input type='hidden' name='corner3' value='$row[corner3]'/>$row[corner3]</td>";
		echo "<td><input type='hidden' name='corner4' value='$row[corner4]'/>$row[corner4]</td>";
		echo "<td><input id='edit' type='submit' name='edit' value='Edit'/></form></td>";

		//Delete Form
		echo "<form style='margin:0px' class='smallFont' id='deleteForm' name='delete' action='$PHP_SELF?>' method='post'>";
		echo "<input type='hidden' name='spaceId' value='$row[spaceId]'/>";
		echo "<input type='hidden' name='parkingLotId' value='$row[ParkingLot_lotId]'/>";
		echo "<input type='hidden' name='clientEmail' value='$row[Client_email]'/>";
		echo "<input type='hidden' name='available' value='$row[available]'/>";
		echo "<input type='hidden' name='handicap' value='$row[handicap]'/>";
		echo "<input type='hidden' name='corner1' value='$row[corner1]'/>";
		echo "<input type='hidden' name='corner2' value='$row[corner2]'/>";
		echo "<input type='hidden' name='corner3' value='$row[corner3]'/>";
		echo "<input type='hidden' name='corner4' value='$row[corner4]'/>";
		echo "<td><input id='delete' type='submit' name='delete' value='Delete'/></form></td>";
		echo "</tr>";
	}

	echo "</table>";




?>