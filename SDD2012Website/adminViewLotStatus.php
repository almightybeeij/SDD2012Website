<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/adminStyle.css" />
<title>Admin View Lot Status Page</title>
</head>
<body>
<?php if (isset($_SESSION['sessionCookie']) && $_SESSION['userType'] == "admin")
	{
	?>
<div id="outerContainer">
	<div id="innerContainer">
	<?php include "menuAdmin"?>
		<div id="rightContentPane">
			Right Content Pane<br>			
		</div>
		<div id="mainContentPane">
			Main Content Pane<br>
			Admin View Lot Status Page			
		</div>
	</div>
</div>
</body>
<?php
	}
	else
		echo"You are not logged in"; 
?>
</html>