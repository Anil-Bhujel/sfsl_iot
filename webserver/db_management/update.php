<?php
include_once("config.php");
session_start();

global $selection;

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['login_user'])) {
	header('Location: /data/login');
	exit;
}

$selection = null;
$update_status = null;

$sites_id = array();
$sites_name = array();
	
$sensors_id = array();
$sensors_name = array();
	
$actuators_id = array();
$actuators_name = array();
	
$site_query = "SELECT site_id, site_name FROM site";
$site_result = mysqli_query($db,$site_query);
	
while($siterow = mysqli_fetch_assoc($site_result)) {
	$sites_id[] = $siterow['site_id'];
	$sites_name[] = $siterow['site_name'];
}
	
$sensor_query = "SELECT sensor_id, sensor_name FROM sensor";
$sensor_result = mysqli_query($db,$sensor_query);
	
while($sensorrow = mysqli_fetch_assoc($sensor_result)) {
	$sensors_id[] = $sensorrow['sensor_id'];
	$sensors_name[] = $sensorrow['sensor_name'];
}
	
$actuator_query = "SELECT actuator_id, actuator_name FROM actuator";
$actuator_result = mysqli_query($db,$actuator_query);
	
while($actuatorrow = mysqli_fetch_assoc($actuator_result)) {
	$actuators_id[] = $actuatorrow['actuator_id'];
	$actuators_name[] = $actuatorrow['actuator_name'];
}
	
// This GET section is to handle the request from update page

if(isset($_GET["update"])) {
	$test = $_GET["update"];
	
	if($test == "Site_update") {
		$site_id = $_GET["site_id"];
		//$sensor_id = $_GET["sensor_id"];
		//$actuator_id = $_GET["actuator_id"];
		
		$selection = "site";
		
		// site query
		$site_query = "SELECT * FROM site WHERE site_id = '$site_id'";
		$site_result = mysqli_query($db,$site_query);
		
		while($row = mysqli_fetch_assoc($site_result)) {
			$site_name = $row['site_name'];
			$site_address = $row['site_address'];
			$latitude = $row['latitude'];
			$longitude = $row['longitude'];
			$altitude = $row['altitude'];
			$site_description = $row['description'];
			
		}
	}
	elseif($test == "Sensor_update") {
		$sensor_id = $_GET['sensor_id'];
		$selection = "sensor";
	
		// sensor query
		$sensor_query = "SELECT * FROM sensor WHERE sensor_id = '$sensor_id'";
		$sensor_result = mysqli_query($db,$sensor_query);
		
		while($row = mysqli_fetch_assoc($sensor_result)) {
			$sensor_name = $row['sensor_name'];
			$sensor_model = $row['sensor_model'];
			$sensor_type = $row['sensor_type'];
			$install_date = $row['installed_date'];
			$siteid = $row['site_id'];
			$unique_id = $row['uniqueID'];
			$status = $row['status'];
			
		}
		//site name query
		$sitequery = "SELECT site_name FROM site WHERE site_id='$siteid'";
		$siteresult = mysqli_query($db,$sitequery);
		while($row = mysqli_fetch_assoc($siteresult)) {
			$sensor_site_name = $row['site_name'];
		}
	}
	
	elseif($test == "Actuator_update") {
		$actuator_id=$_GET['actuator_id'];
		$selection = "actuator";
	
		// Actuator query
		$actuator_query = "SELECT * FROM actuator WHERE actuator_id = '$actuator_id'";
		$actuator_result = mysqli_query($db,$actuator_query);
		
		while($row = mysqli_fetch_assoc($actuator_result)) {
			$siteid = $row['site_id'];
			$actuator_name = $row['actuator_name'];
			$location = $row['location'];
			$act_model = $row['model_number'];
			$install_date = $row['install_date'];
			$act_description = $row['description'];
			
		}
		//site name query
		$sitequery = "SELECT site_name FROM site WHERE site_id='$siteid'";
		$siteresult = mysqli_query($db,$sitequery);
		while($row = mysqli_fetch_assoc($siteresult)) {
			$actuator_site_name = $row['site_name'];
		}
	
	}
}

// This GET sections is for handling the request from home page

if(isset($_GET["site_id"])) {
	$site_id = $_GET["site_id"];
	
	$selection = "site";
	
	// site query
	$site_query = "SELECT * FROM site WHERE site_id = '$site_id'";
	$site_result = mysqli_query($db,$site_query);
	
	while($row = mysqli_fetch_assoc($site_result)) {
		$site_name = $row['site_name'];
		$site_address = $row['site_address'];
		$latitude = $row['latitude'];
		$longitude = $row['longitude'];
		$altitude = $row['altitude'];
		$site_description = $row['description'];
		
	}
}

if(isset($_GET["sensor_id"])) {
	$sensor_id = $_GET["sensor_id"];
	
	$selection = "sensor";
	
	// sensor query
	$sensor_query = "SELECT * FROM sensor WHERE sensor_id = '$sensor_id'";
	$sensor_result = mysqli_query($db,$sensor_query);
	
	while($row = mysqli_fetch_assoc($sensor_result)) {
		$sensor_name = $row['sensor_name'];
		$sensor_model = $row['sensor_model'];
		$sensor_type = $row['sensor_type'];
		$install_date = $row['installed_date'];
		$siteid = $row['site_id'];
		$unique_id = $row['uniqueID'];
		$status = $row['status'];
		
	}
	//site name query
	$sitequery = "SELECT site_name FROM site WHERE site_id='$siteid'";
	$siteresult = mysqli_query($db,$sitequery);
	while($row = mysqli_fetch_assoc($siteresult)) {
		$sensor_site_name = $row['site_name'];
	}
}

if(isset($_GET["actuator_id"])) {
	$actuator_id = $_GET["actuator_id"];
	
	$selection = "actuator";
	
	// Actuator query
	$actuator_query = "SELECT * FROM actuator WHERE actuator_id = '$actuator_id'";
	$actuator_result = mysqli_query($db,$actuator_query);
	
	while($row = mysqli_fetch_assoc($actuator_result)) {
		
		$siteid = $row['site_id'];
		$actuator_name = $row['actuator_name'];
		$location = $row['location'];
		$act_model = $row['model_number'];
		$install_date = $row['install_date'];
		$act_description = $row['description'];
		
	}
	//site name query
	$sitequery = "SELECT site_name FROM site WHERE site_id='$siteid'";
	$siteresult = mysqli_query($db,$sitequery);
	while($row = mysqli_fetch_assoc($siteresult)) {
		$actuator_site_name = $row['site_name'];
	}
	
}

if(isset($_GET["expt_id"])) {
	$expt_id = $_GET["expt_id"];
	
	$selection = "experiment";
	
	// Actuator query
	$expt_query = "SELECT * FROM experiment WHERE id = '$expt_id'";
	$expt_result = mysqli_query($db,$expt_query);
	
	while($row = mysqli_fetch_assoc($expt_result)) {
		$expt_name =  $row['expt_title'];
		$expt_year = $row['expt_year'];
		$start_date = $row['start_date'];
		$end_date = $row['end_date'];
		$expt_field = $row['expt_field'];
		$expt_site = $row['expt_site'];
		$experimenter = $row['experimenter'];
		
	}
	
}

// To handle the post operation
// Site Update
if(isset($_POST["site_update"])) {
	$site_id = $_GET["site_id"];
	$site_name = $_POST["site_name"];
	$site_address = $_POST["site_address"];
	$latitude = $_POST["latitude"];
	$longitude = $_POST["longitude"];
	$altitude = $_POST["altitude"];
	$site_description = $_POST["site_description"];
	
	// Insert site query
	$update_query = "UPDATE site SET site_name='$site_name',site_address='$site_address',latitude='$latitude',longitude='$longitude',
		altitude='$altitude',description='$site_description' WHERE site_id = '$site_id'";
	if(mysqli_query($db,$update_query)){
		$update_status = $site_name." updated successfully!!!";
	}
	else {
		$update_status = "Error: ".$update_query. " ". mysqli_error($db); 
	}
	$selection = null;
	
}

// Sensor Update
if(isset($_POST["sensor_update"])) {
	$sensor_id = $_GET['sensor_id'];
	$sensor_name = $_POST["sensor_name"];
	$sensor_model = $_POST["sensor_model"];
	$sensor_type = $_POST["sensor_type"];
	$install_date = $_POST["install_date"];
	$site_id = $_POST["site_id"];
	$unique_id = $_POST["unique_id"];
	$status = $_POST["status"];
	
	// Insert sensor query
	$update_query = "UPDATE sensor SET sensor_name='$sensor_name',sensor_model='$sensor_model',sensor_type='$sensor_type',installed_date='$install_date',
		site_id='$site_id',uniqueID='$unique_id',status='$status' WHERE sensor_id = '$sensor_id'";
	if(mysqli_query($db,$update_query)){
		$update_status = $sensor_name." updated successfully!!!";
	}
	else {
		$update_status = "Error: ".$update_query. " ". mysqli_error($db); 
	}
	$selection = null;
	
}

// Actuator Update
if(isset($_POST["actuator_update"])) {
	$actuator_id = $_GET["actuator_id"];
	$actuator_name = $_POST["actuator_name"];
	$location = $_POST["location"];
	$site_id = $_POST["site_id"];
	$install_date = $_POST["install_date"];
	$act_model = $_POST["model"];
	$act_description = $_POST["description"];
	
	$update_query = "UPDATE actuator SET site_id='$site_id',actuator_name='$actuator_name',model_number='$act_model',location='$location',
		install_date='$install_date', description='$act_description' WHERE actuator_id = '$actuator_id'";
	if(mysqli_query($db,$update_query)){
		$update_status = $actuator_name." updated successfully!!!";
	}
	else {
		$update_status = "Error: ".$update_query. " ". mysqli_error($db); 
	}
	$selection = null;
}

// Experiment Update
if(isset($_POST["experiment_update"])) {
	$expt_id = $_GET["expt_id"];
	$expt_name = $_POST["expt_title"];
	$expt_year = $_POST["expt_year"];
	$start_date = $_POST["start_date"];
	$end_date = $_POST["end_date"];
	$expt_field = $_POST["expt_field"];
	$expt_site = $_POST["expt_site"];
	$experimenter = $_POST["experimenter"];
	
	$update_query = "UPDATE experiment SET id='$expt_id',expt_title='$expt_name', expt_year='$expt_year',start_date='$start_date',
		end_date='$end_date', expt_field='$expt_field', expt_site='$expt_site',experimenter='$experimenter' WHERE id = '$expt_id'";
	if(mysqli_query($db,$update_query)){
		$update_status = "Experiment_".$expt_id." updated successfully!!!";
	}
	else {
		$update_status = "Error: ".$update_query. " ". mysqli_error($db); 
	}
	$selection = null;
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
<script src="gauge.min.js"></script>

<link rel="stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>

</head>

<body>

<div id="navbar">
 
<ul>
  <li><a href="db_home"><i class="fas fa-home"></i> Home</a></li>
  <li><a href="site_reg"><i class="fas fa-warehouse"></i> Site Reg.</a></li>
  <li><a href="sensor_reg"><i class="fas fa-temperature-high"></i> Sensor Reg.</a></li>
  <li><a href="experiment"><i class="fas fa-microscope"></i> Experiment</a></li>
  <li><a href="actuator_reg"><i class="fas fa-fan"></i> Actuator Reg.</a></li> 
  <li><a href="pheno_data_update"><i class="fas fa-leaf"></i> Pheno data</a></li> 
  <li><a href="image_upload"><i class="fas fa-file-upload"></i> Image Upload</a></li>
  <li><a class="active" href="update"><i class="fas fa-edit"></i> Update</a></li> 
  <li><a href="signout"><i class="fas fa-sign-out-alt"></i> Signout</a></li>
</ul>

</div>

<div class = "container">
<div>
	<?php 
		//echo "<h2 class = 'caption2'>Actuator status of $site_name</h2>";
	?>
</div>

<div class="actuator_status">
	
</div>


<?php 

echo "<div>";
	echo "<h2 class='caption2'> Please select a parameter to update.</h2>";
echo "</div>";
	
echo "<div class = 'form-container'>";
	echo "<form action='' method='GET'>";
		echo "<div class='row'>";
		  
			echo "<div class='col-25'>";
			  echo "<label for='site_name'>Select a Site</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<select id='site_id' name='site_id' value=''>";
				echo "<option value = '$site_id' selected>$site_name</option>";
				echo "<option >--Select a parameter--</option>";
				for($i=0;$i<sizeof($sites_id);$i++) {
					echo "<option value='$sites_id[$i]'>$sites_name[$i]</option>";
				}
				echo "</select>";
			echo "</div>";
		echo"</div>";
		   
		echo"<div class='row'>";
			echo"<input type='submit' name = 'update' value='Site_update'>";
		echo"</div>";
		  
		echo"</form>";
		echo "<br>";
		echo "<form action='' method='GET'>";
		  echo "<div class='row'>";
		  
			echo "<div class='col-25'>";
			  echo "<label for='sensor_name'>Select a sensor</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<select id='sensor_id' name='sensor_id' value=''>";
				echo "<option value = '$sensor_id' selected>$sensor_name</option>";
				echo "<option >--Select a sensor--</option>";
				for($i=0;$i<sizeof($sites_id);$i++) {
					echo "<option value='$sensors_id[$i]'>$sensors_name[$i]</option>";
				}
				echo "</select>";
			echo "</div>";
		echo"</div>";
		   
		echo"<div class='row'>";
			echo"<input type='submit' name = 'update' value='Sensor_update'>";
		echo"</div>";
		  
		echo"</form>";
		
		echo "<br>";
		echo "<form action='' method='GET'>";
		  echo "<div class='row'>";
		  
			echo "<div class='col-25'>";
			  echo "<label for='actuator_name'>Select an actuator</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<select id='actuator_id' name='actuator_id' value=''>";
				echo "<option value = '$actuator_id' selected>$actuator_name</option>";
				echo "<option >--Select an actuator--</option>";
				for($i=0;$i<sizeof($sites_id);$i++) {
					echo "<option value='$actuators_id[$i]'>$actuators_name[$i]</option>";
				}
				echo "</select>";
			echo "</div>";
		echo"</div>";
		   
		echo"<div class='row'>";
			echo"<input type='submit' name = 'update' value='Actuator_update'>";
		echo"</div>";
		  
		echo"</form>";
	echo"</div>";

if(!is_null($selection)) {
	echo "<div>";
		echo "<h2 class='caption2'> Please edit the $selection information and click update button.</h2>";
	echo "</div>";
	if($selection == "site") {
		echo "<div class = 'form-container'>";
		  echo "<form action='' method='POST'>";
		  echo "<div class='row'>";
		  
			echo "<div class='col-25'>";
			  echo "<label for='site_name'>Site Name</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='text' id='site_name' name='site_name' value='$site_name'>";
			echo "</div>";
			
			echo "<div class='col-25'>";
			  echo "<label for='site_address'>Site Adress</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='text' id='site_address' name='site_address' value='$site_address'>";
			echo "</div>";
			
			echo "<div class='col-25'>";
			  echo "<label for='latitude'>Latitude</label>";
			echo "</div>";	
			echo "<div class='col-75'>";
				echo"<input type='text' id='latitude' name='latitude' value='$latitude'>";
			echo '</div>';
			
			echo "<div class='col-25'>";
			  echo "<label for='longitude'>Longitude </label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='text' id='longitude' name='longitude' value='$longitude'>";
			echo "</div>";
			
			echo "<div class='col-25'>";
				echo "<label for='altitude'>Altitude</label>";
			echo "</div>";
			echo"<div class='col-75'>";
				echo"<input type='text' id='altitude' name='altitude' value='$altitude'>";
			echo"</div>";
			
			echo"<div class='col-25'>";
				echo"<label for='site_description'>Site Description</label>";
			echo"</div>";
			echo"<div class='col-75'>";
				echo"<input type='text' id='site_description' name='site_description' value='$site_description'>";
			echo"</div>";
			
		   echo"</div>";
		   
		  echo"<div class='row'>";
				echo"<input type='submit' name = 'site_update' value='Update'>";
		  echo"</div>";
		  
		  echo"</form>";
		echo"</div>";
	}
	elseif($selection == "sensor") {
		
		echo "<div class = 'form-container'>";
		  echo "<form action='' method='POST'>";
		  echo "<div class='row'>";
		  
			echo "<div class='col-25'>";
			  echo "<label for='sensor_name'>Sensor Name</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='text' id='sensor_name' name='sensor_name' value='$sensor_name'>";
			echo "</div>";
			echo "</div>";
			
			
			echo "<div class='col-25'>";
			  echo "<label for='sensor_model'>Sensor Model</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='text' id='sensor_model' name='sensor_model' value='$sensor_model'>";
			echo "</div>";
			
			
			
			echo "<div class='col-25'>";
			  echo "<label for='sensor_type'>Sensor Type</label>";
			echo "</div>";	
			
			echo "<div class='col-75'>";
				echo"<input type='text' id='sensor_type' name='sensor_type' value='$sensor_type'>";
			echo "</div>";
			
			
			
			echo "<div class='col-25'>";
			  echo "<label for='install_date'>Install Date </label>";
			echo "</div>";
			
			echo "<div class='col-75'>";
				echo "<input type='date' id='install_date' name='install_date' value='$install_date'>";
			echo "</div>";
		
			
			echo "<div class='row'>";
			echo "<div class='col-25'>";
				echo "<label for='site_id'> Site Name</label>";
			echo "</div>";
			echo"<div class='col-75'>";
				echo"<select id='site_id' name='site_id' value=''>";
				echo"<option value = '$siteid' selected> $sensor_site_name</option>";
				echo"<option > Select a site name</option>";
				for($i=0;$i<sizeof($sites_id);$i++) {
					echo "<option value='$sites_id[$i]'>$sites_name[$i]</option>";
				}
				echo"</select>";
				
			echo "</div>";
			echo "</div>";
			
			echo "<div class='row'>";
			echo"<div class='col-25'>";
				echo "<label for='unique_id'> Unique ID</label>";
			echo "</div>";
			
			echo"<div class='col-75'>";
				echo"<input type='text' id='unique_id' name='unique_id' value='$unique_id'>";
			echo"</div>";
			echo "</div>";
			
			echo "<div class='row'>";			
			echo"<div class='col-25'>";
				echo"<label for='status'> Status</label>";
			echo"</div>";
			echo"<div class='col-75'>";
				echo"<select id='status' name='status' value=''>";
				echo"<option value = '$status' selected> $status</option>";
				echo"<option > -------- </option>";
				echo"<option value = 'active'> active</option>";
				echo"<option value = 'test'> test</option>";
				echo"</select>";
			echo"</div>";
						
		   echo "</div>";
		   
		  echo"<div class='row'>";
				echo"<input type='submit' name = 'sensor_update' value='Update'>";
		  echo"</div>";
		  
		  echo"</form>";
		echo"</div>";
	}

	elseif($selection == "actuator") {
		echo "<div class = 'form-container'>";
		  echo "<form action='' method='POST'>";
		  echo "<div class='row'>";
		  
			echo "<div class='col-25'>";
			  echo "<label for='actutator_name'>Actuator Name</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='text' id='actuator_name' name='actuator_name' value='$actuator_name'>";
			echo "</div>";
			
			echo "<div class='col-25'>";
			  echo "<label for='model'>Model</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='text' id='model' name='model' value='$act_model'>";
			echo "</div>";
			
			echo "<div class='col-25'>";
			  echo "<label for='location'> Location</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='text' id='location' name='location' value='$location'>";
			echo "</div>";
			
			echo "<div class='col-25'>";
			  echo "<label for='install_date'>Install Date</label>";
			echo "</div>";	
			echo "<div class='col-75'>";
				echo"<input type='date' id='install_date' name='install_date' value='$install_date'>";
			echo '</div>';
			
			echo "<div class='col-25'>";
			  echo "<label for='site_id'> Site Name </label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo"<select id='site_id' name='site_id' value=''>";
				echo"<option value = '$siteid' selected> $actuator_site_name</option>";
				for($i=0;$i<sizeof($sites_id);$i++) {
					echo "<option value='$sites_id[$i]'>$sites_name[$i]</option>";
				}
				echo"</select>";
			echo "</div>";
			
		   echo"</div>";
		   
		   echo "<div class='row'>";
		   echo "<div class='col-25'>";
			  echo "<label for='description'>Description</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='text' id='description' name='description' value='$act_description'>";
			echo "</div>";
			echo "</div>";
			
		  echo"<div class='row'>";
				echo"<input type='submit' name = 'actuator_update' value='Update'>";
		  echo"</div>";
		  
		  echo"</form>";
		echo"</div>";
	}
	elseif($selection == "experiment") {
		echo "<div class = 'form-container'>";
		  echo "<form action='' method='POST'>";
		  echo "<div class='row'>";
		  
			echo "<div class='col-25'>";
			  echo "<label for='expt_title'>Experiment title</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='text' id='expt_title' name='expt_title' value='$expt_name'>";
			echo "</div>";
			
			echo "<div class='col-25'>";
			  echo "<label for='expt_year'>Experiment year</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='year' id='expt_year' name='expt_year' value='$expt_year'>";
			echo "</div>";
			echo "</div>";
			
		  echo "<div class='row'>";
			echo "<div class='col-25'>";
			  echo "<label for='start_date'> Start date</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='date' id='start_date' name='start_date' value='$start_date'>";
			echo "</div>";
			
			echo "<div class='col-25'>";
			  echo "<label for='end_date'>End date</label>";
			echo "</div>";	
			echo "<div class='col-75'>";
				echo"<input type='date' id='end_date' name='end_date' value='$end_date'>";
			echo '</div>';
			
			echo "<div class='col-25'>";
			  echo "<label for='expt_field'> Experiment field </label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo"<select id='expt_field' name='expt_field'>";
				echo"<option value = 'Plant' selected> $expt_field</option>";
				echo "<option value=''> </option>";
				echo "<option value='Plant'> Plant</option>";
				echo "<option value='Animal'> Animal</option>";
				echo"</select>";
			echo "</div>";
			echo "</div>";
		  
		  echo "<div class='row'>"; 
			echo "<div class='col-25'>";
			  echo "<label for='expt_site'>Experiment site</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='text' id='expt_site' name='expt_site' value='$expt_site'>";
			echo "</div>";
			
		   echo "<div class='col-25'>";
			  echo "<label for='experimenter'>Experiment member (*write in comma separated) </label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='text' id='experimenter' name='experimenter' value='$experimenter'>";
			echo "</div>";
			echo "</div>";
			
		  echo"<div class='row'>";
				echo"<input type='submit' name = 'experiment_update' value='Update'>";
		  echo"</div>";
		  
		  echo"</form>";
		echo"</div>";
	}
}
?>
<br>
<div class="station">
	<?php
		echo "<h2 class = 'caption2'> $update_status </h2>";	
		
	?>	
	<br>
	<br>
</div>
</div>
</body>
</html>

