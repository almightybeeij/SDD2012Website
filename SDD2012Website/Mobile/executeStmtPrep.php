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


// Fetch results
for ($i = 0; $i < $stmt->num_rows; $i++)
{
	$output = fetchArray($stmt);
	// Build JSON encoded string
	$outputArray[] = $output;
}

print(json_encode($outputArray));

// Close mysqli connection
include '../Config/closedbServerI.php';

?>