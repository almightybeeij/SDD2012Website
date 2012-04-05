<?php
 
include '../Config/connectServerI.php';
include '../Config/mysqliUtility.php';
include '../Mobile/mcrypt.php';

$outputString;
$outputArray = array();
$vars = array();

// Get all request variables
foreach ($_REQUEST as $key => $value)
{
	$vars[] = $value;	
}

// Sql is first variable
$sql = array_shift($vars);

// Decrypt sql statement
$mcrypt = new MCrypt();
$decrypted = $mcrypt->decrypt($sql);

// Create prepared statement
$stmt = $conn_mysqli->prepare($decrypted);

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
	// Build JSON encoded string
	$outputArray[] = $output;
}

print_r(array_values($outputArray));

// Close mysqli connection
include '../Config/closedbServerI.php';

?>