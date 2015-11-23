<?php 
    $nation = $_GET['nation'];

	// Local
    $siteURL = "http://$_SERVER[SERVER_NAME]:8000/sittning";
    $nationURL = "http://$_SERVER[SERVER_NAME]:8000/sittning/$nation";

    // Live
    //$siteURL = "$_SERVER[HTTP_REFERER]";
    //$nationURL = "$_SERVER[HTTP_REFERER]/$nation";
?>