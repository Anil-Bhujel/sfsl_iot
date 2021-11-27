<?php
include_once("config.php");
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['login_user'])) {
	header('Location: login');
	exit;
}

$site_list = Array();
$site_id = Array();
$site_address = Array();
$site_latitude = Array();
$site_longitude = Array();
$site_altitude = Array();
$site_description = Array();

$sensor_list = Array();
$sensor_id = Array();
$sensor_model = Array();
$sensor_type = Array();
$install_date = Array();
$sensor_site_id = Array();
$unique_id = Array();
$status = Array();

$actuator_id = array();
$act_site_id = array();
$actuator_list = array();
$act_location = array();
$act_model = array();
$act_description = array();
$act_install_date = array();

// Query the site details
$query_site = "SELECT * FROM site";

$result = mysqli_query($db,$query_site);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $site_id[] = $row['site_id'];
    $site_list[] =  $row['site_name'];
    $site_address[] = $row['site_address'];
	$site_latitude[] = $row['latitude'];
	$site_longitude[] = $row['longitude'];
	$site_altitude[] = $row['altitude'];
    $site_description[] = $row['description'];
}

// Query the sensor detail
$query_sensor = "SELECT * FROM sensor";

$result_sensor = mysqli_query($db,$query_sensor);

while ($row = mysqli_fetch_array($result_sensor, MYSQLI_ASSOC)) {
    $sensor_id[] = $row['sensor_id'];
    $sensor_list[] =  $row['sensor_name'];
    $sensor_model[] = $row['sensor_model'];
	$sensor_type[] = $row['sensor_type'];
	$install_date[] = $row['installed_date'];
	$sensor_site_id[] = $row['site_id'];
    $unique_id[] = $row['uniqueID'];
	$status[] = $row['status'];
    
}

/*
// Query the actuator details
$query_actuator = "SELECT * FROM actuator";

$result_actuator = mysqli_query($db,$query_actuator);

while ($row = mysqli_fetch_assoc($result_actuator)) {
    $actuator_id[] = $row['actuator_id'];
	$act_site_id[] = $row['site_id'];
    $actuator_list[] =  $row['actuator_name'];
	$act_location[] = $row['location'];
	$act_install_date[] = $row['install_date'];
	$act_model[] = $row['model_number'];
	$act_description[] = $row['description'];
}
*/
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

</head>

<body>

<div id="navbar">
 
<ul>
  <li><a class="active" href="home_page"><i class="fas fa-home"></i> Home</a></li>
  <li><a href="live_data"><i class="fas fa-chart-line"></i> Numeric Data</a></li>
  <li><a href="pheno_data"><i class="fas fa-leaf"></i> Pheno Data</a></li>
  <li><a href="view_image"><i class="fas fa-image"></i> Image Data</a></li>
  <li><a href="log"><i class="fas fa-clipboard-list"></i> Log</a></li>
  <li><a href="download"><i class="fas fa-download"></i> Download</a></li>  
  <li><a href="signout"><i class="fas fa-sign-out-alt"></i> Signout</a></li>
</ul>

</div>
<div class = "container">
<div class="station">
		
		<?php 
        
        echo "<h2 style = 'margin-left:40px'>Site Information </h2>";
        echo "<table border='1' class= 'table-data'>";
        echo "<tr style='font-weight: bold;'>";
        echo "<td width='50' height='40' align='center'>S.N.</td><td width='100'align='center'>Site Name</td>
		<td width='100' align='center'>Site Address</td><td width='100' align='center'>Latitude</td>
		<td width='100' align='center'>Longitude</td>
		<td width='100' align='center'>Altitude</td>
		<td width='100' align='center'>Site Description</td>";
        echo "</tr>";
        
		$j = 1;
        for ($i = 0; $i < sizeof($site_id); $i++) {
            echo "<tr>";
            echo "<td align='center' width='25' height='50'>".$j." </td>";
            echo "<td align='center' width='100'>".$site_list[$i]."</td>";
            echo "<td align='center' width='100'>".$site_address[$i]." </td>";
			echo "<td align='center' width='100'>".$site_latitude[$i]." </td>";
			echo "<td align='center' width='100'>".$site_longitude[$i]." </td>";
			echo "<td align='center' width='100'>".$site_altitude[$i]." </td>";
            echo "<td align='center' width='100'>".$site_description[$i]."</td>";
            echo "</tr>";
			$j += 1;
        }
        
        echo "</table>";  
		
		?>
		<br>
		
		<?php
		
		echo "<h2 style = 'margin-left:40px'>Sensor Information </h2>";
        echo "<table border='1' class = 'table-data'>";
        echo "<tr style='font-weight: bold;'>";
        echo "<td width='25' height='40' align='center'>S.N.</td><td width='100'align='center'>Sensor Name</td>
		<td width='100' align='center'>Sensor Model</td><td width='100' align='center'>Sensor Type</td>
		<td width='100' align='center'>Install Date</td><td width='100' align='center'>Site Name</td>
		<td width='100' align='center'>Unique ID</td><td width='100' align='center'>Status</td>";
        echo "</tr>";
		
		$j = 1;
		for ($i = 0; $i < sizeof($sensor_id); $i++) {
            echo "<tr>";
            echo "<td align='center' width='25' height='50'>".$j." </td>";
            echo "<td align='center' width='100'>".$sensor_list[$i]."</td>";
            echo "<td align='center' width='100'>".$sensor_model[$i]." </td>";
			echo "<td align='center' width='100'>".$sensor_type[$i]." </td>";
            echo "<td align='center' width='100'>".$install_date[$i]."</td>";
				
			$query_sitename = "SELECT site_name FROM site WHERE site_id = '$sensor_site_id[$i]'";
			$siteresult = mysqli_query($db,$query_sitename);
			$sitename = mysqli_fetch_assoc($siteresult);
			
			echo "<td align='center' width='100'>".$sitename['site_name']."</td>";
		
			echo "<td align='center' width='100'>".$unique_id[$i]."</td>";
			echo "<td align='center' width='100'>".$status[$i]."</td>";
            echo "</tr>";
			$j += 1;
        }
	    echo "</table>";
		
		//echo "<br>";
		//echo "<a href='sensor_download'><input type='submit' name = 'sensor_download' value='Download'></a>";
    ?>
	
	<br>
		
		<?php
		
		echo "<h2 style = 'margin-left:40px'>Actuator Information </h2>";
        echo "<table border='1' class = 'table-data'>";
        echo "<tr style='font-weight: bold;'>";
        echo "<td width='25' height='40' align='center'>S.N.</td><td width='100'align='center'>Site Name</td>
		<td width='100' align='center'>Actuator Name</td><td width='100' align='center'>Model</td>
		<td width='100' align='center'>Actuator Location</td><td width='100' align='center'>Install Date</td>
		<td width='100' align='center'>Description</td>";
        echo "</tr>";
		
		
		$j = 1;
		for ($i = 0; $i < sizeof($actuator_id); $i++) {
            echo "<tr>";
            echo "<td align='center' width='25' height='50'>".$j." </td>";
			
			$query_sitename = "SELECT site_name FROM site WHERE site_id = '$act_site_id[$i]'";
			$siteresult = mysqli_query($db,$query_sitename);
			$sitename = mysqli_fetch_assoc($siteresult);
			
			echo "<td align='center' width='100'>".$sitename['site_name']."</td>";
            echo "<td align='center' width='100'>".$actuator_list[$i]." </td>";
			echo "<td align='center' width='100'>".$act_model[$i]." </td>";
            echo "<td align='center' width='100'>".$act_location[$i]."</td>";
			echo "<td align='center' width='100'>".$act_install_date[$i]."</td>";
			echo "<td align='center' width='100'>".$act_description[$i]."</td>";
            echo "</tr>";
			$j += 1;
        }
	    echo "</table>";
		
		//echo "<br>";
		//echo "<a href='actuator_download'><input type='submit' name = 'actuator_download' value='Download'></a>";
		
    ?>
	<br>
	<br>
  </div>
</div>
</body>
</html>