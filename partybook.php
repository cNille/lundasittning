<?php
	session_start(); 
	require_once 'db/dbHandler.php';
	$loggedIn = false;
	$dbHandler = new DatabaseHandler();	

	if($_SESSION['FBID'] && $_SESSION['FBID'] != null){
		$loggedIn = true;
		$fbid = $_SESSION['FBID'];
		$fbFullname = $_SESSION['FULLNAME'];
		$fbGender = $_SESSION['GENDER'];
		$fbEmail = $_SESSION['EMAIL'] == NULL ? " " : $_SESSION['EMAIL'];
	}

	$guestMode = $_GET['guestMode'];
	$userExists = $dbHandler->fbidExists($fbid);
	if($loggedIn){
		if($userExists){
			$user = $dbHandler->getUser($fbid);
		}
		if($loggedIn && !$userExists && $fbid != null){
			$user = $dbHandler->createUser($fbid, $fbFullname, $fbEmail);
		}	
	} else if($guestMode == 0){
		$_SESSION['LAST_PAGE'] = '../partybook.php';
		header("Location: facebook-login/fbconfig.php");
	} 
	$party = $dbHandler->getParty($_GET['partyId']);
	$sitting = $dbHandler->getSitting($party->date);
	$dbHandler->disconnect();

	echo 'Hej: ' . $party->sittId;
?>
<form action='partybooking.php' method='post' name='frm'>
	<input type='hidden' name='userName' value='<?php echo $user[2]; ?>'>
	<input type='hidden' name='userEmail' value='<?php echo $user[3]; ?>'>
	<input type='hidden' name='userTelephone' value='<?php echo $user[4]; ?>'>
	<input type='hidden' name='party' value='<?php echo $party->id; ?>'>
	<input type='hidden' name='sittId' value='<?php echo $party->sittId; ?>'>
	<input type='hidden' name='guestMode' value='<?php echo $guestMode; ?>'>
</form>
<script language="JavaScript">
document.frm.submit();
</script>