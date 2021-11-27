<?php
include_once("config.php");
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['login_user'])) {
	header('Location: login');
	exit;
}

// for plant pheno data
$id = Array();
$sample_id = Array();
$sample_date = Array();
$plant_height = Array();
$leaf_number = Array();
$leaf_width = Array();
$leaf_length = Array();
$petiole_dia = Array();
$stem_dia = Array();
$flower_number = Array();
$fruit_set_number = Array();
$fruit_number = Array();
$fruit_weight = Array();
$fruit_width = Array();
$fruit_length = Array();
$sugar_content = Array();
$titrable_acidity = Array();
$tss = Array();
$chlorophyll = Array();

// for animal pheno data
$body_temp = Array();
$body_weight = Array();
$water_intake = Array();
$water_wastage = Array();
$manure_weight = Array();
$adg = Array();
$age = Array();
$height = Array();
$girth_length = Array();
$volume = Array();
$fat_content = Array();
$water_content = Array();
$carcass_quality = Array();

// This GET sections is for handling the request from home page

if(isset($_GET["expt_id"])) {
	$expt_id = $_GET["expt_id"];
	
	// query for experiment field
	$expt_query = "SELECT expt_field FROM experiment WHERE id = '$expt_id'";
	
	$expt_result = mysqli_query($db,$expt_query);
	
	while($row = mysqli_fetch_assoc($expt_result)) {
		$expt_field = $row['expt_field'];
	}
	
	if($expt_field == 'Plant') {
		// plant pheno data query
		$pheno_plant_query = "SELECT * FROM plant_pheno_data WHERE expt_id = '$expt_id'";
		$pheno_plant_result = mysqli_query($db,$pheno_plant_query);
		
		while($row = mysqli_fetch_assoc($pheno_plant_result)) {
			$id[] = $row['id'];
			$sample_id[] = $row['sample_id'];
			$sample_date[] = $row['sample_date'];
			$plant_height[] = $row['plant_height'];
			$leaf_number[] = $row['leaf_number'];
			$leaf_width[] = $row['leaf_width'];
			$leaf_length[] = $row['leaf_length'];
			$petiole_dia[] = $row['petiole_dia'];
			$stem_dia[] = $row['stem_dia'];
			$flower_number[] = $row['flower_number'];
			$fruit_set_number[] = $row['fruit_set_number'];
			$fruit_number[] = $row['fruit_number'];
			$fruit_weight[] = $row['fruit_weight'];
			$fruit_width[] = $row['fruit_width'];
			$fruit_length[] = $row['fruit_length'];
			$sugar_content[] = $row['sugar_content'];
			$titrable_acidity[] = $row['titrable_acidity'];
			$tss[] = $row['total_soluble_solid'];
			$chlorophyll[] = $row['chlorophyll_content'];
		}
	}
	elseif($expt_field == 'Animal') {
		// plant pheno data query
		$pheno_animal_query = "SELECT * FROM animal_pheno_data WHERE expt_id = '$expt_id'";
		$pheno_animal_result = mysqli_query($db,$pheno_animal_query);
		
		while($row = mysqli_fetch_assoc($pheno_animal_result)) {
			$id[] = $row['id'];
			$sample_id[] = $row['sample_id'];
			$sample_date[] = $row['sample_date'];
			$body_temp[] = $row['body_temp'];
			$body_weight[] = $row['body_weight'];
			$water_intake[] = $row['water_intake'];
			$water_wastage[] = $row['water_wastage'];
			$manure_weight[] = $row['manure_weight'];
			$adg[] = $row['avg_daily_gain'];
			$age[] = $row['age'];
			$height[] = $row['height'];
			$girth_length[] = $row['girth_length'];
			$volume[] = $row['volume'];
			$fat_content[] = $row['fat_content'];
			$water_content[] = $row['water_content'];
			$carcass_quality[] = $row['carcass_quality'];

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
        if($expt_field == 'Plant') {
			echo "<h2 style = 'margin-left:40px'>Pheno data of plant experiment_".$expt_id." </h2>";
			echo "<table border='0' class= 'table-data'>";
			echo "<tr style='font-weight: bold;'>";
			echo "<td width='50' height='40' align='center'>Sample</td><td width='50'align='center'>Sample date</td>
			<td width='50'align='center'>Height</td><td width='50' align='center'>Leaf no.</td>
			<td width='50' align='center'>Leaf width</td><td width='50' align='center'>Leaf length</td>
			<td width='50' align='center'>Petiole diameter</td> <td width='50' align='center'>Stem diameter</td>
			<td width='50' align='center'>Flower no.</td><td width='50' align='center'>Fruit set</td>
			<td width='50' align='center'>Fruit no.</td><td width='50' align='center'>Fruit weight</td>
			<td width='50' align='center'>Fruit width</td><td width='50' align='center'>Fruit length</td>
			<td width='50' align='center'>Sugar content</td><td width='50' align='center'>Titrable acidity</td>
			<td width='50' align='center'>TSS</td><td width='50' align='center'>Chlorophyll</td>";
			echo "</tr>";
			
			
			for ($i = 0; $i < sizeof($id); $i++) {
				echo "<tr>";
				echo "<td align='center' width='50' height='50'>".$sample_id[$i]." </td>";
				echo "<td align='center' width='50' height='50'>".$sample_date[$i]." </td>";
				echo "<td align='center' width='50'>".$plant_height[$i]."</td>";
				echo "<td align='center' width='50'>".$leaf_number[$i]." </td>";
				echo "<td align='center' width='50'>".$leaf_width[$i]." </td>";
				echo "<td align='center' width='50'>".$leaf_length[$i]." </td>";
				echo "<td align='center' width='50'>".$petiole_dia[$i]." </td>";
				echo "<td align='center' width='50'>".$stem_dia[$i]."</td>";
				echo "<td align='center' width='50'>".$flower_number[$i]."</td>";
				echo "<td align='center' width='50'>".$fruit_set_number[$i]." </td>";
				echo "<td align='center' width='50'>".$fruit_number[$i]." </td>";
				echo "<td align='center' width='50'>".$fruit_weight[$i]."</td>";
				echo "<td align='center' width='50'>".$fruit_width[$i]."</td>";
				echo "<td align='center' width='50'>".$fruit_length[$i]." </td>";
				echo "<td align='center' width='50'>".$sugar_content[$i]." </td>";
				echo "<td align='center' width='50'>".$titrable_acidity[$i]."</td>";
				echo "<td align='center' width='50'>".$tss[$i]."</td>";
				echo "<td align='center' width='50'>".$chlorophyll[$i]."</td>";
				echo "</tr>";
				
			}
			
			echo "</table>";  
		}
		elseif($expt_field == 'Animal') {
			echo "<h2 style = 'margin-left:40px'>Pheno data of animal experiment. </h2>";
			echo "<table border='0' class= 'table-data'>";
			echo "<tr style='font-weight: bold;'>";
			echo "<td width='50' height='40' align='center'>Sample</td><td width='50'align='center'>Sample date</td><td width='50'align='center'>Body temp</td>
			<td width='50' align='center'>Body weight</td><td width='50' align='center'>Water intake</td>
			<td width='50' align='center'>Water wastage</td> <td width='50' align='center'>Manure weight</td>
			<td width='50' align='center'>ADG</td><td width='50' align='center'>Age</td>
			<td width='50' align='center'>Height</td><td width='50' align='center'>Girth length</td>
			<td width='50' align='center'>Volume</td><td width='50' align='center'>Fat</td>
			<td width='50' align='center'>Water content</td><td width='50' align='center'>Carcass quality</td>";
			echo "</tr>";
			
			
			for ($i = 0; $i < sizeof($id); $i++) {
				echo "<tr>";
				echo "<td align='center' width='50' height='50'>".$sample_id[$i]." </td>";
				echo "<td align='center' width='50' height='50'>".$sample_date[$i]." </td>";
				echo "<td align='center' width='50'>".$body_temp[$i]."</td>";
				echo "<td align='center' width='50'>".$body_weight[$i]." </td>";
				echo "<td align='center' width='50'>".$water_intake[$i]." </td>";
				echo "<td align='center' width='50'>".$water_wastage[$i]." </td>";
				echo "<td align='center' width='50'>".$manure_weight[$i]." </td>";
				echo "<td align='center' width='50'>".$adg[$i]."</td>";
				echo "<td align='center' width='50'>".$age[$i]."</td>";
				echo "<td align='center' width='50'>".$height[$i]." </td>";
				echo "<td align='center' width='50'>".$girth_length[$i]." </td>";
				echo "<td align='center' width='50'>".$volume[$i]."</td>";
				echo "<td align='center' width='50'>".$fat_content[$i]."</td>";
				echo "<td align='center' width='50'>".$water_content[$i]."</td>";
				echo "<td align='center' width='50'>".$carcass_quality[$i]."</td>";
				echo "</tr>";
				
			}
			
			echo "</table>";  
		}
		
		?>
		
	<br>
  </div>
</div>
</body>
</html>