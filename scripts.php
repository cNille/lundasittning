<?php 
	session_start(); 
	require_once 'db/dbHandler.php';

	function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	
	// Start up database.
 	$dbHandler = new DatabaseHandler();
 	
 	// Modify database before retrieving data.

	if($_POST['bookSpot']){
		$name = $_POST['name'];
		if(!$name || $name == ''){
			// Lös snyggare!
			echo '<script>window.history.back();</script>';
		}
		$email = $_POST['email'];
		$date = $_POST['date'];
		$phone = $_POST['phone'];
		$semExist = $dbHandler->partyBook($name, $email, $date, $phone);
		header("Location: index.php");
		return;
	}

	if($_POST['createInterestParty']){
		$userId = $_POST['userId'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$dbHandler->updateUserContact($userId, $email, $phone);

		$partyName = $_POST['partyName'];
		$type = 'Sluten';
		$sittId = $_POST['sittId'];
		$int = $_POST['interestedSpots'];
		$msg = $_POST['message'];
		$key = generateRandomString();
		$id = $dbHandler->createParty($partyName, $type, $sittId, $int, $msg, $key);
		$dbHandler->createPartyCreator($id, $userId);
		$dbHandler->addPartyGuest($id, $userId);
		header("Location: party.php?partyKey=" . $key);
		return;
	}
	return;

 	// Close database.
	$dbHandler->disconnect();

	// Redirect back to index.
	header("Location: index.php");
?>