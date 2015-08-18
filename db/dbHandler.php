<?php
	require_once 'dbconfig.php'; 
	require_once 'database.php';
	class DatabaseHandler{
		private $db;

		public function __construct() {
			$this->db = new Database(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		}
		public function connect(){
			$this->db->openConnection();
			if(!$this->db->isConnected()) {
				header("Location: cannotConnect.php");
				exit();
			}
		}
		public function disconnect(){
			$this->db->closeConnection();
		}

		/** 
		  * Here goes all the methods for retrieving and updating data.
		**/

		public function addSitting($sittDate) {
		    $sql = "INSERT INTO sitting (sittDate) VALUES (?);";
    		$result = $this->db->executeUpdate($sql, array($sittDate));
    		return $result[0]; 
		}

		public function deleteSitting($sittDate){
		  	$sql = "DELETE FROM sitting WHERE sittDate=?;";
		    $result = $this->db->executeUpdate($sql, array($sittDate));
		    return count($result) == 1;  
		}
		  
		public function getSittings() {
			$sql = "SELECT * FROM sitting ORDER BY sittDate";
			$result = $this->db->executeQuery($sql, array());
			return $result; 
		}

	}
?>