<?php
include_once("config.php");
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['login_user'])) {
	header('Location: login');
	exit;
}

$site_id = Array();
$site_list = array();
$data_date = Array();
$data_time = Array();
$sensor_list = Array();
$sensor_type = Array();
$temp = Array();
$humd = Array();
$CO2 = Array();
//$parameter = array();


$query_site = "SELECT site_id,site_name FROM site";

$result = mysqli_query($db,$query_site);

while ($row = mysqli_fetch_assoc($result)) {
    $site_id[] = $row['site_id'];
    $site_list[] =  $row['site_name'];
    
}

//$query_parameter = "SELECT * FROM parameter";
//$parameter_result = mysqli_query($db,$query_parameter);

$click_view = false;
$start_date = '';
$end_date = '';
$site_select = '';
$site_name = '';

if(isset($_POST["view"]))  
 {
	$click_view = true;
	
	$site_select = $_POST['site_id'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
		
	/*foreach($_POST['parameter'] as $parameter_name)
	{			
		$parameter[] = $parameter_name;
	}*/
		
	$q_sitename = "SELECT site_name FROM site WHERE site_id='$site_select'";
	$result = mysqli_query($db,$q_sitename);
	
	while($row=mysqli_fetch_assoc($result)) {
		$site_name = $row['site_name'];
	}
	
	// Query sensor list
	$sensor_data = "SELECT sensor_id, sensor_type FROM sensor WHERE site_id='$site_select'";
	$sensor_result = mysqli_query($db,$sensor_data);
	
	while($row = mysqli_fetch_assoc($sensor_result)) {
		$sensor_list[] = $row['sensor_id'];
		$sensor_type[] = $row['sensor_type'];
		
	}
	for($i=0;$i<sizeof($sensor_list);$i++)
	{
		if($sensor_type[$i]=='THC')
		{
			// Query the data
			$query_data = "SELECT * FROM thc_data WHERE site_id='$site_select' AND sensor_id='$sensor_list[$i]' AND data_date BETWEEN '$start_date' AND '$end_date' ORDER BY data_date ASC, data_time ASC";
			$data_result = mysqli_query($db,$query_data);
			
			while($row = mysqli_fetch_assoc($data_result)) {
				$data_date[] = $row['data_date'];
				$data_time[] = $row['data_time'];
				$temp[] = $row['temperature'];
				$humd[] = $row['humidity'];
				$CO2[] = $row['CO2'];
			}
		}
		elseif($sensor_type[$i]=='AQ')
		{
			// Query the data
			$query_data = "SELECT * FROM aq_data WHERE site_id='$site_select' AND sensor_id='$sensor_list[$i]' AND data_date BETWEEN '$start_date' AND '$end_date' ORDER BY data_date ASC, data_time ASC";
			$data_result = mysqli_query($db,$query_data);
			
			while($row = mysqli_fetch_assoc($data_result)) {
				$data_date[] = $row['data_date'];
				$data_time[] = $row['data_time'];
				$temp[] = $row['temperature'];
				$humd[] = $row['humidity'];
				//$CO2[] = $row['CO2'];
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

</head>

<body>

<div id="navbar">
 
<ul>
  <li><a href="home_page"><i class="fas fa-home"></i> Home</a></li>
  <li><a href="live_data"><i class="fas fa-chart-line"></i> Numeric Data</a></li>
  <li><a href="pheno_data"><i class="fas fa-leaf"></i> Pheno Data</a></li>
  <li><a href="view_image"><i class="fas fa-image"></i> Image Data</a></li>
  <li><a href="log"><i class="fas fa-clipboard-list"></i> Log</a></li>
  <li><a class="active" href="download"><i class="fas fa-download"></i> Download</a></li>  
  <li><a href="signout"><i class="fas fa-sign-out-alt"></i> Signout</a></li>
</ul>

</div>
<div class = "container">
<div>
	<h2 class = 'caption2'> Please select the date and site name to download sensor data.</h2>
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
	  <?php 
		if($click_view) {
			echo "<option value='$site_select' selected>$site_name</option>";
		}
		?>
        <option>--Select Site Name --</option>
			<?php 
			    for ($i=0;$i<sizeof($site_id);$i++) {
			        echo "<option value = '".$site_id[$i]."'>".$site_list[$i]."</option>";
			     
			    }
			    
			 ?>
      </select>
	  </div>
	  </div>
	<!--div class="row">
		<div class="col-25">
			<label for="station_id">Parameter</label>
		</div>
	  <div class="col-75">
      <select id="parameter" name="parameter" multiple size="3">
		<option value = "">Temperature</option>
		<option value = "">Humidity</option>		
      </select>
    </div>
  </div-->
  <br>
  <div class="row">
	<input type="submit" name="download" value = "Download" formaction="download_data">
	<input type="submit" name="view" value = "view" formaction="">
	</div>
  </form>
</div>

<!-- For site, sensor and actuator list download -->
<div>
	<h2 class = 'caption2'> Please select a category list to download.</h2>
</div>

<div class = "form-container">
  <form action="download_list" method="POST">
  
  
  <div class="row">
    <div class="col-25">
      <label for="category"> Select Category</label>
    </div>
    <div class="col-75">
      <select id="category" name="category">
	  <option value = "site" selected> Site list</option>
      <option>--Select Category--</option>
	  <option value = "sensor"> Sensor list</option>
	  <option value = "actuator">Actuator list</option>
		
      </select>
	  </div>
	  </div>
	
  <br>
  <div class="row">
	<input type="submit" name="list_download" value = "Download">
	</div>
  </form>
</div>
<div class="station">
	<?php
	
		echo "<div class ='table-data'>";
		
        if($click_view) {
			if(sizeof($sensor_type)>1){
				if($sensor_type[0]=='THC'){
					echo "<h2 class ='caption2'>Data list of $sensor_type[0] sensor of '$site_name' from $start_date to $end_date</h>";
					echo "</br>";
					echo "<table border='0' class='phpTable'>";
					echo "<tr>";
					echo "<td width='50' align='center'>S.N.</td><td width='150'align='center'>Data Date</td><td width='150'align='center'>Data Time</td><td width='100' align='center'>Temperature (degC)</td><td width='100' align='center'>Humidity (%)</td><td width='100' align='center'>CO2</td>";
					echo "</tr>";
					
					$j = 1;
					for ($i = (sizeof($CO2)-1); $i >=0; $i--) {
						echo "<tr style='font-size:16px'>";
						echo "<td align='center' width='50'>".$j." </td>";
						echo "<td align='center' width='150'>".$data_date[$i]."</td>";
						echo "<td align='center' width='150'>".$data_time[$i]."</td>";
						echo "<td align='center' width='100'>".$temp[$i]." </td>";
						echo "<td align='center' width='100'>".$humd[$i]." </td>";
						echo "<td align='center' width='100'>".$CO2[$i]." </td>";
						echo "</tr>";
						$j++;
					}
					
					echo "</table>";  
				}
			}
		}
		echo "</div>";
	
	?>
	
</div>
</div>
</body>
</html>