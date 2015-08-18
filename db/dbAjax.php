<?php
	echo '1';
	require_once 'dbHandler.php';
	
	echo '2';
	if(isset($_POST['action']) && !empty($_POST['action'])) {
		
	echo '3';
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
		echo '4';
		if(isset($_POST['date']) && !empty($_POST['date'])) {
			echo '5';
			$dbHandler->deleteSitting($_POST['date']);
		}
	}
	

	$dbHandler.disconnect();
?>