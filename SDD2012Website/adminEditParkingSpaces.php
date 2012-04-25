<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/adminStyle.css" />
<script type="text/javascript" src="Scripts/adminParkingSpacesAjaxCall.js"></script>
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
			
			$errorKey = NULL;
			$isKosher = NULL;
			$previousLotID = NULL;
			
				if(isset($_POST['delete']))
				{
					if($_POST['spaceId']!="new")
					{
						$sqlDelete = "delete from parkingspace where spaceId=$_POST[spaceId]";
						$resultDelete = mysql_query($sqlDelete);
						
						if(!$resultDelete)
							die('Oh No ... Invalid Query: ' . mysql_error());
					}
					
					
					$sqlSetup = "select * from parkinglot order by lotId asc;";
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
							echo "<option value='$row[lotId]'>$row[lotId]</option>";
						}
						echo "</select>";
						echo "</form>";
					
					
					$sqlSelect = "select * from parkingspace where ParkingLot_lotId='$_POST[lotId]' order by spaceId desc;";
					$resultSelect = mysql_query($sqlSelect);
					
					if(!$resultSelect)
						die("Invalid select query:" . mysql_error());
					
					
					//Set up table
					echo "<table id='preEditTableSpaces' style='font-size:10px'>";
					echo "<tr><th>Space ID</th><th>Lot #</th><th>Client Email</th><th>Open</th><th>Handicap</th><th>Corner 1</th><th>Corner 2</th><th>Corner 3</th><th>Corner 4</th><th>Action</th><th>Delete</th></tr>";
					
					//Set up the very first row to be a row for adding lots
					echo "<form style='margin:0px' class='smallFont' id='editForm' name='edit' action='$PHP_SELF?>' method='post'>";
					echo "<tr>";
					echo "<td><input type='hidden' name='spaceId' value='new'>New</td>";
					echo "<td><input type='hidden' name='lotId' value='$_POST[lotId]'>$_POST[lotId]</td>";
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
						echo "<tr>";
					
						echo "<td><input type='hidden' name='spaceId' value='$row[spaceId]'/>$row[spaceId]</td>";
						echo "<td><input type='hidden' name='lotId' value='$row[ParkingLot_lotId]'/>$row[ParkingLot_lotId]</td>";
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
						echo "<input type='hidden' name='lotId' value='$row[ParkingLot_lotId]'/>";
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
					
					
				}
				if(isset($_POST['update']))
				{
					//All sanitation checks passed
					//Just for test purposes kosher is ture
					//echo"<pre>".var_dump($_POST)."</pre><br>";
					$errorKey = $_POST['spaceId'];
					if(isset($_POST['newHidden']))
						$errorKey='NEW';
					$isKosher = kosher($_POST['lotId'], $_POST['spaceId'], $_POST['available'],$_POST['handicap'] ,$_POST['corner1'], $_POST['corner2'], $_POST['corner3'], $_POST['corner4']) ;
					$num_results = NULL;
					
					if($isKosher == NULL)
					{
						$sqlCheck = "select * from parkingspace where ParkingLot_lotId=$_POST[lotId] and spaceId=$_POST[spaceId];";
						$resultCheck = mysql_query($sqlCheck);
						
						if(!$resultCheck)
							die('Oh No ... Invalid Query: ' . mysql_error());
						
						$num_results = mysql_num_rows($resultCheck);
						
						//Check to see if updating or deleting
						if ($num_results <= 0)
						{
							$sqlInsert = "insert into parkingspace values ($_POST[spaceId],$_POST[lotId], '$_POST[clientEmail]',$_POST[available] ,$_POST[handicap] ,'$_POST[corner1]','$_POST[corner2]','$_POST[corner3]','$_POST[corner4]');";
							$resultInsert = mysql_query($sqlInsert);
							if(!$resultInsert)
								die('Ooopsss NO Insert '. mysql_error());
						}
						else
						{
							
							$sqlUpdate= "UPDATE  parkingspace set Client_email ='$_POST[clientEmail]', available=$_POST[available], handicap=$_POST[handicap], corner1='$_POST[corner1]', corner2='$_POST[corner2]', corner3='$_POST[corner3]', corner4='$_POST[corner4]' where spaceId=$_POST[spaceId] and ParkingLot_lotId=$_POST[lotId];";
							$resultUpdate = mysql_query($sqlUpdate);
							
							if(!resultUpdate)
								die('Uhh Ohh No update' . mysql_error());
								
						}
					}
										
					$sqlSetup = "select * from parkinglot order by lotId asc;";
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
						echo "<option value='$row[lotId]'>$row[lotId]</option>";
					}
					echo "</select>";
					echo "</form>";
					
					$sqlSelect = "select * from parkingspace where ParkingLot_lotId='$_POST[lotId]' order by spaceId desc;";
					$resultSelect = mysql_query($sqlSelect);
					
					if(!$resultSelect)
						die("Invalid select query:" . mysql_error());
					
					echo "<div id='errorDiv'>$isKosher<br></div>";
					//Set up table
					echo "<div id='tableDiv'>";
					echo "<table id='preEditTableSpaces' style='font-size:10px'>";
					echo "<tr><th>Space ID</th><th>Lot #</th><th>Client Email</th><th>Open</th><th>Handicap</th><th>Corner 1</th><th>Corner 2</th><th>Corner 3</th><th>Corner 4</th><th>Action</th><th>Delete</th></tr>";
					
					//Set up the very first row to be a row for adding lots
					echo "<form style='margin:0px' class='smallFont' id='editForm' name='edit' action='$PHP_SELF?>' method='post'>";
					if(isset($isKosher) && $errorKey=='NEW')
					{
						echo "<tr style='background-color: red'>";
						$errorKey = NULL;
					
					}
					else
					echo "<tr>";
					echo "<td><input type='hidden' name='spaceId' value='new'>New</td>";
					echo "<td><input type='hidden' name='lotId' value='$_POST[lotId]'>$_POST[lotId]</td>";
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
						if(isset($isKosher) && $errorKey == $row['spaceId'])
						{
							echo "<tr style='background-color: red'>";
							$errorKey = NULL;
					
						}
						else
							echo "<tr>";
					
					echo "<td><input type='hidden' name='spaceId' value='$row[spaceId]'/>$row[spaceId]</td>";
					echo "<td><input type='hidden' name='lotId' value='$row[ParkingLot_lotId]'/>$row[ParkingLot_lotId]</td>";
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
					echo "<input type='hidden' name='lotId' value='$row[ParkingLot_lotId]'/>";
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
					echo "</div>";
					$isKosher = NULL;
					$errorKey = NULL;
				}
				
				//If we are going to edit table
				if(isset($_POST['edit']))
				{
					$sqlSetup = "select * from parkinglot order by lotId asc;";
					$resultSetup = mysql_query($sqlSetup);

					if(!$resultSetup)
						die("Invalid select query:" . mysql_error());
					
					
					$sqlSelect = "select * from parkingspace where ParkingLot_lotId='$_POST[lotId]' order by spaceId desc;";
					$resultSelect = mysql_query($sqlSelect);
					
					if(!$resultSelect)
						die("Invalid select query:" . mysql_error());
					
					echo "<form>";
					echo "<select name='parkingLotId' onchange='showParkingSpaces(this.value,0,0)'>";
					echo "<option value=''>Select A Parking Lot ID:</option>";
					while($row = mysql_fetch_array($resultSetup))
					{
						echo "<option value='$row[lotId]'>$row[lotId]</option>";
					}
					echo "</select>";
					echo "</form>";
					
					//
					//Set up the edit table
					//
					echo "<div id='tableDiv'>";
					echo "<table id='editTableSpaces' style='font-size:10px'>";
					echo "<tr><th>Space ID</th><th>Lot #</th><th>Client Email</th><th>Open</th><th>Handicap</th><th>Corner 1</th><th>Corner 2</th><th>Corner 3</th><th>Corner 4</th><th>Action</th></tr>";
					if($_POST['spaceId'] == 'new')
					{	
						echo "<form style='margin:0px' class='smallFont' id='updateForm' name='updateForm' action='$PHP_SELF?>' method='post'>";
						echo "<input type='hidden' name='newHidden' value='New'>";
						echo "<tr>";
						echo "<td><input type='text' class='smallFont' style='width:100%' name='spaceId' value='#'></td>";
						echo "<td><input type='hidden' class='smallFont' style='width:100%' name='lotId' value='$_POST[lotId]'>$_POST[lotId]</td>";
						echo "<td><input type='text' class='smallFont' style='width:100%' name='clientEmail' value='new'></td>";
						echo "<td><input type='text' class='smallFont' style='width:100%' name='available' value='new'></td>";
						echo "<td><input type='text' class='smallFont' style='width:100%' name='handicap' value='new'></td>";
						echo "<td><input type='text' class='smallFont' style='width:100%' name='corner1' value='new'></td>";
						echo "<td><input type='text' class='smallFont' style='width:100%' name='corner2' value='new'></td>";
						echo "<td><input type='text' class='smallFont' style='width:100%' name='corner3' value='new'></td>";
						echo "<td><input type='text' class='smallFont' style='width:100%' name='corner4' value='new'></td>";
						echo "<td><input id='update' type='submit' name='update' value='Update'/></form></td>";
						echo "</tr>";
					}
					else
					{
						echo "<form style='margin:0px' class='smallFont' id='editForm' name='editForm' action='$PHP_SELF?>' method='post'>";
						echo "<tr>";
						echo "<td><input type='hidden' style='width:100%' name='spaceId' value='new'>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='lotId' value='$_POST[lotId]'>$_POST[lotId]</td>";
						echo "<td><input type='hidden' style='width:100%' name='clientEmail' value='new'>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='available' value='new'>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='handicap' value='new'>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='corner1' value='new'>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='corner2' value='new'>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='corner3' value='new'>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='corner4' value='new'>New</td>";
						echo "<td><input id='edit' type='submit' name='edit' value='Edit'/></form></td>";
						echo "</tr>";
	
					}
					while ($row = mysql_fetch_array($resultSelect))
					{
					if ($row[spaceId] == $_POST['spaceId'])
					{	
						echo "<form style='margin:0px' class='smallFont' id='updateForm' name='updateForm' action='$PHP_SELF?>' method='post'>";
						echo "<tr>";
						echo "<td><input type='hidden' class='smallFont' style='width:100%' name='spaceId' value='$row[spaceId]'>$row[spaceId]</td>";
						echo "<td><input type='hidden' class='smallFont' style='width:100%' name='lotId' value='$row[ParkingLot_lotId]'>$row[ParkingLot_lotId]</td>";
						echo "<td><input type='text' class='smallFont' style='width:100%' name='clientEmail' value='$row[Client_email]'></td>";
						echo "<td><input type='text' class='smallFont' style='width:100%' name='available' value='$row[available]'></td>";
						echo "<td><input type='text' class='smallFont' style='width:100%' name='handicap' value='$row[handicap]'></td>";
						echo "<td><input type='text' class='smallFont' style='width:100%' name='corner1' value='$row[corner1]'></td>";
						echo "<td><input type='text' class='smallFont' style='width:100%' name='corner2' value='$row[corner2]'></td>";
						echo "<td><input type='text' class='smallFont' style='width:100%' name='corner3' value='$row[corner3]'></td>";
						echo "<td><input type='text' class='smallFont' style='width:100%' name='corner4' value='$row[corner4]'></td>";
						echo "<td><input id='update' type='submit' name='update' value='Update'/></form></td>";
						echo "</tr>";
					}
					else
					{
						echo "<form style='margin:0px' class='smallFont' id='editForm' name='edit' action='$PHP_SELF?>' method='post'>";
						echo "<tr>";
						echo "<td><input type='hidden' style='width:100%' name='spaceId' value='$row[spaceId]'>$row[spaceId]</td>";
						echo "<td><input type='hidden' style='width:100%' name='lotId' value='$row[ParkingLot_lotId]'>$row[ParkingLot_lotId]</td>";
						echo "<td><input type='hidden' style='width:100%' name='clientEmail' value='$row[Client_email]'>$row[Client_email]</td>";
						echo "<td><input type='hidden' style='width:100%' name='available' value='$row[available]'>$row[available]</td>";
						echo "<td><input type='hidden' style='width:100%' name='handicap' value='$row[handicap]'>$row[handicap]</td>";
						echo "<td><input type='hidden' style='width:100%' name='corner1' value='$row[corner1]'>$row[corner1]</td>";
						echo "<td><input type='hidden' style='width:100%' name='corner2' value='$row[corner2]'>$row[corner2]</td>";
						echo "<td><input type='hidden' style='width:100%' name='corner3' value='$row[corner3]'>$row[corner3]</td>";
						echo "<td><input type='hidden' style='width:100%' name='corner4' value='$row[corner4]'>$row[corner4]</td>";
						echo "<td><input id='edit' type='submit' name='edit' value='Edit'/></form></td>";
						echo "</tr>";
					}
				}
	
				echo "</table>";
				echo "</div>";
				}
				
				// This gets executed on the very first page load and as a fall through effect for updating and editing
				else 
				{
					if(!isset($_POST['update']) || !isset($_POST['delete']))
					{
						$sqlSetup = "select * from parkinglot order by lotId asc;";
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
							echo "<option value='$row[lotId]'>$row[lotId]</option>";
						}
						echo "</select>";
						echo "</form>";
						?>
						<div id='tableDiv'>
						<?php

						//Table data will be inserted here from an Ajax call	
					
						?>
						</div>
					
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