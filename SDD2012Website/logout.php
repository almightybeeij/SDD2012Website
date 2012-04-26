<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="StyleSheets/style.css" />
<title>Logout Page</title>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

    google.load("feeds", "1");

    function initialize() {
      var feed = new google.feeds.Feed("http://calendar.uco.edu//RSSFeeds.aspx?data=O05KNhuuK%2bvmWacXx1zmeZ%2byhPDk%2bYf4qBv6clitqUQ%3d");
      //var feed = new google.feeds.Feed("http://www.bangkokpost.com/rss/data/breakingnews.xml");
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
	if (isset($_SESSION['sessionCookie']) && $_SESSION['userType'] == "regular")
	{

		include 'Config/configServer.php';
		include 'Config/connectServer.php';
		?>

	<!--Top Banner-->
	<center>
		<img src="Images/UCOBanner.gif"></img>
		<img src="Images/linux-powered.png"/>		
	</center>
	<?php
	include "menu"
	?>
	<?php

	if (isset($_POST['logout']))
	{
		$sqlDelete = "delete from clientsession where Client_email='$_SESSION[email]' and sessionid = '$_SESSION[sessionCookie]';";
		$resultDelete = mysql_query($sqlDelete);
		$num_results = mysql_num_rows($resultDelete);
		include 'Config/closedbServer.php';
		session_destroy();
		header("Location: index.php");
	}

	?>

	<div id="outerBlock">
		<div id="containerBlarg">
			<!-- Left side Pane-->
			<div id="leftPane">
				<center>
					<span
						style="text-decoration: underline; font: 15px Verdana; font-weight: 900">RSS
						FEED</span>
				</center>
				<br>
			</div>

			<!-- Main Content Area-->
			<div id="content">
				Are you sure you want to log out?
				<form name='logout' action='<?=$PHP_SELF?>' method='post'>
					<input type='submit' name='logout' value='Logout' />
				</form>
			</div>

			<!-- Right Side Pane-->
			<div id="rightPane">
					<?php 
			//Weather
				
				//Name of your town/city
				$place="Oklahoma+City";
				//Initialize CURL
				$ch = curl_init();
				
				
				$timeout = 0;
				
				//Set CURL options
				curl_setopt ($ch, CURLOPT_URL, 'http://www.google.com/ig/api?weather='.$place.'&hl=en');
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				$xml_str=curl_exec($ch);
				
				//close CURL cause we dont need it anymore
				curl_close($ch);
				
				// Parse the XML response
				$xml = new SimplexmlElement($xml_str);
				//echo "<pre>This is what was in XML:  ".var_dump($xml)."</pre><br>";
				foreach($xml->weather as $item) 
				{
				
					$city=NULL;
					$forecastDate=NULL;
					$count=0;
					foreach($item->forecast_information as $new) 
					{
					
						//For temperature in fahrenheit replace temp_c by temp_f
						$city = $new->postal_code['data'];
						$forecastDate = $new->forecast_date['data'];
						
					
					}
					
					
				foreach($item->current_conditions as $new) 
					{		
						$currentCondition = $new->condition['data'];
						$currentTemp = $new->temp_f['data'];
						$currentHumidity = $new->humidity['data'];
						$icon = $new->icon['data'];
						$currentWind = $new->wind_condition['data'];
						
						echo "<table id='weather' class='weatherTable'>";
						echo "<tr><th colspan=2>Current Weather </th></tr>";
						echo "<tr><td border='0' rowspan=5 '><img src='http://www.google.com/$icon'></img></td></tr>";
						echo "<tr><td border='0'>$currentCondition</td></tr>";
						echo "<tr><td border='0'>$currentTemp &degF</td></tr>";
						echo "<tr><td border='0'>$currentHumidity</td></tr>";
						echo "<tr><td border='0'>$currentWind</td></tr>";
						echo "</table>";						
						
					}
					
					
					foreach ($item->forecast_conditions as $new)
					{
						if($count < 3)
						{
							$day = $new->day_of_week['data'];						
							$low = $new->low['data'];						
							$high = $new->high['data'];						
							$icon = $new->icon['data'];						
							$condition = $new->condition['data'];

							echo "<table id='weather'class='weatherTable'>";
							echo "<tr><th colspan=2>$city $day</th></tr>";
							echo "<tr><td rowspan=3 '><img src='http://www.google.com/$icon'></img></td></tr>";
							echo "<tr><td>$condition</td></tr>";
							echo "<tr><td>$low &degF | $high &degF</td></tr>";
							echo "</table>";
							$count += 1;
						
						
						
						}
					}
				
					
					
				}
			
				?>
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
		header('Refresh: 3; URL= index.php'); 
		echo "You are not logged in";
	} 
	?>
</body>
</html>
