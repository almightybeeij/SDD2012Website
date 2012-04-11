<?php
function validateFields($firstName, $lastName, $email, $adminFlag, $facultyFlag, $studentFlag, $handicapFlag, $tempPassFlag)
{
	$error = NULL;
	
	if(($adminFlag == 0 && $facultyFlag == $adminFlag) || ($adminFlag== 0 && $studentFlag == $adminFlag))
	{
		$error = "Your must select at least one user type<br>";
		$error = $error . "Here were the flag values: $adminFlag, $facultyFlag, $studentFlag<br>";
	}
	
	if($firstName == "New" && $lastName =="New")
	{
		$error = "You Must Not Leave a new user's First and Last name as 'New'! Changes to the database HAVE NOT been made.<br>";
		$error = $error . "Here were the values: $firstName, $lastName<br>";
	}
	
	if (empty($firstName) || empty($lastName) || empty($email))
	{
		$error = "You Must Not Leave a Field Blank! Changes to the database HAVE NOT been made.<br>";
		$error = $error . "Here were the values: $firstName, $lastName, $email<br>";
	}
	
	if((empty($adminFlag) && $adminFlag!= '0') || (empty($facultyFlag) && $facultyFlag!= '0') || (empty($studentFlag) && $studentFlag!= '0') || (empty($handicapFlag) && $handicapFlag!= '0') || (empty($tempPassFlag) && $tempPassFlag!= '0'))
	{
		$error = "You Must Not Leave a Field Blank! Changes to the database HAVE NOT been made.<br>";
		$error = $error . "Here were the flag values: $adminFlag, $facultyFlag, $studentFlag, $handicapFlag, $tempPassFlag<br>";
	}
	
	if(!(($adminFlag == 1 || $adminFlag ==0) && ($facultyFlag == 1 || $facultyFlag == 0) && ($studentFlag == 1 || $studentFlag ==0) && ($handicapFlag == 1 || $handicapFlag ==0) && ($tempPassFlag == 1 || $tempPassFlag ==0)))
	{
		$error = $error . "Flags must be between either a '0' or a '1'! Changes to the database HAVE NOT been made.<br>";
		$error = $error . "Here were the flag values: $adminFlag, $facultyFlag, $studentFlag, $handicapFlag, $tempPassFlag<br>";
	}
	$emailCheck = validEmail($email);
	if(!$emailCheck)
	{
		$error = $error . "Email is not a valid email address! Changes to the database HAVE NOT been made.<br>";
		$error = $error . "Here is the email that was entered: $email <br>";
	}
	return $error;
	
}

?>