<?php
	session_start(); 
	require_once 'database/dbHandler.php';
	require_once 'link.php';

	$loggedIn = false;
	
	$dbHandler = new DatabaseHandler();	
	$n = strtolower($nation);
	$restaurant = $dbHandler->getRestaurantFromNickname($n); // Variable determines nation

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

    // Add userType if it doesnt exist.
    $myUserType = $dbHandler->getUserType($user[0], $restaurant[0]);
    if( $myUserType != "" ){
      $dbHandler->addUserType('Användare', $user[0], $restaurant[0]);
    }
	}
	if($loggedIn && !$userExists && $fbid != null){
		$loginId = $dbHandler->createLoginAccount($fbid, $fbEmail);
    $pId = $dbHandler->createParticipant($fbFullname, "", $loginId);
    $dbHandler->addUserType('Användare', $pId, $restaurant[0]);
	} else if($userExists){
		$dbHandler->updateName($fbFullname, $user[0]);
	} 

	$dbHandler->disconnect();
	
	$_SESSION['LAST_PAGE'] = $_SERVER["HTTP_REFERER"];


	// Redirect if the accesslevel is below the required accesslevel.
	function requireAccessLevel( $reqAccess, $access ){
		$isIndex = basename($_SERVER['PHP_SELF']) == 'index.php';
		if($access < $reqAccess && !$isIndex){ 
			echo "<script>window.location = 'index.php';</script>";
		}
		return $access;
	}
?>
