<?php
try{
  if(!session_id()) {
      session_start();
  }
  // Get FB thingys
  require_once '../vendor/autoload.php';
  require_once __DIR__.'/../env/config.php';
  // init app with app id and secret
  $appid = '';
  $secret = '';
  if($_SERVER['HTTP_HOST'] == "lundasittning.se" || $_SERVER['HTTP_HOST'] == "www.lundasittning.se"){
    $appid = $fbappid;
    $secret = $fbsecret;
  } else {
    $appid = $fbtestappid;
    $secret = $fbtestsecret;
  }
  $fb = new Facebook\Facebook([
    'app_id' => $appid,
    'app_secret' => $secret,
    'default_graph_version' => 'v2.5',
  ]);

    // Callback file
    $helper = $fb->getRedirectLoginHelper();
    
    try {
      $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
    
    if (! isset($accessToken)) {
      if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
      } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
      }
      exit;
    }
  
    // Logged in
    //echo '<h3>Access Token</h3>';
    //var_dump($accessToken->getValue());
    
    // The OAuth 2.0 client handler helps us manage access tokens
    $oAuth2Client = $fb->getOAuth2Client();
    
    // Get the access token metadata from /debug_token
    $tokenMetadata = $oAuth2Client->debugToken($accessToken);
    //echo '<h3>Metadata</h3>';
    //var_dump($tokenMetadata);
  
    // Validation (these will throw FacebookSDKException's when they fail)
            
    $tokenMetadata->validateAppId($appid); // Replace {app-id} with your app id

    // If you know the user ID this access token belongs to, you can validate it here
    //$tokenMetadata->validateUserId('123');
    $tokenMetadata->validateExpiration();
  
    if (! $accessToken->isLongLived()) { // Exchanges a short-lived access token for a long-lived one
      try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
      } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
        exit;
      }
      //echo '<h3>Long-lived</h3>';
      //var_dump($accessToken->getValue());
    }
    
    $_SESSION['fb_access_token'] = (string) $accessToken;

    // Get user data.
    try {
      // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get('/me?fields=id,name', $accessToken);
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
    $user = $response->getGraphUser();

    //echo 'Name: ' . $user['name'];
    //echo 'id: ' . $user['id'];
    //echo 'email: ' . $user['email'];
    $_SESSION['FBID'] = $user['id'];           
    $_SESSION['FULLNAME'] = $user['name'];
    $_SESSION['EMAIL'] =  $user['email'];

    // Redirect user back to previous page.
    if( $lastpage != null && $lastpage != ''){
      if(substr( $lastpage, 0, 2 ) === ".."){
        $address = $redir . '/sallskap' . substr( $lastpage, 2, 12);
      } else {
        $address = $lastpage;
      }
      $_SESSION['LAST_PAGE'] = '';
    } else {
       $address = $redir . "/";
    }
    $redir = '';

    header("Location: " . $address);

} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// Not used now...
function goToLogin(){
  // Login
  $helper = $fb->getRedirectLoginHelper();
  $permissions = ['email']; // Optional permissions
  $loginUrl = $helper->getLoginUrl('http://www.lundasittning.se/facebook/callback.php', $permissions);
  header("Location: ". $loginUrl);
  exit;
}
?>
