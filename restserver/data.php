<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once 'Database.php';
  include_once 'thcPost.php';
  include_once 'errorPost.php';
  include_once 'Sensor.php';
  include_once 'testPost.php';
  include_once 'aqPost.php';
  
  // Get Sensor ID

  if(!empty($_GET['sensor-id'])) {
      $usid = $_GET['sensor-id'];
  
   // Instantiate DB & connect
      $database = new Database();
      $db = $database->connect();
      
    //Instantiate device check object
      $sensor = new Sensor($db);
      $sensor->uniqueID = $usid;
      
      // Reading registered device
     
      $result = $sensor->read();
      
      
      // Get row count
      $num = $result->rowCount();

  // Check if registered device found
      if($num > 0) {
     
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $siteID = $site_id;
			$sensorID = $sensor_id;
			$sensor_type = $sensor_type;
			$unique_id = $uniqueID;
			$sensor_status = $status;
            
        }
		 // Get raw posted data
        //   $data_64 = base64_decode(file_get_contents("php://input"));
        //   $data = json_decode($data_64);
            
          $rdata = json_decode(file_get_contents("php://input"));
          
        //   extracting sensor data
          $sensor_data = $rdata->data;
          
        // check whether sensor is in test or active mode
		  if($sensor_status=="active") {
			  if($sensor_type == 'THC')
			  {    
				  // Instantiate data post object
				  $post = new thcPost($db);
				  
				 // Instantiate error post object
				  $errpost = new errorPost($db); 
				  
				 
				  $post->temperature = $sensor_data->temp;
				  $post->humidity = $sensor_data->humid;
				  $post->CO2 = $sensor_data->CO2;
				  
				//   extracting timestamp
				  $ts = $rdata->timestamp;
				  //$date_time = $ts->date." ".$ts->time;
				  
				  $post->data_date = $ts->data_date;
				  $post->data_time = $ts->data_time;
				  
				/* important note
					Example #2 Accessing invalid object properties
					Accessing elements within an object that contain characters not permitted under PHP's naming convention (e.g. the hyphen) can be accomplished by encapsulating the element name within braces and the apostrophe.
					$json = '{"foo-bar": 12345}';
			
					$obj = json_decode($json);
					print $obj->{'foo-bar'}; // 12345
					source: https://www.php.net/manual/en/function.json-decode.php
				*/
				  
				  // Mapping values of sensor ID and site ID for data
				  $post->sensor_id = $sensorID;
				  $post->site_id = $siteID;
						   
			// Create post
				if($post->create()) 
				{
					echo json_encode(
						array( 'dataInserted'=> 1)
					 );
				} 
				else 
				{
					echo json_encode(
						array('dataInserted' => 0,
							'exception'=>$poststatus)
					);
				}
			 }
			 elseif($sensor_type == 'AQ')
			 {
				  // Instantiate data post object
				  $post = new aqPost($db);
				  
				 // Instantiate error post object
				  $errpost = new errorPost($db); 
				  
				 
				  $post->temperature = $sensor_data->temp;
				  $post->humidity = $sensor_data->humid;
				  $post->pressure = $sensor_data->pressure;
				  $post->oxidised = $sensor_data->oxidised;
				  $post->reduced = $sensor_data->reduced;
				  $post->nh3 = $sensor_data->nh3;
				  $post->lux = $sensor_data->lux;
				  $post->pm1 = $sensor_data->pm1;
				  $post->pm25 = $sensor_data->pm25;
				  $post->pm10 = $sensor_data->pm10;
				  
				//   extracting timestamp
				  $ts = $rdata->timestamp;
				  //$date_time = $ts->date." ".$ts->time;
				  
				  $post->data_date = $ts->data_date;
				  $post->data_time = $ts->data_time;
				  
				/* important note
					Example #2 Accessing invalid object properties
					Accessing elements within an object that contain characters not permitted under PHP's naming convention (e.g. the hyphen) can be accomplished by encapsulating the element name within braces and the apostrophe.
					$json = '{"foo-bar": 12345}';
			
					$obj = json_decode($json);
					print $obj->{'foo-bar'}; // 12345
					source: https://www.php.net/manual/en/function.json-decode.php
				*/
				  
				  // Mapping values of sensor ID and site ID for data
				  $post->sensor_id = $sensorID;
				  $post->site_id = $siteID;
						   
			// Create post
				if($poststatus = $post->create()) 
				{
					echo json_encode(
						array( 'dataInserted'=> 1)
					 );
				} 
				else 
				{
					echo json_encode(
						array('dataInserted' => 0,
							'exception'=>$poststatus)
					);
				}
			}
		  }
		  else {
			  // Instantiate test post object
			  $testpost = new testPost($db);
			  
			 // Instantiate error post object
			  $errpost = new errorPost($db); 
			  
			  if($sensor_type == 'THC')
			  {
				$testpost->temperature = $sensor_data->temp;
			    $testpost->humidity = $sensor_data->humid;
			    $testpost->CO2 = $sensor_data->CO2;
			    $testpost->pressure = 0;
			    $testpost->oxidised = 0;
				$testpost->reduced = 0;
			    $testpost->nh3 = 0;
				$testpost->lux = 0;
			    $testpost->pm1 = 0;
			    $testpost->pm25 = 0;
			    $testpost->pm10 = 0;  
			  }
			  
			  elseif($sensor_type == 'AQ')
			  {
			 
				$testpost->temperature = $sensor_data->temp;
				$testpost->humidity = $sensor_data->humid;
				$testpost->pressure = $sensor_data->pressure;
				$testpost->oxidised = $sensor_data->oxidised;
				$testpost->reduced = $sensor_data->reduced;
				$testpost->nh3 = $sensor_data->nh3;
				$testpost->lux = $sensor_data->lux;
				$testpost->pm1 = $sensor_data->pm1;
				$testpost->pm25 = $sensor_data->pm25;
				$testpost->pm10 = $sensor_data->pm10;
			  }
			  
			//   extracting timestamp
			  $ts = $rdata->timestamp;
			  //$date_time = $ts->date." ".$ts->time;
			  
			  $testpost->data_date = $ts->data_date;
			  $testpost->data_time = $ts->data_time;
			  
			/* important note
				Example #2 Accessing invalid object properties
				Accessing elements within an object that contain characters not permitted under PHP's naming convention (e.g. the hyphen) can be accomplished by encapsulating the element name within braces and the apostrophe.
				$json = '{"foo-bar": 12345}';
		
				$obj = json_decode($json);
				print $obj->{'foo-bar'}; // 12345
				source: https://www.php.net/manual/en/function.json-decode.php
			*/
			  
			  // Mapping values of sensor ID and site ID for data
			  $testpost->sensor_id = $sensorID;
			  $testpost->site_id = $siteID;
			  
			// Create post
				if($poststatus = $testpost->create()) 
				{
					echo json_encode(
						array( 'dataInserted'=> 1)
					 );
				} 
				else 
				{
					echo json_encode(
						array('dataInserted' => 0,
							'exception'=>$poststatus)
					);
				}
			  
		  }
	}
	else {
      echo json_encode(
          array('dataInserted'=>0,
                'exception' => "Sensor not in list")
        );
	}
      
  }
  
  else {
      echo json_encode(
          array("Message" => "Invalid request format")
        );
  }

