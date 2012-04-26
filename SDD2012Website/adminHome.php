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
			<?php 
				require_once 'Calendar/Month/Weekdays.php';

				$Month = new Calendar_Month_Weekdays(date('Y'), date('n'),0);

				$Month->build();
				
				$monthOfYear = $Month -> thisMonth();
				$monthName = NULL;
				
				$todaysDate = date('j');
				
				switch ($monthOfYear) 
				{
					case 1:
						$monthName ='January';
						break;
					case 2:
						$monthName ='Febrauray';
						break;
					case 3:
						$monthName ='March';
						break;
					case 4:
						$monthName ='April';
						break;
					case 5:
						$monthName ='May';
						break;
					case 6:
						$monthName ='June';
						break;
					case 7:
						$monthName ='July';
						break;
					case 8:
						$monthName ='August';
						break;
					case 9:
						$monthName ='September';
						break;
					case 10:
						$monthName ='October';
						break;
					case 11:
						$monthName ='November';
						break;
					case 12:
						$monthName ='December';
						break;
								
				}
				
				echo "<table style='text-align:center'>";
				echo "<tr style='background-color: #003366; color:white' ><th colspan='7'>$monthName</th></tr>";
				echo "<tr style='background-color: #003366; color:white'' ><th width='14%'>Sunday</th><th width='14%'>Monday</th><th width='14%'>Tuesday</th><th width='14%'>Wednesday</th><th width='14%'>Thursday</th><th width='14%'>Friday</th><th width='14%'>Saturday</th></tr>";

				while ($Day = $Month->fetch()) 
				{
    				if ($Day->isFirst()) 
    				{
        				echo "<tr>\n";
    				}

    				if ($Day->isEmpty()) 
    				{
	        			echo "<td>&nbsp;</td>\n";
    				} 
    				else 
    				{
    					if($Day->thisDay() == $todaysDate)
        					echo "<td bgcolor='#085258'>".$Day->thisDay()."</td>\n";
    					else 
    						echo "<td>".$Day->thisDay()."</td>\n";
    				}

			    	if ($Day->isLast()) 
			    	{
        				echo "</tr>\n";
	    			}
				}

				echo "</table>\n";
				
				
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
					$city = NULL;
					$forecastDate = NULL;
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
						echo "<div style='display:inline-block; margin:5px'>";
						echo "<br><table id='weather'class='weatherTable'>";
						echo "<tr><th colspan=2>Current Weather for $city</th></tr>";
						echo "<tr><td border='0' rowspan=5 '><img src='http://www.google.com/$icon'></img></td></tr>";
						echo "<tr><td border='0'>$currentCondition</td></tr>";
						echo "<tr><td border='0'>$currentTemp &degF</td></tr>";
						echo "<tr><td border='0'>$currentHumidity</td></tr>";
						echo "<tr><td border='0'>$currentWind</td></tr>";
						echo "</table><br>";
						echo "</div>";						
						
					}
					
					foreach ($item->forecast_conditions as $new)
					{
						$day = $new->day_of_week['data'];						
						$low = $new->low['data'];						
						$high = $new->high['data'];						
						$icon = $new->icon['data'];						
						$condition = $new->condition['data'];
						echo "<div style='display:inline-block; margin:5px'>";
						echo "<table id='weather' class='weatherTable'>";
						echo "<tr><th colspan=2>Weather for $city on $day</th></tr>";
						echo "<tr><td rowspan=3 '><img src='http://www.google.com/$icon'></img></td></tr>";
						echo "<tr><td>$condition</td></tr>";
						echo "<tr><td>$low &degF | $high &degF</td></tr>";
						echo "</table><br>";
						echo "</div>";
						
						
						
					}
				
					
					
				}
				
				
				
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