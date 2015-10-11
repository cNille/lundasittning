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

	if($_POST['bookSpot']){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$foodpref = $_POST['foodpref'];
		$phone = $_POST['phone'];
		$other = $_POST['other'];
		$guestMode = $_POST['guestMode'];
		$partyId = $_POST['partyId'];
		$partyKey = $_POST['partyKey'];

		if(!$guestMode){
			$userId = $_POST['userId'];
			// Update email if it was specified
			if($email && $email != ''){
				$dbHandler->updateEmail($userId, $email);
			}
			// Update email if it was specified
			if($phone && $phone != ''){
				$dbHandler->updatePhone($userId, $phone);
			}
			// Update other if it was specified
			if($other && $other != ''){
				$dbHandler->updateOther($userId, $other);
			}
			// Remove all foodpreferences to this user and add all those checked now.
			$dbHandler->clearUserFood($userId);
			foreach ($foodpref as $key => $f) {
				$dbHandler->addUserFood($userId, $f);
			}

			// Add user to partyguest list.
			$semExist = $dbHandler->addPartyGuest($partyId, $userId);
		} else{
			$_SESSION['LAST_PAGE'] = '../index.php';
			$semExist = $dbHandler->addGuest($name, $partyId, $foodpref);
		}
		header("Location: party.php?partyKey=" . $partyKey);
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
	
	if($_POST['updateSettings']){
		$email = $_POST['email'];
		$foodpref = $_POST['foodpref'];
		$phone = $_POST['phone'];
		$other = $_POST['other'];
		
		$userId = $_POST['userId'];
		// Update email if it was specified
		if($email && $email != ''){
			$dbHandler->updateEmail($userId, $email);
		}
		// Update email if it was specified
		if($phone && $phone != ''){
			$dbHandler->updatePhone($userId, $phone);
		}
		// Update other if it was specified
		if($other && $other != ''){
			$dbHandler->updateOther($userId, $other);
		}
		// Remove all foodpreferences to this user and add all those checked now.
		$dbHandler->clearUserFood($userId);
		foreach ($foodpref as $key => $f) {
			$dbHandler->addUserFood($userId, $f);
		}
		header("Location: http://localhost:8888/NILLEFRANZTEST/sittning/index.php?status=saved");
		return;
	}
	return;

 	// Close database.
	$dbHandler->disconnect();

	// Redirect back to index.
	header("Location: index.php");
?>