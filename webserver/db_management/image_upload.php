<?php

include_once ("config.php");

session_start();

//$user_previlege = $_SESSION['previlege']);

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['login_user'])) {
	header('Location: /data/login');
	exit;
}

$expt_id = array();
$expt_name = array();

// set default date and timezone
date_default_timezone_set('Asia/Seoul');

$uploadPost = 0;

	    
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $expt_select = $_POST['expt_id'];
	$capture_date = $_POST['capture_date'];
	
	#$capture_time = $_POST['capture_time'];
	$upload_date = date("Y-m-d");
	
	$query_expt = "SELECT expt_title FROM experiment WHERE id = '$expt_select'";
	$result = mysqli_query($db,$query_expt);
	
	while($row=mysqli_fetch_assoc($result)) {
		$exptname = $row['expt_title'];
	}
    // $description = $_POST['description'];
    $dirpath = dirname(getcwd());
    $root_dir = "C:/wamp64/www/data/image_data/";
	$target_dir = $root_dir.'expt_'.$expt_select."/";
	if( is_dir($target_dir) === false )
	{
		mkdir($target_dir);
	}
    $basefile = basename($_FILES["file"]["name"]);
	$fileName = $basefile;
    $target_file = $target_dir . $fileName;
    $uploadPost = 1;
    $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
    
    if(!empty($_FILES["file"]["name"])) {
       $allowTypes = array('jpg','png','jpeg','gif','pdf');
       
        if(in_array($fileType, $allowTypes)){
            // Upload file to server
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
                
				// Insert image file name into database
				$capture_date = !empty($capture_date) ? "'$capture_date'" : "NULL";
				/*
				if(!empty($capture_date)){
					$insert_query = "INSERT into image_data (expt_id,file_name,capture_date,upload_date) VALUES ('$expt_select','$fileName','$capture_date','$upload_date')";
				}
				else {
					$insert_query = "INSERT into image_data (expt_id,file_name,capture_date,upload_date) VALUES ('$expt_select','$fileName',NULL,'$upload_date')";
				}
				*/
				$insert_query = "INSERT into image_data (expt_id,file_name,capture_date,upload_date) VALUES ('$expt_select','$fileName',$capture_date,'$upload_date')";
                $insert_result = mysqli_query($db,$insert_query);
                if($insert_result){
                    $statusMsg = "An image of filename ".$fileName. " has been uploaded successfully.";
                }
                else{
                    $statusMsg = "Error ".$insert_query. " ". mysqli_error($db);
                } 
            }
            else{
                $statusMsg = "Sorry, there was an error uploading your photo.";
            }
        }
        else{
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
        }
      
    }
}
else {
    
    $statusMsg = 'Please select a file to upload.';
}

// Experiment photo upload

$expt_query ="SELECT id,expt_title FROM experiment ORDER BY id ASC";
$expt_result = mysqli_query($db,$expt_query);

while($row = mysqli_fetch_assoc($expt_result)) {
	$expt_id[] = $row['id'];
	$expt_name[] = $row['expt_title'];
}
		

/*
For image display part
// Include the database configuration file
include 'dbConfig.php';

// Get images from the database
$query = $db->query("SELECT * FROM images ORDER BY uploaded_on DESC");

if($query->num_rows > 0){
    while($row = $query->fetch_assoc()){
        $imageURL = 'uploads/'.$row["file_name"];
?>
    <img src="<?php echo $imageURL; ?>" alt="" />
<?php }
}else{ ?>
    <p>No image(s) found...</p>
<?php } ?>
*/



/*    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    
    if($check !== false) {
        $statusMsg= "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $statusMsg= "File is not an image.";
        $uploadOk = 0;
    }


    // Check if file already exists
    if (file_exists($target_file)) {
        $statusMsg= "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $statusMsg= "Sorry, your file is too large. Image should be less than 5 MB.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $statusMsg= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $statusMsg= "Sorry, your file was not uploaded.";

    // if everything is ok, try to upload file
    } 
else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    // Insert image file name into database
    $insert = $db->query("INSERT into site_photos (site_name, site_photo) VALUES ('site_name',".$fileName."')");
    if($insert){
        $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }
    else{
         $statusMsg = "Photo upload failed, please try again.";
        } 
    
  } 
  else {
    $statusMsg= "Sorry, there was an error in uploading your photo.";
  }
}

    mysqli_close($db);
}*/

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
  <li><a href="pheno_data_update"><i class="fas fa-leaf"></i> Pheno data</a></li>
  <li><a class="active" href="image_upload"><i class="fas fa-file-upload"></i> Image Upload</a></li> 
  <li><a href="update"><i class="fas fa-edit"></i> Update</a></li> 
  <li><a href="signout"><i class="fas fa-sign-out-alt"></i> Signout</a></li>
</ul>

</div>
<div class = "container">
<div class="station">

<?php echo "<h1 class='caption2'>Please upload a site photo.</h1>";?>

<div class = "form-container">
  <form action="" method="POST" enctype="multipart/form-data">
  
  <div class="row">
    <div class="col-25">
      <label for="file">Select an Image</label>
    </div>
    <div class="col-75">
      <input type="file" id="file" name="file" value="">
    </div>
  </div>
  
  <div class="row">
    <div class="col-25">
      <label for="expt_id">Experiment Name</label>
    </div>
    <div class="col-75">
      <select id="expt_id" name="expt_id">
	  <?php if(!empty($expt_select)) {
		  echo "<option value='$expt_select'>$exptname</option>";
		}
	  ?>
	    <option> --Select Site Name-- </option>
			<?php 
			    for ($i=0;$i<sizeof($expt_id);$i++) {
			        echo "<option value = '$expt_id[$i]'>$expt_name[$i]</option>";
			    }
			    
			 ?>
      </select>
	</div>
  </div> 
  
  <div class="row">
    <div class="col-25">
      <label for="capture_date">Capture Date (optional)</label>
    </div>
    <div class="col-75">
      <input type="date" id="capture_date" name="capture_date" value="">
    </div>
  </div> 
 
  <!--div class="row">
    <div class="col-25">
      <label for="capture_time">Capture Time</label>
    </div>
    <div class="col-75">
      <input type="time" id="capture_time" name="capture_time" value="">
	</div>
  </div-->
  
   
  <div class="row">
		<input type="submit" value="Upload" name="submit">
  </div>
  </form>
</div>


    <!--?php echo "<h1 class='caption'>Please upload a site photo.</h1>";?>
	<div class="form-data">
	
	    <form action="" method="post" enctype="multipart/form-data">
	      <div class="input-group">
	      <label>Site Name</label>
	      <select id = "site_id" name = "site_id">
	      <option disabled selected>--Select Staion Name--</option>
	      <-?php
	        while ($row = mysqli_fetch_assoc($site_result)) 
			    { 
			        echo "<option value = '".$row['site_id']."'>".$row['site_name']."</option>";
			     }
		    ?>
		  </select>
		  </div>
		  <label>Select a station photo to upload. Please provide unique filename.</label>
          <input type="file" name="file">
		  <label> Capture date
			<input type="date" value="capture_date" name="capture_date">
		  </label>
		  
          <input style = "background-color:#182850;border:none;border-radius:5px; color:white; padding:10px" type="submit" value="Upload" name="submit">
		  
        </form>
    </div-->  
  
        <h1><?php 
            if($uploadPost) {
                echo "<h1 class='caption2'>$statusMsg</h1>";
                #echo $target_file;
				#echo $fileType;
            } 
        ?>
		</h1>
 </div>     
    
</div>
</body>
</html>
	