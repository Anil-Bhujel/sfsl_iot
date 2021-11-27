<?php 
  class imagePost {
    // DB stuff
    private $conn;
    private $table = 'image_data';
   
    // Post Properties
    public $image_id;
	public $expt_id;
    public $file_name;
    public $capture_date;
	public $upload_date;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

   // Insert sensor data
    public function create() {
          // Create query
          $query = 'INSERT INTO '. $this->table .' SET expt_id = :expt_id, file_name = :file_name, capture_date = :capture_date, upload_date = :upload_date';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

        
          // Bind data
		  $stmt->bindParam(':expt_id', $this->expt_id);
          $stmt->bindParam(':file_name', $this->file_name);
          $stmt->bindParam(':capture_date', $this->capture_date);
		  $stmt->bindParam(':upload_date', $this->upload_date);
         
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