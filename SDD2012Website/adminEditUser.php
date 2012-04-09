<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/adminStyle.css" />
<title>Admin Edit User Page</title>
</head>
<body>
	<div id="outerContainer">
		<div id="innerContainer">
			<?php include "menuAdmin"?>
			<!--  <div id="rightContentPane">
				Right Content Pane<br>
			</div>-->
			<div id="mainContentPaneAdminUpdate">
				<?php 
				include "Config/configServer.php";
				include "Config/connectServer.php";
				?>
				<br>
				<?php 
				if (isset ($_POST['update']))
				{
					
					$sqlUpdate = "update client set email='$_POST[emailTextBox]', firstName='$_POST[firstNameTextBox]',lastName='$_POST[lastNameTextBox]',adminFlag=$_POST[adminFlagTextBox],facultyFlag=$_POST[facultyFlagTextBox],studentFlag=$_POST[studentFlagTextBox],handicapFlag=$_POST[handicapFlagTextBox],tempPassFlag=$_POST[tempPassFlagTextBox] where password='$_POST[password]';";
					$result = mysql_query($sqlUpdate);

					if (!$result)
						die('Invalid query: ' . mysql_error());
					else 
						echo "Successfully update user with first name: $_POST[firstNameTextBox] and last name: $_POST[lastNameTextBox] with email of: $_POST[emailTextBox]";
					
				}
				if(isset ($_POST['edit']))
				{
					$sql = "select * from client;";
					$result = mysql_query($sql);
						
					if (!$result)
						die('Invalid query: ' . mysql_error());
					
					echo"<table id='editTable'>";
					echo"<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Admin</th><th>Faculty</th><th>Student</th><th>Handicap</th><th>Temp Password</th><th>Action</th></tr>";
					while ($row = mysql_fetch_array($result))
					{
						
						if ($row[email] == $_POST['emailEdit'])
						{
							echo "<form style='margin:0px' id='updateForm' name='updateForm' action='$PHP_SELF?>' method='post'>";
							echo "<input type='hidden' name='password' value='$row[password]'/>";
							echo "<tr>";							
							echo "<td><input type='text' style='width:100%' name='firstNameTextBox' value='$row[firstName]'/></td>";
							echo "<td><input type='text' style='width:100%' name='lastNameTextBox' value='$row[lastName]'/></td>";
							echo "<td><input type='text' style='width:100%' name='emailTextBox' value='$row[email]'/></td>";
							echo "<td><input type='text' style='width:100%' name='adminFlagTextBox' value='$row[adminFlag]'/></td>";
							echo "<td><input type='text' style='width:100%' name='facultyFlagTextBox' value='$row[facultyFlag]'/></td>";
							echo "<td><input type='text' style='width:100%' name='studentFlagTextBox' value='$row[studentFlag]'/></td>";
							echo "<td><input type='text' style='width:100%' name='handicapFlagTextBox' value='$row[handicapFlag]'/></td>";
							echo "<td><input type='text' style='width:100%' name='tempPassFlagTextBox' value='$row[tempPassFlag]'/></td>";
							echo "<td><input id='update' type='submit' name='update' value='Update'/></form></td>";
							echo "</tr>";
						}
						else 
						{
							echo "<form style='margin:0px' id='editForm' name='editForm' action='$PHP_SELF?>' method='post'>";
							echo "<input type='hidden' name='password' value='$row[password]'/>";
							echo "<tr>";							
							echo "<td><input type='hidden' name='firstName' value='$row[firstName]'/>$row[firstName]</td>";
							echo "<td><input type='hidden' name='lastName' value='$row[lastName]'/>$row[lastName]</td>";
							echo "<td><input type='hidden' name='emailEdit' value='$row[email]'/>$row[email]</td>";
							echo "<td><input type='hidden' name='adminFlag' value='$row[adminFlag]'/>$row[adminFlag]</td>";
							echo "<td><input type='hidden' name='facultyFlag' value='$row[facultyFlag]'/>$row[facultyFlag]</td>";
							echo "<td><input type='hidden' name='studentFlag' value='$row[studentFlag]'/>$row[studentFlag]</td>";
							echo "<td><input type='hidden' name='handicapFlag' value='$row[handicapFlag]'/>$row[handicapFlag]</td>";
							echo "<td><input type='hidden' name='tempPassFlag' value='$row[tempPassFlag]'/>$row[tempPassFlag]</td>";						
							echo "<td><input id='edit' type='submit' name='edit' value='Edit'/></form></td>";
							echo "</tr>";
						}
						
						
					}
						

				}
				 
				else 
				{
					$sql = "select * from client;";

					$result = mysql_query($sql);

					if (!$result)
						die('Invalid query: ' . mysql_error());

					echo"<table id='preEditTable'>";
					echo"<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Admin</th><th>Faculty</th><th>Student</th><th>Handicap</th><th>Temp Password</th><th>Action</th></tr>";
					while ($row = mysql_fetch_array($result))
					{
						echo "<form style='margin:0px' id='editForm' name='edit' action='$PHP_SELF?>' method='post'>";
						echo "<input type='hidden' name='password' value='$row[password]'/>";
						echo "<tr>";						
						echo "<td><input type='hidden' name='firstName' value='$row[firstName]'/>$row[firstName]</td>";
						echo "<td><input type='hidden' name='lastName' value='$row[lastName]'/>$row[lastName]</td>";
						echo "<td><input type='hidden' name='emailEdit' value='$row[email]'/>$row[email]</td>";
						echo "<td><input type='hidden' name='adminFlag' value='$row[adminFlag]'/>$row[adminFlag]</td>";
						echo "<td><input type='hidden' name='facultyFlag' value='$row[facultyFlag]'/>$row[facultyFlag]</td>";
						echo "<td><input type='hidden' name='studentFlag' value='$row[studentFlag]'/>$row[studentFlag]</td>";
						echo "<td><input type='hidden' name='handicapFlag' value='$row[handicapFlag]'/>$row[handicapFlag]</td>";
						echo "<td><input type='hidden' name='tempPassFlag' value='$row[tempPassFlag]'/>$row[tempPassFlag]</td>";						
						echo "<td><input id='edit' type='submit' name='edit' value='Edit'/></form></td>";
						echo "</tr>";
					}
				}
				Include "Config/closedbServer.php";
				?>
			</div>
		</div>
	</div>
</body>
</html>
