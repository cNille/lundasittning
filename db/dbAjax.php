<?php
	require_once 'dbHandler.php'; 
 
	
	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];
	    switch($action) {
	        case 'addSitting' : addSitting();break;
	        case 'removeSitting' : removeSitting();break;
	    }
	}

	$dbHandler = new DatabaseHandler();

	function addSitting(){
		if(isset($_POST['date']) && !empty($_POST['date'])) {
			$dbHandler->addSitting($_POST['date']);
		}
	}
	
	function removeSitting(){
		if(isset($_POST['date']) && !empty($_POST['date'])) {
			$dbHandler->deleteSitting($_POST['date']);
		}
	}
	

	$dbHandler.disconnect();
?>