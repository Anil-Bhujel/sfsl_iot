<?php
include_once("config.php");
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['login_user'])) {
	header('Location: /data/login');
	exit;
}

$status = null;

if(isset($_POST['register'])) {	 
	 $site_name = $_POST['site_name'];
	 $site_address = $_POST['site_address'];
	 $latitude = $_POST['latitude'];
	 $longitude = $_POST['longitude'];
	 $altitude = $_POST['altitude'];
	 $site_description = $_POST['site_description'];
	 
	 //Insert the information
	 
	 $insert_query = "INSERT INTO site (site_name,site_address,latitude,longitude,altitude,description)
						VALUES('$site_name','$site_address','$latitude','$longitude','$altitude','$site_description')";
	 if(mysqli_query($db,$insert_query))
	 {
		 $status = "Site information inserted successfully!!!";
	 }
	 else 
	 {
		 $status = "Error: ". $insert_query . " ". mysqli_error($db);
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
  <li><a class="active" href="site_reg"><i class="fas fa-warehouse"></i> Site Reg.</a></li>
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
<div>
	<?php 
		//echo "<h2 class = 'caption2'>Actuator status of $site_name</h2>";
	?>
</div>

<div class="actuator_status">
	
</div>

<div>
	<h2 class='caption2'> Please insert the site details.</h2>
</div>

<div class = "form-container">
  <form action="" method="POST">
  <div class="row">
  
    <div class="col-25">
      <label for="site_name">Site Name</label>
    </div>
	<div class="col-75">
		<input type="text" id="site_name" name="site_name" value="">
	</div>
	
	<div class="col-25">
      <label for="site_address">Site Adress</label>
    </div>
	<div class="col-75">
		<input type="text" id="site_address" name="site_address" value="">
	</div>
	
	<div class="col-25">
      <label for="latitude">Latitude</label>
    </div>
	<div class="col-75">
		<input type="text" id="latitude" name="latitude" value="">
	</div>
	
	<div class="col-25">
      <label for="longitude">Longitude </label>
    </div>
	<div class="col-75">
		<input type="text" id="longitude" name="longitude" value="">
	</div>
	
	<div class="col-25">
		<label for="altitude">Altitude</label>
    </div>
	<div class="col-75">
		<input type="text" id="altitude" name="altitude" value="">
	</div>
	
	<div class="col-25">
		<label for="site_description">Site Description</label>
    </div>
	<div class="col-75">
		<input type="text" id="site_description" name="site_description" value="">
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

