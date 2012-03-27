<?php
session_start();
include 'config.php';
include 'connect.php';

$sql = "select * from parking_lot;";

$result = mysql_query($sql);

if (!$result) 
    die('Invalid query: ' . mysql_error());

$num_results = mysql_num_rows($result);
while ($row = mysql_fetch_array($result))
{
	$output[] = $row;
}

print(json_encode($output));

include 'closedb.php';

?>
