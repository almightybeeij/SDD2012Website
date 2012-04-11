<?php
function validateFields($firstName, $lastName, $email, $adminFlag, $facultyFlag, $studentFlag, $handicapFlag, $tempPassFlag)
{
	$error = NULL;
	
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

// All credit is given to Douglas Lovell from IBM and his artical in Linux Journal
function validEmail($email)
{
	$isValid = true;
	$atIndex = strrpos($email, "@");
	if (is_bool($atIndex) && !$atIndex)
	{
		$isValid = false;
	}
	else
	{
		$domain = substr($email, $atIndex+1);
		$local = substr($email, 0, $atIndex);
		$localLen = strlen($local);
		$domainLen = strlen($domain);
		if ($localLen < 1 || $localLen > 64)
		{
			// local part length exceeded
			$isValid = false;
		}
		else if ($domainLen < 1 || $domainLen > 255)
		{
			// domain part length exceeded
			$isValid = false;
		}
		else if ($local[0] == '.' || $local[$localLen-1] == '.')
		{
			// local part starts or ends with '.'
			$isValid = false;
		}
		else if (preg_match('/\\.\\./', $local))
		{
			// local part has two consecutive dots
			$isValid = false;
		}
		else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
		{
			// character not valid in domain part
			$isValid = false;
		}
		else if (preg_match('/\\.\\./', $domain))
		{
			// domain part has two consecutive dots
			$isValid = false;
		}
		else if
		(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
				str_replace("\\\\","",$local)))
		{
			// character not valid in local part unless
			// local part is quoted
			if (!preg_match('/^"(\\\\"|[^"])+"$/',
					str_replace("\\\\","",$local)))
			{
				$isValid = false;
			}
		}
		if ($isValid && !(checkdnsrr($domain,"MX") ||
				↪checkdnsrr($domain,"A")))
		{
		// domain not found in DNS
			$isValid = false;
		}
		}
			return $isValid;
}




?>