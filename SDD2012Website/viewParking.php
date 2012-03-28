<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/style.css" />
<title>View Parking Map Page</title>
</head>
<body>
	<?php
	if (isset($_SESSION['sessionCookie']))
	{
		?>
	<img src="Images/UCOBanner.gif"></img>
	<div style="background-color: #FFCC00">
		<?php
		include "menu.workingInsideContainer"
		?>
	</div>
	This is the view Parking Page
	<?php
	}
	else
	{
		echo 'You are not logged in';
	}
	?>
</body>
</html>
