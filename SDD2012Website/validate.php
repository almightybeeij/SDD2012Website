<?php
session_start();
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
?>
<html>
<body>

	<?php

	include 'Config/configServer.php';
	include 'Config/connectServer.php';

	//Delete from clientSession if there is a previous session cookie
	$sha256Pass = hash ('sha256', $_POST['password']);
	$sqlDelete = "delete from clientsession where Client_email='$_POST[email]';";
	$resultDelete = mysql_query($sqlDelete);
	$userType = NULL;


	$sha256Pass = hash ( 'sha256' , $_POST['password'] );
	$sql = "select * from client where email='".$_POST['email']."' and password='".$sha256Pass."';";

	$result = mysql_query($sql);
	if (!$result)
		die('Invalid query: ' . mysql_error());

	$num_results = mysql_num_rows($result);
	if ($num_results <= 0)
	{
	
		
		$sqlTempCheck = "select * from client where email='$_POST[email]' and password='$_POST[password]' and tempPassFlag=1 ;";
		
		$resultTempCheck = mysql_query($sqlTempCheck);
		if (!$result)
			die('Invalid query: ' . mysql_error());
		
		$tempPassword_result = mysql_num_rows($resultTempCheck);
		if($tempPassword_result > 0)
		{
			include 'Config/closedbServer.php';
			#header("Location: invalid.php");
			//$_SESSION['invalid'] = 'invalidEmailAndPassword';
			header("Location: updateTempPassword.php");
		}
		else 
		{
			include 'Config/closedbServer.php';
			#header("Location: invalid.php");
			$_SESSION['invalid'] = 'invalidEmailAndPassword';
			header("Location: index.php");
		}
		
	}
	else
	{
		$row = mysql_fetch_array($result);
		if($row['adminFlag'] == 1)
			$userType = "admin";
		else
			$userType = "regular";
		//Use timestamp to create a a hash for session cookie
		$time = time();
		$sessionCookie = hash ('sha256', $time);
		
		//Format the timestamp to put into mysql datestamp
		$format="Y-m-d H:i:s";
		$formattedTime = date($format,$time);
		$sqlSession = "insert into clientsession values ('$sessionCookie','$_POST[email]','$formattedTime');";

		$_SESSION['email'] = $_POST['email'];
		$_SESSION['password'] = $sha256Pass;
		$_SESSION['sessionCookie'] = $sessionCookie;
		$_SESSION['userType'] = $userType;

		$resultSession = mysql_query($sqlSession);
		if (!$resultSession)
			die('Invalid query: ' . mysql_error());

		include 'Config/closedbServer.php';
		if($userType == "admin")
			header("Location: adminHome.php");
		else
			header("Location: home.php");
	}

	?>

</body>
</html>
