<?php
include_once("config.php");
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['login_user'])) {
	header('Location: login');
	exit;
}

// set default date and timezone
date_default_timezone_set('Asia/Seoul');

$site_list = Array();
$site_id = Array();
//$parameter_id = Array();
//$parameter_list = Array();

$sensor_list = Array();
$sensor_id = Array();
$sensor_name = Array();
$sensor_type = Array();
$site_site_id = Array();
$sensor_description = Array();

$dataPoints1 = array();
$dataPoints2 = array();
$dataPoints3 = array();
$dataPoints4 = array();
$dataPoints5 = array();
$dataPoints6 = array();

//identify the username from session logged user

$username = $_SESSION['login_user'];

// set default date and timezone
date_default_timezone_set('Asia/Seoul');

//findout the client name from account

$query_site = "SELECT site_id,site_name,site_address,description FROM site";

$result = mysqli_query($db,$query_site);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $site_id[] = $row['site_id'];
    $site_list[] =  $row['site_name'];
    
}

if(isset($_POST['submit'])) {	 
	 //$duration = $_POST['duration'];
	 $site_select = $_POST['site_id'];
	 //$site_select = 9;
	 $start_date = $_POST['start_date'];
	 $end_date = $_POST['end_date'];
	 
	 //$site_query = "SELECT site_name FROM site WHERE site_id = '$site_select'";
	 
	 $site_result = mysqli_query($db,"SELECT site_name FROM site WHERE site_id = '$site_select'");
	 $sitename = mysqli_fetch_assoc($site_result);
	 $site_name = $sitename['site_name'];
	 
	// Query number sensor in site
	$sensor_query = "SELECT sensor_id,sensor_name,sensor_type,uniqueID,status FROM sensor WHERE site_id = '$site_select' ORDER BY sensor_id ASC";
	$sensor_result = mysqli_query($db,$sensor_query);

	while($row=mysqli_fetch_assoc($sensor_result)) {
		$sensor_id[] = $row['sensor_id'];
		$sensor_name[] = $row['sensor_name'];
		$sensor_type[] = $row['sensor_type'];
	}

	for($i=0;$i<sizeof($sensor_id);$i++) 
	{
		if($i==0) 
		{
			if($sensor_type[$i] == 'TH')
			{
				$data_query = "SELECT data_date,data_time,temperature,humidity,CO2 FROM sensor_data WHERE site_id = '$site_select' AND sensor_id='$sensor_id[$i]' AND data_date BETWEEN '$start_date' AND '$end_date' ORDER BY data_date ASC,data_time ASC";
				$data_result = mysqli_query($db,$data_query);
			
				while($row=mysqli_fetch_assoc($data_result)) {
					$ts = $row['data_date']." ".$row['data_time'];
					
					$js_ts = strtotime($ts) * 1000;
					
					//echo $row['data_date'];
					array_push($dataPoints1, array("x" => $js_ts, "y" => $row['temperature']));
					array_push($dataPoints2, array("x" => $js_ts, "y" => $row['humidity']));
					array_push($dataPoints3, array("x" => $js_ts, "y" => $row['CO2']));
					
				} 
			
			}
		
			elseif($sensor_type[$i] == 'THC')
			{
				$data_query = "SELECT data_date,data_time,temperature,humidity,CO2 FROM thc_data WHERE site_id = '$site_select' AND sensor_id='$sensor_id[$i]' AND data_date BETWEEN '$start_date' AND '$end_date' ORDER BY data_date ASC,data_time ASC";
				$data_result = mysqli_query($db,$data_query);
				
					while($row=mysqli_fetch_assoc($data_result)) {
						$ts = $row['data_date']." ".$row['data_time'];
						
						$js_ts = strtotime($ts) * 1000;
						
						//echo $row['data_date'];
						array_push($dataPoints1, array("x" => $js_ts, "y" => $row['temperature']));
						array_push($dataPoints2, array("x" => $js_ts, "y" => $row['humidity']));
						array_push($dataPoints3, array("x" => $js_ts, "y" => $row['CO2']));
						
					}
			}
			elseif($sensor_type[$i] == 'AQ')
			{
				$data_query = "SELECT * FROM aq_data WHERE site_id = '$site_select' AND sensor_id='$sensor_id[$i]' AND data_date BETWEEN '$start_date' AND '$end_date' ORDER BY data_date ASC,data_time ASC";
				$data_result = mysqli_query($db,$data_query);
				
					while($row=mysqli_fetch_assoc($data_result)) {
						$ts = $row['data_date']." ".$row['data_time'];
						
						$js_ts = strtotime($ts) * 1000;
						
						//echo $row['data_date'];
						array_push($dataPoints1, array("x" => $js_ts, "y" => $row['temperature']));
						array_push($dataPoints2, array("x" => $js_ts, "y" => $row['humidity']));
						array_push($dataPoints3, array("x" => $js_ts, "y" => $row['pm10']));
						
					}
			}
		}
			
		if($i==1)
		{
			if($sensor_type[$i] == 'TH')
			{
				$data_query = "SELECT data_date,data_time,temperature,humidity,CO2 FROM sensor_data WHERE site_id = '$site_select' AND sensor_id='$sensor_id[$i]' AND data_date BETWEEN '$start_date' AND '$end_date' ORDER BY data_date ASC,data_time ASC";
				$data_result = mysqli_query($db,$data_query);
				
				while($row=mysqli_fetch_assoc($data_result)) {
					$ts = $row['data_date']." ".$row['data_time'];
					
					$js_ts = strtotime($ts) * 1000;
					
					//echo $row['data_date'];
					array_push($dataPoints4, array("x" => $js_ts, "y" => $row['temperature']));
					array_push($dataPoints5, array("x" => $js_ts, "y" => $row['humidity']));
					array_push($dataPoints6, array("x" => $js_ts, "y" => $row['CO2']));
					
				} 
			}
			
			elseif($sensor_type[$i] == 'THC')
			{
				$data_query = "SELECT data_date,data_time,temperature,humidity,CO2 FROM thc_data WHERE site_id = '$site_select' AND sensor_id='$sensor_id[$i]' AND data_date BETWEEN '$start_date' AND '$end_date' ORDER BY data_date ASC,data_time ASC";
				$data_result = mysqli_query($db,$data_query);
				
				while($row=mysqli_fetch_assoc($data_result)) {
					$ts = $row['data_date']." ".$row['data_time'];
					
					$js_ts = strtotime($ts) * 1000;
					
					//echo $row['data_date'];
					array_push($dataPoints4, array("x" => $js_ts, "y" => $row['temperature']));
					array_push($dataPoints5, array("x" => $js_ts, "y" => $row['humidity']));
					array_push($dataPoints6, array("x" => $js_ts, "y" => $row['CO2']));
					
				} 
			}
		
			elseif($sensor_type[$i] == 'AQ')
			{
				$data_query = "SELECT * FROM aq_data WHERE site_id = '$site_select' AND sensor_id='$sensor_id[$i]' AND data_date BETWEEN '$start_date' AND '$end_date' ORDER BY data_date ASC,data_time ASC";
				$data_result = mysqli_query($db,$data_query);
			
				while($row=mysqli_fetch_assoc($data_result)) {
					$ts = $row['data_date']." ".$row['data_time'];
					
					$js_ts = strtotime($ts) * 1000;
					
					//echo $row['data_date'];
					array_push($dataPoints4, array("x" => $js_ts, "y" => $row['pm1']));
					array_push($dataPoints5, array("x" => $js_ts, "y" => $row['pm25']));
					array_push($dataPoints6, array("x" => $js_ts, "y" => $row['pm10']));
					
				} 
			}
			
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<title>SFSL Data Portal</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<link rel="stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>

<style>
	#timeToRender {
		position:absolute; 
		top: 10px; 
		font-size: 20px; 
		font-weight: bold; 
		background-color: #d85757;
		padding: 0px 4px;
		color: #ffffff;
	}
</style>
<script type="text/javascript">
window.onload = function () {

// Checking number of sensors in the site
var sensors = <?php echo json_encode(sizeof($sensor_id));?>;
var sensor1_type = <?php echo json_encode($sensor_type[0]);?>;

// for sensor1
if(sensor1_type=='THC')
{
	//for temperature
	var data = [{
			type: "spline",
			lineThickness:1,
			color:"red",
			showInLegend: true,
			legendText: "Temperature",
			xValueType: "dateTime",
			xValueFormatString: "YYYY-MM-DD, HH:mm", 
			interval: "day",
			dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
		}];
		
	//Better to construct options first and then pass it as a parameter
	var options = {
		zoomEnabled: true,
		//animationEnabled: true,
		title: {
			text: "",
			fontSize: 16,
		},
		legend: {
		   horizontalAlign: "center", // "center" , "right"
		   verticalAlign: "top",  // "center",top" , "bottom"
		   fontSize: 14
		 },
		exportFileName: "temperature_graph",  //Give any name accordingly
		exportEnabled: true,
		axisY: {
			lineThickness: 2,
			suffix: "\xB0C",
		},
		data: data  // random data
	};
	 
	var chart = new CanvasJS.Chart("chartContainer1", options);

	var startTime = new Date();
	var endTime = new Date();

	chart.render();

	// for Humidity	sensor1

	var data = [{
			type: "spline",
			lineThickness:2,
			color:"green",
			showInLegend: true,
			legendText: "Humidity",
			xValueType: "dateTime",
			xValueFormatString: "YYYY-MM-DD, HH:mm", 
			interval: "day",
			dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
		}];
		
	//Better to construct options first and then pass it as a parameter
	var options = {
		zoomEnabled: true,
		//animationEnabled: true,
		title: {
			text: "",
			fontSize: 16,
		},
		legend: {
		   horizontalAlign: "center", // "center" , "right"
		   verticalAlign: "top",  // "center",top" , "bottom"
		   fontSize: 14
		 },
		exportFileName: "Humidity_graph",  //Give any name accordingly
		exportEnabled: true,
		axisY: {
			lineThickness: 1,
			suffix: "%",
		},
		data: data  // random data
	}; 
	var chart = new CanvasJS.Chart("chartContainer2", options);

	var startTime = new Date();
	var endTime = new Date();
	
	chart.render();
	
	// for CO2	sensor1

	var data = [{
			type: "spline",
			lineThickness:2,
			color:"blue",
			showInLegend: true,
			legendText: "CO2",
			xValueType: "dateTime",
			xValueFormatString: "YYYY-MM-DD, HH:mm", 
			interval: "day",
			dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
		}];
		
	//Better to construct options first and then pass it as a parameter
	var options = {
		zoomEnabled: true,
		//animationEnabled: true,
		title: {
			text: "",
			fontSize: 16,
		},
		legend: {
		   horizontalAlign: "center", // "center" , "right"
		   verticalAlign: "top",  // "center",top" , "bottom"
		   fontSize: 14
		 },
		exportFileName: "CO2_graph",  //Give any name accordingly
		exportEnabled: true,
		axisY: {
			lineThickness: 1,
			suffix: "PPM",
		},
		data: data  // random data
	}; 
	var chart = new CanvasJS.Chart("chartContainer3", options);

	var startTime = new Date();
	var endTime = new Date();
	
	chart.render();
}

// for AQ sensor
if(sensor1_type=='AQ') {
	//for temperature
	var data = [{
			type: "spline",
			lineThickness:1,
			color:"red",
			showInLegend: true,
			legendText: "PM1",
			xValueType: "dateTime",
			xValueFormatString: "YYYY-MM-DD, HH:mm", 
			interval: "day",
			dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
		}];
		
	//Better to construct options first and then pass it as a parameter
	var options = {
		zoomEnabled: true,
		//animationEnabled: true,
		title: {
			text: "",
			fontSize: 16,
		},
		legend: {
		   horizontalAlign: "center", // "center" , "right"
		   verticalAlign: "top",  // "center",top" , "bottom"
		   fontSize: 14
		 },
		exportFileName: "PM1_graph",  //Give any name accordingly
		exportEnabled: true,
		axisY: {
			lineThickness: 2,
			suffix: "µg",
		},
		data: data  // random data
	};
	 
	var chart = new CanvasJS.Chart("chartContainer1", options);

	var startTime = new Date();
	var endTime = new Date();

	chart.render();

	// for Humidity	sensor1

	var data = [{
			type: "spline",
			lineThickness:2,
			color:"green",
			showInLegend: true,
			legendText: "PM25",
			xValueType: "dateTime",
			xValueFormatString: "YYYY-MM-DD, HH:mm", 
			interval: "day",
			dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
		}];
		
	//Better to construct options first and then pass it as a parameter
	var options = {
		zoomEnabled: true,
		//animationEnabled: true,
		title: {
			text: "",
			fontSize: 16,
		},
		legend: {
		   horizontalAlign: "center", // "center" , "right"
		   verticalAlign: "top",  // "center",top" , "bottom"
		   fontSize: 14
		 },
		exportFileName: "PM25_graph",  //Give any name accordingly
		exportEnabled: true,
		axisY: {
			lineThickness: 1,
			suffix: "µg",
		},
		data: data  // random data
	}; 
	var chart = new CanvasJS.Chart("chartContainer2", options);

	var startTime = new Date();
	var endTime = new Date();
	
	chart.render();
	
	// for pm10	sensor1

	var data = [{
			type: "spline",
			lineThickness:2,
			color:"blue",
			showInLegend: true,
			legendText: "PM10",
			xValueType: "dateTime",
			xValueFormatString: "YYYY-MM-DD, HH:mm", 
			interval: "day",
			dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
		}];
		
	//Better to construct options first and then pass it as a parameter
	var options = {
		zoomEnabled: true,
		//animationEnabled: true,
		title: {
			text: "",
			fontSize: 16,
		},
		legend: {
		   horizontalAlign: "center", // "center" , "right"
		   verticalAlign: "top",  // "center",top" , "bottom"
		   fontSize: 14
		 },
		exportFileName: "PM10_graph",  //Give any name accordingly
		exportEnabled: true,
		axisY: {
			lineThickness: 1,
			suffix: "µg",
		},
		data: data  // random data
	}; 
	var chart = new CanvasJS.Chart("chartContainer3", options);

	var startTime = new Date();
	var endTime = new Date();
	
	chart.render();
}

if(sensors > 1)
{
	var sensor2_type = <?php echo json_encode($sensor_type[1]);?>;

	//For thc sensor
	if(sensor2_type=='THC'){
		//for temperature
		var data = [{
				type: "spline",
				lineThickness:1,
				color:"red",
				showInLegend: true,
				legendText: "Temperature",
				xValueType: "dateTime",
				xValueFormatString: "YYYY-MM-DD, HH:mm", 
				interval: "day",
				dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
			}];
			
		//Better to construct options first and then pass it as a parameter
		var options = {
			zoomEnabled: true,
			//animationEnabled: true,
			title: {
				text: "",
				fontSize: 16,
			},
			legend: {
			   horizontalAlign: "center", // "center" , "right"
			   verticalAlign: "top",  // "center",top" , "bottom"
			   fontSize: 14
			 },
			exportFileName: "temperature_graph",  //Give any name accordingly
			exportEnabled: true,
			axisY: {
				lineThickness: 2,
				suffix: "\xB0C",
			},
			data: data  // random data
		};
		 
		var chart = new CanvasJS.Chart("chartContainer4", options);

		var startTime = new Date();
		var endTime = new Date();

		chart.render();

		// for Humidity	sensor1

		var data = [{
				type: "spline",
				lineThickness:2,
				color:"green",
				showInLegend: true,
				legendText: "Humidity",
				xValueType: "dateTime",
				xValueFormatString: "YYYY-MM-DD, HH:mm", 
				interval: "day",
				dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
			}];
			
		//Better to construct options first and then pass it as a parameter
		var options = {
			zoomEnabled: true,
			//animationEnabled: true,
			title: {
				text: "",
				fontSize: 16,
			},
			legend: {
			   horizontalAlign: "center", // "center" , "right"
			   verticalAlign: "top",  // "center",top" , "bottom"
			   fontSize: 14
			 },
			exportFileName: "Humidity_graph",  //Give any name accordingly
			exportEnabled: true,
			axisY: {
				lineThickness: 1,
				suffix: "%",
			},
			data: data  // random data
		}; 
		var chart = new CanvasJS.Chart("chartContainer5", options);

		var startTime = new Date();
		var endTime = new Date();
		
		chart.render();
		
		// for CO2	sensor1

		var data = [{
				type: "spline",
				lineThickness:2,
				color:"blue",
				showInLegend: true,
				legendText: "CO2",
				xValueType: "dateTime",
				xValueFormatString: "YYYY-MM-DD, HH:mm", 
				interval: "day",
				dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>
			}];
			
		//Better to construct options first and then pass it as a parameter
		var options = {
			zoomEnabled: true,
			//animationEnabled: true,
			title: {
				text: "",
				fontSize: 16,
			},
			legend: {
			   horizontalAlign: "center", // "center" , "right"
			   verticalAlign: "top",  // "center",top" , "bottom"
			   fontSize: 14
			 },
			exportFileName: "CO2_graph",  //Give any name accordingly
			exportEnabled: true,
			axisY: {
				lineThickness: 1,
				suffix: "PPM",
			},
			data: data  // random data
		}; 
		var chart = new CanvasJS.Chart("chartContainer6", options);

		var startTime = new Date();
		var endTime = new Date();
		
		chart.render();
	}

	// For AQ sensor
	if(sensor2_type=='AQ') {
		//for temperature
		var data = [{
				type: "spline",
				lineThickness:1,
				color:"red",
				showInLegend: true,
				legendText: "PM1",
				xValueType: "dateTime",
				xValueFormatString: "YYYY-MM-DD, HH:mm", 
				interval: "day",
				dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
			}];
			
		//Better to construct options first and then pass it as a parameter
		var options = {
			zoomEnabled: true,
			//animationEnabled: true,
			title: {
				text: "",
				fontSize: 16,
			},
			legend: {
			   horizontalAlign: "center", // "center" , "right"
			   verticalAlign: "top",  // "center",top" , "bottom"
			   fontSize: 14
			 },
			exportFileName: "PM1_graph",  //Give any name accordingly
			exportEnabled: true,
			axisY: {
				lineThickness: 2,
				suffix: "µg",
			},
			data: data  // random data
		};
		 
		var chart = new CanvasJS.Chart("chartContainer4", options);

		var startTime = new Date();
		var endTime = new Date();

		chart.render();

		// for Humidity	sensor1

		var data = [{
				type: "spline",
				lineThickness:2,
				color:"green",
				showInLegend: true,
				legendText: "PM25",
				xValueType: "dateTime",
				xValueFormatString: "YYYY-MM-DD, HH:mm", 
				interval: "day",
				dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
			}];
			
		//Better to construct options first and then pass it as a parameter
		var options = {
			zoomEnabled: true,
			//animationEnabled: true,
			title: {
				text: "",
				fontSize: 16,
			},
			legend: {
			   horizontalAlign: "center", // "center" , "right"
			   verticalAlign: "top",  // "center",top" , "bottom"
			   fontSize: 14
			 },
			exportFileName: "PM25_graph",  //Give any name accordingly
			exportEnabled: true,
			axisY: {
				lineThickness: 1,
				suffix: "µg",
			},
			data: data  // random data
		}; 
		var chart = new CanvasJS.Chart("chartContainer5", options);

		var startTime = new Date();
		var endTime = new Date();
		
		chart.render();
		
		// for pm10	sensor1

		var data = [{
				type: "spline",
				lineThickness:2,
				color:"blue",
				showInLegend: true,
				legendText: "PM10",
				xValueType: "dateTime",
				xValueFormatString: "YYYY-MM-DD, HH:mm", 
				interval: "day",
				dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>
			}];
			
		//Better to construct options first and then pass it as a parameter
		var options = {
			zoomEnabled: true,
			//animationEnabled: true,
			title: {
				text: "",
				fontSize: 16,
			},
			legend: {
			   horizontalAlign: "center", // "center" , "right"
			   verticalAlign: "top",  // "center",top" , "bottom"
			   fontSize: 14
			 },
			exportFileName: "PM10_graph",  //Give any name accordingly
			exportEnabled: true,
			axisY: {
				lineThickness: 1,
				suffix: "µg",
			},
			data: data  // random data
		}; 
		var chart = new CanvasJS.Chart("chartContainer6", options);

		var startTime = new Date();
		var endTime = new Date();
		
		chart.render();
	}
}

document.getElementById("timeToRender").innerHTML = "Time to Render: " + (endTime - startTime) + "ms";
 
}

</script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</head>

<body>

<div class="header">
 
<ul>
  <li><a href="home_page"><i class="fas fa-home"></i> Home</a></li>
  <li><a class="active" href="live_data"><i class="fas fa-chart-line"></i> Numeric Data</a></li>
  <li><a href="pheno_data"><i class="fas fa-leaf"></i> Pheno Data</a></li>
  <li><a href="view_image"><i class="fas fa-image"></i> Image Data</a></li>
  <li><a href="log"><i class="fas fa-clipboard-list"></i> Log</a></li>
  <li><a href="download"><i class="fas fa-download"></i> Download</a></li>  
  <li><a href="signout"><i class="fas fa-sign-out-alt"></i> Signout</a></li>
</ul>

</div>

<div class = "container">
<div>
	<h2 class = 'caption2'> Please select the date and site name.</h2>
</div>

<div class = "form-container">
  <form action="" method="POST">
  
  <div class="row">
    <div class="col-25">
      <label for="start_date">Start Date</label>
    </div>
    <div class="col-75">
      <input type="date" id="start_date" name="start_date" value=<?php echo "$start_date"?>>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="end_date">End Date</label>
    </div>
    <div class="col-75">
      <input type="date" id="end_date" name="end_date" value=<?php echo "$end_date"?>>
    </div>
  </div>
 
  <div class="row">
    <div class="col-25">
      <label for="station_id">Site Name</label>
    </div>
    <div class="col-75">
      <select id="site_id" name="site_id">
	  <option value = <?php echo "$site_select"?>selected><?php echo $site_name?></option>
        <option disabled>--Select Site Name --</option>
			<?php 
			    for ($i=0;$i<sizeof($site_id);$i++) {
			        echo "<option value = '".$site_id[$i]."'>".$site_list[$i]."</option>";
			    }
			    
			 ?>
      </select>
	  <!--select id="parameter" name="parameter">
        <option disabled selected>--Select a parameter --</option>
			<-?php 
			    for ($i=0;$i<sizeof($parameter_id);$i++) {
			        echo "<option value = '".$parameter_id[$i]."'>".$parameter_list[$i]."</option>";
			    }
			    
			 ?>
      </select-->
      
    </div>
  </div>
  <div class="row">
		<input type="submit" name = "submit" value="View">
  </div>
  </form>
</div>
<div class="station">
	
	<?php 
	
        if($sensor_type[0]=='THC')
		{
			echo "<h2 class = 'caption2'>Temperature of $sensor_name[0] in $start_date to $end_date.</h2>";
			echo "<div id='chartContainer1'></div>"	;
			echo "<br>";
			
			echo "<h2 class = 'caption2'>Humidity of $sensor_name[0] in  $start_date to $end_date.</h2>";
			echo "<div id='chartContainer2'></div>";
			echo "<br>";
			
			echo "<h2 class = 'caption2'>CO2 of $sensor_name[0] in  $start_date to $end_date.</h2>";
			echo "<div id='chartContainer3'></div>";				
			echo "<br>";
		}
		
		if($sensor_type[0]=='AQ')
		{
			echo "<h2 class = 'caption2'>PM1 of $sensor_name[0] in $start_date to $end_date.</h2>";
			echo "<div id='chartContainer1'></div>";	
			echo "<br>";
			 
			echo "<h2 class = 'caption2'>PM25 of $sensor_name[0] in  $start_date to $end_date.</h2>";
			echo "<div id='chartContainer2'></div>";		
			echo "<br>";
			
			echo "<h2 class = 'caption2'>PM10 of $sensor_name[0] in  $start_date to $end_date.</h2>";
			echo "<div id='chartContainer3'></div>";	
			echo "<br>";
		}
		if (sizeof($sensor_id)>1){
			if($sensor_type[1]=='THC')
			{
				echo "<h2 class = 'caption2'>Temperature of $sensor_name[1] in $start_date to $end_date.</h2>";
				echo "<div id='chartContainer4'></div>";	
				echo "<br>";
				
				echo "<h2 class = 'caption2'>Humidity of $sensor_name[1] in  $start_date to $end_date.</h2>";
				echo "<div id='chartContainer5'></div>";	
				echo "<br>";
				
				echo "<h2 class = 'caption2'>CO2 of $sensor_name[1] in  $start_date to $end_date.</h2>";
				echo "<div id='chartContainer6'></div>";				
				echo "<br>";
			}
			
			if($sensor_type[1]=='AQ')
			{
				echo "<h2 class = 'caption2'>PM1 of $sensor_name[1] in $start_date to $end_date.</h2>";
				echo "<div id='chartContainer4'></div>";	
				echo "<br>";
				 
				echo "<h2 class = 'caption2'>PM25 of $sensor_name[1] in  $start_date to $end_date.</h2>";
				echo "<div id='chartContainer5'></div>";		
				echo "<br>";
				
				echo "<h2 class = 'caption2'>PM10 of $sensor_name[1] in  $start_date to $end_date.</h2>";
				echo "<div id='chartContainer6'></div>";
				echo "<br>";
			}
		}
		?>
<br>
<br>	
</div>
</div>
</body>
</html>
