<?php
include_once("config.php");
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['login_user'])) {
	header('Location: login.php');
	exit;
}

//Use array variables to hold site data

$site_id = Array();
$site_list = Array();
$log_id = Array();
$log_date = Array();
$log_parameter = Array();
$log_value = Array();
$log_type = Array();
$sensor_id = Array();
$sensor_name = Array();

//identify the username from session logged user

$username = $_SESSION['login_user'];

// set default date and timezone
date_default_timezone_set('Asia/Seoul');

$log_display=0;

$query_site="SELECT site_id,site_name from site ORDER BY site_id";
$result = mysqli_query($db,$query_site);
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $site_id[] = $row["site_id"];
        $site_list[] = $row["site_name"];
    }


if(isset($_POST['submit']))
{	 
	 $site_select = $_POST['site_id'];
	 $start_date = $_POST['start_date'];
	 
	 $end_date = $_POST['end_date'];
	 
	 
	 if(isset($site_select)!='' && isset($start_date)!='' && isset($end_date)!='') {
		 
		 	 
		$log_query = "SELECT * FROM log WHERE log_site_id = '$site_select' AND log_date BETWEEN '$start_date' AND '$end_date'";
	    
		$log_result = mysqli_query($db,$log_query);
	 
		while($log = mysqli_fetch_array($log_result,MYSQLI_ASSOC)) {
			$log_id[] = $log['log_id'];
			$log_date[]=$log['log_date'];
			$log_parameter[] = $log['log_parameter'];
			$log_value[] = $log['log_value'];
			$log_type[] = $log['log_type'];
			$sensor_id[] = $log['log_sensor_id'];
            
		}
	   $query_select_site = "SELECT site_name FROM site WHERE site_id='$site_select'";
	   $result_select_site = mysqli_query($db,$query_select_site);
	   $select_site_name = mysqli_fetch_array($result_select_site, MYSQLI_ASSOC);
	 
	 }
	 else {
	 
	   echo "please select the date and station name.";
	 }
	 $log_display =1;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>SFSL Data Portal</title>
<!--style>
body {
  font-size: 28px;
}

ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
  position: -webkit-sticky; /* Safari */
  position: sticky;
  top: 0;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover {
  background-color: #111;
}

.active {
  background-color: #4CAF50;
}

input[type=text],input[type=date],input[type=time], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.form-container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
  width:60%;
  margin-top:20px;
  margin:auto;
}

.col-25 {
  float: left;
  width: 25%;
  margin-top: 10px;
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 10px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
.container {
  width: 80%;
  padding:10px;
  margin-left:310px;
  margin-top:40px;
  margin-right:40px;
}

.station {
  width: 80%;
  padding:10px;
  margin:auto;
}
</style-->

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<link rel="stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>

</head>

<body>

<div class="header">
 
<ul>
  <li><a href="home_page"><i class="fas fa-home"></i> Home</a></li>
  <li><a href="live_data"><i class="fas fa-chart-line"></i> Numeric Data</a></li>
  <li><a href="pheno_data"><i class="fas fa-leaf"></i> Pheno Data</a></li>
  <li><a href="view_image"><i class="fas fa-image"></i> Image Data</a></li>
  <li><a class="active" href="log"><i class="fas fa-clipboard-list"></i> Log</a></li>
  <li><a href="download"><i class="fas fa-download"></i> Download</a></li>  
  <li><a href="signout"><i class="fas fa-sign-out-alt"></i> Signout</a></li>
</ul>

</div>
<div class = "container">
<div>
	<h2 class = 'caption2'> Please select the date and station name.</h2>
</div>

<div class = "form-container">
  <form action="">
  <div class="row">
    <div class="col-25">
      <label for="start_date">Start Date</label>
    </div>
    <div class="col-75">
      <input type="date" id="start_date" name="start_date" placeholder="Select start date">
	  
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="end_date">End Date</label>
    </div>
    <div class="col-75">
      <input type="date" id="end_date" name="end_date" placeholder="Select end date">
	 
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="station_id">Site Name</label>
    </div>
    <div class="col-75">
      <select id="station_name" name="station_name">
        <option disabled selected>--Select Site Name --</option>
			<?php 
			    for ($i=0;$i<sizeof($site_id);$i++) {
			        echo "<option value = '".$site_id[$i]."'>".$site_list[$i]."</option>";
			     
			    }
			    
			 ?>
      </select>
      
    </div>
  </div>
  <div class="row">
	<input style="margin-top:15px;" type="submit" name = "submit" value="View">
  </div>
  </form>
</div>

<div class="station">
<?php
	if($log_display) {
            echo "<h2 class = 'caption1'>
			Log detail of station '".$select_site_name['site_name']."' from ".$start_date." to ".$end_date.". </h2>";
            echo "<table border='0' style='border-collapse: collapse;border-color: #182850;'>";
            echo "<tr style='font-weight: bold;font-size:14px'>";
            echo "<tr style='font-weight: bold;font-size:14px'>";
            echo "<td width='150' align='center'>Log ID</td><td width='150'align='center'>Log Date</td>
			<td width='150' align='center'>Sensor Name</td><td width='150' align='center'>Parameter</td>
			<td width='150' align='center'>Value</td><td width='150' align='center'>Status</td>";
            echo "</tr>";
        
        for($i=0;$i<sizeof($log_id);$i++) {
            echo "<tr>";
            echo "<td align='center' width='150'>".$log_id[$i]." </td>";
            echo "<td align='center' width='150'>".$log_date[$i]."</td>";
			$sensor_query = "SELECT sensor_name FROM sensor WHERE sensor_id='$sensor_id[$i]'";
			$sensor_result = mysqli_query($db,$sensor_query);
			$sensor_name = mysqli_fetch_array($sensor_result,MYSQLI_ASSOC);
			echo "<td align='center' width='150'>".$sensor_name['senosr_name']." </td>";
			echo "<td align='center' width='150'>".$log_parameter[$i]." </td>";
            echo "<td align='center' width='150'>".$log_value[$i]." </td>";
            echo "<td align='center' width='150'>".$log_type[$i]." </td>";
            echo "</tr>";
        }   
        
        echo "</table>"; 
        }
		       
?>
  </div>
</div>
</body>
</html>