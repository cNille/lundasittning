<?php
	session_start(); 
	require_once 'db/dbHandler.php';

	$loggedIn = false;
	
	$resName = 'Nilles nation';
	$dbHandler = new DatabaseHandler();	
	$restaurant = $dbHandler->getRestaurant($resName); // Variable determines nation
	
	if($_SESSION['FBID'] && $_SESSION['FBID'] != null){
		$loggedIn = true;
		$fbid = $_SESSION['FBID'];
		$fbFullname = $_SESSION['FULLNAME'];
		$fbGender = $_SESSION['GENDER'];
		$fbEmail = $_SESSION['EMAIL'] == NULL ? " " : $_SESSION['EMAIL'];
	}

	// Copy this code to every page where a certain accesslevel is required.
	$myAccessLevel = $dbHandler->getAccessLevel($fbid, $restaurant->name);
	//requireAccessLevel(0, $myAccessLevel);

	$userExists = $dbHandler->fbidExists($fbid);
	if($userExists){
		$user = $dbHandler->getUser($fbid);
	}
	if($loggedIn && !$userExists && $fbid != null){
		$dbHandler->createUser($fbid, $fbFullname, $fbEmail);
	}
	else if($userExists){
		$dbHandler->updateFbUser($fbFullname, $fbid);
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