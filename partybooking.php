<?php 
	require_once 'header.php';
 	$dbHandler = new DatabaseHandler();
	$party = $dbHandler->getParty($_POST['party']);

	$guestMode = $_GET['guestMode'];
	$party = $dbHandler->getParty($_GET['partyId']);

	if($guestMode == 1){
		
	} else {
        $userId = $user[0];
        $name = $user[1];
        $email = $user[3];
        $phone = $user[4];
        $other = $user[5];
        $myFoodPref = $dbHandler->getMyFoodpref($userId);
    }
    $foodPref = $dbHandler->getAllFoodpref();
	$sittId = $party->sittId;
	$sitting = $dbHandler->getSitting($sittId);

	$dbHandler->disconnect();

	function form($x){
		echo '<input type="text" name="name" value="' . $x . '">';
	}
 ?>
<div class="content">
	<div class="title">Boka plats</div>
	<div class="booking-content">
        <h4>Sittningsdatum</h4>
        <span><?php echo $sitting->date; ?></span>
        <h4>Sällskap</h4>
        <span><?php echo $party->name; ?></span>
		<form class="myForm" action="scripts.php" method="POST">
			<h4>Namn * </h4>
			<span>
                <?php 
                    if($guestMode == 1){ 
                        form(); 
                    } else { 
                        echo $name . '<input type="hidden" name="name" value="' . $name . '" />'; 
                    } 
                ?>
            </span>
			<h4>Matpreferens</h4>
			<?php
				foreach ($foodPref as $key => $fp) {
					$checked = '';
					foreach ($myFoodPref as $key => $mfp) {
						if($mfp[0] == $fp[0]){
							$checked = 'checked';
						}
					}
					echo '<input type="checkbox" name="foodpref[]" value="' . $fp[0] . '" ' . $checked . ' >' . $fp[0] . '<br />';
				}
			?>
			<br />
			
			<h4>Övrigt</h4>
			<span><input type="text" name="other" value="<?php echo $other; ?>"></span>

            <?php if($guestMode != 1) : ?>
                <h4>Epost</h4>
                <span><input type="text" name="email" value="<?php echo $email; ?>"></span>
                <h4>Telefonnummer</h4>
                <span><input type="text" name="phone" value="<?php echo $phone; ?>"></span>
            <?php endif; ?>

			<input class="primary" type="submit" value="Boka plats" name="bookSpot" />
			<input type="hidden" name="guestMode" value="<?php echo $guestMode; ?>" />
			<input type="hidden" name="partyId" value="<?php echo $party->id; ?>" />
			<input type="hidden" name="partyKey" value="<?php echo $party->key; ?>" />
			<input type="hidden" name="userId" value="<?php echo $userId; ?>" />
			<button class="formcancel" onclick="window.history.back();">Avbryt</button>
		</form>
	</div>
</div>
<?php include 'footer.php'; ?>































