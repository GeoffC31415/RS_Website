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
				<iframe src="RS_Website/add_note.html"></iframe>
			</div>
			<div class="rightbar">
				<iframe src="RS_Website/add_Reading.html"></iframe>
			</div>
			<div class="cleared"></div>
		</div>

		<!-- Google Charts Graphs -->
		<h2> Graphs of Readings </h2>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript">
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);

			function drawChart() {
				
				var jsonData1 = $.ajax({
					url: "RS_Website/php/getJSON_Sensor_Humidities.php",
					dataType: "json",
					async: false
					}).responseText;
				var jsonData2 = $.ajax({
					url: "RS_Website/php/getJSON_Sensor_Temps.php",
					dataType: "json",
					async: false
					}).responseText;
				var jsonData9 = $.ajax({
					url: "RS_Website/php/getJSON_Sensor9.php",
					dataType: "json",
					async: false
					}).responseText;
				var jsonData10 = $.ajax({
					url: "RS_Website/php/getJSON_Sensor10.php",
					dataType: "json",
					async: false
					}).responseText;
				
				// Create our data table out of JSON data loaded from server.
				var data1  = new google.visualization.DataTable(jsonData1);
				var data2  = new google.visualization.DataTable(jsonData2);
				var data9  = new google.visualization.DataTable(jsonData9);
				var data10 = new google.visualization.DataTable(jsonData10);
				
				var options1 = {
					title: 'Humidity Readings',
					vAxis: {title: 'Percent Humidity'},
					colors: ['firebrick','green','dodgerblue','darkkhaki', 'firebrick','green','dodgerblue','darkkhaki'],
					chartArea: { backgroundColor : '#f6f6f6' },
					legend: {
						position: 'bottom', textStyle: {fontSize: 10}
					},
					series: {
								// series 0 is the data points
								0: {
									pointSize: 3,
									pointShape: { type: 'star', sides: 4, dent: 0.2 },
									visibleInLegend: false
								},
								1: {
									pointSize: 3,
									pointShape: { type: 'star', sides: 4, dent: 0.2 },
									visibleInLegend: false
								},
								2: {
									pointSize: 3,
									pointShape: { type: 'star', sides: 4, dent: 0.2 },
									visibleInLegend: false
								},
								3: {
									pointSize: 3,
									pointShape: { type: 'star', sides: 4, dent: 0.2 },
									visibleInLegend: false
								},
								// series 1 is the moving average
								4: {
									lineWidth: 3,
									pointSize: 0,
									visibleInLegend: true
								},
								5: {
									lineWidth: 3,
									pointSize: 0,
									visibleInLegend: true
								},
								6: {
									lineWidth: 3,
									pointSize: 0,
									visibleInLegend: true
								},
								7: {
									lineWidth: 3,
									pointSize: 0,
									visibleInLegend: true
								}
							},
					vAxis: 	{
								minValue: 0,
								maxValue: 100
							}
				};
				var options2 = {
					title: 'Temperature Readings',
					vAxis: {title: 'Degrees Celsius'},
					legend: 'none',
					colors: ['firebrick','green','dodgerblue','darkkhaki', 'firebrick','green','dodgerblue','darkkhaki'],
					chartArea: { backgroundColor : '#f6f6f6' },
					legend: {
						position: 'bottom', textStyle: {fontSize: 10}
					},
					series: {
								// series 0 is the data points
								0: {
									pointSize: 3,
									pointShape: { type: 'star', sides: 4, dent: 0.2 },
									visibleInLegend: false
								},
								1: {
									pointSize: 3,
									pointShape: { type: 'star', sides: 4, dent: 0.2 },
									visibleInLegend: false
								},
								2: {
									pointSize: 3,
									pointShape: { type: 'star', sides: 4, dent: 0.2 },
									visibleInLegend: false
								},
								3: {
									pointSize: 3,
									pointShape: { type: 'star', sides: 4, dent: 0.2 },
									visibleInLegend: false
								},
								// series 1 is the moving average
								4: {
									lineWidth: 3,
									pointSize: 0,
									visibleInLegend: true
								},
								5: {
									lineWidth: 3,
									pointSize: 0,
									visibleInLegend: true
								},
								6: {
									lineWidth: 3,
									pointSize: 0,
									visibleInLegend: true
								},
								7: {
									lineWidth: 3,
									pointSize: 0,
									visibleInLegend: true
								}
							},
					vAxis: 	{
								minValue: 0,
								maxValue: 40
							}
				};
				var options9 = {
					title: 'Reservoir pH',
					vAxis: {title: 'pH'},
					legend: 'none',
					colors: ['black', '#ff3a25'],
					chartArea: { backgroundColor : '#f6f6f6' },
					series: {
								// series 0 is the data points
								0: {
									pointSize: 3,
									pointShape: { type: 'star', sides: 4, dent: 0.2 }
								},
								// series 1 is the moving average
								1: {
									lineWidth: 3,
									pointSize: 0
								}
							}
				};
				var options10 = {
					title: 'Reservoir EC',
					vAxis: {title: 'uS per cm'},
					legend: 'none',
					colors: ['black', '#ff3a25'],
					chartArea: { backgroundColor : '#f6f6f6' },
					series: {
								// series 0 is the data points
								0: {
									pointSize: 3,
									pointShape: { type: 'star', sides: 4, dent: 0.2 }
								},
								// series 1 is the moving average
								1: {
									lineWidth: 3,
									pointSize: 0
								}
							}
				};


				var chart1 = new google.visualization.ScatterChart(document.getElementById('humidity'));
				var chart2 = new google.visualization.ScatterChart(document.getElementById('temp'));
				var chart9 = new google.visualization.ScatterChart(document.getElementById('ph_1'));
				var chart10 = new google.visualization.ScatterChart(document.getElementById('ec_1'));

				chart1.draw(data1, options1);
				chart2.draw(data2, options2);
				chart9.draw(data9, options9);
				chart10.draw(data10, options10);
			}
		</script>
		<div id="temp" 			style="height: 440px; width: 955px"></div>
		<div id="ph_1" 			style="height: 440px; width: 955px"></div>
		<div id="humidity" 		style="height: 440px; width: 955px"></div>
		<div id="ec_1" 			style="height: 440px; width: 955px"></div>
		
	</body>
</html>
