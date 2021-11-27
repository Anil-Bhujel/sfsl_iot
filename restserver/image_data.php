<?php

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");
#header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once 'Database.php'; // include database connection file
include_once 'imagePost.php';

if(!empty($_GET['expt-id'])) {
    $expt_id = $_GET['expt-id'];
	$data = json_decode(file_get_contents("php://input"), true); // collect input parameters and convert into readable format
		
	$fileName  =  $_FILES['sendimage']['name'];
	$tempPath  =  $_FILES['sendimage']['tmp_name'];
	$fileSize  =  $_FILES['sendimage']['size'];
	
	$capture_date = '';
	
	#echo json_encode(array("filename" => $fileName, "temppath" => $tempPath, "filesize" => $fileSize));
	
	$capture_date = !empty($capture_date) ? "'$capture_date'" : NULL;
	
	// Instantiate DB & connect
	$database = new Database();
	$db = $database->connect();
	
	// Instantiate data post object
	$post = new imagePost($db);
	
	if(empty($fileName))
	{
		$errorMSG = json_encode(array("message" => "please select image", "status" => false));	
		echo $errorMSG;
	}
	else
	{
		$root_dir = "image root dir";
		
		$target_dir = $root_dir.'expt_'.$expt_id."/"; // set upload folder path 
		
		if( is_dir($target_dir) === false )
		{
			mkdir($target_dir);
		}
		
		$fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get image extension
			
		// valid image extensions
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); 
						
		// allow valid image file formats
		if(in_array($fileExt, $valid_extensions))
		{				
			//check file not exist our upload folder path
			if(!file_exists($target_dir.$fileName))
			{
				// check file size '5MB'
				if($fileSize < 5000000){
					move_uploaded_file($tempPath, $target_dir . $fileName); // move file from system temporary path to our upload folder path 
				}
				else{		
					$errorMSG = json_encode(array("message" => "Sorry, your file is too large, please upload 5 MB size", "status" => false));	
					echo $errorMSG;
				}
			}
			else
			{		
				$errorMSG = json_encode(array("message" => "Sorry, file already exists check upload folder", "status" => false));	
				echo $errorMSG;
			}
		}
		else
		{		
			$errorMSG = json_encode(array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed", "status" => false));	
			echo $errorMSG;		
		}
	}
			
	// if no error caused, continue ....
	if(!isset($errorMSG))
	{
		#$query = mysqli_query($conn,'INSERT into tbl_image (name) VALUES("'.$fileName.'")');
		$upload_date = date("Y-m-d"); 
		
		$post->expt_id = $expt_id;
		$post->file_name = $fileName;
		$post->capture_date = $capture_date;
		$post->upload_date = $upload_date;
		
		#$insert_query = "INSERT into image_data (expt_id,file_name,capture_date,upload_date) VALUES ('$expt_id','$fileName',$capture_date,'$upload_date')";
        #$insert_result = mysqli_query($db,$insert_query);
		
		// Create post
		if($post_status = $post->create()) 
		{
			$statusMsg = "An image of filename ".$fileName. " has been uploaded successfully.";
			echo json_encode(
				array( 'message'=> $statusMsg,"status" => true)
				);
		} 
		else 
		{
			$statusMsg = $post_status;
			echo json_encode(
				array('message' => $statusMsg,
							'status'=>false)
				);
		}
		
	}
}

?>