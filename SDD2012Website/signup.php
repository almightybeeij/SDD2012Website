<?php
session_start();
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/signup.css" />
</head>
<header> </header>
<body>
	<?php

	include 'Config/configServer.php';
	include 'Config/connectServer.php';
	
	/* We are going to check if the page is posted back and make sure all the text boxes are filled with info
	 * If all the boxes are filled with user information then we are going to proceed to checking if the passwords match or not
	 * 
	 */
	if (isset($_POST['submit']) && !empty($_POST['firstNameTextBox']) && !empty($_POST['lastNameTextBox']) && !empty($_POST['emailTextBox']) && !empty($_POST['password']) && !empty($_POST['userTypeRadioButton']))
	{

		
		/* If the passwords match we can proceed to enter the information into the database
		 * As of right now the information the user entered is not sanitized using htmlentities or strip
		 * Will Implement this as time permits
		*/
		if($_POST['password'] == $_POST['password2'] )
		{
			$sha256Pass = hash ( 'sha256' , $_POST['password'] );
			$adminFlag = 0;
			
			// Assign appropriate variables based on the radio button
			// Either student or admin
			if ($_POST['userTypeRadioButton']=="student")
			{
				$facultyFlag = 0;
				$studentFlag = 1;
			}
			else
			{
				$facultyFlag = 1;
				$studentFlag = 0;
			}
			
			// Prepare the sql insert statement passing along the posted values
			$sql = "insert into client values ('$_POST[emailTextBox]','$sha256Pass','$_POST[firstNameTextBox]','$_POST[lastNameTextBox]','$adminFlag','$facultyFlag','$studentFlag',0);";

			// Get result from the mysql query execution
			$result = mysql_query($sql);
			
			// If query failed then print error
			if (!$result)
				die('Invalid query: ' . mysql_error());

			// Start session cookie and enter appropriate variables to reflect the new session
			$sessionCookie = hash ('sha256', time());
			$time = time();
			$_SESSION['email'] = $_POST['emailTextBox'];
			$_SESSION['password'] = $sha256Pass;
			$_SESSION['sessionCookie'] = $sessionCookie;

			$sqlSession = "insert into clientsession values ('$sessionCookie','$_POST[emailTextBox]','$time');";


			$resultSession = mysql_query($sqlSession);
			if (!$resultSession)
			{		
				die('Invalid query: ' . mysql_error());
			}

			include 'Config/closedbServer.php';
			header("Location: home.php");
		}
		

	}

	include 'Config/closedbServer.php';

	?>
	
	<div id="outerContainer">
		<div id="innerContainer">
		
		<?php
			// Set error to null first to flush variable 
			$error=null;
		?>
		<center><b>Please Sign Up To Access the System!!</b></center> 
			<form method='post' action='<?= $PHP_SELF?>'>
				<label name="firstNameLabel" for="firstNameTextBox">First Name :</label>
				<input type='text' name='firstNameTextBox' value='<?= $_POST['firstNameTextBox']?>'/> 
				<?php 
					if (empty($_POST['firstNameTextBox']) && isset($_POST['submit']))
					{ 
						echo "<font color='red'>*</font>";
						$error = $error."First Name Must Not Be Blank<br> ";
					}	  
				?>
				<br> 
				
				<label name="lastNameLabel" for="lastNameTextBox">Last Name :</label> 
				<input type='text' name='lastNameTextBox' value='<?= $_POST['lastNameTextBox']?>'/>
				<?php 
					if (empty($_POST['lastNameTextBox']) && isset($_POST['submit']))
					{ 
						echo "<font color='red'>*</font>";
						$error = $error."Last Name Must Not Be Blank<br> ";
					}	  
				?> 
				<br>
				
				<label name="emailLabel" for="emailTextBox">Email :</label> 
				<input type='text' name='emailTextBox' value='<?= $_POST['emailTextBox']?>'/>
				<?php 
					if (empty($_POST['emailTextBox']) && isset($_POST['submit']))
					{ 
						echo "<font color='red'>*</font>";
						$error = $error."Email Must Not Be Blank<br>";
					}	  
				?>
				<br>

				<label name="passwordLabel" for="password">Password :</label>
				<input type='password' name='password' />
				<?php 
					if (empty($_POST['password']) && isset($_POST['submit']))
					{ 
						echo "<font color='red'>*</font>";
						$error = $error."Password Must Not Be Blank<br>";
					}	  
				?>
				<br> 
				
				<label name="password2Label" for="password2">Enter Password Again :</label>
				<input type='password' name='password2' />
				<?php
					if ($_POST['password'] != $_POST['password2'])
						$error = $error."Your Passwords Did Not Match<br>"; 
				?>
				<br>
				<label name="userType">Please Select Your User Type :</label>
				<div> 
					<input type="radio" name="userTypeRadioButton" value="student"/>Student
					<input type="radio" name="userTypeRadioButton" value="faculty"/>Faculty
				</div>
				<?php 
					if (empty($_POST['userTypeRadioButton']) && isset($_POST['submit']))
					{ 
						echo "<font color='red'>*</font>";
						$error = $error."Select a User Type<br>";
					}	  
				?>
				<br>
				<?php echo "<font color='red'>$error</font>"?> 
				<input style="float:right" type='submit' name='submit' value='Sign Up' />
			</form>
		</div>
	</div>



</body>
</html>

