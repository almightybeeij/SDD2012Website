<?php

session_start();
include '../Config/connectServerI.php';

//foreach ($_GET as $key => $value)
//{
//	print "$key has a value of $value";
//}

echo $conn_mysqli->host_info . "<br/><br/>";
echo phpversion();

$bind_id = $_GET["lotid"];

$stmt = $conn_mysqli->prepare("SELECT Boundary1 FROM parkinglot WHERE lotid = ?");
$stmt->bind_param("i", $bind_id);
$stmt->execute();

$res = $stmt->get_result();

$row = $res->fetch_array(MYSQLI_NUM);

print(json_encode($row));

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