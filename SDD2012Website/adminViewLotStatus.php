<?php session_start() ?>
<html>
<head>
<script type="text/javascript" src="Scripts/ViewParking.js"></script>
    <script type="text/javascript"
            src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA87azXEcr0D_JcWoAdIWNKtH6ExPC1EMc&sensor=false">
    </script>
<link rel="stylesheet" type="text/css" href="StyleSheets/adminStyle.css" />
<title>Admin View Lot Status Page</title>
</head>
<body onload='initializeMap()'>
<?php if (isset($_SESSION['sessionCookie']) && $_SESSION['userType'] == "admin")
	{
	?>
<div id="outerContainer">
	<div id="innerContainer">
	<?php include "menuAdmin"?>
		<div id="content">
		</div>
	</div>
</div>
</body>
<?php
	}
else
	{
		header('Refresh: 3; URL= index.php'); 
		echo "You are not logged in";
	} 
?>
</html>
