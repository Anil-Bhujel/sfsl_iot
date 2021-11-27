<?php

include_once("config.php");

session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['login_user'])) {
	header('Location: login');
	exit;
}

// set default date and timezone
date_default_timezone_set('Asia/Seoul');

if(isset($_POST['download']))
{	 
    $image_view = true;
	 // Retrieve the form data
	 $site_select = $_POST['site_id'];
	 $start_date = $_POST['start_date'];
	 $end_date = $_POST['end_date'];
	 
	 // Read site name
	 $query_sitename = "SELECT site_name FROM site WHERE site_id='$site_select'";
	 $sitename_result = mysqli_query($db,$query_sitename);
	 
	 $row = mysqli_fetch_assoc($sitename_result);
	 $sitename = $row['site_name'];
	 
	 //Read the images of selected site
	 $query_photo = "SELECT * FROM image_data WHERE site_id='$site_select' AND capture_date BETWEEN '$start_date' and '$end_date' ORDER BY capture_date ASC";
	 $photo_result = mysqli_query($db,$query_photo);
	
	 while($rows= mysqli_fetch_assoc($photo_result)) {
		$imgURL[] = 'http://sfsl.gnu.ac.kr/data/image_data/'.$sitename.'/'.$rows['file_name'];
		$filenames[] = $rows['file_name'];
	}
	if(mysqli_num_rows($photo_result)> 0) {
    
		$statusMsg = 0;
		/*
		for($i=0;$i<sizeof($imgURL);$i++) {
		
			$tmpFile = tempnam('/tmp', '');

			$zip = new ZipArchive;
			$zip->open($tmpFile, ZIPARCHIVE::CREATE);
			foreach ($imgURL as $file) {
				// download file
				$fileContent = file_get_contents($file);

				$zip->addFromString(basename($file), $fileContent);
			}
			//$zip->close();

			header('Content-Type: application/zip');
			header('Content-disposition: attachment; filename='.$sitename.'.zip');
			header('Content-Length: ' . filesize($tmpFile));
			readfile($tmpFile);

			unlink($tmpFile);
			$zip->close();
		}*/
		$tmpFile = tempnam('/tmp', '');

		$zip = new ZipArchive;
		$zip->open($tmpFile, ZIPARCHIVE::CREATE);
		foreach ($imgURL as $file) {
			// download file
			$fileContent = file_get_contents($file);

			$zip->addFromString(basename($file), $fileContent);
		}
		$zip->close();

		header('Content-Type: application/zip');
		header('Content-disposition: attachment; filename='.$sitename.'.zip');
		header('Content-Length: ' . filesize($tmpFile));
		readfile($tmpFile);
		
		unlink($tmpFile);
		
		
	}
	else {
		$imgs = 0;
		$statusMsg = "No image(s) found in the selected site and dates. Please go back and select again.";
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
 
<!--ul>
  <li><a class="active" href="home_page"><i class="fas fa-home"></i> Home</a></li>
  <li><a href="live_data"><i class="fas fa-chart-line"></i> Numeric Data</a></li>
  <li><a href="view_image"><i class="fas fa-image"></i> Image Data</a></li>
  <li><a href="log"><i class="fas fa-clipboard-list"></i> Log</a></li>
  <li><a href="download"><i class="fas fa-download"></i> Download</a></li>  
  <li><a href="signout"><i class="fas fa-sign-out-alt"></i> Signout</a></li>
</ul-->

</div>
<div class = "container">
	<div class="station">
		<?php 
			if(!$imgs) {
				echo $statusMsg;
				echo "<a href='view_image'><input type='submit' value='Go Back'></a>";
			}
		?>
	</div>
</div>
</body>
</html>		