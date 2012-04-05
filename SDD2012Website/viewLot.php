<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/style.css" />
<title>View Lot Status Page</title>
</head>
<body>
	<?php
	if (isset($_SESSION['sessionCookie']))
	{
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
				View Lot Status
			</div>

			<!-- Right Side Pane-->
			<div id="rightPane" style="background-image: url('Images/linuxPengGreen.jpg')">This is the right pane</div>
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

