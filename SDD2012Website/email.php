<?php
	
	include "Config/configServer.php";
	include "Config/connectServer.php";

	require_once "Mail.php";
		
	$response=null;
	
	if (isset($_REQUEST['question']) && !empty($_REQUEST['question']))
	{
		$question=$_REQUEST['question'];
		
	}
	else 
		$response = $response."<font color='red'>You need to select a Security Question to Answer</font><br>";
	
	if (isset($_REQUEST['answer']) && !empty($_REQUEST['answer']))
	{
		$answer=$_REQUEST['answer'];
		
	}
	else 
	{
		$response = $response."<font color='red'>You need to answer the Security Question</font><br>";
		
	}
	
	if (isset($_REQUEST['email']))
	{
		$email=$_REQUEST['email'];
		
	}
	else
	{
		$response = $response."<font color='red'>You need to answer the Security Question</font><br>";
		
	}
	
	$sql = "select * from client where email='$email';";
	$result = mysql_query($sql);
	
	if (!$result)
		die('Invalid query: ' . mysql_error());
	
	$num_results = mysql_num_rows($result);
	if ($num_results <= 0)
	{
		$response = $response. "<font color='red'>There is no matching email in the database</font><br>";
		
	}
	
	$time = time();
	$tempPassword = hash ('md5', $time);
	
	$tempPasswordHash = hash ('sha256',$tempPassword);
	
	if((isset($question) || !empty($_REQUEST['question'])) && (isset($answer) || !empty($_REQUEST['answer'])) && (isset($email) || !empty($_REQUEST['email'])))
	{
		$response = null;
		$sqlUpdate = "update client set password='$tempPasswordHash', tempPassFlag=1 where email='$email';";
		$result2 = mysql_query($sqlUpdate);
		if (!$result2)
			die('Invalid query: ' . mysql_error());
		
		
		$from = "software.design.development@gmail.com";
		$to = $email;
		$subject = "Your new temporary password";
		$body = "Hi,\n\nYour new password has been updated.\n Please use this temporary password to log in: $tempPasswordHash";
	
		
		$headers = array('From' => $from, 'To'=>$to, 'Subject'=>$subject);
				
		$smtp = Mail::factory('smtp', array('host' => "ssl://smtp.gmail.com", 'port' => '465', 'auth' => true, 'username' => "software.design.development@gmail.com", 'password' => "sddspring2012"));
		
		$mail = $smtp->send($to, $headers, $body);
		
		if(!(PEAR::isError($mail)))
		{
			$response = "Mail With Temporary Password Sent Successfully!<br>Click Link to go to the <a href='index.php'>Login Page</a>";
		}
		else 
			$response = "<pre>".$mail -> getMessage()."<br>".$mail->getCode()."</pre>";
	
	}
	
	include "Config/closedbServer.php";
	echo $response;
	
	
?>