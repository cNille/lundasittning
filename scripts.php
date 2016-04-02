<?php 
	require_once 'loginCheck.php';


	function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	
	// Start up database.
 	$dbHandler = new DatabaseHandler();

	if($_POST['bookSpot']){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$foodpref = $_POST['foodpref'];
		$phone = $_POST['phone'];
		$other = $_POST['other'];
		$guestMode = $_POST['guestMode'];
		$partyId = $_POST['partyId'];
		$partyKey = $_POST['partyKey'];

		if(!$guestMode){
			$userId = $_POST['userId'];
			// Update if specified.
			if($email && $email != ''){ $dbHandler->updateEmail($userId, $email); }
			if($phone && $phone != ''){ $dbHandler->updatePhone($userId, $phone); }
			if($other && $other != ''){ $dbHandler->updateOther($userId, $other); }
		} else{
			$userId = $dbHandler->createParticipant($name, $other, NULL);
		}

		// Remove all foodpreferences to this user and add all those checked now.
		$dbHandler->clearParticipantFood($userId);
		foreach ($foodpref as $key => $f) {
			$dbHandler->addParticipantFood($userId, $f, NULL);
		}

		// Add user to partyguest list.
		$dbHandler->addPartyParticipant($partyId, $userId);

        $_SESSION['message'] = "Plats bokad.";
        
		header("Location: $nationURL/sallskap/$partyKey");
		return;
	}


	// Needs to be logged in to access methods below
	// ======================================================================================================
	if(!$loggedIn){
		header("Location: $siteURL");
		return;
	}


	if($_POST['updateUserType']){
    $_SESSION['message'] = "Användare uppdaterad.";

		$users = $_POST['user'];
		$userType = $_POST['userType'];
		$accessLevel = $dbHandler->getLevelOfUserType($userType);

		if($accessLevel <= $myAccessLevel){
			foreach ($users as $key => $u) {
				$userAccessLevel = $dbHandler->getAccessLevelById($u, $restaurant[0]);
				if($userAccessLevel < $myAccessLevel || $u == $user[0]){
					$dbHandler->updateUserType($userType, $u, $restaurant[0]);
				} else {
          $_SESSION['message'] = "Kan inte ändra användartyp på en användare av samma typ som dig.";
        }
			}
		}		
		header("Location: $nationURL/users.php");
		return;
	}

	if($_POST['sendFeedback']){
		$q = $_POST['question'];
		$email = $_POST['email'];
		$name = $_POST['name'];


		// Send email to SuperAdmins
    $superheroes = $dbHandler->getSuperAdmins();
    $to = "";
    foreach( $superheroes as $key => $super){
      if($key > 0){
        $to .= ',';
      }
      $to .= $super[2];
    }
		$link = $_SERVER['HTTP_REFERER'];
		$pos = strrpos($link, '/');
		$link = substr($link, 0, $pos+1);
   	$from = "info@lundasittning.se";
    
		ini_set("SMTP", "send.one.com");
   		ini_set("sendmail_from", $from);

   	$subject = "Lundasittning, fråga";
		$msg = "En fråga har inkommit från $name ($email)\r\n";
		$msg .= "Fråga:\r\n";
		$msg .= "$q\r\n";
		$msg = wordwrap($msg,70);

		$headers = "From: $from\r\nReply-To: $to\r\n";
		mail($to, $subject, $msg, $headers);

		header("Location: $nationURL/faq.php");
		return;
	}
	
	if($_POST['createInterestParty']){
		$userId = $_POST['userId'];
		$dbHandler->updateEmail($userId, $_POST['email']);
		$dbHandler->updatePhone($userId, $_POST['phone']);

		$partyName = $_POST['partyName'];
		$type = 'Sluten';
		$sittId = $_POST['sittId'];
		$int = $_POST['interestedSpots'];
		$msg = $_POST['message'];
		$key = generateRandomString();

    if($partyName == "" || $partyName == null){
      $partyName = "NO NAME";
    }

		$dbHandler->createParty($partyName, $type, $sittId, $int, $msg, $key, $user[0], $restaurant[0]);
		$p = $dbHandler->getPartyFromKey($key);

		
		$id = $p->id;
		$dbHandler->createPartyCreator($id, $userId, $restaurant[0]);
		$dbHandler->addPartyParticipant($id, $userId, $restaurant[0]);

		// Send email to Restaurant
   		$party = $dbHandler->getParty($id);
   		$sitting = $dbHandler->getSitting($party->sittId);
   		//$user = $dbHandler->getUser($userId);

		$link = $_SERVER['HTTP_REFERER'];
		$pos = strrpos($link, '/');
		$link = substr($link, 0, $pos+1);
   		$from = "info@lundasittning.se";
   		$to = $restaurant[2]; 
		ini_set("SMTP", "send.one.com");
   		ini_set("sendmail_from", $from);

   		$subject = "Sittningsintresseanmälan, $sitting->date";
		$msg = "En intresseanmälan har lagts till sittningen $sitting->date.\r\n";
		$msg .= "Anmälan är gjord av $user[1] ($user[3], $user[4]).\r\n\r\n";
		$msg .= "Vill du veta mer så besök sidan här:\r\n";
		$msg .= "$nationURL\r\n";
		$msg = wordwrap($msg,70);

		$headers = "From: $from\r\nReply-To: $to\r\n";
		mail($to, $subject, $msg, $headers);

		// Send email to PartyCreator
   		$to = $user[3]; 
   		$subject = "Anmälningsbekräftelse, $sitting->date";
		$msg = "Vi har mottagit den intresseanmälan av ett sällskap.\r\n";
		$msg .= "Nationen kommer att behandla din anmälan och inom kort kontakta dig, har du några frågor kan du skicka maila:$restaurant[2]\r\n\r\n";
		$msg .= "Med varma hälsningar,\r\n";
		$msg .= "Lundasittning\r\n";
		$msg = wordwrap($msg,70);

		$headers = "From: $from\r\nReply-To: $to\r\n";
		mail($to, $subject, $msg, $headers);

        $_SESSION['message'] = 'Intresseanmälan lagd. Mail skickat till Nationen med info.';
        
		header("Location: $nationURL/sallskap/$key");
		return;
	}
	
	
	if($_POST['createRestaurant']){
    if($loggedIn){
      $name = $_POST['name'];
      $nickname = $_POST['nickname'];
      $nickname = strtolower($nickname);
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $homepage = $_POST['homepage'];
      $hours = $_POST['hours'];
      $address = $_POST['address'];
      $deposit = $_POST['deposit'];
      $price = $_POST['price'];
      $size = $_POST['size'];
      $summary = $_POST['summary'];

      $msg = "Save successfull.";
      if (isset($_FILES['backgroundimage']) && $_FILES['backgroundimage'] != '') {
          $bgName = "$restaurant[0]_background";
          $success = uploadImage($_FILES["backgroundimage"], $bgName);
          if($success != ""){
              $msg = $success;
          } else {
              $bgType = explode(".", $_FILES["backgroundimage"]["name"])[1];
              $bg = "$bgName.$bgType";
          }
      }
      if ($bg == "") {
          $bg = $restaurant[11];
          $msg = "Save successfull.";
      }
      if (isset($_FILES['nationloggo']) && $_FILES['nationloggo'] != '') {
          $loggoName = "$restaurant[0]_loggo";
          $success = uploadImage($_FILES["nationloggo"], $loggoName);
          if($success != ""){
              $msg = $success;
          } else {
              $loggoType = explode(".", $_FILES["nationloggo"]["name"])[1];
              $loggo = "$loggoName.$loggoType";
          }
      }
      if ($loggo == "") {
          $loggo = $restaurant[12];
          $msg = "Save successfull.";
      }
  
      $dbHandler->createRestaurant($name, $nickname, $email, $phone, $homepage, $hours, $address, $deposit, $price, $size, $summary, $bg, $loggo, $user[0]);
      $dbHandler->addUserType('Quratel', $user[0], $name);

      // Send email to SuperAdmins
      $superheroes = $dbHandler->getSuperAdmins();
      $to = "";
      foreach( $superheroes as $key => $super){
        if($key > 0){
          $to .= ',';
        }
        $to .= $super[2];
      }
      $link = $_SERVER['HTTP_REFERER'];
      $pos = strrpos($link, '/');
      $link = substr($link, 0, $pos+1);
      $from = "info@lundasittning.se";
      
      ini_set("SMTP", "send.one.com");
        ini_set("sendmail_from", $from);

      $subject = "Lundasittning, ny restaurang";
      $msg = "En ny restaurang har skapats av $user[0]. Restaurangens namn är:$ $name ($email)\r\n";
      $msg = wordwrap($msg,70);

      $headers = "From: $from\r\nReply-To: $to\r\n";
      mail($to, $subject, $msg, $headers);

      if($msg != ""){
          $_SESSION['message'] = $msg;
      }
      header("Location: $siteURL/$nickname");
      return;
    }
	}
	if($_POST['updateNationSettings']){
        // Only quratel or admin are allowed
        $access = $dbHandler->getAccessLevel($fbid, $restaurant[0]);
        requireAccessLevel(5, $access);

		$name = $_POST['name'];
		$nickname = $_POST['nickname'];
		$nickname = strtolower($nickname);
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$homepage = $_POST['homepage'];
		$hours = $_POST['hours'];
		$address = $_POST['address'];
		$deposit = $_POST['deposit'];
		$price = $_POST['price'];
		$size = $_POST['size'];
		$summary = $_POST['summary'];

        $msg = "Save successfull.";
        if (isset($_FILES['backgroundimage']) && $_FILES['backgroundimage'] != '') {
            $bgName = "$restaurant[0]_background";
            $success = uploadImage($_FILES["backgroundimage"], $bgName);
            if($success != ""){
                $msg = $success;
            } else {
                $bgType = explode(".", $_FILES["backgroundimage"]["name"])[1];
                $bg = "$bgName.$bgType";
            }
        }
        if ($bg == "") {
            $bg = $restaurant[11];
            $msg = "Save successfull.";
        }
        if (isset($_FILES['nationloggo']) && $_FILES['nationloggo'] != '') {
            $loggoName = "$restaurant[0]_loggo";
            $success = uploadImage($_FILES["nationloggo"], $loggoName);
            if($success != ""){
                $msg = $success;
            } else {
                $loggoType = explode(".", $_FILES["nationloggo"]["name"])[1];
                $loggo = "$loggoName.$loggoType";
            }
        }
        if ($loggo == "") {
            $loggo = $restaurant[12];
            $msg = "Save successfull.";
        }
    
        $dbHandler->updateRestaurant($name, $nickname, $email, $phone, $homepage, $hours, $address, $deposit, $price, $size, $summary, $bg, $loggo, $user[0]);

        if($msg != ""){
            $_SESSION['message'] = $msg;
        }
		header("Location: $nationURL/nationsettings.php");
        return;
	}
	if($_POST['updateSettings']){
		$email = $_POST['email'];
		$foodpref = $_POST['foodpref'];
		$phone = $_POST['phone'];
		$other = $_POST['other'];
		
		$userId = $_POST['userId'];
		// Update email if it was specified
		if($email && $email != ''){
			$dbHandler->updateEmail($user[0], $email);
		}
		// Update email if it was specified
		if($phone && $phone != ''){
			$dbHandler->updatePhone($user[0], $phone);
		}
		// Update other if it was specified
		if($other && $other != ''){
			$dbHandler->updateOther($user[0], $other);
		}
		// Remove all foodpreferences to this user and add all those checked now.
		$dbHandler->clearParticipantFood($user[0]);
		foreach ($foodpref as $key => $f) {
			$dbHandler->addParticipantFood($user[0], $f);
		}

        $_SESSION['message'] = 'Inställningar sparade.';

		header("Location: $nationURL/restaurant.php?status=saved");
		return;
	}
	if($_POST['updatePartyInterest']){
		$interest = $_POST['interest'];
		$uId = $user[0];
		$pId = $_POST['partyId'];
		$creator = $dbHandler->getCreator($pId);
		$isCreator = $creator[0] == $user[0];
		if($isCreator){
			$dbHandler->updatePartyInterest($pId, $interest, $user[0], $restaurant[0]);
		}
        $party = $dbHandler->getParty($pId);

        $_SESSION['message'] = 'Antal intresserade uppdaterat.';

		header("Location: $nationURL/sallskap/$party->key");
		return;		
	}
	if($_POST['updatePartyMsg']){
		$msg = $_POST['message'];
		$uId = $user[0];
		$pId = $_POST['partyId'];
		$creator = $dbHandler->getCreator($pId);
		$isCreator = $creator[0] == $user[0];
		if($isCreator || $myAccessLevel >= 5){
			$dbHandler->updatePartyMsg($pId, $msg, $user[0], $restaurant[0]);
		}
        $party = $dbHandler->getParty($pId);

        $_SESSION['message'] = 'Meddelande uppdaterad.';

		header("Location: $nationURL/sallskap/$party->key");
		return;		
	}

    if($_POST['partyDeleteParticipant']){
      	$_SESSION['message'] = 'Gäst borttagen.';

      	// Determine isCreator
      	$uId = $user[0];
		  $pId = $_POST['partyid'];
      	$party = $dbHandler->getParty($pId);
		  $creator = $dbHandler->getCreator($pId);
		  $isCreator = $creator[0] == $user[0];
      
      	// Get id's to remove
      	$userIds = $_POST['userId'];
    
      	// If has access level
		if($isCreator || $myAccessLevel >= 5){
        foreach($userIds as $key => $u){
          //if($u != $creator[0]){
            $success = $dbHandler->deletePartyParticipant($pId, $u, $uId, $restaurant[0]);
            if(!$success){
              $_SESSION['message'] = 'Deltagare gick ej att ta bort.';
              break;
            }
          /*
          } else {
            $_SESSION['message'] = 'Du kan ej ta bort sällskapsskaparen.';
            break;
          }
          */
        }
		  }
      header("Location: $nationURL/sallskap/$party->key");
      return;
    }
	
	if($_POST['deleteParty']){
		$partyId = $_POST['partyId'];
		$sittId = $_POST['sittId'];

		if($myAccessLevel >= 5){
			$dbHandler->deleteParty($partyId, $user[0], $restaurant[0]);
		}
        $_SESSION['message'] = 'Sällskapet är nu borttagen.';

		header("Location: $nationURL/sittning/$sittId");
		return;		
	}

    if($_POST['partyUpdatePay']){
        $paystatus = $_POST['payStatus'];
        $userIds = $_POST['userId'];
        $partykey = $_POST['partykey'];
        $partyid = $_POST['partyid'];
        $reqAccessLevel = $dbHandler->getPayAccessLevel($paystatus);
        
        if($myAccessLevel >= $reqAccessLevel){
            foreach($userIds as $key => $u){
        		$oldPayStatus = $dbHandler->getParticipantPayedStatus($u, $partyid);
        		$oldReqAccessLevel = $dbHandler->getPayAccessLevel($oldPayStatus);
        		if($myAccessLevel >= $oldReqAccessLevel){
	                $dbHandler->updateParticipantPayStatus($u, $partyid, $paystatus, $restaurant[0]);
	            }
            }
        }


        header("Location: $nationURL/sallskap/$partykey");
        return;
    }

    if($_POST['updateSittingMenu']){
        $appetiser = $_POST['appetiser'];
        $main = $_POST['main'];
        $desert = $_POST['desert'];
        $sittId = $_POST['sittId'];        
        $sittForeman = $dbHandler->isSittingForeman($sittId, $user[0]);
        
        if($sittForeman || $myAccessLevel >= 5){

            $dbHandler->updateAppetiser($sittId, $appetiser, $user[0], $restaurant[0]);
            $dbHandler->updateMain($sittId, $main, $user[0], $restaurant[0]);
            $dbHandler->updateDesert($sittId, $desert, $user[0], $restaurant[0]);

            $_SESSION['message'] = 'Menyn är nu uppdaterad.';
            
            header("Location: $nationURL/sittning/$sittId");
            return;		
        }       
    }

    if($_POST['updateSpotsTaken']){
        $spotsTaken = $_POST['spotsTaken'];
        $sittId = $_POST['sittId'];        
        
        if($myAccessLevel >= 5){
            $dbHandler->updateSpotsTaken($sittId, $spotsTaken, $user[0], $restaurant[0]);

            $_SESSION['message'] = "Antal bokade platser är nu uppdaterat.";
            
            header("Location: $nationURL/sittning/$sittId");
            return;		
        }       
    }


	if($_POST['addSittingForeman']){
        $_SESSION['message'] = 'Förman är nu tillagd.';

		$sittId = $_POST['sittId'];
		$formanId = $_POST['user'];

		if($myAccessLevel >= 5 && isset($formanId)){
			$foreman = $dbHandler->getSittingForeman($sittId);
			$isSittingForeman = false;
			foreach ($foreman as $key => $f) {
				if($f[1] == $formanId){
					$isSittingForeman = true;
				}
			}
			if (!$isSittingForeman){
				$dbHandler->setSittingForeman($sittId, $formanId, $user[0]);
			}
		} else {
			$_SESSION['message'] = 'Vänligen ange en sittningsförman.';
		}

		header("Location: $nationURL/sittning/$sittId");
		return;		
	}
	if($_POST['removeSittingForeman']){
		$sittId = $_POST['sittId'];
		$formanId = $_POST['user'];

		if($myAccessLevel >= 5){
			$dbHandler->removeSittingForeman($sittId, $formanId, $user[0]);
		}
	
        $_SESSION['message'] = 'Förman är nu borttagen.';

		header("Location: $nationURL/sittning/$sittId");
		return;		
	}

  function uploadImage($file, $name){
      $target_dir = "uploads";

      $end = $file["name"];
      $e = explode(".", $end);
      $target_file = "$target_dir/$name.$e[1]";
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      $check = getimagesize($file["tmp_name"]);
      
      if($check !== false) {
          $msg = "File is an image - " . $check["mime"] . ".\n";
          $uploadOk = 1;
      } else {
          $msg = "File is not an image.";
          $uploadOk = 0;
      }

      // Check file size
      $size = $file["size"];
      if ($size > 15000000) {
          $msg = "Sorry, your file is too large. $size";
          $uploadOk = 0;
      }
      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
          $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed. $imageFileType";
          $uploadOk = 0;
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
          $msg .= "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($file["tmp_name"], $target_file)) {
              $msg = "";
          }
      }
      return $msg;
  }

 	// Close database.
	$dbHandler->disconnect();

	// Redirect back to index.
	header("Location: $siteURL");
?>
