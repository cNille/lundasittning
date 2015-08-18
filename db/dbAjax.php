<?php
	require_once 'dbHandler.php';
	
	if(isset($_POST['action']) && !empty($_POST['action'])) {
		$dbHandler = new DatabaseHandler();
		$action = $_POST['action'];
	    
	    switch($action) {
	        case 'addSitting' : addSitting($dbHandler);break;
	        case 'removeSitting' : removeSitting($dbHandler);break;
	    }
	    $dbHandler.disconnect();
	}

	function addSitting($dbHandler){
		if(isset($_POST['date']) && !empty($_POST['date'])) {
			$dbHandler->addSitting($_POST['date'], $_POST['preldate'], $_POST['paydate'], $_POST['resName']);
		}
	}
	
	function removeSitting($dbHandler){
		if(isset($_POST['date']) && !empty($_POST['date'])) {
			$dbHandler->deleteSitting($_POST['date']);
		}
	}
?>