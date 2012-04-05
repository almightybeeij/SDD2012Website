<?php
 
include '../Config/connectServerI.php';
include '../Config/mysqliUtility.php';
include '../Mobile/mcrypt.php';

$elem=0;
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
	$outputArray[$elem] = array();
	//$outputArray[] = $output;
	foreach($output as $key=>$value)
	{
		$outputArray[$elem][$key] = $value;
	}
	$elem++;
}

print(json_encode($outputArray));

// Close mysqli connection
include '../Config/closedbServerI.php';

?>