<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/viewLot.css" />
<title>View Lot Status Page</title>
</head>
<body>
<?php
if (isset($_SESSION['sessionCookie']))
{
?>
<div id="pageContainer">
<img src="Images/UCOBanner.gif"></img>
<div style="background-color:#FFCC00">
<?php
include "menu.workingInsideContainer"
?>
</div>
This is the view lot page
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

