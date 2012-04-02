<?php

include 'configServer.php';

$conn_mysqli = new mysqli($host, $username, $password, $database, $port);

if ($conn_mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

?>