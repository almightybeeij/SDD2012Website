<?php
 
session_start();

include '../Config/connectServerI.php';
include '../Config/dbUtility.php';

$vars = array();

foreach ($_REQUEST as $key => $value)
{
	$vars[] = $value;	
}

var_dump($vars);

$bind_id = $_REQUEST["lotid"];
$bind_avail = $_REQUEST["available"];

$sql = "SELECT * FROM parkingspace WHERE parkinglot_lotid = ? and available = ?";
$stmt = $conn_mysqli->prepare($sql);

$bindParamsMethod = new ReflectionMethod('mysqli_stmt', 'bind_param');
$bindParamsMethod->invokeArgs($stmt,$vars);

//call_user_func_array(mysqli_stmt_bind_param, $vars);

//$stmt->bind_param("ii", $bind_id, $bind_avail);
$stmt->execute();

$output = array();
$output = fetchArray($stmt);

while ($stmt->fetch())
{
	print(json_encode($output));
}

include '../Config/closedbServerI.php';

?>