<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/style.css" />
<title>Logout Page</title>
</head>
<body>
<?php
if (isset($_SESSION['sessionCookie']))
{

include 'configServer.php';
include 'connectServer.php';
?>

	<div style="background-color:#FFFFFF;">
		<img src="Images/UCOBanner.gif"></img>
	</div>
	<div style="background-color:#FFCC00">
		<?php include "menu"?>
	</div>
	<?php

		if (isset($_POST['logout']))
		{
        			$sqlDelete = "delete from clientSession where username='$_SESSION[username]' and password = '$_SESSION[password]';";
        			$resultDelete = mysql_query($sqlDelete);
        			$num_results = mysql_num_rows($resultDelete);
        			include 'closedbServer.php';
        			session_destroy();
        			header("Location: index.php");
		}

	?>

	Are you sure you want to log out?
	<form name='logout' action='<?=$PHP_SELF?>' method = 'post' >
		<input type='submit' name='logout' value='Logout'/>
	</form>
<?php
}
else
{
        echo 'You are not logged in';
}
?>
</body>
</html>
