<?php

include "Config/configServer.php";
include "Config/connectServer.php";

$response = null;

if (isset($_REQUEST['email']) && !empty($_REQUEST['email']))
{
	$email=$_REQUEST['email'];

}
else
	$response = $response."<font color='red'>You need enter your email address</font><br>";

if (isset($_REQUEST['password']) && !empty($_REQUEST['password']))
{
	$password=$_REQUEST['password'];

}
else
	$response = $response."<font color='red'>You need enter a non blank password</font><br>";

if (isset($_REQUEST['password2']) && !empty($_REQUEST['password2']))
{
	$password2=$_REQUEST['password2'];

}
else
{
	$response = $response."<font color='red'>Your second password must not be blank</font><br>";

}

if ($password == $password2)
{
	//Update database and move person back to home page
	$sha256Pass = hash ( 'sha256' , $password );
	
	$sql = "select * from client where email='$email' and tempPassFlag=1;";
	$result = mysql_query($sql);
	if (!$result)
		die('Invalid query: ' . mysql_error());
	
	$check_result = mysql_num_rows($result);
	if($check_result > 0)
	{
		$sqlUpdate = "update client set password='$sha256Pass', tempPassFlag=0 where email='$email';";
		$result = mysql_query($sqlUpdate);
		if (!$result)
			die('Invalid query: ' . mysql_error());
		$response = $response . "Password Updated Successfully<br>Click Link to go to the <a href='index.php'>Login Page</a>";
	}
	else 
		$response = $response . "You did not enter a valid email";
	

}
else
{
	$response = $response."<font color='red'>Your Passwords must match</font><br>";

}

include "Config/closedbServer.php";
echo $response;

?>