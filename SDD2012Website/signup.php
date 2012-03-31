<?php
session_start();
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="~/StyleSheets/mystyle.css" />
</head>
<header> Please Sign Up To Access the System!! </header>
<body>
	<?php

	include 'Config/configServer.php';
	include 'Config/connectServer.php';

	if (isset($_POST['submit']))
	{

		if($_POST['password'] == $_POST['password2'])
		{
			$sha256Pass = hash ( 'sha256' , $_POST['password'] );
			$adminFlag = 0;
			$facultyFlag = 0;
			$studentFlag = 1;
			$sql = "insert into client values ('$_POST[email]','$sha256Pass','$_POST[firstName]','$_POST[lastName]','$adminFlag','$facultyFlag','$studentFlag');";

			$result = mysql_query($sql);
			if (!$result)
				die('Invalid query: ' . mysql_error());

			$sessionCookie = hash ('sha256', time());
			$time = time();
			$sqlSession = "insert into clientsession values ('$sessionCookie','$_POST[email]','$time');";

			$_SESSION['email'] = $_POST['email'];
			$_SESSION['password'] = $sha256Pass;
			$_SESSION['sessionCookie'] = $sessionCookie;

			$resultSession = mysql_query($sqlSession);
			if (!$resultSession)
				die('Invalid query: ' . mysql_error());

			include 'Config/closedbServer.php';
			header("Location: home.php");
		}
		else
		{

			echo "Good Job Dumbass you <b>DID NOT</b> enter the password twice in a row!</br>";
			echo $_POST['password']."</br>";
			echo $_POST['password2']."</br>";

		}



	}

	include 'Config/closedbServer.php';


	echo "<form method='post' action='$PHP_SELF'>";

	echo "First Name :<input type='text' name= 'firstName'/></br>";
	echo "Last Name :<input type='text' name= 'lastName'/></br>";
	echo "Email :<input type='text' name= 'email'/></br>";
	echo "Password :<input type='password' name= 'password'/></br>";
	echo "Enter Password Again :<input type='password' name= 'password2'/></br>";
	echo "<input type='submit' name='submit' value='Sign Up'/>";
	echo "</form>";

	?>
</body>
</html>

