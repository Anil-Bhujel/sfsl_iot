<?php 
  class thcPost {
    // DB stuff
    private $conn;
    private $table = 'thc_data';
   
    // Post Properties
    public $id;
	public $site_id;
    public $sensor_id;
    public $data_date;
	public $data_time;
    public $temperature;
	public $humidity;
	public $CO2;


    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

   // Insert sensor data
    public function create() {
          // Create query
          $query = 'INSERT INTO '. $this->table .' SET site_id = :site_id, sensor_id = :sensor_id, data_date = :data_date, data_time = :data_time, temperature = :temperature, humidity = :humidity, CO2 = :CO2';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

        
          // Bind data
		  $stmt->bindParam(':site_id', $this->site_id);
          $stmt->bindParam(':sensor_id', $this->sensor_id);
          $stmt->bindParam(':data_date', $this->data_date);
		  $stmt->bindParam(':data_time', $this->data_time);
          $stmt->bindParam(':temperature',$this->temperature);
          $stmt->bindParam(':humidity', $this->humidity);
		  $stmt->bindParam(':CO2', $this->CO2);
          
          // Execute query
          if($stmt_result = $stmt->execute()) {
            #return true;
			return $stmt_result;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }
    
    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table ;
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }
    
   
    
  }