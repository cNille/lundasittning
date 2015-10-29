<?php 
	require_once 'init.php';

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
			$dbHandler->addPartyGuest($partyId, $userId);
		} else{
			$_SESSION['LAST_PAGE'] = '../index.php';
			$dbHandler->addGuest($name, $partyId, $foodpref);
		}
		header("Location: party.php?partyKey=" . $partyKey);
		return;
	}




	// Needs to be logged in to access methods below
	// ======================================================================================================
	if(!$loggedIn){
		header("Location: index.php");
		return;
	}



	if($_POST['updateUserType']){
		$users = $_POST['user'];
		$userType = $_POST['userType'];
		$accessLevel = $dbHandler->getLevelOfUserType($userType);

		if($accessLevel < $myAccessLevel){
			foreach ($users as $key => $u) {
				$userAccessLevel = $dbHandler->getAccessLevelById($u, $resName);
				if($userAccessLevel < $myAccessLevel){
					$dbHandler->updateUserType($userType, $u, $resName);
				}
			}
		}		
		header("Location: users.php");
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
		header("Location: index.php?status=saved");
		return;
	}
	if($_POST['updatePartyMsg']){
		$msg = $_POST['message'];
		$uId = $user[0];
		$pId = $_POST['partyId'];
		$party = $dbHandler->getParty($pId);
		$creator = $dbHandler->getCreator($pId);
		$isCreator = $creator[0] == $user[0];
		if($isCreator){
			$dbHandler->updatePartyMsg($pId, $msg);
		}
		header("Location: party.php?partyKey=$party->key");
		return;		
	}

    if($_POST['partyUpdatePay']){
        $paystatus = $_POST['payStatus'];
        $userIds = $_POST['userId'];
        $guestIds = $_POST['guestId'];
        $partykey = $_POST['partykey'];
        $partyid = $_POST['partyid'];
        $reqAccessLevel = $dbHandler->getPayAccessLevel($paystatus);
        
        if($myAccessLevel >= $reqAccessLevel){
            foreach($userIds as $key => $u){
        		$oldPayStatus = $dbHandler->getUserPayedStatus($u, $partyid);
        		$oldReqAccessLevel = $dbHandler->getPayAccessLevel($oldPayStatus);
        		if($myAccessLevel >= $oldReqAccessLevel){
	                $dbHandler->updateUserPayStatus($u, $partyid, $paystatus);
	            }
            } 
            foreach($guestIds as $key => $g){
            	$oldPayStatus = $dbHandler->getUserPayedStatus($u, $partyid);
        		$oldReqAccessLevel = $dbHandler->getPayAccessLevel($oldPayStatus);
        		if($myAccessLevel >= $oldReqAccessLevel){
	                $dbHandler->updateGuestPayStatus($g, $partyid, $paystatus);
				}
            } 
        }
        header("Location: ./$partykey");
        return;
    }

    if($_POST['updateSittingMenu']){
        $appetiser = $_POST['appetiser'];
        $main = $_POST['main'];
        $desert = $_POST['desert'];
        $sittId = $_POST['sittId'];        
        $sittForeman = $dbHandler->isSittingForeman($sittId, $user[0]);
        
        if($sittForeman || $myAccessLevel >= 5){

            
            header("Location: sitting.php?sittId=$sittId");
            return;		
        }       
    }

	if($_POST['addSittingForeman']){
		$sittId = $_POST['sittId'];
		$user = $_POST['user'];

		if($myAccessLevel >= 5){
			$foreman = $dbHandler->getSittingForeman($sittId);
			$isSittingForeman = false;
			foreach ($foreman as $key => $f) {
				if($f[1] == $user){
					$isSittingForeman = true;
				}
			}
			if (!$isSittingForeman){
				$dbHandler->setSittingForeman($sittId, $user);
			}
		}
	
		header("Location: sitting.php?sittId=$sittId");
		return;		
	}
	if($_POST['removeSittingForeman']){
		$sittId = $_POST['sittId'];
		$user = $_POST['user'];

		if($myAccessLevel >= 5){
			$dbHandler->removeSittingForeman($sittId, $user);
		}
	
		header("Location: sitting.php?sittId=$sittId");
		return;		
	}


 	// Close database.
	$dbHandler->disconnect();

	// Redirect back to index.
	header("Location: index.php");
?>
