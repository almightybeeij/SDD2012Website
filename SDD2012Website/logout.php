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

	<!--Top Banner-->
	<center>
		<img src="Images/UCOBanner.gif"></img>
	</center>
	<?php
	include "menu"
	?>
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
				Are you sure you want to log out?
				<form name='logout' action='<?=$PHP_SELF?>' method='post'>
					<input type='submit' name='logout' value='Logout' />
				</form>
			</div>

			<!-- Right Side Pane-->
			<div id="rightPane">This is the right pane</div>
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
