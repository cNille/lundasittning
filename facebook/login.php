<?php
  if(!session_id()) {
    session_start();
  }
  require_once __DIR__.'/../env/config.php';
  require_once '../vendor/autoload.php';

  $appid = '';
  $secret = '';
  if($_SERVER['HTTP_HOST'] == "lundasittning.se" || $_SERVER['HTTP_HOST'] == "www.lundasittning.se"){
    $appid = $fbappid;
    $secret = $fbsecret;
  } else {
    $appid = $fbtestappid;
    $secret = $fbtestsecret;
  }

  // Get FB thingys
  $fb = new Facebook\Facebook([
    'app_id' => $appid,
    'app_secret' => $secret,
    'default_graph_version' => 'v2.5',
  ]);

  // Save lastpage
  $lastpage = $_SESSION["LAST_PAGE"];
  $redir = $_SESSION['FB_REDIRECT'];
  // Save redirect link.
  if( $redir == null && $redir == '' ){
    $redir = $nationURL;
    $_SESSION['FB_REDIRECT'] = $redir;
  }


  // Login
  $helper = $fb->getRedirectLoginHelper();

  $permissions = ['email']; // Optional permissions
  $loginUrl = $helper->getLoginUrl('http://www.lundasittning.se/facebook/callback.php', $permissions);
  header("Location: ". $loginUrl);
?>
