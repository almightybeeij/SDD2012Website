<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/style.css" />
<title>Update User Page</title>
</head>
<body>
	<?php
	if (isset($_SESSION['sessionCookie']))
	{
		include "Config/configServer.php";
		include "Config/connectServer.php";
		?>

	<!--Top Banner-->
	<center>
		<img src="Images/UCOBanner.gif"></img>
	</center>
	<?php
	include "menu"
	?>
	<div id="outerBlock">
		<div id="containerBlarg">
			<!-- Left side Pane-->
			<div id="leftPane">
				<center>
					<span
						style="text-decoration: underline; font: 15px Verdana; font-weight: 900">RSS
						FEED</span>
				</center>
				<br>
			</div>

			<!-- Main Content Area-->
			<div id="content">
				Here is your user information<br><br>

				<?php
				//This sets up the variable to be used for displaying error messages
				$passwordUpdateError = null;
				
				/*
				 * This is the part the updates the password after a user clicks the Yes button after taking a seminar
				 * After the Yes button is clicked and then the update button the user can update their password if nothing
				 * is wrong with the input 
				 */
				if (isset ($_POST['passwordUpdate']))
				{
					if($_POST['password1TextBox'] == $_POST['password2TextBox'])
					{
						if(empty($_POST['password1TextBox']))
							$passwordUpdateError = "Password fields must not be blank";
						else 
						{
							$sha256Pass = hash ( 'sha256' , $_POST['password1TextBox'] );
							
							$sqlUpdate = "update client set password='$sha256Pass' where email='$_SESSION[email]';";
							$result = mysql_query($sqlUpdate);
							
							if (!$result)
								die('Invalid query: ' . mysql_error());
							
							$_SESSION['password']=$sha256Pass;
							
							echo "<br>Password Update Succesfull";
							
						}
					}
					else 
						$passwordUpdateError = "Your passwords did not match";
				}

				/* This part of code is for when the user updates their fields in the text boxes
				 * It also updates both the client and clientsession tables to reflect the changes
				* This is reached by the user clicking the edit button followed by the update button
				* isset checks to see if the update value is set in the $_POST array
				*/

				if(isset ($_POST['update']))
				{

					$sqlUpdate = "update client set email='$_POST[emailTextBox]', firstName='$_POST[firstNameTextBox]',lastName='$_POST[lastNameTextBox]' where email='$_SESSION[email]' and password='$_SESSION[password]';";
					$result = mysql_query($sqlUpdate);

					if (!$result)
						die('Invalid query: ' . mysql_error());

					$sqlSessionUpdate = "update clientsession set Client_email='$_POST[emailTextBox]' where sessionid='$_SESSION[sessionCookie]';";
					$resultSessionUpdate = mysql_query($sqlSessionUpdate);

					if (!$resultSessionUpdate)
						die('Invalid query: ' . mysql_error());


					$_SESSION['email'] = $_POST['emailTextBox'];

					echo "<br>Update Succesfull";
					
				}
					

				/* This part of the code changes the cells in the table to text boxes so the user can update information
				 * This is reached by the user clicking the edit button
				* PHP_SELF is used to post back to same page
				* isset checks to see if the edit value is set in the $_POST array
				*/

				else if(isset ($_POST['edit']))
				{
					$sha256Pass = $_SESSION['password'];
					$sql = "select * from client where email='$_SESSION[email]' and password='$sha256Pass';";

					$result = mysql_query($sql);

					if (!$result)
						die('Invalid query: ' . mysql_error());

					echo "<form name='update' action='$PHP_SELF?>' method='post'>";
					echo"<table>";
					echo"<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Type</th><th>Update?</th></tr>";
					while ($row = mysql_fetch_array($result))
					{
						echo "<tr>";
						echo "<td><input id='firstName' type='text' name='firstNameTextBox' value='$row[firstName]' /></td>";
						echo "<td><input id='lastName' type='text' name='lastNameTextBox' value='$row[lastName]' /></td>";
						echo "<td><input id='email' type='text' name='emailTextBox' value='$row[email]' /></td>";

						if ($row['facultyFlag'] == 1)
							echo "<td>You are a Faculty Member</td>";
						else
							echo "<td>You are a Student</td>";

						echo "<td><input id='update' type='submit' name='update' value='Update'/></td>";
						echo "</tr>";
					}
				}
				
				/*
				 * This part prints out the table to update the users password
				 */
				else if (isset ($_POST['passwordButton']) || !empty($passwordUpdateError))
				{
				?>
					<form name='update' action='<?=$PHP_SELF?>' method='post'>
						<table>
						<tr>
							<th>Enter Password</th><th>Reenter Password</th><th>Update Password?</th>
						</tr>
						<tr>
							<td><input id='password' type='text' name='password1TextBox' /></td>
							<td><input id='lastName' type='text' name='password2TextBox' /></td>
							<td><input id='passwordUpdate' type='submit' name='passwordUpdate' value='Update'/></td>
						</tr>
						<?php 
							if ($passwordUpdateError == "Your passwords did not match")
							{
								echo "<tr>";
								echo "<td style='border:0px'></td>";
								echo "<td style='color:red; font-weight:bold; border:0px'>$passwordUpdateError</td>";
								echo "</tr>";
								$passwordUpdateError = null;
							}
							else if ($passwordUpdateError == "Password fields must not be blank")
							{
								echo "<tr>";
								echo "<td style='border:0px'></td>";
								echo "<td style='color:red; font-weight:bold; border:0px'>$passwordUpdateError</td>";
								echo "</tr>";
								$passwordUpdateError = null;
							}
						?>
						</table>
					</form>
				<?php 	
				}
			
				/* This part of the code is reached when user first comes to page because neither the edit or update is in $_POST array
				 * This pulls the users information from the client table and displays them inside a table
				*/

				else
				{
					$sha256Pass = $_SESSION['password'];
					$sql = "select * from client where email='$_SESSION[email]' and password='$sha256Pass';";

					$result = mysql_query($sql);

					if (!$result)
						die('Invalid query: ' . mysql_error());

					echo"<table id='preEditTable'>";
					echo"<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Type</th><th>Edit Info?</th><th>Edit Password?</th></tr>";
					while ($row = mysql_fetch_array($result))
					{
						echo "<tr>";
						echo "<td>$row[firstName]</td>";
						echo "<td>$row[lastName]</td>";
						echo "<td>$row[email]</td>";
							
						if ($row['facultyFlag'] == 1)
							echo "<td>You are a Faculty Member</td>";
						else
							echo "<td>You are a Student</td>";
							
						echo "<td><form id='editForm' name='edit' action='$PHP_SELF?>' method='post'>";
						echo "<input id='edit' type='submit' name='edit' value='Edit'/></form></td>";
						echo "<td><form id='passwordForm' name='passwordUpdate' action='$PHP_SELF?>' method='post'>";
						echo "<input id='password' type='submit' name='passwordButton' value='Yes'/></form></td>";
						echo "</tr>";
					}

				}
				echo "</table>";
					
				include "Config/closedbServer.php";
				?>
			
			</div>

			<!-- Right Side Pane-->
			<div id="rightPane" style="background-image: url('Images/linux-background-wallpapers.jpeg')">This is the right pane</div>
		</div>
		<!-- Footer-->
		<div id="footer">
			<?php 
			$time = time();
			$year=date("Y",$time);
			echo" Copyright &copy $year - Tyler's SDD Group - All Rights Reserved";
			?>
		</div>
	</div>
	<?php 
	}
	else
	{
		echo 'You are not logged in';
	}
	?>
</body>
</html>

