<?php

session_start();

include '../Config/connectServerI.php';

//foreach ($_GET as $key => $value)
//{
//	print "$key has a value of $value";
//}

$eor = false;
$bind_id = $_REQUEST["lotid"];
$bind_avail = $_REQUEST["available"];

$stmt = $conn_mysqli->prepare("SELECT * FROM parkingspace WHERE parkinglot_lotid = ? and available = ?");

$stmt->bind_param("ii", $bind_id, $bind_avail);
$stmt->execute();
$stmt->store_result();

$meta = $stmt->result_metadata();
while ($columnName = $meta->fetch_field())
{
	$columns[] = &$results[$columnName->name];
}

while (!$eor)
{
	call_user_func_array(array($stmt, 'bind_result'), $columns);
	
	if ($stmt->fetch()) { $output[] = $results;	}
	else { $eor = true; }
}

print(json_encode($output));

include '../Config/closedbServerI.php';

?>