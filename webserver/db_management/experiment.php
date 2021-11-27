<?php
include_once("config.php");
session_start();

//$user_previlege = $_SESSION['previlege']);

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['login_user'])) {
	header('Location: /data/login');
	exit;
}

// for experiment data
$expt_id = Array();
$expt_name = Array();
$expt_year = Array();
$start_date = Array();
$end_date = Array();
$expt_field = Array();
$expt_site = Array();
$experimenter = Array();

$status = '';
// Experiment Register
if(isset($_POST["experiment_register"])) {
	$expt_name = $_POST["expt_title"];
	$expt_year = $_POST["expt_year"];
	$start_date = $_POST["start_date"];
	$end_date = $_POST["end_date"];
	$expt_field = $_POST["expt_field"];
	$expt_site = $_POST["expt_site"];
	$experimenter = $_POST["experimenter"];
	
	//Insert the information
	 
	 $insert_query = "INSERT INTO experiment (expt_title,expt_year,start_date,end_date,expt_field,expt_site,experimenter)
						VALUES('$expt_name','$expt_year','$start_date','$end_date','$expt_field','$expt_site','$experimenter')";
						
						
	 if(mysqli_query($db,$insert_query))
	 {
		 $status = "Experiment details are registered successfully!!!";
	 }
	 else 
	 {
		 $status = "Error: ".$insert_query. " ". mysqli_error($db);
	 }
	 
}

$expt_view = 0;
// View the experiment details
if(isset($_POST["experiment_view"])) {
	$query_expt = "SELECT * FROM experiment ORDER BY id ASC";


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
	$expt_view = 1;
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
  <li><a href="db_home"><i class="fas fa-home"></i> Home</a></li>
  <li><a href="site_reg"><i class="fas fa-warehouse"></i> Site Reg.</a></li>
  <li><a href="sensor_reg"><i class="fas fa-temperature-high"></i> Sensor Reg.</a></li>
  <li><a class="active" href="experiment"><i class="fas fa-microscope"></i> Experiment</a></li>
  <li><a href="actuator_reg"><i class="fas fa-fan"></i> Actuator Reg.</a></li> 
  <li><a href="pheno_data_update"><i class="fas fa-leaf"></i> Pheno data</a></li> 
  <li><a href="image_upload"><i class="fas fa-file-upload"></i> Image Upload</a></li>
  <li><a href="update"><i class="fas fa-edit"></i> Update</a></li> 
  <li><a href="signout"><i class="fas fa-sign-out-alt"></i> Signout</a></li>
</ul>

</div>
<div class = "container">
<?php
		// Experiment register form
		echo "<h2 class = 'caption2'>Please enter the experiment details or click View button to view the list of experiments. </h2>";
		
		echo "<div class = 'form-container'>";
		  echo "<form action='' method='POST'>";
		  echo "<div class='row'>";
		  
			echo "<div class='col-25'>";
			  echo "<label for='expt_title'>Experiment title</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='text' id='expt_title' name='expt_title' value=''>";
			echo "</div>";
			
			echo "<div class='col-25'>";
			  echo "<label for='expt_year'>Experiment year</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='year' id='expt_year' name='expt_year' value=''>";
			echo "</div>";
			echo "</div>";
			
		  echo "<div class='row'>";
			echo "<div class='col-25'>";
			  echo "<label for='start_date'> Start date</label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='date' id='start_date' name='start_date' value=''>";
			echo "</div>";
			
			echo "<div class='col-25'>";
			  echo "<label for='end_date'>End date</label>";
			echo "</div>";	
			echo "<div class='col-75'>";
				echo"<input type='date' id='end_date' name='end_date' value=''>";
			echo '</div>';
			
			echo "<div class='col-25'>";
			  echo "<label for='expt_field'> Experiment field </label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo"<select id='expt_field' name='expt_field'>";
				echo"<option value = '' disabled selected> Select experiment field</option>";
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
				echo "<input type='text' id='expt_site' name='expt_site' value=''>";
			echo "</div>";
			
		   echo "<div class='col-25'>";
			  echo "<label for='experimenter'>Experiment member (*write in comma separated form) </label>";
			echo "</div>";
			echo "<div class='col-75'>";
				echo "<input type='text' id='experimenter' name='experimenter' value=''>";
			echo "</div>";
			echo "</div>";
			
		  echo"<div class='row'>";
				echo"<input type='submit' name = 'experiment_view' value='View'>";
				echo"<input type='submit' name = 'experiment_register' value='Register'>";
		  echo"</div>";
		  
		  echo"</form>";
		echo"</div>";
		
?>
<div class="station">
				
	<?php
	echo "<h2 class = 'caption2'> $status </h2>";
	if($expt_view){
		// To display experiment lists
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
	}	
    ?>
	<br>
	<br>
  </div>
</div>
</body>
</html>