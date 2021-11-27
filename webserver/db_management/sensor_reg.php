<?php
include_once("config.php");
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['login_user'])) {
	header('Location: /data/login');
	exit;
}

$site_list = Array();
$site_id = Array();

// Query the site details
$query_site = "SELECT site_id, site_name FROM site";

$result = mysqli_query($db,$query_site);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $site_id[] = $row['site_id'];
    $site_list[] =  $row['site_name'];
    
}

$status = null;
if(isset($_POST['register'])) {	 
	 $sensor_name = $_POST['sensor_name'];
	 $sensor_model = $_POST['sensor_model'];
	 $sensor_type = $_POST['sensor_type'];
	 $install_date = $_POST['install_date'];
	 $site_id = $_POST['site_id'];
	 $unique_id = $_POST['unique_id'];
	 $sensor_status = $_POST['status'];
	 
	 //Insert the information
	 
	 $insert_query = "INSERT INTO sensor (sensor_name,sensor_model,sensor_type,installed_date,site_id,uniqueID,status)
						VALUES('$sensor_name','$sensor_model','$sensor_type','$install_date','$site_id','$unique_id','$sensor_status')";
	 if(mysqli_query($db,$insert_query))
	 {
		 $status = "Sensor information inserted successfully!!!";
	 }
	 else 
	 {
		 $status = "Error: ";
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
<script src="gauge.min.js"></script>

<link rel="stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>

</head>

<body>

<div id="navbar">
 
<ul>
  <li><a href="db_home"><i class="fas fa-home"></i> Home</a></li>
  <li><a href="site_reg"><i class="fas fa-warehouse"></i> Site Reg.</a></li>
  <li><a class="active" href="sensor_reg"><i class="fas fa-temperature-high"></i> Sensor Reg.</a></li>
  <li><a href="experiment"><i class="fas fa-microscope"></i> Experiment</a></li>
  <li><a href="actuator_reg"><i class="fas fa-fan"></i> Actuator Reg.</a></li> 
  <li><a href="pheno_data_update"><i class="fas fa-leaf"></i> Pheno data</a></li> 
  <li><a href="image_upload"><i class="fas fa-file-upload"></i> Image Upload</a></li>
  <li><a href="update"><i class="fas fa-edit"></i> Update</a></li> 
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

<div>
	<h2 class='caption2'> Please insert the Sensor details.</h2>
</div>

<div class = "form-container">
  <form action="" method="POST">
  <div class="row">
  
    <div class="col-25">
      <label for="sensor_name">Sensor Name</label>
    </div>
	<div class="col-75">
		<input type="text" id="sensor_name" name="sensor_name" value="">
	</div>
	
	<div class="col-25">
      <label for="sensor_model">Sensor Model</label>
    </div>
	<div class="col-75">
		<input type="text" id="sensor_model" name="sensor_model" value="">
	</div>
	
	<div class="col-25">
      <label for="sensor_type">Sensor Type</label>
    </div>
	<div class="col-75">
		<input type="text" id="sensor_type" name="sensor_type" value="">
	</div>
	
	<div class="col-25">
      <label for="install_date">Install Date </label>
    </div>
	<div class="col-75">
		<input type="date" id="install_date" name="install_date" value="">
	</div>
	
	<div class="col-25">
		<label for="site_name">Site Name</label>
    </div>
	<div class="col-75">
		<select id="site_id" name="site_id">
        <option>--Select Site Name --</option>
			<?php 
			    for ($i=0;$i<sizeof($site_id);$i++) {
			        echo "<option value = '".$site_id[$i]."'>".$site_list[$i]."</option>";
			    }
			    
			 ?>
      </select>
	</div>
	
	</div>
	
	<div class="row">
		<div class="col-25">
			<label for="unique_id">Unique ID</label>
		</div>
		<div class="col-75">
			<input type="text" id="unique_id" name="unique_id" value="">
		</div>
		
		<div class="col-25">
			<label for="status">Status</label>
		</div>
		<div class="col-75">
			<select id="status" name="status" value="">
			  <option value="test" selected>test</option>
			  <option value="active" >active</option>
			</select>
		</div>
	
   </div>
   
  <div class="row">
		<input type="submit" name = "register" value="Register">
  </div>
  
  </form>
</div>

<div class="station">
	<?php 
		echo "<h2 class = 'caption2'> $status </h2>";
	?>
	
	<br>
	<br>
</div>
</div>
</body>
</html>

