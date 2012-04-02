<?php

session_start();
include '../Config/connectServerI.php';

//foreach ($_GET as $key => $value)
//{
//	print "$key has a value of $value";
//}

$bind_id = $_GET["lotid"];

$stmt = $conn_mysqli->prepare("SELECT Boundary1 FROM parkinglot WHERE lotid = (?)");
$stmt->bind_param("i", $bind_id);
$stmt->execute();

$out_boundary = NULL;
$stmt->bind_result($out_boundary);

while ($row = $stmt->fetch()) {
	$output[] = $row;
}

print(json_encode($output));

include '../Config/closedbServerI.php';

?>