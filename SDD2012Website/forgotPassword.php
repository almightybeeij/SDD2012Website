<?php 
session_destroy();
ob_end_flush();
?>
<html>
<head>
<link rel="stylesheet" type="text/css"
	href="StyleSheets/forgotPassword.css" />
<script type="text/javascript" src="Scripts/email.js"></script>
</head>
<body>
	<div id="outerContainer">
		<div id="innerContainer">

			<label id="securityQuestions">Select Security Question:</label> <select
				id="questions">
				<option value="" selected="selected">Please choose one below</option>
				<option value="pet">What is your pet's name?</option>
				<option value="birth">Where were you born?</option>
				<option value="team">What is your favorite sports team?</option>
			</select><br>
			<label id="answerLabel" for="answerTextBox">Enter your security answer here:</label><input id="answerTextBox" type="text" />
			<br><br> 
			<label id="emailLabel" for="emailTextBox">Enter your email address:</label>
			<input id="emailTextBox" name="email" type="text" />
			<br>
			<button type="button"onclick="emailTempPassword(document.getElementById('questions').options[document.getElementById('questions').selectedIndex].value ,document.getElementById('answerTextBox').value ,document.getElementById('emailTextBox').value)">Email Password</button>
			<br><br> 
			<div id="status"></div>
		</div>
	</div>
</body>
</html>
