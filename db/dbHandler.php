<?php
	require_once 'dbconfig.php'; 
	require_once 'database.php';
 	$db = new Database(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	$db->openConnection();

	if(!$db->isConnected()) {
		header("Location: cannotConnect.php");
		exit();
	}
	

	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];
	    switch($action) {
	        case 'addEvent' : addEvent();break;
	        case 'blah' : blah();break;
	        // ...etc...
	    }
	}


	$sittings = $db->getSittings();
	

	function addEvent(){


	}
	


	$db->closeConnection();
?>