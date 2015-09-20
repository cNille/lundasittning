<?php 
	require_once 'header.php';
 	$dbHandler = new DatabaseHandler();
	$party = $dbHandler->getParty($_POST['party']);

	$guestMode = $_POST['guestMode'];
	$name = $_POST['userName'];
	$email = $_POST['userEmail'];
	$phone = $_POST['userTelephone'];
	$sittId = $_POST['sittId'];
	$sitting = $dbHandler->getSitting($sittId);
	$foodPref = $dbHandler->getAllFoodpref();
	$myFoodPref = $dbHandler->getMyFoodpref($user[0]);

	if($loggedIn){
		$user = $dbHandler->getUser($fbid);
	} else if($guestMode == 0){
		include 'facebook-login/fbconfig.php';
	} else {

	}
	$dbHandler->disconnect();

	function form($x){
		echo '<input type="text" name="name" value="' . $x . '">';
	}
 ?>
<div class="content">
	<div class="title">Boka plats</div>
	<div class="booking-content">
		<h2><?php echo $party->name; ?></h2>
		<form action="scripts.php" method="POST">
			Namn *<br /Namn>
			<span><?php if($guestMode){ form($name); } else { echo $name . '<input type="hidden" name="name" value="' . $name . '" />'; } ?></span>
			
			Foodpreferences or allergies <br />
			<?php
				if(!$guestMode){
					foreach ($foodPref as $key => $fp) {
						$checked = '';
						foreach ($myFoodPref as $key => $mfp) {
							if($mfp[0] == $fp[0]){
								$checked = 'checked';
							}
						}
						echo '<input type="checkbox" name="foodpref[]" value="' . $fp[0] . '" ' . $checked . ' >' . $fp[0] . '<br />';
					}
				} else {
					echo '<input type="text" name="foodpref" /><br />';
				}
			?>
			<br />

			Datum <br />
			<span><?php echo $sitting->date; ?></span>
			Epost <br />
			<span><input type="text" name="email" value="<?php echo $email; ?>"></span>
			Telefonnummer <br />
			<span><input type="text" name="phone" value="<?php echo $phone; ?>"></span>
			<input type="submit" value="Boka plats" name="bookSpot" />
			<input type="hidden" name="guestMode" value="<?php echo $guestMode; ?>" />
			<input type="hidden" name="partyId" value="<?php echo $party->id; ?>" />
			<input type="hidden" name="partyKey" value="<?php echo $party->key; ?>" />
			<input type="hidden" name="userId" value="<?php echo $user[0]; ?>" />
			<button onclick="window.history.back();">Avbryt</button>
		</form>
	</div>
</div>
<?php include 'footer.php'; ?>






























