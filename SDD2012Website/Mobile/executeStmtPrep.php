<?php

session_start();

include '../Config/connectServerI.php';

function fetchArray (&$statement)
{
	$data = mysqli_stmt_result_metadata($statement);
	$fields = array();
	$out = array();

	$fields[0] = $statement;
	$count = 1;

	while($field = mysqli_fetch_field($data))
	{
		$fields[$count] = &$out[$field->name];
		$count++;
	}

	call_user_func_array(mysqli_stmt_bind_result, $fields);
	mysqli_stmt_fetch($statement);
	return (count($out) == 0) ? false : $out;
}

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

$output = array();
$output = fetchArray($stmt);

while ($stmt->fetch())
{
	print(json_encode($output));
}
//$stmt->store_result();

//$meta = $stmt->result_metadata();
//while ($columnName = $meta->fetch_field())
//{
//	$columns[] = &$results[$columnName->name];
//}

//while (!$eor)
//{
//	call_user_func_array(array($stmt, 'bind_result'), $columns);
//	
//	if ($stmt->fetch()) { $output[] = $results;	}
//	else { $eor = true; }
//}

include '../Config/closedbServerI.php';

?>