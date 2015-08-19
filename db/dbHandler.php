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

		public function createUser($fbid, $fullname, $email) {
		    $sql = "INSERT INTO users (facebookId, userName, userEmail) VALUES (?,?,?);";
    		$result = $this->db->executeUpdate($sql, array($fbid, $fullname, $email));
    		return $result[0]; 
		}
		
		public function updateFbUser($fullname, $email, $fbid) {
		    $sql = "UPDATE users SET userName=?, userEmail=? WHERE facebookId = ?;";
    		$result = $this->db->executeUpdate($sql, array($fullname, $email, $fbid));
    		return $result[0];
		}
		
		public function getAccessLevel($fbid, $restaurantName) {
		    $sql = "SELECT userType FROM restaurantuser JOIN users ON restaurantuser.userId = users.userId WHERE facebookId=? AND resName=?";
    		$result = $this->db->executeQuery($sql, array($fbid,$restaurantName));
    		return $result[0][0];
		}

		public function addSitting($sittDate, $sittPrelDeadline, $sittPayDeadline, $restaurant, $spots) {
		    $sql = "INSERT INTO sitting (sittDate, sittPrelDeadline, sittPayDeadline, resName, spotsLeft) VALUES (?, ?, ?, ?, ?);";
    		$result = $this->db->executeUpdate($sql, array($sittDate, $sittPrelDeadline, $sittPayDeadlinel, $restaurant, $spots));
    		return $this->db->getLastId(); 
		}

		public function deleteSitting($sittId){
			$sql = "UPDATE sitting SET active = 0 WHERE sittId=?;";
		    $result = $this->db->executeUpdate($sql, array($sittId));
		    return count($result) == 1;  
		}
		  
		public function getSittings() {
			$sql = "SELECT * FROM sitting WHERE active = 1 ORDER BY sittDate";
			$result = $this->db->executeQuery($sql, array());
			return $this->arrarrSitting($result); // Structure: [ {'id', 'date', 'appetiser', 'main', 'desert', 'prelDay', 'payDay'} ]
		}

		public function getSitting($sittId) {
			$sql = "SELECT * FROM sitting WHERE sittId=?";
			$result = $this->db->executeQuery($sql, array($sittId));
			return $this->arrToSitting($result[0]);  // Structure: {'id', 'date', 'appetiser', 'main', 'desert', 'prelDay', 'payDay'}
		}

		public function getSittingForeman($sittId) {
			$sql = "SELECT * FROM sittingforeman WHERE sittId=?";
			$result = $this->db->executeQuery($sql, array($sittId));
			return $this->arrToSitting($result[0]);  // Structure: {'id', 'date', 'appetiser', 'main', 'desert', 'prelDay', 'payDay'}
		}

		public function getParties($sittId) {
			$sql = "SELECT * FROM party WHERE sittId=?";
			$result = $this->db->executeQuery($sql, array($sittId));
			return $this->arrarrParty($result); // Structure: [{ 'id', 'name', 'type', 'date', 'interest', 'prel', 'payed', 'interestOnly' }, ...]
		}

		public function getRestaurant($name){
			$sql = "SELECT * FROM restaurant WHERE resName=?";
			$result = $this->db->executeQuery($sql, array($name));
			return $this->arrToRes($result[0]);  // Structure: { 'name', 'email', 'openhours', 'deposit', 'price', 'size', 'summary' }
		}

		public function getResSize($name){
			$sql = "SELECT resSize FROM restaurant WHERE resName=?";
			$result = $this->db->executeQuery($sql, array($name));
			return $result[0][0];
		}
		

	}
?>