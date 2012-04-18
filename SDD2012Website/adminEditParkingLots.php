<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/adminStyle.css" />
<title>Admin Edit Parking Page</title>
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
			
			
				if(isset($_POST['delete']))
				{
					echo "YES SIR!!<br>";
				}
				if(isset($_POST['update']))
				{
					echo "HOLY SHIT<br>";
				}
				if(isset($_POST['edit']))
				{
					$sql = "select * from parkinglot;";
					$result = mysql_query($sql);
					
					if (!$result)
						die('Invalid query: ' . mysql_error());
					
					echo "<table id='editTableLots'>";
					echo "<tr><th>Lot ID</th><th>Student Lot</th><th>Faculty Lot</th><th>Boundry 1</th><th>Boundry 2</th><th>Boundry 3</th><th>Boundry 4</th><th>Direction To</th><th>Action</th></tr>";
					if($_POST['lotId'] == 'new')
					{
						echo "<form style='margin:0px' id='updateForm' name='updateForm' action='$PHP_SELF?>' method='post'>";
						echo "<tr>";
						echo "<td><input type='text' style='width:100%' name='lotId' value='#'></td>";
						echo "<td><input type='text' style='width:100%' name='studentLot' value='new'></td>";
						echo "<td><input type='text' style='width:100%' name='facultyLot' value='new'></td>";
						echo "<td><input type='text' style='width:100%' name='boundary1' value='new'></td>";
						echo "<td><input type='text' style='width:100%' name='boundary2' value='new'></td>";
						echo "<td><input type='text' style='width:100%' name='boundary3' value='new'></td>";
						echo "<td><input type='text' style='width:100%' name='boundary4' value='new'></td>";
						echo "<td><input type='text' style='width:100%' name='directionTo' value='new'></td>";
						echo "<td><input id='update' type='submit' name='update' value='Update'/></form></td>";
						echo "</tr>";
					}
					else 
					{
						echo "<form style='margin:0px' id='editForm' name='editForm' action='$PHP_SELF?>' method='post'>";
						echo "<tr>";
						echo "<td><input type='hidden' style='width:100%' name='lotId' value='new'>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='studentLot' value='new'>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='facultyLot' value='new'>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='boundary1' value='new'>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='boundary2' value='new'>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='boundary3' value='new'>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='boundary4' value='new'>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='directionTo' value='new'>New</td>";
						echo "<td><input id='edit' type='submit' name='edit' value='Edit'/></form></td>";
						echo "</tr>";
						
					}
					while ($row = mysql_fetch_array($result))
					{
						if ($row[lotId] == $_POST['lotId'])
						{
							echo "<form style='margin:0px' id='updateForm' name='updateForm' action='$PHP_SELF?>' method='post'>";
							echo "<tr>";
							echo "<td><input type='text' style='width:100%' name='lotId' value='$row[lotId]'></td>";
							echo "<td><input type='text' style='width:100%' name='studentLot' value='$row[studentLot]'></td>";
							echo "<td><input type='text' style='width:100%' name='facultyLot' value='$row[facultyLot]'></td>";
							echo "<td><input type='text' style='width:100%' name='boundary1' value='$row[Boundary1]'></td>";
							echo "<td><input type='text' style='width:100%' name='boundary2' value='$row[Boundary2]'></td>";
							echo "<td><input type='text' style='width:100%' name='boundary3' value='$row[Boundary3]'></td>";
							echo "<td><input type='text' style='width:100%' name='boundary4' value='$row[Boundary4]'></td>";
							echo "<td><input type='text' style='width:100%' name='directionTo' value='$row[directionTo]'></td>";
							echo "<td><input id='update' type='submit' name='update' value='Update'/></form></td>";
							echo "</tr>";
						}
						else
						{
							echo "<form style='margin:0px' id='editForm' name='edit' action='$PHP_SELF?>' method='post'>";
							echo "<input type='hidden' name='password' value='$row[password]'/>";
							echo "<tr>";
					
							echo "<td><input type='hidden' name='lotId' value='$row[lotId]'/>$row[lotId]</td>";
							echo "<td><input type='hidden' name='studentLot' value='$row[studentLot]'/>$row[studentLot]</td>";
							echo "<td><input type='hidden' name='facultyLot' value='$row[facultyLot]'/>$row[facultyLot]</td>";
							echo "<td><input type='hidden' name='boundary1' value='$row[Boundary1]'/>$row[Boundary1]</td>";
							echo "<td><input type='hidden' name='boundary2' value='$row[Boundary2]'/>$row[Boundary2]</td>";
							echo "<td><input type='hidden' name='boundary3' value='$row[Boundary3]'/>$row[Boundary3]</td>";
							echo "<td><input type='hidden' name='boundary4' value='$row[Boundary4]'/>$row[Boundary4]</td>";
							echo "<td><input type='hidden' name='directionTo' value='$row[directionTo]'/>$row[directionTo]</td>";
							echo "<td><input id='edit' type='submit' name='edit' value='Edit'/></form></td>";
							echo "</tr>";
						}
					}
					
				}
				
				// This gets executed on the very first page load and as a fall through effect for updating and editing
				else 
				{
					$sql = "select * from parkinglot;";
					$result = mysql_query($sql);
					
					if (!$result)
						die('Invalid query: ' . mysql_error());
						
					echo "<table id='preEditTableLots'>";
					echo "<tr><th>Lot ID</th><th>Student Lot</th><th>Faculty Lot</th><th>Boundry 1</th><th>Boundry 2</th><th>Boundry 3</th><th>Boundry 4</th><th>Direction To</th><th>Action</th><th>Delete</th></tr>";
					
					//Set up the very first row to be a row for adding lots
					echo "<form style='margin:0px' id='editForm' name='edit' action='$PHP_SELF?>' method='post'>";
					echo "<td><input type='hidden' name='lotId' value='new'>New</td>";
					echo "<td><input type='hidden' name='studentLot' value='new'>New</td>";
					echo "<td><input type='hidden' name='facultyLot' value='new'>New</td>";
					echo "<td><input type='hidden' name='boundary1' value='new'>New</td>";
					echo "<td><input type='hidden' name='boundary2' value='new'>New</td>";
					echo "<td><input type='hidden' name='boundary3' value='new'>New</td>";
					echo "<td><input type='hidden' name='boundary4' value='new'>New</td>";
					echo "<td><input type='hidden' name='directionTo' value='new'>New</td>";
					echo "<td><input id='edit' type='submit' name='edit' value='Add'/></form></td>";
					echo "<td></td>";
					echo "</tr>";
					
					while ($row = mysql_fetch_array($result))
					{
						//Edit Form
						echo "<form style='margin:0px' id='editForm' name='edit' action='$PHP_SELF?>' method='post'>";
						echo "<input type='hidden' name='password' value='$row[password]'/>";
						echo "<tr>";
						
						echo "<td><input type='hidden' name='lotId' value='$row[lotId]'/>$row[lotId]</td>";
						echo "<td><input type='hidden' name='studentLot' value='$row[studentLot]'/>$row[studentLot]</td>";
						echo "<td><input type='hidden' name='facultyLot' value='$row[facultyLot]'/>$row[facultyLot]</td>";
						echo "<td><input type='hidden' name='boundary1' value='$row[Boundary1]'/>$row[Boundary1]</td>";
						echo "<td><input type='hidden' name='boundary2' value='$row[Boundary2]'/>$row[Boundary2]</td>";
						echo "<td><input type='hidden' name='boundary3' value='$row[Boundary3]'/>$row[Boundary3]</td>";
						echo "<td><input type='hidden' name='boundary4' value='$row[Boundary4]'/>$row[Boundary4]</td>";
						echo "<td><input type='hidden' name='directionTo' value='$row[directionTo]'/>$row[directionTo]</td>";
						echo "<td><input id='edit' type='submit' name='edit' value='Edit'/></form></td>";
						
						//Delete Form
						echo "<form style='margin:0px' id='deleteForm' name='delete' action='$PHP_SELF?>' method='post'>";
						echo "<input type='hidden' name='password' value='$row[password]'/>";
						echo "<input type='hidden' name='lotId' value='$row[lotId]'/>";
						echo "<input type='hidden' name='studentLot' value='$row[studentLot]'/>";
						echo "<input type='hidden' name='facultyLot' value='$row[facultyLot]'/>";
						echo "<input type='hidden' name='boundary1' value='$row[Boundary1]'/>";
						echo "<input type='hidden' name='boundary2' value='$row[Boundary2]'/>";
						echo "<input type='hidden' name='boundary3' value='$row[Boundary3]'/>";
						echo "<input type='hidden' name='boundary4' value='$row[Boundary4]'/>";
						echo "<input type='hidden' name='directionTo' value='$row[directionTo]'>";
						echo "<td><input id='delete' type='submit' name='delete' value='Delete'/></form></td>";
						echo "</tr>";
						
						
						
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
		echo "You are not logged in"; 
?>
</body>
</html>