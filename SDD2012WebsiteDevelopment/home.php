<?php session_start() ?>
<html>
<head>
<Title>Welcome to UCO Parking Management Homepage</Title>
<link rel="stylesheet" type="text/css" href="StyleSheets/style.css" />
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript" href="Scrips/myScript.js"></script>
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
<div id="outerBlock">
<div id="containerBlarg">
<!-- Left side Pane-->
 <div id="leftPane">
    <center><span style="text-decoration:underline; font:15px Verdana; font-weight:900">RSS FEED</span></center></br>
 </div>

<!-- Main Content Area-->
 <div id="content">
    Hello and welcome to the SDD Spring Semester Class Page</br>
    A Line</br>
    B Line</br>
    C Line</br>
    D Line</br>
    E Line</br>
    F Line</br>
    G Line</br>
    H Line</br>
    I Line</br>
    J Line </br>
    K Line</br>
    L Line</br>
    M Line</br>
    N Line</br>
    O Line</br>
    P Line</br>
    Q Line</br>
    R Line</br>
    S Line</br>
    T Line</br>
    U Line</br>
    V Line</br>
    W Line</br>
    X Line</br>
    Y Line</br>
    Z Line</br>
    0 Line</br>
    1 Line</br>
    2 Line</br>
    3 Line</br>
    4 Line</br>
    5 Line</br>
    6 Line</br>
 </div>

<!-- Right Side Pane-->
    <div id="rightPane">
	This is the right pane
    </div>
</div>
<!-- Footer-->
    <div id="footer">
       <?php 
            $time = time(); 
            $year=date("Y",$time);
	    echo" Copyright &copy $year - Tyler's SDD Group - All Rights Reserved";
       ?>
    </div>
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
