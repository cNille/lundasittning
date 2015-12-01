<?php 
    $nation = $_GET['nation'];


	if($_SERVER['HTTP_HOST'] == "www.lundasittning.se"){
    	$siteURL = "http://$_SERVER[SERVER_NAME]";
    	$nationURL = "http://$_SERVER[SERVER_NAME]/$nation"; 
	} else {
	    $siteURL = "http://$_SERVER[SERVER_NAME]:8000/sittning";
	    $nationURL = "http://$_SERVER[SERVER_NAME]:8000/sittning/$nation";
	}
?>