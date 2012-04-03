<?php

session_start();

include '../Config/connectServerI.php';

//foreach ($_GET as $key => $value)
//{
//	print "$key has a value of $value";
//}

$bind_id = $_REQUEST["lotid"];
$bind_avail = $_REQUEST["available"];

$stmt = $conn_mysqli->prepare("SELECT * FROM parkingspace WHERE parkinglot_lotid = ? and available = ?");

$stmt->bind_param("ii", $bind_id, $bind_avail);
$stmt->execute();
$stmt->store_result();

$meta = $stmt->result_metadata();

while ($columnName = $meta->fetch_field()) {
	$columns[] = &$results[$columnName->name];
}
call_user_func_array(array($stmt, 'bind_result'), $columns);

while ($stmt->fetch())
{
	$output[] = $results;
}

//$output[] = $results;

print(json_encode($output));

include '../Config/closedbServerI.php';

?>