<?php
include_once("config.php");
session_start();

//$user_previlege = $_SESSION['previlege']);

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['login_user'])) {
	header('Location: /data/login');
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

// for experiment data
$expt_id = Array();
$expt_name = Array();
$expt_year = Array();
$start_date = Array();
$end_date = Array();
$expt_field = Array();
$expt_site = Array();
$experimenter = Array();

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

// Query the experiment details
$query_expt = "SELECT * FROM experiment ORDER BY id DESC";


$expt_result = mysqli_query($db,$query_expt);

while ($row = mysqli_fetch_assoc($expt_result)) {
    $expt_id[] = $row['id'];
    $expt_name[] =  $row['expt_title'];
    $expt_year[] = $row['expt_year'];
	$start_date[] = $row['start_date'];
	$end_date[] = $row['end_date'];
	$expt_field[] = $row['expt_field'];
	$expt_site[] = $row['expt_site'];
    $experimenter[] = $row['experimenter'];
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

</head>

<body>

<div id="navbar">
 
<ul>
  <li><a class="active" href="db_home"><i class="fas fa-home"></i> Home</a></li>
  <li><a href="site_reg"><i class="fas fa-warehouse"></i> Site Reg.</a></li>
  <li><a href="sensor_reg"><i class="fas fa-temperature-high"></i> Sensor Reg.</a></li>
  <li><a href="experiment"><i class="fas fa-microscope"></i> Experiment</a></li>
  <li><a href="actuator_reg"><i class="fas fa-fan"></i> Actuator Reg.</a></li> 
  <li><a href="pheno_data_update"><i class="fas fa-leaf"></i> Pheno data</a></li> 
  <li><a href="image_upload"><i class="fas fa-file-upload"></i> Image Upload</a></li>
  <li><a href="update"><i class="fas fa-edit"></i> Update</a></li> 
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
		<td width='100' align='center'>Longitude</td><td width='100' align='center'>Altitude</td>
		<td width='100' align='center'>Site Description</td><td width='50' align='center'> Modify</td>";
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
			echo "<td align='center' width='50'><a href='update?site_id=$site_id[$i]'><input type='submit' name = 'submit' value='Edit'></a></td>";
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
		<td width='100' align='center'>Unique ID</td><td width='100' align='center'>Status</td>
		<td width='50' align='center'> Modify</td>";
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
			echo "<td align='center' width='50'><a href='update?sensor_id=$sensor_id[$i]'><input type='submit' name = 'submit' value='Edit'></a></td>";
            echo "</tr>";
			$j += 1;
        }
	    echo "</table>";
    ?>
	
	<br>
		
		<?php
		
		echo "<h2 style = 'margin-left:40px'>List of experiments. </h2>";
        echo "<table border='1' class= 'table-data'>";
        echo "<tr style='font-weight: bold;'>";
        echo "<td width='50' height='40' align='center'>Expt_id</td><td width='200'align='center'>Expt title</td>
		<td width='100' align='center'>Expt year</td><td width='100' align='center'>Start date</td><td width='100' align='center'>End date</td>
		<td width='100' align='center'>Expt field</td> <td width='100' align='center'>Expt site</td>
		<td width='150' align='center'>Expt member</td><td width='150' align='center'>Modify</td>";
        echo "</tr>";
        
		
        for ($i = 0; $i < sizeof($expt_id); $i++) {
            echo "<tr>";
            echo "<td align='center' width='50' height='50'>".$expt_id[$i]." </td>";
            echo "<td align='center' width='200'>".$expt_name[$i]."</td>";
            echo "<td align='center' width='100'>".$expt_year[$i]." </td>";
			echo "<td align='center' width='100'>".$start_date[$i]." </td>";
			echo "<td align='center' width='100'>".$end_date[$i]." </td>";
			echo "<td align='center' width='100'>".$expt_field[$i]." </td>";
			echo "<td align='center' width='100'>".$expt_site[$i]." </td>";
            echo "<td align='center' width='150'>".$experimenter[$i]."</td>";
			echo "<td align='center' width='150'><a href='update?expt_id=$expt_id[$i]'><input type='submit' name = 'submit' value='Edit'></a></td>";
            echo "</tr>";
			
        }
        
        echo "</table>";  
		echo "<br>";
		
		echo "<h2 style = 'margin-left:40px'>Actuator Information </h2>";
        echo "<table border='1' class = 'table-data'>";
        echo "<tr style='font-weight: bold;'>";
        echo "<td width='25' height='40' align='center'>S.N.</td><td width='100'align='center'>Site Name</td>
		<td width='100' align='center'>Actuator Name</td><td width='100' align='center'>Model</td>
		<td width='100' align='center'>Actuator Location</td><td width='100' align='center'>Install Date</td>
		<td width='100' align='center'>Description</td><td width='50' align='center'> Modify</td>";
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
			echo "<td align='center' width='50'><a href='update?actuator_id=$actuator_id[$i]'><input type='submit' name = 'submit' value='Update'></a></td>";
            echo "</tr>";
			$j += 1;
        }
	    echo "</table>";
		
		
    ?>
	<br>
	<br>
  </div>
</div>
</body>
</html>