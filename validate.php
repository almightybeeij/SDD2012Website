<?php
session_start();
?>
<html>
<body>

<?php

include 'configServer.php';
include 'connectServer.php';

//Delete from clientSession if there is a previous session cookie
$sha256Pass = hash ('sha256', $_POST['password']);
$sqlDelete = "delete from clientSession where username='$_POST[username]' and password = '$sha256Pass';";
$resultDelete = mysql_query($sqlDelete);



$sha256Pass = hash ( 'sha256' , $_POST['password'] );
$sql = "select * from users where username='".$_POST['username']."' and password='".$sha256Pass."';";

$result = mysql_query($sql);
if (!$result) 
    die('Invalid query: ' . mysql_error());

$num_results = mysql_num_rows($result);
if ($num_results <= 0)
{
	include 'closedbServer.php';
	#header("Location: invalid.php");
	$_SESSION['invalid'] = 'invalidUserNameAndPassword';
	header("Location: index.php");
}
else
{
	$sessionCookie = hash ('sha256', time());
        $sqlSession = "insert into clientSession values ('$_POST[username]','$sha256Pass','$sessionCookie');";

        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $sha256Pass;
        $_SESSION['sessionCookie'] = $sessionCookie;

        $resultSession = mysql_query($sqlSession);
        if (!$resultSession)
	        die('Invalid query: ' . mysql_error());

	include 'closedbServer.php';
	header("Location: home.php");
}

?>

</body>
</html>
