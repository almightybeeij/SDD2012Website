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
//$stmt->execute();

$result = mysqli_query($conn_mysqli, $stmt);

$out_boundary = NULL;
$stmt->bind_result($out_boundary);

$md = $stmt->result_metadata();
$output = array();

$output[] = $md->fetch_assoc();

print(json_encode($md));

include '../Config/closedbServerI.php';

?>