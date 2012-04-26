<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/adminStyle.css" />
<title>Admin Logout Page</title>
</head>
<body>
<?php if (isset($_SESSION['sessionCookie']) && $_SESSION['userType'] == "admin")
	{
	?>
<div id="outerContainer">
	<div id="innerContainer">
	<?php include "menuAdmin"?>
		<!--<div id="rightContentPane">
			Right Content Pane<br>			
		</div>-->
		<div id="mainContentPane">
		<?php 
				
		if (isset($_POST['logout']))
		{
			include 'Config/configServer.php';
			include 'Config/connectServer.php';
			$sqlDelete = "delete from clientsession where Client_email='$_SESSION[email]' and sessionid = '$_SESSION[sessionCookie]';";
			$resultDelete = mysql_query($sqlDelete);
			$num_results = mysql_num_rows($resultDelete);
			include 'Config/closedbServer.php';
			session_destroy();
			header("Location: index.php");
		}
				
		?>
		Are you sure you want to log out?
		<form name='logout' action='<?=$PHP_SELF?>' method='post'>
			<input type='submit' name='logout' value='Logout' />
		</form>
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
