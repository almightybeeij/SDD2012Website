<?php
$lotId = $_POST['lotId'];
$coordinates = $_POST['coordinates'];
$drawOrder = $_POST['drawOrder'];

if ( !empty($lotId) && !empty($coordinates) && !empty($drawOrder))
{
	echo 'yes';
}
else
	echo 'no';




?>
