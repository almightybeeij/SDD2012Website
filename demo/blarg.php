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
	printf(" %s %s %s ",$row[0],$row[1],$row[2]);
	echo "</br>";
	
}

echo"Here are the number of results $num_results";
echo "</br></br>";
echo "Here is your IP address $_SERVER[REMOTE_ADDR]";

var_dump(headers_list());

include 'closedb.php';

?>
