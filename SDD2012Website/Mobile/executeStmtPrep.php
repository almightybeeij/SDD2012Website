<?php
 
session_start();

include '../Config/connectServerI.php';
include '../Config/mysqliUtility.php';

$vars = array();

foreach ($_REQUEST as $key => $value)
{
	$vars[] = $value;	
}

$sql = array_shift($vars);

//$sql = "SELECT * FROM parkingspace WHERE parkinglot_lotid = ? and available = ?";
$stmt = $conn_mysqli->prepare($sql);

bindParameters($stmt, $vars);

$stmt->execute();

$output = array();
$output = fetchArray($stmt);

while ($stmt->fetch())
{
	print(json_encode($output));
}

include '../Config/closedbServerI.php';

?>