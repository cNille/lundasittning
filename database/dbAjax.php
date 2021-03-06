<?php
	require_once '../loginCheck.php';
	
	if(isset($_POST['action']) && !empty($_POST['action'])) {
		$dbHandler = new DatabaseHandler();
		$action = $_POST['action'];
	    
	    switch($action) {
	        case 'addSitting' : addSitting($dbHandler, $user);break;
	        case 'removeSitting' : removeSitting($dbHandler, $user);break;
	        case 'updateSettings' : updateSettings($dbHandler);break;
	        case 'addGuestList' : addGuestList($dbHandler, $user, $myAccessLevel);break;
	    }
	    $dbHandler.disconnect();
	}

	function addSitting($dbHandler, $user){
		if(isset($_POST['date']) && !empty($_POST['date'])) {
			echo $dbHandler->addSitting($_POST['date'], $_POST['resName'], $user[0]);
		}
	}
	
	function removeSitting($dbHandler, $user){
		if(isset($_POST['id']) && !empty($_POST['id'])) {
			echo $dbHandler->deleteSitting($_POST['id'], $user[0], $restaurant[0]);
		}
	}
    
	function updateSettings($dbHandler){
		$dbHandler->updateEmail($_POST['userid'], $_POST['email']);
		$dbHandler->updatePhone($_POST['userid'], $_POST['telephone']);
		$dbHandler->updateOther($_POST['userid'], $_POST['other']);
	}
	
	function addGuestList($dbHandler, $user, $accessLevel){
        $partyId = $_POST["partyId"];
        
        $creator = $dbHandler->getCreator($partyId);
        $isCreator = $user[0] == $creator[0];

        if($isCreator || $accessLevel >= 5){
            $json = $_POST["guestList"];
            $guestList = json_decode($json);

            foreach($guestList as $key => $g){
                $guestId = $dbHandler->createParticipant($g->name, $g->other);

                $foodStr = trim($g->preferens);
                $foodpref = explode(",", $foodStr);
                
                // Remove all foodpreferences to this user and add all those checked now.
                foreach ($foodpref as $key => $f) {
                    if($f != ""){
                        $dbHandler->addParticipantFood($guestId, trim($f));
                    }
                }

                // Add user to partyguest list.
                $dbHandler->addPartyParticipant($partyId, $guestId, $restaurant[0]);
            }
            $party = $dbHandler->getParty($partyId);
            echo $party->key;
        } else {
            echo "notCreator";
        }
	}
?>
