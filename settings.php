<?php 
	require_once 'header.php';
	$dbHandler = new DatabaseHandler();
	$foodPref = $dbHandler->getAllFoodpref();
	$myFoodPref = $dbHandler->getMyFoodpref($user[0]);
	$dbHandler->disconnect();
?>

<div class="content">
	<div class="title">
		Inställningar
	</div>
	<div class="userSettings">
		<form action="scripts.php" method="POST">
			<div style="max-width: 280px; margin: auto;">
				<div class="category">
					E-mail <input type="text" name="email" value="<?php echo $user[3]; ?>">
				</div>
				<div class="category">
					Telefonnummer <input type="text" name="phone" value="<?php echo $user[4]; ?>">
				</div>
				<div class="category">
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
				</div>
				<div class="category">
					Övrigt <input type="text" name="other" value="<?php echo $user[5]; ?>">
				</div>
				<input class="category" type="submit" value="Spara" name="updateSettings" />
			</div>
			<input type="hidden" name="userId" value="<?php echo $user[0]; ?>" />
		</form>
	</div>
</div>

<?php include 'footer.php'; ?>
