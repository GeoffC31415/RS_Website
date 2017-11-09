<!DOCTYPE html>
<head>
	<link rel="stylesheet" type="text/css" href="RS_Website/newstyle.css">
</head>

<html>
	<title> ExHydro Hydroponic Condition Monitoring </title>
	<body>
		<?php include "RS_Website/php/RS_db_handler.php"; ?>

		<!-- Header section -->
		<h1> ExHydro: Mobile Plant Autofactory </h1>
		<div class="introtext">
			<h3> Proposition </h3>
			Requiring just 10kW of power per unit and a water source, our mobile autofactories monitor and maintain plant growth from germination through to harvest.
			<br><br>
			Our business provides the hardware and software, and also supplies seeds, nutrients, and assorted additives to control the conditions remotely.
			<br>
			<h3> Operations </h3>
			Our mobile autofactories are contained within a standard shipping container and are deployable anywhere in the world and can grow a wide range of crops using pre-defined 'recipes'.
			High value crops can be grown whatever the weather and at any time of year, maintaining optimal growing conditions resulting in huge yields.
			<br><br>
			Being containerised, operations are trivial to scale to produce any required output. Each container can reliably produce 300kg of rocket every ten days.
			<br><br>
			Being a hermetically sealed unit, no herbicides or insecticides are required, nor are traditional fertilisers.
			<br><br>
			We believe this offers an excellent opportunity for fresh salad crops at <b>restaurants and hotels in the Middle East</b> or other <b>desert or island environments</b>, improving freshness and reducing cost.
			<br><br>
			Other applications are for tight control and automation on high value pharmaceutical crops, and micro-herbs.
			<br>
			<h3> Find out more </h3>
			To find out more, please contact our Propositions Director on <b>+44 7849 834648</b>.
		</div>
		
		<!-- Hard Data :) -->
		<h2> Graphs of Readings </h2>
		
		<!-- Google Charts Graphs 
		<div class="sensorgroup" style="background-color: #EEFFEE;">
			<h3 class="sensorgrouptitle">Atmospheric Conditions</h3>
			<div id="temp" 		style="height: 440px; width: 938px"></div>
			<div id="humidity" 	style="height: 440px; width: 938px"></div>
		</div>
		<br>
		<div class="sensorgroup" style="background-color: #EEEEFF;">
			<h3 class="sensorgrouptitle">Reservoir Conditions</h3>
			<div id="ph_1" 		style="height: 440px; width: 938px"></div>
			<div id="ec_1" 		style="height: 440px; width: 938px"></div>
		</div>
		
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="RS_Website/js/charts.js"></script>
		<script type="text/javascript"> generateCharts(); </script>
		-->
		
		<!-- Grafana Dashboard iFrame -->
		<iframe src="http://hydro.organicdrive.co.uk:3000/dashboard/db/demo-plant?theme=light" width="955" height="1185" frameborder="0"></iframe>
		
		<!-- Display latest image -->
		<h2> Current Picture - Our Experimental Bench </h2>
		<img src="RS_Website/images/image_recent.jpg" alt="Current Snapshot">
		<?php
			$filename = "RS_Website/images/image_recent.jpg";
			if (file_exists($filename)) {
				echo "<div class=\"centretext\">";
				echo "Image was last recorded: " . date ("F d Y H:i:s.", filemtime($filename));
				echo "</div>";
			}
		?>
		
		<!-- Tables of past notes -->
		<h2> Logs </h2>
		<div class="wrapper">
			<?php getNoteTopFive(); ?>
		</div>
		<br>
		
		<!-- iFrames for the forms -->
		<div class="wrapper">
			<div class="leftbar">
				<iframe class="insertrow" src="RS_Website/add_note.html"></iframe>
			</div>
			<div class="rightbar">
				<iframe class="insertrow" src="RS_Website/add_Reading.html"></iframe>
			</div>
			<div class="cleared"></div>
		</div>
	</body>
</html>
