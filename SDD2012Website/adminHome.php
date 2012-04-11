<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/adminStyle.css" />
<title>Admin Home Page</title>
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
			Admin Home Page		
		</div>
	</div>
</div>
<?php
	}
	else 
			echo "You are not logged in<br>";
?>
</body>
</html>