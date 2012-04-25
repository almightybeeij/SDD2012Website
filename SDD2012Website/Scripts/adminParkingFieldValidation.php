<?php

function validationCheck($lotId,$studentLot,$facultyLot,$boundary1,$boundary2,$boundary3,$boundary4,$directionTo)
{
	$error = null;
	
	if($lotId == 0)
		$error = $error . "You must not have a lotId of 0<br>";
	
	if(($studentLot == 0 && $facultyLot == 0) || ($studentLot == 1 && $facultyLot == 1))
		$error = $error . "Student lot and faculty lot must NOT be the same<br>";
	
	if(empty($boundary1) || empty($boundary2) || empty($boundary3) || empty($boundary4) || empty($directionTo))
		$error = $error . "You must not leave a field blank<br>";
	
	list($boundary01,$boundary11) = explode(",",$boundary1);
	list($boundary02,$boundary12) = explode(",",$boundary2);
	list($boundary03,$boundary13) = explode(",",$boundary3);
	list($boundary04,$boundary14) = explode(",",$boundary4);
	
	if(!is_numeric($boundary01))
		$error = $error . 'Boundary 1(' .$boundary01. ') must be a numerical value:<br> ';
	if(!is_numeric($boundary11))
		$error = $error . 'Boundary 2(' .$boundary11. ') must be a numerical value:<br> ';
	if(!is_numeric($boundary02))
		$error = $error . 'Boundary 3(' .$boundary02. ') must be a numerical value:<br> ';
	if(!is_numeric($boundary12))
		$error = $error . 'Boundary 4(' .$boundary12. ') must be a numerical value:<br> ';
	if(!is_numeric($boundary03))
		$error = $error . 'Boundary 5(' .$boundary03. ') must be a numerical value:<br> ';
	if(!is_numeric($boundary13))
		$error = $error . 'Boundary 6(' .$boundary13. ') must be a numerical value:<br> ';
	if(!is_numeric($boundary04))
		$error = $error . 'Boundary 7(' .$boundary04. ') must be a numerical value:<br> ';
	if(!is_numeric($boundary14))
		$error = $error . 'Boundary 8(' .$boundary14. ') must be a numerical value:<br> ';
	
	return $error;
	
}

function kosher($lotId, $spaceId,$available,$handicap,$corner1, $corner2, $corner3, $corner4)
{
	$error = null;
	
	if($lotId == 0)
		$error = $error . "You must not have a lotId of 0<br>";
	
	if(!is_numeric($spaceId))
		$error = $error . 'Space Id(' .$spceId. ') must be a numerical value:<br> ';
	
	if(!is_numeric($available))
		$error = $error . 'Available(' .$available. ') must be a numerical value:<br> ';
	
	if(!is_numeric($handicap))
		$error = $error . 'Handicap(' .$handicap. ') must be a numerical value:<br> ';
	
	if(!($available == 1 || $available == 0))
		$error = $error . 'Available(' .$available. ') must be 0 or 1<br> ';
	
	if(!($handicap == 1 || $handicap == 0))
		$error = $error . 'Handicap(' .$handicap. ') must be 0 or 1<br> ';
	
	
	list($corner01,$corner11) = explode(",",$corner1);
	list($corner02,$corner12) = explode(",",$corner2);
	list($corner03,$corner13) = explode(",",$corner3);
	list($corner04,$corner14) = explode(",",$corner4);

	if(!is_numeric($corner01))
		$error = $error . 'corner 1(' .$corner01. ') must be a numerical value:<br> ';
	if(!is_numeric($corner11))
		$error = $error . 'corner 2(' .$corner11. ') must be a numerical value:<br> ';
	if(!is_numeric($corner02))
		$error = $error . 'corner 3(' .$corner02. ') must be a numerical value:<br> ';
	if(!is_numeric($corner12))
		$error = $error . 'corner 4(' .$corner12. ') must be a numerical value:<br> ';
	if(!is_numeric($corner03))
		$error = $error . 'corner 5(' .$corner03. ') must be a numerical value:<br> ';
	if(!is_numeric($corner13))
		$error = $error . 'corner 6(' .$corner13. ') must be a numerical value:<br> ';
	if(!is_numeric($corner04))
		$error = $error . 'corner 7(' .$corner04. ') must be a numerical value:<br> ';
	if(!is_numeric($corner14))
		$error = $error . 'corner 8(' .$corner14. ') must be a numerical value:<br> ';
	
	return $error;
	
	
	
}


?>