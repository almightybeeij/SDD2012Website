<?php
include "Config/configServer.php";
include "Config/connectServer.php";
$q=$_GET["q"];

if($q=="lot"){
    $sql = "SELECT lotId,coordinates,studentLot,facultyLot,drawOrder FROM parkinglot,coordinates
    WHERE lotId=ParkingLot_lotId ORDER BY lotId,drawOrder;";

    $result = mysql_query($sql);

    if (!$result)
        die('Invalid query: ' . mysql_error());

    while ($row = mysql_fetch_array($result))
    {
        $output[] = $row;
    }
    echo(json_encode($output));
}

if($q=="space"){
    $sql = "SELECT lotId, corner1, corner2, corner3, corner4, studentLot, facultyLot, available
            FROM parkingspace,parkinglot WHERE ParkingLot_lotId = lotId;";

    $result = mysql_query($sql);

    if (!$result)
        die('Invalid query: ' . mysql_error());

    while ($row = mysql_fetch_array($result))
    {
        $output[] = $row;
    }
    echo(json_encode($output));
}

include 'Config/closedbServer.php';

?>
