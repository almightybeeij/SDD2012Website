<?php

include 'config.php';
include 'connect.php';

$sql = "select * from parking_lot;";

$result = mysql_query($sql);

if (!$result) 
    die('Invalid query: ' . mysql_error());

$num_results = mysql_num_rows($result);

echo($num_results);

include 'closedb.php';

?>