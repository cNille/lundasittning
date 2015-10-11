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

		// Restaurant
		// ======================================================
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

		// Users
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
		public function updateFbUser($fullname, $fbid) {
		    $sql = "UPDATE users SET userName=? WHERE facebookId = ?;";
    		$result = $this->db->executeUpdate($sql, array($fullname, $fbid));
    		return $result[0];
		}
		public function updateUserContact($id, $email, $telephone) {
		    $sql = "UPDATE users SET userTelephone=?, userEmail=? WHERE userId = ?;";
    		$result = $this->db->executeUpdate($sql, array($telephone, $email, $id));
    		return $result[0];
		}
		public function updateEmail($id, $email) {
		    $sql = "UPDATE users SET userEmail=? WHERE userId = ?;";
    		$result = $this->db->executeUpdate($sql, array($email, $id));
    		return $result[0];
		}
		public function updatePhone($id, $phone) {
		    $sql = "UPDATE users SET userTelephone=? WHERE userId = ?;";
    		$result = $this->db->executeUpdate($sql, array($phone, $id));
    		return $result[0];
		}
		public function updateOther($id, $other) {
		    $sql = "UPDATE users SET userOther=? WHERE userId = ?;";
    		$result = $this->db->executeUpdate($sql, array($other, $id));
    		return $result[0];
		}
		public function getUser($fbid) {
		    $sql = "SELECT * FROM users WHERE facebookId = ?;";
    		$result = $this->db->executeQuery($sql, array($fbid));
    		return $result[0];
		}
		public function getUsers($resName) {
		    $sql = "SELECT u.userId, u.userName, u.userEmail, u.userTelephone, ru.resName, ru.userType FROM users as u JOIN restaurantuser as ru ON u.userId=ru.userId WHERE ru.resName=? ORDER BY userName;";
    		$result = $this->db->executeQuery($sql, array($resName));
    		return $result;
		}
		public function getSettings($fbid) {
			$sql = "SELECT * FROM users WHERE facebookId=?";
			$result = $this->db->executeQuery($sql, array($fbid));
			return $this->arrToUser($result[0]); // Structure: {'id', 'fbid', 'name', 'email', 'telephone', 'other', 'active'}
		}

		// Guestuser
		// ======================================================
		public function addGuest($name, $partyId, $foodpref) {
		    $sql = "INSERT INTO guestuser (guestName, partyId, guestFoodPref) VALUES (?,?,?);";
    		$result = $this->db->executeUpdate($sql, array($name, $partyId, $foodpref));
    		return $result[0]; 
		}
		public function getPartyGuests($partyId) {
			$sql = "SELECT * FROM guestuser WHERE partyId=?";
			$result = $this->db->executeQuery($sql, array($partyId));
			return $result;
		}

		// UserType
		// ======================================================
		public function getAccessLevel($fbid, $restaurantName) {
		    $sql = "SELECT ut.accessLevel FROM restaurantuser as ru JOIN users as u ON ru.userId = u.userId JOIN usertype as ut ON ru.userType=ut.userType WHERE u.facebookId=? AND ru.resName=?";
    		$result = $this->db->executeQuery($sql, array($fbid,$restaurantName));
    		return $result[0][0];
		}
		public function getAccessLevelById($id, $restaurantName) {
		    $sql = "SELECT ut.accessLevel FROM restaurantuser as ru JOIN users as u ON ru.userId = u.userId JOIN usertype as ut ON ru.userType=ut.userType WHERE u.userId=? AND ru.resName=?";
    		$result = $this->db->executeQuery($sql, array($id,$restaurantName));
    		return $result[0][0];
		}

		public function getUserTypes($level) {
		    $sql = "SELECT * from usertype WHERE accessLevel < ?";
    		$result = $this->db->executeQuery($sql, array($level));
    		return $result;
		}

		public function getLevelOfUserType($userType) {
		    $sql = "SELECT * from usertype WHERE userType=?";
    		$result = $this->db->executeQuery($sql, array($userType));
    		return $result[0][1];
		}

		// Restaurantuser
		// ======================================================
		public function updateUserType($userType, $userId, $resName) {
			$sql = "UPDATE restaurantuser SET userType=? WHERE userId=? AND resName=?";
    		$result = $this->db->executeUpdate($sql, array($userType, $userId, $resName));
    		return $result;
		}

		// Foodpref
		// ======================================================
		public function getAllFoodpref() {
			$sql = "SELECT * FROM foodpref";
			$result = $this->db->executeQuery($sql, array());
			return $result;
		}

		// Userfood
		// ======================================================
		public function getMyFoodpref($userId) {
			$sql = "SELECT foodPref FROM userfood WHERE userId=?";
			$result = $this->db->executeQuery($sql, array($userId));
			return $result;
		}
		public function addUserFood($userId, $food) {
		    $sql = "INSERT INTO userfood VALUES (?,?);";
    		$result = $this->db->executeUpdate($sql, array($userId, $food));
    		return $result[0];
		}
		public function clearUserFood($userId) {
		    $sql = "DELETE FROM userfood where userId=?;";
    		$result = $this->db->executeUpdate($sql, array($userId));
    		return $result[0];
		}



		// Sitting
		// ======================================================
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
			$sql = "SELECT * FROM sitting WHERE active = 1 AND sittDate >= CURRENT_DATE() ORDER BY sittDate";
			$result = $this->db->executeQuery($sql, array());
			return $this->arrarrSitting($result); // Structure: [ {'id', 'date', 'appetiser', 'main', 'desert', 'prelDay', 'payDay'} ]
		}
		public function getSitting($sittId) {
			$sql = "SELECT * FROM sitting WHERE sittId=?";
			$result = $this->db->executeQuery($sql, array($sittId));
			return $this->arrToSitting($result[0]);  // Structure: {'id', 'date', 'appetiser', 'main', 'desert', 'prelDay', 'payDay'}
		}

		// Sittingforeman
		// ======================================================
		public function getSittingForeman($sittId) {
			$sql = "SELECT userName, users.userId FROM sittingforeman join users WHERE sittingforeman.userId = users.userId AND sittingforeman.sittId=?";
			$result = $this->db->executeQuery($sql, array($sittId));
			return $result; 
		}

		public function getSittingForemanFromRes($resName) {
			$sql = "SELECT u.userId, u.userName FROM users as u WHERE u.userId IN (SELECT s.userId FROM sittingforeman as s) AND u.userId IN (SELECT r.userId FROM restaurantuser as r WHERE resName=?);";
			$result = $this->db->executeQuery($sql, array($resName));
			return $result; 
		}

		public function setSittingForeman($sittId, $userId) {
			$sql = "INSERT INTO sittingforeman VALUES (?,?);";
			$result = $this->db->executeUpdate($sql, array($sittId, $userId));
			return $result; 
		}

		public function removeSittingForeman($sittId, $userId) {
			$sql = "DELETE FROM sittingforeman WHERE sittId=? AND userId=?;";
			$result = $this->db->executeUpdate($sql, array($sittId, $userId));
			return $result; 
		}


		// Party
		// ======================================================
		public function getParty($partyId) {
			$sql = "SELECT * FROM party WHERE partyId=?";
			$result = $this->db->executeQuery($sql, array($partyId));
			return $this->arrToParty($result[0]);  // Structure: {'id', 'name', 'type','sittId', 'interest', 'prel','payed', 'interestOnly' }
		}
		public function getPartyFromKey($partyKey) {
			$sql = "SELECT * FROM party WHERE urlkey=?";
			$result = $this->db->executeQuery($sql, array($partyKey));
			return $this->arrToParty($result[0]);  // Structure: {'id', 'name', 'type','sittId', 'interest', 'prel','payed', 'interestOnly' }
		}
		public function getParties($sittId) {
			$sql = "SELECT * FROM party WHERE sittId=?";
			$result = $this->db->executeQuery($sql, array($sittId));
			return $this->arrarrParty($result); // Structure: [{ 'id', 'name', 'type', 'date', 'interest', 'prel', 'payed', 'interestOnly' }, ...]
		}
		public function createParty($name, $type, $sittId, $int, $msg, $key) {
		    $sql = "INSERT INTO party (partyName, partyType, sittId, partyInterest, partyMessage, urlkey) VALUES (?, ?, ?, ?, ?, ?);";
    		$result = $this->db->executeUpdate($sql, array($name, $type, $sittId, $int, $msg, $key));
    		return $this->db->getLastId(); 
		}
		public function updatePartyMsg($pId, $msg){
		    $sql = "UPDATE party SET partyMessage=? WHERE partyId = ?;";
    		$result = $this->db->executeUpdate($sql, array($msg, $pId));
    		return $result[0];		
		}

		// Partytype
		// ======================================================


		// Partycreator
		// ======================================================
		public function getCreator($partyId) {
			$sql = "SELECT users.userId, users.userName, users.userEmail, users.userTelephone FROM partycreator JOIN users ON users.userId=partycreator.userId WHERE partycreator.partyId=?";
			$result = $this->db->executeQuery($sql, array($partyId));
			return $result[0]; // Structure: username, email, telephone
		}
		public function createPartyCreator($partyId, $userId) {
		    $sql = "INSERT INTO partycreator (partyId, userId) VALUES (?, ?);";
    		$result = $this->db->executeUpdate($sql, array($partyId, $userId));
    		return $this->db->getLastId(); 
		}


		// Partyguest
		// ======================================================
		public function getPartiesByUser($userId) {
			$sql = "SELECT * FROM partyguest WHERE userId=?";
			$result = $this->db->executeQuery($sql, array($userId));
			return $result;
		}
		public function getPartyUsers($partyId) {
			$sql = "SELECT users.userId, users.userName, partyguest.userPayed FROM partyguest JOIN users ON users.userId=partyguest.userId WHERE partyguest.partyId=?";
			$result = $this->db->executeQuery($sql, array($partyId));
			return $this->arrarrGuest($result); // Structure: [ {'id', 'name', 'foodpref', payed}, ...]
		}
		public function addPartyGuest($partyId, $userId) {
		    $sql = "INSERT INTO partyguest (partyId, userId) VALUES (?, ?);";
    		$result = $this->db->executeUpdate($sql, array($partyId, $userId));
    		return $this->db->getLastId(); 
		}
		public function isParticipating($partyId, $userId) {
			$sql = "SELECT * FROM partyguest WHERE partyId=? AND userId=?";
			$result = $this->db->executeQuery($sql, array($partyId, $userId));
			return count($result) == 1;
		}


		// Log
		// ======================================================


		// Event
		// ======================================================


	}
?>