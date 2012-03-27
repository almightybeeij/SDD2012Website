<?php session_start()?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/login.css" />
<title>Login Page</title>
</head>
<body>
	<div id="header">
		Welcome to UCO Parking Management System</br></br>
	</div>
	<div id="outerBlock">
	<div id='container'>
	<img src='Images/ucoScaled50.jpg'/>
	  <div id='formBlock'>
	    <div id="formText">
	<?php
        #foreach ($_SESSION as $key => $value)
        #{
        #        echo "$Key is $value</br>";
        #}
        if ($_SESSION['invalid'] == 'invalidUserNameAndPassword')
        {
	$link=true;
        ?>
	  <p style="color:red"><b>Please Enter Valid Username and Password</b></p>
	  <?php session_destroy();
	}
	else
		echo '</br></br>';
	?>
	<form name='login' action='validate.php' method = 'post'>
	    <label id="usernameLabel" for="username">Username:</label> <input id="usernameText" type='text' name= 'username'/></br>
	    <label id="passwordLabel" for="password">Password:</label> <input id="passwordText" type='password' name= 'password'/></br>
	    <?php if ($link == true) echo "<a href='forgot.php'>Forgot Password?</a>"; ?>
	    </label><input id="submit" type='submit' name='submit' value='Sign In'/>
	</form>
	    </div>
	  </div>
	</div>
	</div>

</body>
</html>
