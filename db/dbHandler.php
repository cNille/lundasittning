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
			$sql = "SELECT * FROM restaurant WHERE name=?";
			$result = $this->db->executeQuery($sql, array($name));
			return $this->arrToRes($result[0]);  // Structure: { 'name', 'email', 'openhours', 'deposit', 'price', 'size', 'summary' }
		}
		public function getResSize($name){
			$sql = "SELECT resSize FROM restaurant WHERE name=?";
			$result = $this->db->executeQuery($sql, array($name));
			return $result[0][0];
		}

		// Loginaccount
		// ======================================================
		public function fbidExists($fbid){
			$sql = "SELECT * FROM loginaccount WHERE fbid=?";
			$result = $this->db->executeQuery($sql, array($fbid));
			return count($result) == 1;
		}
		public function createLoginAccount($fbid, $email) {
		    $sql = "INSERT INTO loginaccount (fbid, email) VALUES (?,?);";
    		$result = $this->db->executeUpdate($sql, array($fbid, $email));
    		return $this->db->getLastId(); 
		}
		public function updateEmail($id, $email) {
		    $sql = "UPDATE loginaccount SET email=? WHERE id = ?;";
    		$result = $this->db->executeUpdate($sql, array($email, $id));
    		return $result[0];
		}
		public function updatePhone($id, $phone) {
		    $sql = "UPDATE loginaccount SET telephone=? WHERE id = ?;";
    		$result = $this->db->executeUpdate($sql, array($phone, $id));
    		return $result[0];
		}
		public function getSettings($fbid) {
			$sql = "SELECT * FROM participantlogin WHERE fbid=?";
			$result = $this->db->executeQuery($sql, array($fbid));
			return $result[0];
		}

		// Participant
		// ======================================================
        public function createParticipant($name, $other, $loginaccount){
            $sql = "INSERT INTO participant (name, other) VALUES (?,?)";
            $result = $this->db->executeUpdate($sql, array($name, $other));
    		return $this->db->getLastId(); 
        }
        public function getParticipants($resName) {
            $sql = "SELECT p.id, p.name, p.email, p.telephone, r.resName, r.userType FROM participantlogin as p JOIN restaurantparticipant as r ON p.id=r.participantId WHERE r.resName=? ORDER BY p.name;";
            $result = $this->db->executeQuery($sql, array($resName));
            return $result;
        }
        public function updateName($name, $participantId) {
            $sql = "UPDATE participant SET name=? WHERE id=?;";
            $result = $this->db->executeUpdate($sql, array($name, $participantId));
            return $result[0];
        }
        public function updateOther($id, $other) {
            $sql = "UPDATE participant SET other=? WHERE id = ?;";
            $result = $this->db->executeUpdate($sql, array($other, $id));
            return $result[0];
        }

		// Participantlogin
		// ======================================================
        public function getUser($fbid) {
            $sql = "SELECT * FROM participantlogin WHERE fbid = ?;";
            $result = $this->db->executeQuery($sql, array($fbid));
            return $result[0];
        }

		// UserType
		// ======================================================
		public function getAccessLevel($fbid, $resName) {
		    $sql = "SELECT ut.accessLevel FROM restaurantparticipant as rp JOIN participantlogin as p ON rp.participantId = p.id JOIN usertype as ut ON rp.userType=ut.userType WHERE p.fbid=? AND rp.resName=?";
    		$result = $this->db->executeQuery($sql, array($fbid, $resName));
    		return $result[0][0];
		}
		public function getAccessLevelById($id, $resName) {
		    $sql = "SELECT ut.accessLevel FROM restaurantparticipant as r JOIN participant as p ON r.participantId=p.id JOIN usertype as ut ON r.userType=ut.userType WHERE p.id=? AND r.resName=?";
    		$result = $this->db->executeQuery($sql, array($id,$resName));
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

		// restaurantparticipant
		// ======================================================
		public function updateUserType($usertype, $participantid, $resname) {
			$sql = "update restaurantparticipant set usertype=? where participantid=? and resname=?";
    		$result = $this->db->executeupdate($sql, array($usertype, $participantid, $resname));
    		return $result;
		}

		// foodpref
		// ======================================================
		public function getallfoodpref() {
			$sql = "select * from foodpref";
			$result = $this->db->executequery($sql, array());
			return $result;
		}

		// userfood
		// ======================================================
		public function getMyFoodPref($participantid) {
			$sql = "select foodpref from participantfood where participantid=?";
			$result = $this->db->executequery($sql, array($participantid));
			return $result;
		}
		public function addParticipantFood($participantid, $food) {
		    $sql = "insert into participantfood values (?,?);";
    		$result = $this->db->executeupdate($sql, array($participantid, $food));
    		return $result[0];
		}
		public function clearParticipantFood($participantid) {
		    $sql = "delete from participantfood where participantid=?;";
    		$result = $this->db->executeupdate($sql, array($participantid));
    		return $result[0];
		}

		// Sitting
		// ======================================================
		public function addSitting($sittDate, $sittPrelDeadline, $sittPayDeadline, $restaurant) {
		    $sql = "INSERT INTO sitting (sittDate, prelDeadline, payDeadline, resName) VALUES (?, ?, ?, ?);";
    		$result = $this->db->executeUpdate($sql, array($sittDate, $sittPrelDeadline, $sittPayDeadlinel, $restaurant));
    		return $this->db->getLastId(); 
		}
		public function deleteSitting($sittId){
			$sql = "UPDATE sitting SET active = 0 WHERE id=?;";
		    $result = $this->db->executeUpdate($sql, array($sittId));
		    return count($result) == 1;  
		} 
		public function getSittings($active) {
			$sql = "SELECT id, sittDate, active FROM sitting WHERE active=? AND sittDate >= NOW();";
			$result = $this->db->executeQuery($sql, array($active));
			return $result; 
		}
		public function getSittingsSpots($active) {
			$sql = "SELECT s.id, count(*) as spots FROM sitting as s JOIN party as p JOIN partyparticipant as pp WHERE s.active=? AND s.id=p.sittId AND p.id=pp.partyId GROUP BY s.id";
			$result = $this->db->executeQuery($sql, array($active));
			return $result; 
		}
		public function getSitting($sittId) {
			$sql = "SELECT * FROM sitting WHERE id=?";
			$result = $this->db->executeQuery($sql, array($sittId));
			return $this->arrToSitting($result[0]);  // Structure: {'id', 'date', 'appetiser', 'main', 'desert', 'prelDay', 'payDay'}
		}

        public function updateAppetiser($sittId, $appetiser) {
            $sql = "UPDATE sitting SET appetiser=? WHERE id = ?;";
            $result = $this->db->executeUpdate($sql, array($appetiser, $sittId));
        }
        public function updateMain($sittId, $main) {
            $sql = "UPDATE sitting SET main=? WHERE id = ?;";
            $result = $this->db->executeUpdate($sql, array($main, $sittId));
        }
        public function updateDesert($sittId, $desert) {
            $sql = "UPDATE sitting SET desert=? WHERE id = ?;";
            $result = $this->db->executeUpdate($sql, array($desert, $sittId));
        }



		// Sittingforeman
		// ======================================================
		public function getSittingForeman($sittId) {
			$sql = "SELECT p.name, p.id FROM sittingforeman as sf JOIN participant as p WHERE sf.participantId = p.id AND sf.sittId=?";
			$result = $this->db->executeQuery($sql, array($sittId));
			return $result; 
		}
        public function isSittingForeman($sittId, $pId){
            $sql = "SELECT * FROM sittingforeman WHERE sittId=? AND participantId=?";
            $result = $this->db->executeQuery($sql, array($sittId, $pId));
            return count($result) == 1;
        }
		public function getSittingForemanFromRes($resName) {
			$sql = "SELECT p.id, p.name FROM participant as p WHERE p.id IN (SELECT participantId FROM restaurantparticipant WHERE resName=? AND userType='Sittningsförman');";
			$result = $this->db->executeQuery($sql, array($resName));
			return $result; 
		}

		public function setSittingForeman($sittId, $participantId) {
			$sql = "INSERT INTO sittingforeman VALUES (?,?);";
			$result = $this->db->executeUpdate($sql, array($sittId, $participantId));
			return $result; 
		}

		public function removeSittingForeman($sittId, $participantId) {
			$sql = "DELETE FROM sittingforeman WHERE sittId=? AND participantId=?;";
			$result = $this->db->executeUpdate($sql, array($sittId, $participantId));
			return $result; 
		}


		// Party
		// ======================================================
		public function getParty($partyId) {
			$sql = "SELECT * FROM party WHERE id=?";
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
		public function getPartiesPayStatus($sittId) {
			$sql = "SELECT p.id, p.sittId, pp.participantPayed, count(*) as Count FROM party as p JOIN partyparticipant as pp WHERE p.sittId=? AND p.id=pp.partyId GROUP BY p.id, pp.participantPayed";
			$result = $this->db->executeQuery($sql, array($sittId));
			return $result;
		}
		public function createParty($name, $type, $sittId, $int, $msg, $key) {
		    $sql = "INSERT INTO party (name, partyType, sittId, interest, message, urlkey) VALUES (?, ?, ?, ?, ?, ?);";
    		$result = $this->db->executeUpdate($sql, array($name, $type, $sittId, $int, $msg, $key));
    		return $this->db->getLastId(); 
		}
		public function updatePartyMsg($pId, $msg){
		    $sql = "UPDATE party SET message=? WHERE id=?;";
    		$result = $this->db->executeUpdate($sql, array($msg, $pId));
    		return $result[0];		
		}
		public function updatePartyInterest($pId, $interest){
		    $sql = "UPDATE party SET interest=? WHERE id=?;";
    		$result = $this->db->executeUpdate($sql, array($interest, $pId));
    		return $result[0];		
		}

		// Partytype
		// ======================================================


		// Partycreator
		// ======================================================
		public function getCreator($partyId) {
			$sql = "SELECT p.id, p.name, p.email, p.telephone FROM partycreator as pc JOIN participantlogin as p ON p.id=pc.participantId WHERE pc.partyId=?";
			$result = $this->db->executeQuery($sql, array($partyId));
			return $result[0]; 
		}
		public function createPartyCreator($partyId, $participantId) {
		    $sql = "INSERT INTO partycreator (partyId, participantId) VALUES (?, ?);";
    		$result = $this->db->executeUpdate($sql, array($partyId, $participantId));
    		return $this->db->getLastId(); 
		}


		// Partyparticipant
		// ======================================================
		public function getPartiesByParticipant($participantId) {
			$sql = "SELECT * FROM partyparticipant WHERE participantId=?";
			$result = $this->db->executeQuery($sql, array($participantId));
			return $result;
		}
		public function getPartyParticipantFromSitting($sittId) {
			$sql = "SELECT p.name, u.id, u.name, pp.participantPayed FROM party as p JOIN partyparticipant as pp JOIN participant as u WHERE p.id=pp.partyId AND u.id=pp.participantId AND p.sittId=?";
			$result = $this->db->executeQuery($sql, array($sittId));
            return $result;
		}
		public function getPartyParticipant($partyId) {
			$sql = "SELECT p.id, p.name, pp.participantPayed FROM partyparticipant as pp JOIN participant as p ON p.id=pp.participantId WHERE pp.partyId=?";
			$result = $this->db->executeQuery($sql, array($partyId));
			return $this->arrarrGuest($result); // Structure: [ {'id', 'name', 'foodpref', payed}, ...]
		}
		public function addPartyParticipant($partyId, $participantId) {
		    $sql = "INSERT INTO partyparticipant (partyId, participantId, participantPayed) VALUES (?, ?, 'Nej');";
    		$result = $this->db->executeUpdate($sql, array($partyId, $participantId));
    		return $this->db->getLastId(); 
		}
		public function isParticipating($partyId, $participantId) {
			$sql = "SELECT * FROM partyparticipant WHERE partyId=? AND participantId=?";
			$result = $this->db->executeQuery($sql, array($partyId, $participantId));
			return count($result) == 1;
		}
        public function updateParticipantPayStatus($participant, $party, $paystatus){
            $sql = "UPDATE partyparticipant SET participantPayed=? WHERE participantId=? AND partyId=?";
            $result = $this->db->executeUpdate($sql, array($paystatus, $participant, $party));
            return $result;
        }
		public function getParticipantPayedStatus($participant, $party){
            $sql = "SELECT participantPayed FROM partyparticipant WHERE participantId=? AND partyId=?";
            $result = $this->db->executeQuery($sql, array($participant, $party));
            return $result[0];
        }


		// Paystatus
		// ======================================================
        public function getPayStatus($accesslevel){
            $sql = "SELECT * FROM paystatus WHERE accesslevel <= ?;";
            $result = $this->db->executeQuery($sql, array($accesslevel));
            return $result;
        }

        public function getPayAccessLevel($status){
            $sql = "SELECT accesslevel FROM paystatus WHERE status=?;";
            $result = $this->db->executeQuery($sql, array($status));
            return $result[0][0];
        }

		// Log
		// ======================================================


		// Event
		// ======================================================


	}
?>
