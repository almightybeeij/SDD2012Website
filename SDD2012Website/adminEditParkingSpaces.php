<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/adminStyle.css" />
<title>Admin Edit Parking Page</title>
</head>
<body>
<?php if (isset($_SESSION['sessionCookie']) && $_SESSION['userType'] == "admin")
	{
	?>
<div id="outerContainer">
	<div id="innerContainer">
	<?php include "menuAdmin"?>
		<!--  <div id="rightContentPane">
			Right Content Pane<br>
			Edit Parking Spaces Page<br>			
		</div>-->
		<div id="mainContentPane">
			Main Content Pane<br>
			Admin Edit Parking Spaces Page<br>			
		</div>
	</div>
</div>
<?php
	}
	else 
		echo "You are not logged in"; 
?>
</body>
</html>