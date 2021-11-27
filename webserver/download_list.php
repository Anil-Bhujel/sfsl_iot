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

if(isset($_POST['list_download']))
{	 
    $category = $_POST['category'];
	
	if($category == "site") {
		header('Content-Type: text/csv; charset=utf-8');  
		header('Content-Disposition: attachment; filename=site_list.csv');  
		$output = fopen("php://output", "w"); 
		
		//$download_date = date("Y-m-d H:M");
		
		//fputscsv($output, array('Downloaded at ".$download_date." local time'));
		
		fputcsv($output, array('Site name','Site address', 'Latitude', 'Longitude', 'Altitude', 'Description'));  
		$download_query = "SELECT site_name,site_address,latitude,longitude,altitude,description FROM site";  
		
		$download_result = mysqli_query($db, $download_query);  
		while($row_data = mysqli_fetch_array($download_result,MYSQLI_ASSOC)) {  
			   fputcsv($output, $row_data);  
		  }  
		  fclose($output); 
	}
	
	elseif($category == "sensor") {
		header('Content-Type: text/csv; charset=utf-8');  
		header('Content-Disposition: attachment; filename=sensor_list.csv');  
		$output = fopen("php://output", "w"); 
		
		//$download_date = date("Y-m-d H:M");
		
		//fputscsv($output, array('Downloaded at ".$download_date." local time'));
		
		fputcsv($output, array('Sensor name','Sensor model', 'Sensor type', 'Install date', 'Site ID', 'Unique ID','Status'));  
		$download_query = "SELECT sensor_name,sensor_model,sensor_type,installed_date,site_id,uniqueID,status FROM sensor";  
		
		$download_result = mysqli_query($db, $download_query);  
		while($row_data = mysqli_fetch_array($download_result,MYSQLI_ASSOC)) {  
			   fputcsv($output, $row_data);  
		  }  
		  fclose($output); 
	}
	else {
	
		header('Content-Type: text/csv; charset=utf-8');  
		header('Content-Disposition: attachment; filename=actuator_list.csv');  
		$output = fopen("php://output", "w"); 
		
		//$download_date = date("Y-m-d H:M");
		
		//fputscsv($output, array('Downloaded at ".$download_date." local time'));
		
		fputcsv($output, array('Site ID','Actuator name', 'Location', 'Install date'));  
		$download_query = "SELECT site_id,actuator_name,location,install_date FROM actuator";  
		$download_result = mysqli_query($db, $download_query);  
		while($row_data = mysqli_fetch_array($download_result,MYSQLI_ASSOC)) {  
			   fputcsv($output, $row_data);  
		  }  
		  fclose($output); 
	}
}


?>