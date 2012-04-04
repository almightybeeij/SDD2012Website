<html>
<head>
<link rel="stylesheet" type="text/css"
	href="StyleSheets/forgotPassword.css" />
<script type="text/javascript" src="Scripts/email.js"></script>
</head>
<body>
	<div id="outerContainer">
	<label style="font-weight:bold">Update Your Temporary Password</label>
	<br>
		<div id="innerContainer">
			<label id="emailLabel" for="emailTextBox">Enter Your Email Address:</label>
			<input id="emailTextBox" name="emailTextBox" type="text" />
			<br>
			<label id="passwordLabel" for="passwordTextBox">Update Your New Password:</label>
			<input id="passwordTextBox" name="passwordTextBox" type="password" />
			<br>
			<label id="password2Label" for="password2TextBox">Enter Your Password Again:</label>
			<input id="password2TextBox" name="password2TextBox" type="password" />
			<br>
			<button type="button"onclick="updatePassword(document.getElementById('emailTextBox').value,document.getElementById('passwordTextBox').value,document.getElementById('password2TextBox').value )">Email Password</button>
			<br><br> 
			<div id="passwordStatus"></div>
		</div>
	</div>
</body>
</html>
