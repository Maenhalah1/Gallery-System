

<?php

class Database {

	private $conn;

	 function __construct() {
		$this->connection_DB();
	} 
	public function connection_DB () {
		try{

			$this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER,DB_PASS);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		}catch(PDOException $e){
			die("Connection Faild To Data Base " . $e->getMessage());
		}
	}
	public function query($sql,$values = null) {
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($values);
		$this->check_query($stmt);
		return $stmt;
	}
	private function check_query($stmt) {
		if(!$stmt) {
			die("Query Faild");
		}
	}
	public function last_id() {
	     return $this->conn->lastInsertId();
    }
}
$database = new database();
?>