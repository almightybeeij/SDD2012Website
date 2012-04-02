<?php

session_start();
include '../Config/connectServerI.php';

foreach ($_GET as $key => $value)
{
	print "$key has a value of $value";
}

include '../Config/closedbServerI.php';

?>