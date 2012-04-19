<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/adminStyle.css" />
<!--  <script type="text/javascript" src="https://www.google.com/jsapi"></script>-->
<title>Admin Home Page</title>

<script language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script language="javascript" src="Scripts/jquery.tweet.js" type="text/javascript"></script>
<link href="StyleSheets/jquery.tweet.css" media="all" rel="stylesheet" type="text/css"/>
<script type='text/javascript'>
    jQuery(function($){
        $(".tweet").tweet({
            username: "UCOParking",
            join_text: "auto",
            avatar_size: 20,
            count: 3,
            auto_join_text_default: "we said,", 
            auto_join_text_ed: "we",
            auto_join_text_ing: "we were",
            auto_join_text_reply: "we replied to",
            auto_join_text_url: "we were checking out",
            loading_text: "loading tweets..."
        });
    });
</script>
</head>
<body>
<?php if (isset($_SESSION['sessionCookie']) && $_SESSION['userType'] == "admin")
	{
	?>
<div id="outerContainer">
	<div id="innerContainer">
	<?php include "menuAdmin"?>
		<div class="tweet" id="tweet">
			<b>twitter Feed</b>
			<br><br>			
		</div>
		<div id="mainContentPane">
			Main Content Pane<br>	
			Admin Home Page	<br>
			Here can be some Intersting stuff<br>	
		</div>
	</div>
</div>
<?php
	}
else
	{
		header('Refresh: 3; URL= index.php'); 
		echo "You are not logged in";
	} 
?>
</body>
</html>