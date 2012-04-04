<?php
 
session_start();

include '../Config/connectServerI.php';
include '../Config/mysqliUtility.php';

$vars = array();

foreach ($_REQUEST as $key => $value)
{
	$vars[] = $value;	
}

$bind_id = $_REQUEST["lotid"];
$bind_avail = $_REQUEST["available"];

$sql = "SELECT * FROM parkingspace WHERE parkinglot_lotid = ? and available = ?";
$stmt = $conn_mysqli->prepare($sql);

bindParameters($stmt, $vars);

// $bindParamsMethod = new ReflectionMethod('mysqli_stmt', 'bind_param');
// $bindParamsReferences = array();
// $typeDefinitionString = array_shift($vars);
// foreach($vars as $key => $value){
// 	$bindParamsReferences[$key] = &$vars[$key];
// }

// array_unshift($bindParamsReferences,$typeDefinitionString);
// $bindParamsMethod->invokeArgs($stmt,$bindParamsReferences);

// call_user_func_array(mysqli_stmt_bind_param, $vars);

// $stmt->bind_param("ii", $bind_id, $bind_avail);

$stmt->execute();

$output = array();
$output = fetchArray($stmt);

while ($stmt->fetch())
{
	print(json_encode($output));
}

include '../Config/closedbServerI.php';

?>