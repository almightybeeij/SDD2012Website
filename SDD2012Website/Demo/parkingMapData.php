<?php
session_start();
include 'config.php';
include 'connect.php';
$q=$_GET["q"];

if($q=="lot"){
    $sql = "SELECT lotId,coordinates,studentLot,facultyLot,drawOrder FROM parkinglot,coordinates
    WHERE lotId=ParkingLot_lotId GROUP BY lotId,drawOrder;";

    $result = mysql_query($sql);

    if (!$result)
        die('Invalid query: ' . mysql_error());

    while ($row = mysql_fetch_array($result))
    {
        $output[] = $row;
    }
    echo(json_encode($output));
}
include 'closedb.php';

?>
