<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/style.css" />
<title>About Page</title>
</head>
<body>
<?php
if (isset($_SESSION['sessionCookie']))
{
?>
<!--Top Banner-->
  <center><img src="Images/UCOBanner.gif"></img></center>

  <!-- Main Content Area-->
 <div id="aboutContent">

     <?php
        include "menu.workingInsideContainer"
     ?>
  <!-- Left side Pane-->
  <div id="aboutLeftPane">
    <center><span style="text-decoration:underline; font:15px Verdana; font-weight:900">RSS FEED</span></center></br>
  </div>

  <!-- Middle Pane -->
  <div id="aboutMiddlePane">
    Whats it all about eh?</br>
    Filler text</br>
    Filler text</br>
    Filler text</br>
    Filler text</br>
    Filler text</br>
    Filler text</br>
    Filler text</br>
    Filler text</br>
    Filler text</br>
    Filler text</br>
    Filler text</br>
  </div>

  <!-- Right Side Pane-->
  <div id="aboutRightPane">
      This is the right pane
  </div>
  <!-- Footer-->
  <div id="footer">This is the footer</div>

 </div>

  <?php
    }
    else
    {
        echo 'You are not logged in';
    }
  ?>
</body>
</html>


