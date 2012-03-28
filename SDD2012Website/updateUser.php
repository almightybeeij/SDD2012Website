<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/style.css" />
<title>Update User Page</title>
</head>
<?php
if (isset($_SESSION['sessionCookie']))
{
	?>
<body>
	<img src="Images/UCOBanner.gif"></img>
	<div style="background-color: #FFCC00">
		<?php
		include "menu"
		?>
	</div>
	This is the update user page
	<?php
}
else
{
	echo 'You are not logged in';
}
?>
</body>
</html>

