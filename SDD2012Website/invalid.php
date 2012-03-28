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

	include 'config.php';
	include 'connect.php';

	if (isset($_POST['submit']))
	{

		if($_POST['password'] == $_POST['password2'])
		{
			$sha256Pass = hash ( 'sha256' , $_POST['password'] );
			$sql = "insert into users values ('$_POST[firstName]','$_POST[lastName]','$_POST[username]','$sha256Pass');";

			$result = mysql_query($sql);
			if (!$result)
				die('Invalid query: ' . mysql_error());

			$sessionCookie = hash ('sha256', time());
			$sqlSession = "insert into clientSession values ('$_POST[username]','$sha256Pass','$sessionCookie');";

			$_SESSION['username'] = $_POST['username'];
			$_SESSION['password'] = $sha256Pass;
			$_SESSION['sessionCookie'] = $sessionCookie;

			$resultSession = mysql_query($sqlSession);
			if (!$resultSession)
				die('Invalid query: ' . mysql_error());

			include 'closedb.php';
			header("Location: welcome.php");
		}
		else
		{

			echo "Good Job Dumbass you <b>DID NOT</b> enter the password twice in a row!</br>";
			echo $_POST['password']."</br>";
			echo $_POST['password2']."</br>";

		}



	}

	include 'closedb.php';


	echo "<form method='post' action='$PHP_SELF'>";

	echo "First Name :<input type='text' name= 'firstName'/></br>";
	echo "Last Name :<input type='text' name= 'lastName'/></br>";
	echo "Username :<input type='text' name= 'username'/></br>";
	echo "Password :<input type='password' name= 'password'/></br>";
	echo "Enter Password Again :<input type='password' name= 'password2'/></br>";
	echo "<input type='submit' name='submit' value='Sign Up'/>";
	echo "</form>";

	?>
</body>
</html>

