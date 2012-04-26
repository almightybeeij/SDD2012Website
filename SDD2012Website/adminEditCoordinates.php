<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/adminStyle.css" />
<script type="text/javascript" src="Scripts/adminCoordinatesAjaxCall.js"></script>
<script type="text/javascript" src="Scripts/adminUpdateCoordinatesAjaxCall.js"></script>
<title>Admin Edit Parking Spaces Page</title>
</head>
<body>
<?php if (isset($_SESSION['sessionCookie']) && $_SESSION['userType'] == "admin")
	{
	?>
<div id="outerContainer">
	<div id="innerContainer">
	<?php include "menuAdmin"?>
		<!--  <div id="rightContentPane">
			Right Content Pane<br>
			Edit Parking Page Lots<br>			
		</div>-->
		<div id="mainContentPaneAdminUpdate">
			<?php
			
			include "Config/configServer.php";
			include "Config/connectServer.php";
			include "Scripts/adminParkingFieldValidation.php";
			
			$errorKey = "New";
			$error = "";
			$previousLotID = NULL;
			
				if(isset($_POST['delete']))
				{
					if($_POST['ParkingLot_lotId']!="new")
					{
						$sqlDelete = "delete from coordinates where ParkingLot_lotId=$_POST[ParkingLot_lotId] and coordinates='$_POST[coordinates]'";
						$resultDelete = mysql_query($sqlDelete);
						
						if(!$resultDelete)
							die('Oh No ... Invalid Query: ' . mysql_error());
					}
					
					
					$sqlSetup = "select distinct ParkingLot_lotId from coordinates;";
					$resultSetup = mysql_query($sqlSetup);
						
					if(!$resultSetup)
						die("Invalid Query from parkinglot" . mysql_error());
					
					echo "<form>";
						
					if(!empty($error))
						echo "<select name='parkingLotId' onchange='showParkingSpaces(this.value,\"$errorKey\",1)'>";
					
						else
							echo "<select name='parkingLotId' onchange='showParkingSpaces(this.value,0,0)'>";
						echo "<option value=''>Select A Parking Lot ID:</option>";
						while($row = mysql_fetch_array($resultSetup))
						{
							echo "<option value='$row[ParkingLot_lotId]'>$row[ParkingLot_lotId]</option>";
						}
						echo "</select>";
						echo "</form>";
						
						$sqlSelect = "select * from coordinates where ParkingLot_lotId='$_POST[ParkingLot_lotId]' order by drawOrder asc;";
						$resultSelect = mysql_query($sqlSelect);
							
						if(!$resultSelect)
							die("Invalid select query:" . mysql_error());
					//Set up table
					echo "<div id='tableDiv'>";
					echo "<table id='preEditTableCoordinates'>";
					echo "<tr><th>Parking Lot ID</th><th>Coordinates</th><th>Draw Order</th><th>Action</th><th>Delete</th></tr>";
					
					//Set up the very first row to be a row for adding lots
					echo "<form style='margin:0px' id='editForm' name='edit' action='$PHP_SELF?>' method='post'>";
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
					echo "</div>";
					echo "<div id='errorDiv'></div>";
					
				}
				
				if(isset($_POST['update']))
				{
					//All sanitation checks passed
					//Just for test purposes kosher is ture
					//echo"<pre>".var_dump($_POST)."</pre><br>";
					
					
					$sqlSetup = "select distinct ParkingLot_lotId from coordinates;";
					$resultSetup = mysql_query($sqlSetup);
						
					if(!$resultSetup)
						die("Invalid Query from parkinglot" . mysql_error());
					
					echo "<form>";
						
					if(!empty($error))
						echo "<select name='parkingLotId' onchange='showParkingSpaces(this.value,\"$errorKey\",1)'>";
					
					else
						echo "<select name='parkingLotId' onchange='showParkingSpaces(this.value,0,0)'>";
					echo "<option value=''>Select A Parking Lot ID:</option>";
					while($row = mysql_fetch_array($resultSetup))
					{
						echo "<option value='$row[ParkingLot_lotId]'>$row[ParkingLot_lotId]</option>";
					}
					echo "</select>";
					echo "</form>";
					
					$sqlSelect = "select * from coordinates where ParkingLot_lotId='$_POST[ParkingLot_lotId]' order by drawOrder asc;";
					$resultSelect = mysql_query($sqlSelect);
					
					if(!$resultSelect)
						die("Invalid select query:" . mysql_error());
					
					
					//Set up table
					echo "<div id='tableDiv'>";
					echo "<table id='preEditTableCoordinates'>";
					echo "<tr><th>Parking Lot ID</th><th>Coordinates</th><th>Draw Order</th><th>Action</th><th>Delete</th></tr>";
					//Set up the very first row to be a row for adding lots
					echo "<form style='margin:0px' id='editForm' name='edit' action='$PHP_SELF?>' method='post'>";
					echo "<input type='hidden' name='lotId' value='$lotId'/>";
					if(isset($error) && $errorKey == "New")
					{
					echo "<tr style='background-color: red'>";
					$errorKey = NULL;
					
					}
					else
						echo "<tr>";
					echo "<td><input type='hidden' name='parkingLot_lotId' value='new'>New</td>";
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
					echo "</div>";
			
				}
				
				//If we are going to edit table
				if(isset($_POST['edit']))
				{
					$count = 0;
					$sqlSetup = "select distinct ParkingLot_lotId from coordinates;";
					$resultSetup = mysql_query($sqlSetup);

					if(!$resultSetup)
						die("Invalid select query:" . mysql_error());
					
					
					$sqlSelect = "select * from coordinates where ParkingLot_lotId='$_POST[ParkingLot_lotId]' order by drawOrder asc;";
					$resultSelect = mysql_query($sqlSelect);
					
					if(!$resultSelect)
						die("Invalid select query:" . mysql_error());
					
					echo "<form>";
					echo "<select name='parkingLotId' onchange='showParkingSpaces(this.value,0,0)'>";
					echo "<option value=''>Select A Parking Lot ID:</option>";
					while($row = mysql_fetch_array($resultSetup))
					{
						echo "<option value='$row[ParkingLot_lotId]'>$row[ParkingLot_lotId]</option>";
					}
					echo "</select>";
					echo "</form>";
					
					//
					//Set up the edit table
					//				
					echo "<div id='tableDiv'>";
					echo "<table id='editTableCoordinates'>";
					echo "<tr><th>Parking Lot ID</th><th>Coordinates</th><th>Old Draw Order</th><th>New Draw Order</th><th>Action</th></tr>";
					if($_POST['coordinates'] == 'new')
					{
						echo "<form style='margin:0px' class='smallFont' id='updateForm$count' name='updateForm$count' action='$PHP_SELF?>' method='post'>";
						echo "<input type='hidden' name=newField value='New'/>";
						echo "<tr id='tableRow$count'>";
						echo "<td><input type='hidden' style='width:100%' id='ParkingLot_lotId$count' name='ParkingLot_lotId$count' value='$_POST[ParkingLot_lotId]'>$_POST[ParkingLot_lotId]</td>";
						echo "<td><input type='text' style='width:100%' id='coordinates$count' name='coordinates$count' value='new'></td>";
						echo "<td><input type='hidden' style='width:100%' id='oldDrawOrder$count' name='oldDrawOrder$count' value='NULL'></td>";
						echo "<td><input type='text' style='width:100%' id='drawOrder$count' name='drawOrder$count' value='#'></td>";
						echo "<td><input id='update$count' type='button' name='update' onclick='updateCoordinates(updateForm$count.ParkingLot_lotId$count.value, updateForm$count.coordinates$count.value, updateForm$count.drawOrder$count.value, $count)' value='Update'/></form></td>";
						echo "</tr>";
					}
					else
					{
						echo "<form style='margin:0px' class='smallFont' id='editForm' name='editForm' action='$PHP_SELF?>' method='post'>";
						echo "<tr>";
						echo "<td><input type='hidden' style='width:100%' name='ParkingLot_lotId' value='$_POST[ParkingLot_lotId]'>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='coordinates' value='new'>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='oldDrawOrder' value='NULL'></td>";
						echo "<td><input type='hidden' style='width:100%' name='drawOrder' value='new'>New</td>";
						echo "<td><input id='edit' type='submit' name='edit' value='Edit'/></form></td>";
						echo "</tr>";
	
					}
					while ($row = mysql_fetch_array($resultSelect))
					{
						$count += 1;
					
						echo "<form style='margin:0px' class='smallFont' id='updateForm$count' name='updateForm$count' action='$PHP_SELF?>' method='post'>";
						echo "<tr id='tableRow$count'>";
						echo "<td><input type='hidden' style='width:100%' id='ParkingLot_lotId$count' name='ParkingLot_lotId$count' value='$row[ParkingLot_lotId]'>$row[ParkingLot_lotId]</td>";
						echo "<td><input type='text' style='width:100%' id='coordinates$count' name='coordinates$count' value='$row[coordinates]'></td>";
						echo "<td><input type='hidden' style='width:100%' id='oldDrawOrder$count' name='oldDrawOrder$count' value='$row[drawOrder]'>$row[drawOrder]</td>";
						echo "<td><input type='text' style='width:100%' id='drawOrder$count' name='drawOrder$count' value='#'></td>";
						echo "<td><input id='update$count' type='button' name='update' onclick='updateCoordinates(updateForm$count.ParkingLot_lotId$count.value, updateForm$count.coordinates$count.value, updateForm$count.drawOrder$count.value, $count)' value='Update'/></form></td>";
						echo "</tr>";					
				}
	
				echo "</table>";
				echo "</div>";
				echo "<div id='errorDiv'></div>";
				}
				
				// This gets executed on the very first page load and as a fall through effect for updating and editing
				else 
				{
					if(!isset($_POST['update']) && !isset($_POST['edit']) && !isset($_POST['delete']))
					{
						$sqlSetup = "select distinct ParkingLot_lotId from coordinates;";
						$resultSetup = mysql_query($sqlSetup);
					
						if(!$resultSetup)
							die("Invalid Query from parkinglot" . mysql_error());
						
						echo "<form>";
					
						if(!empty($error))
							echo "<select name='parkingLotId' onchange='showParkingSpaces(this.value,\"$errorKey\",1)'>";
					 
						else
							echo "<select name='parkingLotId' onchange='showParkingSpaces(this.value,0,0)'>";
						echo "<option value=''>Select A Parking Lot ID:</option>";
						while($row = mysql_fetch_array($resultSetup))
						{
							echo "<option value='$row[ParkingLot_lotId]'>$row[ParkingLot_lotId]</option>";
						}
						echo "</select>";
						echo "</form>";
						?>
						
						<div id='tableDiv'>
						<?php

						//Table data will be inserted here from an Ajax call	
					
						?>
						</div>
						<div id='errorDiv'></div>
						<?php 	
					}
				}
			
				Include "Config/closedbServer.php";
				?>
				<?php echo "<div>$error<br></div>";?>
					
		</div>
	</div>
</div>
<?php
	}
	else
	{
		header('Refresh: 3; URL= index.php'); 
		echo "You are not logged in";
	} 
?>
</body>
</html>
