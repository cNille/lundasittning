<?php
	echo '1';
	require_once 'dbHandler.php';
	
	echo '2';
	if(isset($_POST['action']) && !empty($_POST['action'])) {
		echo '3';
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
			$dbHandler->addSitting($_POST['date']);
		}
	}
	
	function removeSitting($dbHandler){
		echo '4';
		if(isset($_POST['date']) && !empty($_POST['date'])) {
			echo '5';
			$dbHandler->deleteSitting($_POST['date']);
		}
	}
?>