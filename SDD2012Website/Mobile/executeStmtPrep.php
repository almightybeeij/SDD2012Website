<?php

session_start();
include '../Config/connectServerI.php';

//foreach ($_GET as $key => $value)
//{
//	print "$key has a value of $value";
//}

//echo $conn_mysqli->host_info . "<br/><br/>";

$bind_id = $_REQUEST["lotid"];

$stmt = $conn_mysqli->prepare("SELECT Boundary1 FROM parkinglot WHERE lotid = ?");
$stmt->bind_param("i", $bind_id);
$stmt->execute();
$stmt->store_result();
$meta = $stmt->result_metadata();
while ($columnName = $meta->fetch_field()) {
	$columns[] = &$results[$columnName->name];
}
call_user_func_array(array($stmt, 'bind_result'), $columns);

$stmt->fetch();

$output[] = $results;

print(json_encode($output));

//$out_boundary = NULL;
//$stmt->bind_result($out_boundary);

//$md = $stmt->result_metadata();
//$output = array();
//$output[] = $md->fetch_assoc();

//print(json_encode($output));

//while ($stmt->fetch()) {
//	$output[0] = array($out_boundary);
//}

include '../Config/closedbServerI.php';

?>