<?php
	
	session_start(); 
	require_once 'db/dbHandler.php';

	$loggedIn = false;
	if($_SESSION['FBID'] && $_SESSION['FBID'] != null){
		$loggedIn = true;
		$fbid = $_SESSION['FBID'];
		$fbFullname = $_SESSION['FULLNAME'];
		$fbUsername = $_SESSION['USERNAME'];
		$fbEmail = $_SESSION['EMAIL'] == NULL ? " " : $_SESSION['EMAIL'];
	}
		
	$dbHandler = new DatabaseHandler();	
	$restaurant = $dbHandler->getRestaurant('Franz nation'); // Change variable to change nation
	
	$userExists = $dbHandler->fbidExists($fbid);
	if($loggedIn && !$userExists && $fbid != null){
		$dbHandler->createUser($fbid, $fbFullname, $fbEmail);
	}
	else if($userExists){
		$dbHandler->updateFbUser($fbFullname, $fbEmail, $fbid);
		switch ($dbHandler->getAccessLevel($fbid, $restaurant->name)){
			case SuperAdmin: 
				blabla;
				break;
			case Quratel:
				blabla;
				break;
			case Sittningsförman:
				blabla;
				break;
			case Förman:
				blabla;
				break;
			default:
		}
	}
	$dbHandler->disconnect();
		
?>
<!doctype html>

<html>
	<head>
		<title> Sittningsbokning </title>
		<link rel="stylesheet" type="text/css" href="css/main.css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	</head>
	<body>
		<script>
			var RESTAURANT_NAME = '<?php echo $restaurant->name ?>';
			var RESTAURANT_SIZE = '<?php echo $restaurant->size ?>';
		</script>


		<div class="header">
			<button class="header-button" id="open-button" onclick="toggleSide()">Open Menu</button>
		</div>


