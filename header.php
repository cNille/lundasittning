<?php
	
	session_start(); 
	require_once 'db/dbHandler.php';
	require_once 'accessLevelCheck.php';

	 
	$loggedIn = false;
	
	$dbHandler = new DatabaseHandler();	
	$restaurant = $dbHandler->getRestaurant('Nilles nation'); // Variable determines nation
	
	if($_SESSION['FBID'] && $_SESSION['FBID'] != null){
		$loggedIn = true;
		$fbid = $_SESSION['FBID'];
		$fbFullname = $_SESSION['FULLNAME'];
		$fbGender = $_SESSION['GENDER'];
		$fbEmail = $_SESSION['EMAIL'] == NULL ? " " : $_SESSION['EMAIL'];
	}

	// Copy this code to every page where accesslevel is required.
	requireAccessLevel(0, $dbHandler->getAccessLevel($fbid, $restaurant->name));

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
?>
<!doctype html>

<html>
	<head>
		<title> Sittningsbokning </title>
		<link rel="stylesheet" type="text/css" href="css/main.css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href='http://fonts.googleapis.com/css?family=Josefin+Sans:400,100' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<script>
			var RESTAURANT_NAME = '<?php echo $restaurant->name ?>';
			var RESTAURANT_SIZE = '<?php echo $restaurant->size ?>';
		</script>


