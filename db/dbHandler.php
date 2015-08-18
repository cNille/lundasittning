<?php
	require_once 'dbconfig.php'; 
	require_once 'database.php';
	require_once 'dataConverter.php';
	
	class DatabaseHandler extends DataConverter {
		private $db;

		public function __construct() {
			$this->db = new Database(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			$this->connect();
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

		// Here are all the methods for retrieving and updating data.
		// ======================================================

		public function fbidExists($fbid){
			$sql = "SELECT userName FROM users WHERE facebookId=?";
			$result = $this->db->executeQuery($sql, array($fbid));
			return count($result) == 1;
		}

		public function createUser($fbid, $fullname) {
		    $sql = "INSERT INTO users (facebookId, userName) VALUES (?,?);";
    		$result = $this->db->executeUpdate($sql, array($fbid, $fullname));
    		return $result[0]; 
		}

		public function addSitting($sittDate, $sittPrelDeadline, $sittPayDeadline, $restaurant) {
		    $sql = "INSERT INTO sitting (sittDate, sittPrelDeadline, sittPayDeadline, resName) VALUES (?, ?, ?, ?);";
    		$result = $this->db->executeUpdate($sql, array($sittDate, $sittPrelDeadline, $sittPayDeadlinel, $restaurant));
    		return $result[0]; 
		}

		public function deleteSitting($sittDate){
		$sql = "UPDATE sitting SET active = 0 WHERE sittDate=?;";
		    $result = $this->db->executeUpdate($sql, array($sittDate));
		    return count($result) == 1;  
		}
		  
		public function getSittings() {
			$sql = "SELECT * FROM sitting ORDER BY sittDate";
			$result = $this->db->executeQuery($sql, array());
			return $result; 
		}

		public function getSitting($sittDate) {
			$sql = "SELECT * FROM sitting WHERE sittDate=?";
			$result = $this->db->executeQuery($sql, array($sittDate));
			return $this->arrToSitting($result[0]);  // Structure: {'date', 'appetiser', 'main', 'desert', 'prelDay', 'payDay'}
		}

		public function getParties($sittDate) {
			$sql = "SELECT * FROM party WHERE sittingDate=?";
			$result = $this->db->executeQuery($sql, array($sittDate));
			return $this->arrarrParty($result); // Structure: [{ 'id', 'name', 'type', 'date', 'interest', 'prel', 'payed', 'interestOnly' }, ...]
		}

		public function getRestaurant($name){
			$sql = "SELECT * FROM restaurant WHERE resName=?";
			$result = $this->db->executeQuery($sql, array($name));
			return $this->arrToRes($result[0]);  // Structure: { 'name', 'email', 'openhours', 'deposit', 'price', 'size', 'summary' }
		}
		

	}
?>