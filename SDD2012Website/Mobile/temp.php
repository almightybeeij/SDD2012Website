<html>
<?php

session_start();
include '../Config/connectServerI.php';

echo $conn_mysqli->host_info . "\n";

include '../Config/closedbServerI.php';

?>
</html>