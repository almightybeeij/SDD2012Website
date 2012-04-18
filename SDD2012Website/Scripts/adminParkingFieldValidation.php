<?php
$error = null;
function validationCheck($lotId,$studentLot,$facultyLot,$boundary1,$boundary2,$boundary3,$boundary4,$directionTo)
{
	if($lotId == 0)
		$error = $error . "You must not have a lotId of 0<br>";
	
	if(($studentLot == 0 && $facultyLot == 0) || ($studentLot == 1 && $facultyLot == 1))
		$error = $error . "Student lot and faculty lot must NOT be the same";
	
	if(empty($boundary1) || empty($boundary2) || empty($boundary3) || empty($boundary4))
		$error = $error . "You must not leave a field blank";
	
	list($boundary01,$boundary11) = explode(",",$boundary1);
	list($boundary02,$boundary12) = explode(",",$boundary2);
	list($boundary03,$boundary13) = explode(",",$boundary3);
	list($boundary04,$boundary14) = explode(",",$boundary4);
	
	
	$boundary01Check = boundaryCheck($boundary01);
	$boundary11Check = boundaryCheck($boundary11);
	$boundary02Check = boundaryCheck($boundary02);
	$boundary12Check = boundaryCheck($boundary12);
	$boundary03Check = boundaryCheck($boundary03);
	$boundary13Check = boundaryCheck($boundary13);
	$boundary04Check = boundaryCheck($boundary04);
	$boundary14Check = boundaryCheck($boundary14);
	
	if($boundary01Check == false || $boundary11Check == false || $boundary02Check == false || $boundary12Check == false || $boundary03Check == false || $boundary13Check == false || $boundary04Check == false || $boundary14Check == false)
		$error = $error . "One or more boundaries are not in the correct format of xx.123456,xx.123456<br>";
	
	
	return $error;
	
}

function boundaryCheck($boundary)
{
	$result = true;
	$numberOfDecimals = strlen(substr(strrchr($boundary, "."), 1));
	
	if($numberOfDecimals != 6)
		$result = false;
	
	return $result;
}


?>