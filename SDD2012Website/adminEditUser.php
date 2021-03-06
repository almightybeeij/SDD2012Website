<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/adminStyle.css" />
<title>Admin Edit User Page</title>
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
			</div>-->
			<div id="mainContentPaneAdminUpdate">
				<?php 
				include "Config/configServer.php";
				include "Config/connectServer.php";
				require_once "Mail.php";
				include "Scripts/emailValidation.php";
				include "Scripts/adminUserFieldValidation.php";
				$error = NULL;
				$errorKey = NULL;
				?>
				<br>
				<?php

				if (isset ($_POST['delete']))
				{
					//echo "Deleting";
					
					if($_POST['email'] != "new")
					{
						$sqlDelete = "delete from client where email='$_POST[email]' and password='$_POST[password]';";
						// Get result from the mysql query execution
						$result = mysql_query($sqlDelete);
							
						// If query failed then print error
						if (!$result)
							die('Invalid delete query In Statement: ' . mysql_error());
					}
				}
				
				if (isset ($_POST['update']))
				{
					$errorKey = NULL;
					// This means it's a new user that we are adding so we will insert into database
					if($_POST['password'] == '' && $_POST['tempPassFlag'] == 1)
					{
						$error = validateFields($_POST['firstNameTextBox'],$_POST['lastNameTextBox'],$_POST['emailTextBox'],$_POST['adminFlagTextBox'],$_POST['facultyFlagTextBox'],$_POST['studentFlagTextBox'],$_POST['handicapFlagTextBox'],1);
						if(!isset($error))
						{
							$sqlInsert = "insert into client values ('$_POST[emailTextBox]','NULL','$_POST[firstNameTextBox]','$_POST[lastNameTextBox]','$_POST[adminFlagTextBox]','$_POST[facultyFlagTextBox]','$_POST[studentFlagTextBox]','$_POST[handicapFlagTextBox]','$_POST[tempPassFlag]');";
						
							// Get result from the mysql query execution
							$result = mysql_query($sqlInsert);
							
							// If query failed then print error
							if (!$result)
								die('Invalid query In Insert Statement: ' . mysql_error());
						
							//send email to new added user
							$time = time();
							$tempPassword = hash ('md5', $time);
						
							$tempPasswordHash = hash ('sha256',$tempPassword);
						
							$sqlUpdate = "update client set password='$tempPasswordHash'where email='$_POST[emailTextBox]';";
							$result2 = mysql_query($sqlUpdate);
						
							if (!$result2)
								die('Invalid query: ' . mysql_error());
						
						
							$from = "software.design.development@gmail.com";
							$to = $_POST[emailTextBox];
							$subject = "Your new temporary password";
							$body = "Hi,\n\nYou have been added to the database by an Administrator.\n Please use this temporary password to log in: $tempPasswordHash";
						
							$headers = array('From' => $from, 'To'=>$to, 'Subject'=>$subject);
						
							$smtp = Mail::factory('smtp', array('host' => "ssl://smtp.gmail.com", 'port' => '465', 'auth' => true, 'username' => "software.design.development@gmail.com", 'password' => "sddspring2012"));
						
							$mail = $smtp->send($to, $headers, $body);
						
							if(!(PEAR::isError($mail)))
							{
								echo "Mail With Temporary Password Sent Successfully to:<br>$_POST[firstNameTextBox] $_POST[lastNameTextBox] at email address of: $_POST[emailTextBox]";
							}
							else
								echo "<pre>".$mail -> getMessage()."<br>".$mail->getCode()."</pre>";
						}
						else 
						{
							$errorKey = "NEW";
						}
						
					}
					
					// This not a new user so we just want to update the user
					else 
					{
						$error = validateFields($_POST['firstNameTextBox'],$_POST['lastNameTextBox'],$_POST['emailTextBox'],$_POST['adminFlagTextBox'],$_POST['facultyFlagTextBox'],$_POST['studentFlagTextBox'],$_POST['handicapFlagTextBox'],$_POST['tempPassFlagTextBox']);
						if (!isset($error))
						{
							$sqlUpdate = "update client set email='$_POST[emailTextBox]', firstName='$_POST[firstNameTextBox]',lastName='$_POST[lastNameTextBox]',adminFlag=$_POST[adminFlagTextBox],facultyFlag=$_POST[facultyFlagTextBox],studentFlag=$_POST[studentFlagTextBox],handicapFlag=$_POST[handicapFlagTextBox],tempPassFlag=$_POST[tempPassFlagTextBox] where password='$_POST[password]';";
							$result = mysql_query($sqlUpdate);

							if (!$result)
								die('Invalid query in Update Statement: ' . mysql_error());
							else 
								echo "Successfully update user with first name: $_POST[firstNameTextBox] and last name: $_POST[lastNameTextBox] with email of: $_POST[emailTextBox]";
						}
						else 
						{
							$errorKey = $_POST['emailTextBox'];
						}
					}
					
				}
				if(isset ($_POST['edit']))
				{
					$sql = "select * from client order by email asc;";
					$result = mysql_query($sql);
						
					if (!$result)
						die('Invalid query: ' . mysql_error());
					
					echo"<table id='editTableUsers'>";
					echo"<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Admin</th><th>Faculty</th><th>Student</th><th>Handicap</th><th>Temp Password</th><th>Action</th></tr>";
					
					if($_POST['email'] == 'new' && $_POST['password'] == '')
					{
						
						echo "<form style='margin:0px' id='updateForm' name='updateForm' action='$PHP_SELF?>' method='post'>";
						echo "<input type='hidden' name='password' value='$row[password]'/>";
						echo "<tr>";
						echo "<td><input type='text' style='width:100%' name='firstNameTextBox' value='New'/></td>";
						echo "<td><input type='text' style='width:100%' name='lastNameTextBox' value='New'/></td>";
						echo "<td><input type='text' style='width:100%' name='emailTextBox' value='New'/></td>";
						echo "<td><input type='text' style='width:100%' name='adminFlagTextBox' value='New'/></td>";
						echo "<td><input type='text' style='width:100%' name='facultyFlagTextBox' value='New'/></td>";
						echo "<td><input type='text' style='width:100%' name='studentFlagTextBox' value='New'/></td>";
						echo "<td><input type='text' style='width:100%' name='handicapFlagTextBox' value='New'/></td>";
						echo "<td><input type='hidden' name='tempPassFlag' value='1'/>1</td>";
						echo "<td><input id='edit' type='submit' name='update' value='Add'/></form></td>";
						echo "</tr>";
					}
					else
					{
						echo "<form style='margin:0px' id='editForm' name='editForm' action='$PHP_SELF?>' method='post'>";
						echo "<input type='hidden' name='password' value='$row[password]'/>";
						echo "<tr>";
						echo "<td><input type='hidden' style='width:100%' name='firstName' value='new'/>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='lastName' value='new'/>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='email' value='new'/>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='adminFlag' value='new'/>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='facultyFlag' value='new'/>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='studentFlag' value='new'/>New</td>";
						echo "<td><input type='hidden' style='width:100%' name='handicapFlag' value='new'/>New</td>";
						echo "<td><input type='hidden' name='tempPassFlag' value='new'/>New</td>";
						echo "<td><input id='edit' type='submit' name='edit' value='Edit'/></form></td>";
						echo "</tr>";
						
					}
					
					
					while ($row = mysql_fetch_array($result))
					{
						// If this row's email matches the email we want to update then we will use text boxes
						if ($row[email] == $_POST['email'])
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
						
						// If this row's email deos not match the email we want to edit we will use hidden field to store vars
						else 
						{	
							echo "<form style='margin:0px' id='editForm' name='editForm' action='$PHP_SELF?>' method='post'>";
							echo "<input type='hidden' name='password' value='$row[password]'/>";
							echo "<tr>";							
							echo "<td><input type='hidden' name='firstName' value='$row[firstName]'/>$row[firstName]</td>";
							echo "<td><input type='hidden' name='lastName' value='$row[lastName]'/>$row[lastName]</td>";
							echo "<td><input type='hidden' name='email' value='$row[email]'/>$row[email]</td>";
							echo "<td><input type='hidden' name='adminFlag' value='$row[adminFlag]'/>$row[adminFlag]</td>";
							echo "<td><input type='hidden' name='facultyFlag' value='$row[facultyFlag]'/>$row[facultyFlag]</td>";
							echo "<td><input type='hidden' name='studentFlag' value='$row[studentFlag]'/>$row[studentFlag]</td>";
							echo "<td><input type='hidden' name='handicapFlag' value='$row[handicapFlag]'/>$row[handicapFlag]</td>";
							echo "<td><input type='hidden' name='tempPassFlag' value='$row[tempPassFlag]'/>$row[tempPassFlag]</td>";						
							echo "<td><input id='edit' type='submit' name='edit' value='Edit'/></form></td>";
							echo "</tr>";
						}
						
						
					}
						
					echo "</table>";

				}

				// This gets executed on the very first page load and as a fall through effect for updating and editing
				else 
				{
					$sql = "select * from client order by email asc;";

					$result = mysql_query($sql);

					if (!$result)
						die('Invalid query: ' . mysql_error());

					echo "<table id='preEditTableUsers'>";
					echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Admin</th><th>Faculty</th><th>Student</th><th>Handicap</th><th>Temp Password</th><th>Action</th><th>Delete</th></tr>";
					
					//Set up the very first row to be a row for adding users					
					echo "<form style='margin:0px' id='editForm' name='edit' action='$PHP_SELF?>' method='post'>";
					echo "<input type='hidden' name='password' value='$row[password]'/>";
					//If previous attempt to edit fail highlight the row that had an error
					if(isset($errorKey) && $errorKey == "NEW")
					{
						echo "<tr style='background-color: red'>";
						$errorKey = NULL;
							
					}
					else
						echo "<tr>";
					
					echo "<td><input type='hidden' name='firstName' value='new'/>New</td>";
					echo "<td><input type='hidden' name='lastName' value='new'/>New</td>";
					echo "<td><input type='hidden' name='email' value='new'/>New</td>";
					echo "<td><input type='hidden' name='adminFlag' value='new'/>New</td>";
					echo "<td><input type='hidden' name='facultyFlag' value='new'/>New</td>";
					echo "<td><input type='hidden' name='studentFlag' value='new'/>New</td>";
					echo "<td><input type='hidden' name='handicapFlag' value='new'/>New</td>";
					echo "<td><input type='hidden' name='tempPassFlag' value='new'/>New</td>";
					echo "<td><input id='edit' type='submit' name='edit' value='Add'/></form></td>";
					
					//This pads the delete cell for the new row
					echo "<td></td>";
					echo "</tr>";
					
					while ($row = mysql_fetch_array($result))
					{
						//Set up the edit form
						echo "<form style='margin:0px' id='editForm' name='edit' action='$PHP_SELF?>' method='post'>";
						echo "<input type='hidden' name='password' value='$row[password]'/>";
						
						//If previous attempt to edit fail highlight the row that had an error
						if(isset($errorKey) && $errorKey == $row['email'])
						{
							echo "<tr style='background-color: red'>";
							$errorKey = NULL;
							
						}
						else
							echo "<tr>";						
						echo "<td><input type='hidden' name='firstName' value='$row[firstName]'/>$row[firstName]</td>";
						echo "<td><input type='hidden' name='lastName' value='$row[lastName]'/>$row[lastName]</td>";
						echo "<td><input type='hidden' name='email' value='$row[email]'/>$row[email]</td>";
						echo "<td><input type='hidden' name='adminFlag' value='$row[adminFlag]'/>$row[adminFlag]</td>";
						echo "<td><input type='hidden' name='facultyFlag' value='$row[facultyFlag]'/>$row[facultyFlag]</td>";
						echo "<td><input type='hidden' name='studentFlag' value='$row[studentFlag]'/>$row[studentFlag]</td>";
						echo "<td><input type='hidden' name='handicapFlag' value='$row[handicapFlag]'/>$row[handicapFlag]</td>";
						echo "<td><input type='hidden' name='tempPassFlag' value='$row[tempPassFlag]'/>$row[tempPassFlag]</td>";						
						echo "<td><input id='edit' type='submit' name='edit' value='Edit'/></form></td>";
						
						//This is the delete form
						echo "<form style='margin:0px' id='deleteForm' name='delete' action='$PHP_SELF?>' method='post'>";
						echo "<input type='hidden' name='password' value='$row[password]'/>";
						echo "<input type='hidden' name='firstName' value='$row[firstName]'/>";
						echo "<input type='hidden' name='lastName' value='$row[lastName]'/>";
						echo "<input type='hidden' name='email' value='$row[email]'/>";
						echo "<input type='hidden' name='adminFlag' value='$row[adminFlag]'/>";
						echo "<input type='hidden' name='facultyFlag' value='$row[facultyFlag]'/>";
						echo "<input type='hidden' name='studentFlag' value='$row[studentFlag]'/>";
						echo "<input type='hidden' name='handicapFlag' value='$row[handicapFlag]'/>";
						echo "<input type='hidden' name='tempPassFlag' value='$row[tempPassFlag]'/>";
						echo "<td><input id='delete' type='submit' name='delete' value='Delete'/></form></td>";
						echo "</tr>";
					}
					echo "</table>";
					
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
