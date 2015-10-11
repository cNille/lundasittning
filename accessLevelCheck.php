<?php
	function accessLevel($level){
		switch ($level){
			case SuperAdmin: 
				$accessLevel = 10;
				break;
			case Quratel:
				$accessLevel = 5;
				break;
			case Sittningsförman:
				$accessLevel = 3;
				break;
			case Förman:
				$accessLevel = 2;
				break;
			default:
				$accessLevel = 1;		
		}
		return $accessLevel;
	}

	// Redirect if the accesslevel is below the required accesslevel.
	function requireAccessLevel( $reqAccess, $level ){
		$access = accessLevel($level);
		$isIndex = basename($_SERVER['PHP_SELF']) == 'index.php';
		if($access < $reqAccess && !$isIndex){ 
			echo "<script>window.location = 'index.php';</script>";
		}
	}
?>