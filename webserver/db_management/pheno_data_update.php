<?php
include_once("config.php");
session_start();

//global $sel_expt_id,$sel_expt_field, $insert_query,$status;

//$user_previlege = $_SESSION['previlege']);

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['login_user'])) {
	header('Location: /data/login');
	exit;
}

// for experiment data
$expt_id = Array();
$expt_name = Array();
$expt_field = Array();

// For plant pheno data
$pheno_id = Array();;
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
$titrable_acid = Array();
$tss = Array();
$chlorophyll = Array();

// For animal pheno data
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


// form display controller
$data_form = 0;
$data_view = 0;
$data_register = 0;
$data_update = 0;

// Pheno data view 
if(isset($_POST["pheno_data_view"])) {
	$sel_expt_id = $_POST["expt_id"];
	
	// query expt field
	$query_expt = "SELECT expt_field FROM experiment WHERE id=$sel_expt_id";
	
	$expt_result = mysqli_query($db,$query_expt);

	while ($row = mysqli_fetch_assoc($expt_result)) {
		$sel_expt_field = $row['expt_field'];
	}
	
	// for plant pheno data
	if($sel_expt_field == 'Plant'){
		$pheno_query = "SELECT * FROM plant_pheno_data WHERE expt_id=$sel_expt_id";
		
		$pheno_result = mysqli_query($db,$pheno_query);
		
		while ($row = mysqli_fetch_assoc($pheno_result)) {
			$pheno_id[] = $row['id'];
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
			$titrable_acid[] = $row['titrable_acidity'];
			$tss[] = $row['total_soluble_solid'];
			$chlorophyll[] = $row['chlorophyll_content'];
			
		}
	}
	// for animal pheno data
	else {
		$pheno_query = "SELECT * FROM animal_pheno_data WHERE expt_id=$sel_expt_id";
		
		$pheno_result = mysqli_query($db,$pheno_query);
		
		while ($row = mysqli_fetch_assoc($pheno_result)) {
			$pheno_id[] = $row['id'];
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
	
	$data_view = 1;
	
}

// pheno data register
if(isset($_POST["pheno_data_register"])) {
	$sel_expt_id = $_POST["expt_id"];
	
	// query expt field
	$query_expt = "SELECT expt_field FROM experiment WHERE id=$sel_expt_id";
	
	$expt_result = mysqli_query($db,$query_expt);

	while ($row = mysqli_fetch_assoc($expt_result)) {
		$sel_expt_field = $row['expt_field'];
	}
	
	$data_form = 1;
	
}

// pheno data saving
if(isset($_POST["pheno_data_post"])) {
	if($_POST["expt_field"] == 'Plant'){
		$sel_expt_id = $_POST["expt_id"];
		$s_id = $_POST["sample_id"];
		$s_date = $_POST["sample_date"];
		$p_height = $_POST["plant_height"];
		$l_number = $_POST["leaf_number"];
		$l_width = $_POST["leaf_width"];
		$l_length = $_POST["leaf_length"];
		$p_dia = $_POST["petiole_dia"];
		$s_dia = $_POST["stem_dia"];
		$f_number = $_POST["flower_number"];
		$f_set = $_POST["fruit_set"];
		$fruit_no = $_POST["fruit_number"];
		$f_weight = $_POST["fruit_weight"];
		$f_width = $_POST["fruit_width"];
		$f_length = $_POST["fruit_length"];
		$s_content = $_POST["sugar_content"];
		$t_acidity = $_POST["titrable_acidity"];
		$s_tss = $_POST["tss"];
		$c_content = $_POST["chlorophyll"];
		
				
		//Insert the information
		// For null data insert 
		$s_id = !empty($s_id)? "'$s_id'":"NULL";
		$s_date = !empty($s_date)? "'$s_date'":"NULL";
		$p_height = !empty($p_height)? "'$p_height'":"NULL";
		$l_number = !empty($l_number)? "'$l_number'":"NULL";
		$l_width = !empty($l_width)? "'$l_width'":"NULL";
		$l_length = !empty($l_length)? "'$l_length'":"NULL";
		$p_dia = !empty($p_dia)? "'$p_dia'":"NULL";
		$s_dia = !empty($s_dia)? "'$s_dia'":"NULL";
		$f_number = !empty($f_number)? "'$f_number'":"NULL";
		$f_set = !empty($f_set)? "'$f_set'":"NULL";
		$fruit_no = !empty($fruit_no)? "'$fruit_no'":"NULL";
		$f_weight = !empty($f_weight)? "'$f_weight'":"NULL";
		$f_width = !empty($f_width)? "'$f_width'":"NULL";
		$f_length = !empty($f_length)? "'$f_length'":"NULL";
		$s_content = !empty($s_content)? "'$s_content'":"NULL";
		$t_acidity = !empty($t_acidity)? "'$t_acidity'":"NULL";
		$s_tss = !empty($s_tss)? "'$s_tss'":"NULL";
		$c_content = !empty($c_content)? "'$c_content'":"NULL";
		 
		 $insert_query = "INSERT INTO plant_pheno_data (expt_id,sample_id,sample_date,plant_height,leaf_number,leaf_width,leaf_length,petiole_dia,stem_dia,flower_number,fruit_set_number,fruit_number,fruit_weight,fruit_width,fruit_length,sugar_content,titrable_acidity,total_soluble_solid,chlorophyll_content)
							VALUES('$sel_expt_id',$s_id,$s_date,$p_height,$l_number,$l_width,$l_length,$p_dia,$s_dia,$f_number,$f_set,$fruit_no,$f_weight,$f_width,$f_length,$s_content,$t_acidity,$s_tss,$c_content)";
							
		
	}
	elseif($_POST["expt_field"]=='Animal'){
		$sel_expt_id = $_POST["expt_id"];
		$s_id = $_POST["sample_id"];
		$s_date = $_POST["sample_date"];
		$b_temp = $_POST["body_temp"];
		$b_weight = $_POST["body_weight"];
		$w_intake = $_POST["water_intake"];
		$w_wastage = $_POST["water_wastage"];
		$m_weight = $_POST["manure_weight"];
		$s_adg = $_POST["adg"];
		$s_age = $_POST["age"];
		$s_height = $_POST["height"];
		$g_length = $_POST["girth_length"];
		$s_volume = $_POST["volume"];
		$f_content = $_POST["fat_content"];
		$w_content = $_POST["water_content"];
		$c_quality = $_POST["carcass_quality"];
		
		//Insert the information
		// For null form data handling
		$s_id = !empty($s_id)? "'$s_id'":"NULL";
		$s_date = !empty($s_date)? "'$s_date'":"NULL";
		$b_temp = !empty($b_temp)? "'$b_temp'":"NULL";
		$b_weight = !empty($b_weight)? "'$b_weight'":"NULL";
		$w_intake = !empty($w_intake)? "'$w_intake'":"NULL";
		$w_wastage = !empty($w_wastage)? "'$w_wastage'":"NULL";
		$m_weight = !empty($m_weight)? "'$m_weight'":"NULL";
		$s_adg = !empty($s_adg)? "'$s_adg'":"NULL";
		$s_age = !empty($s_age)? "'$s_age'":"NULL";
		$s_height = !empty($s_height)? "'$s_height'":"NULL";
		$g_length = !empty($g_length)? "'$g_length'":"NULL";
		$s_volume = !empty($s_volume)? "'$s_volume'":"NULL";
		$f_content = !empty($f_content)? "'$f_content'":"NULL";
		$w_content = !empty($w_content)? "'$w_content'":"NULL";
		$c_quality = !empty($c_quality)? "'$c_quality'":"NULL";
		 
		 $insert_query = "INSERT INTO animal_pheno_data (expt_id,sample_id,sample_date,body_temp,body_weight,water_intake,water_wastage,manure_weight,avg_daily_gain,age,height,girth_length,volume,fat_content,water_content,carcass_quality)
							VALUES('$sel_expt_id',$s_id,$s_date,$b_temp,$b_weight,$w_intake,$w_wastage,$m_weight,$s_adg,$s_age,$s_height,$g_length,$s_volume,$f_content,$w_content,$c_quality)";
							
		
	}					
						
	 if(mysqli_query($db,$insert_query))
	 {
		 $status = "Pheno data of experiment_".$sel_expt_id." saved successfully!!!";
	 }
	 else 
	 {
		 $status = "Error: ".$insert_query. " ". mysqli_error($db);
	 }
	 $data_register = 1;
	
}

// pheno data update
/*
if(isset($_GET["pheno_data_id"])) {
	if($_GET["exp_field"] == 'Plant'){
		$sel_expt_field = $_GET["exp_field"]
		$exp_name = $_POST["expt_title"];
		$expt_year = $_POST["expt_year"];
		$start_date = $_POST["start_date"];
		$end_date = $_POST["end_date"];
		$expt_field = $_POST["expt_field"];
		$expt_site = $_POST["expt_site"];
		$experimenter = $_POST["experimenter"];
		
		//Insert the information
		 
		 $insert_query = "INSERT INTO plant_pheno_data (expt_id,sample_id,sample_date,plant_height,leaf_number,leaf_width,leaf_length,petiole_dia,stem_dia,flower_number,fruit_set_number,fruit_number,fruit_weight,fruit_width,fruit_length,sugar_content,titrable_acidity,total_soluble_solidity,chlorophyll_content)
							VALUES('$expt_name','$expt_year','$start_date','$end_date','$expt_field','$expt_site','$experimenter')";
							
		
	}
	elseif($sel_expt_field=='Animal'){
		$expt_name = $_POST["expt_title"];
		$expt_year = $_POST["expt_year"];
		$start_date = $_POST["start_date"];
		$end_date = $_POST["end_date"];
		$expt_field = $_POST["expt_field"];
		$expt_site = $_POST["expt_site"];
		$experimenter = $_POST["experimenter"];
		
		//Insert the information
		 
		 $insert_query = "INSERT INTO animal_pheno_data (expt_id,sample_id,sample_date,body_temp,body_weight,water_intake,water_wastage,manure_weight,avg_daily_gain,age,height,girth_length,volume,fat_content,water_content,carcass_quality)
							VALUES('$expt_name','$expt_year','$start_date','$end_date','$expt_field','$expt_site','$experimenter')";
							
		
	}					
						
	 if(mysqli_query($db,$insert_query))
	 {
		 $status = "Pheno data of ".$expt_name." updated successfully!!!";
	 }
	 else 
	 {
		 $status = "Error: ".$insert_query. " ". mysqli_error($db);
	 }
	
}
*/

// Query the experiment details
$query_expt = "SELECT id,expt_title FROM experiment ORDER BY id ASC";


$expt_result = mysqli_query($db,$query_expt);

while ($row = mysqli_fetch_assoc($expt_result)) {
    $expt_id[] = $row['id'];
    $expt_name[] =  $row['expt_title'];
    
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
  <li><a href="experiment"><i class="fas fa-microscope"></i> Experiment</a></li>
  <li><a href="actuator_reg"><i class="fas fa-fan"></i> Actuator Reg.</a></li> 
  <li><a class="active" href="pheno_data_update"><i class="fas fa-leaf"></i> Pheno data</a></li> 
  <li><a href="image_upload"><i class="fas fa-file-upload"></i> Image Upload</a></li>
  <li><a href="update"><i class="fas fa-edit"></i> Update</a></li> 
  <li><a href="signout"><i class="fas fa-sign-out-alt"></i> Signout</a></li>
</ul>

</div>
<div class = "container">
<?php
		// Experiment register form
		echo "<h2 class = 'caption2'>Please select an action. </h2>";
		
		echo "<div class = 'form-container'>";
		  echo "<form action='' method='POST'>";
		  echo "<div class='row'>";
			
			echo "<div class='col-75'>";
				echo"<select id='expt_id' name='expt_id'>";
				echo"<option value = '' disabled selected> Select an experiment title</option>";
				echo"<option value = '' > </option>";
				for($i=0;$i<sizeof($expt_id);$i++){
					echo "<option value='$expt_id[$i]'> $expt_id[$i] - $expt_name[$i]</option>";
				}
				
				echo"</select>";
			echo "</div>";
			echo "</div>";
			
		  echo"<div class='row'>";
				echo"<input type='submit' name = 'pheno_data_view' value='Data View'>";
				echo"<input type='submit' name = 'pheno_data_register' value='Data Register'>";
		  echo"</div>";
		  
		  echo"</form>";
		echo"</div>";
		

		if($data_form){
			// Pheno data register form
			echo "<h2 class = 'caption2'>Please enter the experiment details. </h2>";
			if($sel_expt_field=='Plant'){
				echo "<div class = 'form-container'>";
				  echo "<form action='' method='POST'>";
				  echo "<div class='row'>";
				  
					echo "<div class='col-25'>";
					  echo "<label for='expt_id'>Experiment ID</label>";
					echo "</div>";
				
					echo "<div class='col-75'>";
					echo"<select id='expt_id' name='expt_id'>";
						echo"<option value = '$sel_expt_id' selected>$sel_expt_id </option>";
					echo"</select>";
					echo "</div>";
					echo "</div>";
					
					echo "<div class='row'>";
					echo "<div class='col-25'>";
					  echo "<label for='expt_field'>Experiment field</label>";
					echo "</div>";
				
					echo "<div class='col-75'>";
					echo"<select id='expt_field' name='expt_field'>";
						echo"<option value = '$sel_expt_field' selected>$sel_expt_field </option>";
					echo"</select>";
					echo "</div>";
					echo "</div>";
			
					echo "<div class='row'>";
					echo "<div class='col-25'>";
					  echo "<label for='sample_id'>Sample ID</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='text' id='sample_id' name='sample_id' value=''>";
					echo "</div>";
					
					echo "<div class='col-25'>";
					  echo "<label for='sample_date'> Sample date</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='date' id='sample_date' name='sample_date' value=''>";
					echo "</div>";
					
					echo "<div class='col-25'>";
					  echo "<label for='plant_height'>Plant height (cm)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='plant_height' name='plant_height' value=''>";
					echo "</div>";
					echo "</div>";
					
				echo "<div class='row'>";
					echo "<div class='col-25'>";
					  echo "<label for='leaf_number'> Leaf number </label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' id='leaf_number' name='leaf_number' value=''>";
					echo "</div>";
					echo "</div>";
				  
				  echo "<div class='row'>"; 
					echo "<div class='col-25'>";
					  echo "<label for='leaf_width'>Leaf width (cm)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step = 0.01 id='leaf_width' name='leaf_width' value=''>";
					echo "</div>";
					echo "</div>";
				
				echo "<div class='row'>";
				   echo "<div class='col-25'>";
					  echo "<label for='leaf_length'>Leaf length (cm)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='leaf_length' name='leaf_length' value=''>";
					echo "</div>";
					echo "</div>";
					
					echo "<div class='row'>"; 
					echo "<div class='col-25'>";
					  echo "<label for='petiole_dia'>Petiole diameter (cm)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step = 0.01 id='petiole_dia' name='petiole_dia' value=''>";
					echo "</div>";
					echo "</div>";
					
				echo "<div class='row'>";	
				   echo "<div class='col-25'>";
					  echo "<label for='stem_dia'>Stem diameter (cm)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='stem_dia' name='stem_dia' value=''>";
					echo "</div>";
					echo "</div>";
					
				echo "<div class='row'>";	
					echo "<div class='col-25'>";
					  echo "<label for='flower_number'>Flower number</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' id='flower_number' name='flower_number' value=''>";
					echo "</div>";
					echo "</div>";
					echo "<div class='row'>";
					
				   echo "<div class='col-25'>";
					  echo "<label for='fruit_set'>Fruit set number </label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' id='fruit_set' name='fruit_set' value=''>";
					echo "</div>";
					echo "</div>";
					
					echo "<div class='row'>";
					echo "<div class='col-25'>";
					  echo "<label for='fruit_number'>Fruit number</label>";
					echo "</div>";
					
					echo "<div class='col-75'>";
						echo "<input type='number' id='fruit_number' name='fruit_number' value=''>";
					echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
				   echo "<div class='col-25'>";
					  echo "<label for='fruit_weight'>Fruit weight (gm)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='fruit_weight' name='fruit_weight' value=''>";
					echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
					echo "<div class='col-25'>";
					  echo "<label for='fruit_width'>Fruit width (cm)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='fruit_width' name='fruit_width' value=''>";
					echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
				   echo "<div class='col-25'>";
					  echo "<label for='fruit_length'>Fruit length (cm)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step = 0.01 id='fruit_length' name='fruit_length' value=''>";
					echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
					echo "<div class='col-25'>";
					  echo "<label for='sugar_content'>Sugar content </label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='sugar_content' name='sugar_content' value=''>";
					echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
				   echo "<div class='col-25'>";
					  echo "<label for='titrable_acidity'>Titrable acidity </label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='titrable_acidity' name='titrable_acidity' value=''>";
					echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
					echo "<div class='col-25'>";
					  echo "<label for='tss'>Total soluble solid</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='tss' name='tss' value=''>";
					echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
				   echo "<div class='col-25'>";
					  echo "<label for='chlorophyll'>Chlorophyll content </label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='chlorophyll' name='chlorophyll' value=''>";
					echo "</div>";
					echo "</div>";
					
				  echo"<div class='row'>";
						echo"<input type='submit' name = 'pheno_data_post' value='Save'>";
				  echo"</div>";
				  
				  echo"</form>";
				echo"</div>";
			}
			elseif($sel_expt_field=='Animal'){
				echo "<div class = 'form-container'>";
				  echo "<form action='' method='POST'>";
				  echo "<div class='row'>";
					
					echo "<div class='col-25'>";
					  echo "<label for='expt_id'>Experiment ID</label>";
					echo "</div>";
					
					echo "<div class='col-75'>";
					echo"<select id='expt_id' name='expt_id'>";
						echo"<option value = '$sel_expt_id' selected>$sel_expt_id </option>";
					echo"</select>";
					echo "</div>";
					echo "</div>";
					
					echo "<div class='row'>";
					echo "<div class='col-25'>";
					  echo "<label for='expt_field'>Experiment field</label>";
					echo "</div>";
				
					echo "<div class='col-75'>";
					echo"<select id='expt_field' name='expt_field'>";
						echo"<option value = '$sel_expt_field' selected>$sel_expt_field </option>";
					echo"</select>";
					echo "</div>";
					echo "</div>";
					
				echo "<div class='row'>";
					echo "<div class='col-25'>";
					  echo "<label for='sample_id'>Sample ID</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='text' id='sample_id' name='sample_id' value=''>";
					echo "</div>";
					
					echo "<div class='col-25'>";
					  echo "<label for='sample_date'> Sample date</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='date' id='sample_date' name='sample_date' value=''>";
					echo "</div>";
					
					echo "<div class='col-25'>";
					  echo "<label for='body_temp'>Body temp (DegC)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='body_temp' name='body_temp' value=''>";
					echo "</div>";
					echo "</div>";
					
				echo "<div class='row'>";
					echo "<div class='col-25'>";
					  echo "<label for='body_weight'> Body weight (kg)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='body_weight' name='body_weight' value=''>";
					echo "</div>";
					echo "</div>";
				  
				  echo "<div class='row'>"; 
					echo "<div class='col-25'>";
					  echo "<label for='water_intake'>Water intake (ml)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step = 0.01 id='water_intake' name='water_intake' value=''>";
					echo "</div>";
					echo "</div>";
				
				echo "<div class='row'>";
				   echo "<div class='col-25'>";
					  echo "<label for='water_wastage'>Water wastage (ml)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='water_wastage' name='water_wastage' value=''>";
					echo "</div>";
					echo "</div>";
					
					echo "<div class='row'>"; 
					echo "<div class='col-25'>";
					  echo "<label for='manure_weight'>Manure weight (kg)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step = 0.01 id='manure_weight' name='manure_weight' value=''>";
					echo "</div>";
					echo "</div>";
					
				echo "<div class='row'>";	
				   echo "<div class='col-25'>";
					  echo "<label for='adg'>Avg daily gain (kg)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='adg' name='adg' value=''>";
					echo "</div>";
					echo "</div>";
					
				echo "<div class='row'>";	
					echo "<div class='col-25'>";
					  echo "<label for='age'> Age (year)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='age' name='age' value=''>";
					echo "</div>";
					echo "</div>";
					echo "<div class='row'>";
					
				   echo "<div class='col-25'>";
					  echo "<label for='height'> Height (cm)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='height' name='height' value=''>";
					echo "</div>";
					echo "</div>";
					
					echo "<div class='row'>";
					echo "<div class='col-25'>";
					  echo "<label for='girth_length'> Girth length (cm)</label>";
					echo "</div>";
					
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='girth_length' name='girth_length' value=''>";
					echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
				   echo "<div class='col-25'>";
					  echo "<label for='volume'> Volume (cm3)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='volume' name='volume' value=''>";
					echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
					echo "<div class='col-25'>";
					  echo "<label for='fat_content'> Fat content</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='fat_content' name='fat_content' value=''>";
					echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
				   echo "<div class='col-25'>";
					  echo "<label for='water_content'>Water content (gm)</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step = 0.01 id='water_content' name='water_content' value=''>";
					echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
					echo "<div class='col-25'>";
					  echo "<label for='carcass_quality'>Carcass quality</label>";
					echo "</div>";
					echo "<div class='col-75'>";
						echo "<input type='number' step=0.01 id='carcass_quality' name='carcass_quality' value=''>";
					echo "</div>";
					echo "</div>";

				  echo"<div class='row'>";
						echo"<input type='submit' name = 'pheno_data_post' value='Save'>";
				  echo"</div>";
				  
				  echo"</form>";
				echo"</div>";
			}
		}
		elseif($data_view) {
			// To display experiment lists
			if($sel_expt_field == 'Plant') {
			echo "<h2 style = 'margin-left:40px'>Pheno data of experiment_".$sel_expt_id." </h2>";
			echo "<table border='0' class= 'table-data'>";
			echo "<tr style='font-weight: bold;'>";
			echo "<td width='50' height='40' align='center'>Sample</td><td width='50'align='center'>Sample date</td><td width='50'align='center'>Height</td>
			<td width='50' align='center'>Leaf no.</td><td width='50' align='center'>Leaf Width</td>
			<td width='50' align='center'>Leaf length</td><td width='50' align='center'>Petiole diameter</td> 
			<td width='50' align='center'>Stem diameter</td><td width='50' align='center'>Flower no.</td>
			<td width='50' align='center'>Fruit set</td><td width='50' align='center'>Fruit no.</td>
			<td width='50' align='center'>Fruit weight</td><td width='50' align='center'>Fruit Width</td>
			<td width='50' align='center'>Fruit Length</td><td width='50' align='center'>Sugar content</td>
			<td width='50' align='center'>Titrable acidity</td><td width='50' align='center'>TSS</td>
			<td width='50' align='center'>Chlorophyll</td>";
			#<td width='50' align='center'>Modify</td>";
			echo "</tr>";
			
			
			for ($i = 0; $i < sizeof($pheno_id); $i++) {
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
				echo "<td align='center' width='50'>".$titrable_acid[$i]."</td>";
				echo "<td align='center' width='50'>".$tss[$i]."</td>";
				echo "<td align='center' width='50'>".$chlorophyll[$i]."</td>";
				#echo "<td align='center' width='50'><a href='pheno_data_update?pheno_data_id=$pheno_id[$i]&exp_field=$sel_expt_field'><input type='submit' name = 'submit' value='Edit'></a></td>";
				echo "</tr>";
				
			}
			
			echo "</table>";  
		}
		elseif($sel_expt_field == 'Animal') {
			echo "<h2 style = 'margin-left:40px'>Pheno data of experiment_".$sel_expt_id." </h2>";
			echo "<table border='0' class= 'table-data'>";
			echo "<tr style='font-weight: bold;'>";
			echo "<td width='50' height='40' align='center'>Sample</td><td width='50'align='center'>Sample date</td><td width='50'align='center'>Body temp</td>
			<td width='50' align='center'>Body weight</td><td width='50' align='center'>Water intake</td>
			<td width='50' align='center'>Water wastage</td> <td width='50' align='center'>Manure weight</td>
			<td width='50' align='center'>ADG</td><td width='50' align='center'>Age</td>
			<td width='50' align='center'>Height</td><td width='50' align='center'>Girth length</td>
			<td width='50' align='center'>Volume</td><td width='50' align='center'>Fat</td>
			<td width='50' align='center'>Water content</td><td width='50' align='center'>Carcass quality</td>";
			#<td width='50' align='center'>Modify</td>";
			echo "</tr>";
			
			
			for ($i = 0; $i < sizeof($pheno_id); $i++) {
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
				#echo "<td align='center' width='50'><a href='pheno_data_update?pheno_data_id=$pheno_id[$i]&exp_field=$sel_expt_field'><input type='submit' name = 'submit' value='Edit'></a></td>";
				echo "</tr>";
				
			}
			
			echo "</table>";  
		}
		}
		elseif($data_register or $data_update) {
			echo "<h2 class = 'caption2'> $status </h2>";
		}
		
    ?>
	<br>
	<br>
  </div>
</div>
</body>
</html>