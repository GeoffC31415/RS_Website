function generateCharts() {
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);
};

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
		backgroundColor: '#eeffee',
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
		backgroundColor: '#eeffee',
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
		backgroundColor: '#eeeeff',
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
		backgroundColor: '#eeeeff',
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
