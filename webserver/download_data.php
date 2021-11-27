<?php

include_once("config.php");

session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['login_user'])) {
	header('Location: login');
	exit;
}

$sensor_list = Array();
$sensor_type = Array();

// set default date and timezone
date_default_timezone_set('Asia/Seoul');

if(isset($_POST['download']))
{	 
    $site_select = $_POST['site_id'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	//$site_select = 9;

	$q_sitename = "SELECT site_name FROM site WHERE site_id='$site_select'";
	$result = mysqli_query($db,$q_sitename);
	
	while($row=mysqli_fetch_assoc($result)) {
		$site_name = $row['site_name'];
	}
	
	// Query sensor list
	$sensor_data = "SELECT sensor_id, sensor_type FROM sensor WHERE site_id='$site_select'";
	$sensor_result = mysqli_query($db,$sensor_data);
	
	while($row = mysqli_fetch_assoc($sensor_result)) {
		$sensor_list[] = $row['sensor_id'];
		$sensor_type[] = $row['sensor_type'];
		
	}
	
	$file_name = $site_name."_data_from_".$start_date."_to_".$end_date.".csv";
	
	header('Content-Type: text/csv; charset=utf-8');  
	header('Content-Disposition: attachment; filename='.$file_name);  
	$output = fopen("php://output", "w"); 
			
	if(sizeof($sensor_list)>1)
	{
		if($sensor_type[0]=='THC')
		{
			/*
			$file_name = $site_name."_sensor1_thc_data_from_".$start_date."_to_".$end_date.".csv";
			
			header('Content-Type: text/csv; charset=utf-8');  
			header('Content-Disposition: attachment; filename='.$file_name);  
			$output = fopen("php://output", "w"); 
			*/
			//$download_date = date("Y-m-d H:M");
			
			//fputscsv($output, array('Downloaded at ".$download_date." local time'));
			
			fputcsv($output, array('Site name',$site_name, 'Start Date', $start_date, 'End Date', $end_date));
			
			fputcsv($output, array('sensor_id','Date', 'Time', 'Temperature', 'Humidity', 'CO2'));  
			$download_query = "SELECT sensor_id,data_date,data_time,temperature,humidity,CO2 FROM thc_data WHERE site_id = '$site_select' AND sensor_id='$sensor_list[0]' AND data_date BETWEEN '$start_date' AND '$end_date' ORDER BY data_date ASC, data_time ASC";  
			$download_result = mysqli_query($db, $download_query);  
			while($row_data = mysqli_fetch_array($download_result,MYSQLI_ASSOC)) {  
				   fputcsv($output, $row_data);  
			  }  
			  //fclose($output); 
			 
		}
		elseif($sensor_type[0]=='AQ')
		{
			/*
			$file_name = $site_name."_sensor1_aq_data_from_".$start_date."_to_".$end_date.".csv";
		
			header('Content-Type: text/csv; charset=utf-8');  
			header('Content-Disposition: attachment; filename='.$file_name);  
			$output = fopen("php://output", "w"); 
			*/
			//$download_date = date("Y-m-d H:M");
			
			//fputscsv($output, array('Downloaded at ".$download_date." local time'));
			
			fputcsv($output, array('Site name',$site_name, 'Start Date', $start_date, 'End Date', $end_date));
			
			fputcsv($output, array('sensor_id','Date', 'Time', 'Temperature', 'Humidity', 'Pressure','Oxidised','Reduced','NH3','Lux','PM1','PM2.5','PM10'));  
			$download_query = "SELECT sensor_id,data_date,data_time,temperature,humidity,pressure,oxidised,reduced,nh3,lux,pm1,pm25,pm10 FROM aq_data WHERE site_id = '$site_select' AND sensor_id='$sensor_list[1]' AND data_date BETWEEN '$start_date' AND '$end_date' ORDER BY data_date ASC, data_time ASC";  
			$download_result = mysqli_query($db, $download_query);  
			while($row_data = mysqli_fetch_array($download_result,MYSQLI_ASSOC)) {  
				   fputcsv($output, $row_data);  
			  }  
			  //fclose($output); 
			 
		}
		
		fputcsv($output, array('','',''));
		fputcsv($output, array('','',''));
		
		if($sensor_type[1]=='THC')
		{
			/*
			$file_name = $site_name."_sensor2_thc_data_from_".$start_date."_to_".$end_date.".csv";
			
			header('Content-Type: text/csv; charset=utf-8');  
			header('Content-Disposition: attachment; filename='.$file_name);  
			$output = fopen("php://output", "w"); 
			*/
			//$download_date = date("Y-m-d H:M");
			
			//fputscsv($output, array('Downloaded at ".$download_date." local time'));
			
			fputcsv($output, array('Site name',$site_name, 'Start Date', $start_date, 'End Date', $end_date));
			
			fputcsv($output, array('sensor_id','Date', 'Time', 'Temperature', 'Humidity', 'CO2'));  
			$download_query = "SELECT sensor_id,data_date,data_time,temperature,humidity,CO2 FROM thc_data WHERE site_id = '$site_select' AND sensor_id='$sensor_list[1]' AND data_date BETWEEN '$start_date' AND '$end_date' ORDER BY data_date ASC, data_time ASC";  
			$download_result = mysqli_query($db, $download_query);  
			while($row_data = mysqli_fetch_array($download_result,MYSQLI_ASSOC)) {  
				   fputcsv($output, $row_data);  
			  }  
			  //fclose($output); 
			 
		}
		elseif($sensor_type[1]=='AQ')
		{
			/*
			$file_name = $site_name."_sensor2_aq_data_from_".$start_date."_to_".$end_date.".csv";
		
			header('Content-Type: text/csv; charset=utf-8');  
			header('Content-Disposition: attachment; filename='.$file_name);  
			$output = fopen("php://output", "w"); 
			*/
			//$download_date = date("Y-m-d H:M");
			
			//fputscsv($output, array('Downloaded at ".$download_date." local time'));
			
			fputcsv($output, array('Site name',$site_name, 'Start Date', $start_date, 'End Date', $end_date));
			
			fputcsv($output, array('sensor_id','Date', 'Time', 'Temperature', 'Humidity', 'Pressure','Oxidised','Reduced','NH3','Lux','PM1','PM2.5','PM10'));  
			$download_query = "SELECT sensor_id,data_date,data_time,temperature,humidity,pressure,oxidised,reduced,nh3,lux,pm1,pm25,pm10 FROM aq_data WHERE site_id = '$site_select' AND sensor_id='$sensor_list[1]' AND data_date BETWEEN '$start_date' AND '$end_date' ORDER BY data_date ASC, data_time ASC";  
			$download_result = mysqli_query($db, $download_query);  
			while($row_data = mysqli_fetch_array($download_result,MYSQLI_ASSOC)) {  
				   fputcsv($output, $row_data);  
			  }  
			 // fclose($output); 
			 
		}
	}
	
	else
	{
		if($sensor_type[0]=='THC')
		{
			/*
			$file_name = $site_name."_sensor1_thc_data_from_".$start_date."_to_".$end_date.".csv";
			
			header('Content-Type: text/csv; charset=utf-8');  
			header('Content-Disposition: attachment; filename='.$file_name);  
			$output = fopen("php://output", "w"); 
			*/
			//$download_date = date("Y-m-d H:M");
			
			//fputscsv($output, array('Downloaded at ".$download_date." local time'));
			
			fputcsv($output, array('Site name',$site_name, 'Start Date', $start_date, 'End Date', $end_date));
			
			fputcsv($output, array('sensor_id','Date', 'Time', 'Temperature', 'Humidity', 'CO2'));  
			$download_query = "SELECT sensor_id,data_date,data_time,temperature,humidity,CO2 FROM thc_data WHERE site_id = '$site_select' AND data_date BETWEEN '$start_date' AND '$end_date' ORDER BY data_date ASC, data_time ASC";  
			$download_result = mysqli_query($db, $download_query);  
			while($row_data = mysqli_fetch_array($download_result,MYSQLI_ASSOC)) {  
				   fputcsv($output, $row_data);  
			  }  
			 // fclose($output); 
			 
		}
		elseif($sensor_type[0]=='AQ')
		{
			/*
			$file_name = $site_name."_sensor1_aq_data_from_".$start_date."_to_".$end_date.".csv";
		
			header('Content-Type: text/csv; charset=utf-8');  
			header('Content-Disposition: attachment; filename='.$file_name);  
			$output = fopen("php://output", "w"); 
			*/
			//$download_date = date("Y-m-d H:M");
			
			//fputscsv($output, array('Downloaded at ".$download_date." local time'));
			
			fputcsv($output, array('Site name',$site_name, 'Start Date', $start_date, 'End Date', $end_date));
			
			fputcsv($output, array('sensor_id','Date', 'Time', 'Temperature', 'Humidity', 'Pressure','Oxidised','Reduced','NH3','Lux','PM1','PM2.5','PM10'));  
			$download_query = "SELECT sensor_id,data_date,data_time,temperature,humidity,pressure,oxidised,reduced,nh3,lux,pm1,pm25,pm10 FROM aq_data WHERE site_id = '$site_select' AND data_date BETWEEN '$start_date' AND '$end_date' ORDER BY data_date ASC, data_time ASC";  
			$download_result = mysqli_query($db, $download_query);  
			while($row_data = mysqli_fetch_array($download_result,MYSQLI_ASSOC)) {  
				   fputcsv($output, $row_data);  
			  }  
			  //fclose($output); 
			 
		}
		 
	}
	fclose($output);
}


?>