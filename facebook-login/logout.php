<?php 
session_start();
require_once "../loginCheck.php";

if(isset($_SESSION['LAST_PAGE'])){
  $address = $_SESSION['LAST_PAGE'];
  $_SESSION['LAST_PAGE'] = NULL;
} else{
   $address = $siteURL;
}


session_unset();
$_SESSION['FBID'] = NULL;
$_SESSION['FULLNAME'] = NULL;
$_SESSION['EMAIL'] =  NULL;

header("Location: $address"); 
?>
