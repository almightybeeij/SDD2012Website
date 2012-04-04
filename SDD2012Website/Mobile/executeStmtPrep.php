<?php
 
include '../Config/connectServerI.php';
include '../Config/mysqliUtility.php';
include '../Mobile/mcrypt.php';

$vars = array();

// Get all request variables
foreach ($_REQUEST as $key => $value)
{
	$vars[] = $value;	
}

// Sql is first variable
$sql = array_shift($vars);

try
{
	$algorithms = mcrypt_list_algorithms("/usr/lib/libmcrypt");
	var_dump($algorithms);
}
catch (Exception $e)
{
	echo $e->getMessage();
}

$mcrypt = new MCrypt();
$encrypted = $mcrypt->encrypt("Test");
echo $encrypted;

// $decrypted = $mcrypt->decrypt($sql);
// echo $decrypted;

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