<?php session_start() ?>
<html>
<head>
<Title>Welcome to UCO Parking Management Homepage</Title>
<link rel="stylesheet" type="text/css" href="StyleSheets/style.css" />
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

    google.load("feeds", "1");

    function initialize() {
      //var feed = new google.feeds.Feed("http://calendar.uco.edu//RSSFeeds.aspx?data=O05KNhuuK%2bvmWacXx1zmeZ%2byhPDk%2bYf4qBv6clitqUQ%3d");
      var feed = new google.feeds.Feed("http://www.bangkokpost.com/rss/data/breakingnews.xml");
      feed.load(function(result) {
        if (!result.error) {
          var container = document.getElementById("leftPane");
          for (var i = 0; i < result.feed.entries.length; i++) {
            var entry = result.feed.entries[i];
            var div = document.createElement("div");
	    var newLine = document.createElement("br");
            div.appendChild(document.createTextNode(entry.title));
            container.appendChild(div);
            container.appendChild(newLine);
          }
        }
      });
    }
    google.setOnLoadCallback(initialize);

    </script>
</head>
<body>
<?php
if (isset($_SESSION['sessionCookie']))
{
?>

<!--Top Banner-->
<center><img src="Images/UCOBanner.gif"></img></center>

   <?php
     include "menu"
   ?>

<!-- Left side Pane-->
 <div id="leftPane">
    <center><span style="text-decoration:underline; font:15px Verdana; font-weight:900">RSS FEED</span></center></br>
 </div>

<!-- Main Content Area-->
 <div id="content">
    Hello and welcome to the SDD Spring Semester Class Page</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
    Filler Text</br>
 </div>

<!-- Right Side Pane-->
    <div id="rightPane">
	This is the right pane
    </div>

<!-- Footer-->
    <div id="footer">This is the footer</div>
  <?php 
    }
    else
    {
	echo 'You are not logged in';
    }
  ?>
</body>
</html>
