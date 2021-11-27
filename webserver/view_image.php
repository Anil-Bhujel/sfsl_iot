<?php

// Get the data coming with link like follow

include_once("config.php");
global $statusMsg;

session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['login_user'])) {
	header('Location: login');
	exit;
}

$expt_id = array();
$expt_name = array();
$imgURL = array();
$filenames = array();


$image_view = false;

$start_date = '';
$end_date = '';

if(isset($_POST['submit'])) {	
	$image_view = true;
	 // Retrieve the form data
	 $expt_select = $_POST['expt_id'];
	 $start_date = $_POST['start_date'];
	 $end_date = $_POST['end_date'];
	 
	 // Read site name
	 $query_exptname = "SELECT expt_title FROM experiment WHERE id='$expt_select'";
	 $exptname_result = mysqli_query($db,$query_exptname);
	 
	 $row = mysqli_fetch_assoc($exptname_result);
	 $exptname = $row['expt_title'];
	 
	 //Read the images of selected site
	 if(!empty($start_date) and !empty($end_date)){
		 $query_photo = "SELECT * FROM image_data WHERE expt_id='$expt_select' AND capture_date BETWEEN '$start_date' and '$end_date' ORDER BY image_id ASC";
	 }
	 else {
		 $query_photo = "SELECT * FROM image_data WHERE expt_id='$expt_select' ORDER BY image_id ASC";
	 }
	 $photo_result = mysqli_query($db,$query_photo);
	
	 while($rows= mysqli_fetch_assoc($photo_result)) {
		$imgURL[] = 'image_data/'.'expt_'.$expt_select.'/'.$rows['file_name'];
		$filenames[] = $rows['file_name'];
	}
	if(mysqli_num_rows($photo_result)> 0) {
    
		$statusMsg = 0;
	}
	else {
		$statusMsg = "No image(s) found...";
	}

}

//read the site_id and site_names from site 

$query_expt = "SELECT id,expt_title FROM experiment ORDER BY id ASC";

$result = mysqli_query($db,$query_expt);
    
while($row = mysqli_fetch_assoc($result)) {
	$expt_id[] = $row['id'];
	$expt_name[] = $row['expt_title'];
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
  <li><a class="active" href="view_image"><i class="fas fa-image"></i> Image Data</a></li>
  <li><a href="log"><i class="fas fa-clipboard-list"></i> Log</a></li>
  <li><a href="download"><i class="fas fa-download"></i> Download</a></li>  
  <li><a href="signout"><i class="fas fa-sign-out-alt"></i> Signout</a></li>
</ul>

</div>
<div class = "container">

<h2 class='caption2'> Select an experiment name and image captured date (*optional) to view the images. </h2>
<div class = "form-container">
  <form action="" method="POST">
  <div class = "row">
  <div class="row">
    <div class="col-25">
      <label for="expt_id"> Experiment Name</label>
    </div>
    <div class="col-75">
      <select id="expt_id" name="expt_id">
		<?php if(!empty($expt_select)) {
			echo "<option value='$expt_select'>$exptname</option>";
			}
		?>	
	    <option>--Select Expt. Name --</option>
			<?php 
			    for ($i=0;$i<sizeof($expt_id);$i++) {
			        echo "<option value = '$expt_id[$i]'>$expt_id[$i] - $expt_name[$i]</option>";
			    }
			    
			 ?>
      </select>
	  
    </div>
  </div>
  
  <div class="row">
    <div class="col-25">
      <label for="start_date">Start Date (optional)</label>
    </div>
    <div class="col-75">
      <input type="date" id="start_date" name="start_date" value = <?php echo "$start_date";?>>
    </div>
  </div
  
  <div class="row">
    <div class="col-25">
      <label for="end_date">End Date (optional)</label>
    </div>
    <div class="col-75">
      <input type="date" id="end_date" name="end_date" value = <?php echo "$end_date";?>>
    </div>
  </div> 
  </br>
  <div class="row">
		<input type="submit" name = "download" formaction = "download_image" value="Download">
		<input type="submit" name = "submit" value="View">
  </div>
 </div>
  </form>
		
<div class="station"> 	       
<?php   
if($image_view) {
	echo "<h2 class='caption2'> Experiment images of '$exptname'.</h2>";
	
	echo "<div class = 'image_div'>";

	    if(!$statusMsg) { 
			for($i=0;$i < sizeof($imgURL);$i++) {
				
				echo "<img src='$imgURL[$i]' alt='Expt images' width = '400' height = '300' class = 'image_view'>";
				//echo "<img src='$imgURL[$i]' alt='Site images' class = 'image_view'>";
				//if($i%2!=0){
				//	$j = $i-1;
					
					//echo "<figcaption>$filenames[$j]; $filenames[$i]</figcaption>";
					//echo "<figcaption>$filenames[$i]</figcaption>";
				//}
			}
			echo "<h2 class='image_caption'> List of image filenames.</h2>";
			for($i=0;$i < sizeof($imgURL);$i++) {
				echo "<figcaption class='figure_caption'>$filenames[$i]</figcaption>";
			}
		} 
	    else {
	           echo $statusMsg;
	        }
	echo "</div>";
}
?>
	        
<br>
<br>
	
</div>
	
</div>

</body>
</html>