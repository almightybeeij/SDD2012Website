<?php
 
include '../Config/connectServerI.php';
include '../Config/mysqliUtility.php';
include '../Mobile/mcrypt.php';

error_reporting(E_ALL);

$vars = array();

// Get all request variables
foreach ($_REQUEST as $key => $value)
{
	$vars[] = $value;	
}

// Sql is first variable
$sql = array_shift($vars);

$mcrypt = new MCrypt();
//$encrypted = $mcrypt->encrypt("Test");
//echo $encrypted;

$decrypted = $mcrypt->decrypt("2f7f5743682a747b01af2299f5b5523c7413a5f602699f5e5ed896296abafaae96806012bc3cfba72207c2c3aa8c91c26328c36c5783f195b54bf765206a2ac506399e3cdcd3e8ded37cb61373fae5c4");
echo $decrypted;

// Create prepared statement
$stmt = $conn_mysqli->prepare($sql);

// Bind parameters to statement
bindParameters($stmt, $vars);

// Exexute statement
$stmt->execute();

// Bind variables
$output = array();
$output = fetchArray($stmt);

// Fetch results
while ($stmt->fetch())
{
	// Return JSON encoded string
	print(json_encode($output));
}

// Close mysqli connection
include '../Config/closedbServerI.php';

?>