<html>
<?php

session_start();
include '../Config/connectServerI.php';

echo $conn_mysqli->host_info . "<br/><br/>";

$id = 18;
$stmt = $conn_mysqli->prepare("SELECT Boundary1 FROM parkinglot WHERE lotid = (?)");
$stmt->bind_param("i", $id);
$stmt->execute();

$out_boundary = NULL;
$stmt->bind_result($out_boundary);

while ($stmt->fetch()) {
	echo $out_boundary;
}
	
include '../Config/closedbServerI.php';

?>
</html>