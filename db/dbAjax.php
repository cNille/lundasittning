<?php
	require_once 'dbHandler.php';
	
	if(isset($_POST['action']) && !empty($_POST['action'])) {
		$dbHandler = new DatabaseHandler();
		$action = $_POST['action'];
	    
	    switch($action) {
	        case 'addSitting' : addSitting($dbHandler);break;
	        case 'removeSitting' : removeSitting($dbHandler);break;
	        case 'updateSettings' : updateSettings($dbHandler);break;
	    }
	    $dbHandler.disconnect();
	}

	function addSitting($dbHandler){
		if(isset($_POST['date']) && !empty($_POST['date'])) {
			echo $dbHandler->addSitting($_POST['date'], $_POST['preldate'], $_POST['paydate'], $_POST['resName'], $_POST['resSize']);
		}
	}
	
	function removeSitting($dbHandler){
		if(isset($_POST['id']) && !empty($_POST['id'])) {
			$dbHandler->deleteSitting($_POST['id']);
		}
	}
	
	function updateSettings($dbHandler){
		$dbHandler->updateEmail($_POST['userid'], $_POST['email']);
		$dbHandler->updatePhone($_POST['userid'], $_POST['telephone']);
		$dbHandler->updateOther($_POST['userid'], $_POST['other']);
	}
?>