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

$cur_time = date("Y-m-d H:i:00");
// Query the site details
$query_site = "SELECT site_id, site_name FROM site";

$result = mysqli_query($db,$query_site);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $site_id[] = $row['site_id'];
    $site_list[] =  $row['site_name'];
    
}

$status = null;

if(isset($_POST['register'])) {	
	$site_id = $_POST['site_id'];
	 $actuator_name = $_POST['actuator_name'];
	 $location = $_POST['location'];
	 $model = $_POST['model'];
	 $install_date = $_POST['install_date'];
	 $act_description = $_POST['description'];
	 
	 
	 //Insert the information
	 
	 $insert_query = "INSERT INTO actuator (site_id,actuator_name,model_number,location,install_date,description)
						VALUES('$site_id','$actuator_name','$model','$location','$install_date','$act_description')";
	 if(mysqli_query($db,$insert_query))
	 {
		 $status = "Actuator information inserted successfully!!!";
	 }
	 else 
	 {
		 $status = "Error: ". $insert_query. " " . mysqli_error($db);
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
  <li><a href="sensor_reg"><i class="fas fa-temperature-high"></i> Sensor Reg.</a></li>
  <li><a href="experiment"><i class="fas fa-microscope"></i> Experiment</a></li>
  <li><a class="active" href="actuator_reg"><i class="fas fa-fan"></i> Actuator Reg.</a></li> 
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
	<h2 class='caption2'> Please insert the Actuator details.</h2>
</div>

<div class = "form-container">
  <form action="" method="POST">
  <div class="row">
  
    <div class="col-25">
      <label for="actuator_name">Actuator Name</label>
    </div>
	<div class="col-75">
		<input type="text" id="actuator_name" name="actuator_name" value="">
	</div>
	
	<div class="col-25">
      <label for="model"> Model Number</label>
    </div>
	<div class="col-75">
		<input type="text" id="model" name="model" value="">
	</div>
	
	<div class="col-25">
      <label for="location">Location</label>
    </div>
	<div class="col-75">
		<input type="text" id="location" name="location" value="">
	</div>
	
	<div class="col-25">
      <label for="install_date">Install Date</label>
    </div>
	<div class="col-75">
		<input type="date" id="install_date" name="install_date" value="">
	</div>
	<div class="col-25">
		<label for="site_id">Site Name</label>
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
      <label for="description">Description</label>
    </div>
	<div class="col-75">
		<input type="text" id="description" name="description" value="">
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

