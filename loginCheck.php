<?php
	session_start(); 
	require_once 'db/dbHandler.php';

	$loggedIn = false;
	
	$resName = 'Nilles nation';
	//$resName = 'Malins nation';
	//$resName = 'Franz nation';
	$dbHandler = new DatabaseHandler();	
	$restaurant = $dbHandler->getRestaurant($resName); // Variable determines nation
	
	if($_SESSION['FBID'] && $_SESSION['FBID'] != null){
		$loggedIn = true;
		$fbid = $_SESSION['FBID'];
		$fbFullname = $_SESSION['FULLNAME'];
		$fbGender = $_SESSION['GENDER'];
		$fbEmail = $_SESSION['EMAIL'] == NULL ? " " : $_SESSION['EMAIL'];
	}

	// Use this variabel where a certain accesslevel is required.
	$myAccessLevel = $dbHandler->getAccessLevel($fbid, $restaurant[0]);

	$userExists = $dbHandler->fbidExists($fbid);
	if($userExists){
		$user = $dbHandler->getUser($fbid);
	}
	if($loggedIn && !$userExists && $fbid != null){
		$loginId = $dbHandler->createLoginAccount($fbid, $fbFullname, $fbEmail);
        $dbHandler->createParticipant($fbFullName, "", $loginId);
	}
	else if($userExists){
		$dbHandler->updateName($fbFullname, $user[0]);
	}
	$dbHandler->disconnect();
	$_SESSION['LAST_PAGE'] = str_replace("/sittning", "..", $_SERVER['REQUEST_URI']);


	// Redirect if the accesslevel is below the required accesslevel.
	function requireAccessLevel( $reqAccess, $access ){
		$isIndex = basename($_SERVER['PHP_SELF']) == 'index.php';
		if($access < $reqAccess && !$isIndex){ 
			echo "<script>window.location = 'index.php';</script>";
		}
		return $access;
	}
?>
