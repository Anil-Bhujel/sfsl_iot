<?php
include_once("config.php");
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['login_user'])) {
	header('Location: login');
	exit;
}

$expt_id = Array();
$expt_name = Array();
$expt_year = Array();
$start_date = Array();
$end_date = Array();
$expt_field = Array();
$expt_site = Array();
$experimenter = Array();


// Query the experiment details
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
  <li><a class="active" href="pheno_data"><i class="fas fa-leaf"></i> Pheno Data</a></li>
  <li><a href="view_image"><i class="fas fa-image"></i> Image Data</a></li>
  <li><a href="log"><i class="fas fa-clipboard-list"></i> Log</a></li>
  <li><a href="download"><i class="fas fa-download"></i> Download</a></li>  
  <li><a href="signout"><i class="fas fa-sign-out-alt"></i> Signout</a></li>
</ul>

</div>
<div class = "container">
<div class="station">
		
		<?php 
        
        echo "<h2 style = 'margin-left:40px'>List of experiments. </h2>";
        echo "<table border='1' class= 'table-data'>";
        echo "<tr style='font-weight: bold;'>";
        echo "<td width='50' height='40' align='center'>Expt_id</td><td width='200'align='center'>Expt title</td>
		<td width='100' align='center'>Expt year</td><td width='100' align='center'>Start date</td><td width='100' align='center'>End date</td>
		<td width='100' align='center'>Expt field</td> <td width='100' align='center'>Expt site</td>
		<td width='150' align='center'>Expt member</td><td width='150' align='center'>Pheno data</td>";
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
			echo "<td align='center' width='150'><a href='view_pheno_data?expt_id=$expt_id[$i]'><input type='submit' name = 'submit' value='View'></a></td>";
            echo "</tr>";
			
        }
        
        echo "</table>";  
		
		?>
		
	<br>
  </div>
</div>
</body>
</html>