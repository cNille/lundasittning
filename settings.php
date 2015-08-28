<?php 
	require_once 'header.php';
	$dbHandler = new DatabaseHandler();
	$user = $dbHandler->getSettings($fbid);
	$dbHandler->disconnect();
?>

<div class="content">
	<div class="title">
		Inställningar
	</div>
	<div class="userSettings">
		<form id="TEMPNAME">
			<div class="left">
				<div>
					Namn <input type="text" name="name" value="<?php echo $user->name; ?>">
				</div>
				<div class="category">
					E-mail <input type="text" name="email" value="<?php echo $user->email; ?>">
				</div>
				<div class="category">
					Telefonnummer <input type="text" name="telephone" value="<?php echo $user->telephone; ?>">
				</div>
				<div class="category">
					Alkohol <input type="radio" name="alcohol" value="1"> Alkoholfritt <input type="radio" name="alcohol" value="0">
				</div>
				<div class="category">
					Kostym/Frack <input type="radio" name="gender" value="2"> Klänning <input type="radio" name="gender" value="1"> Annat <input type="radio" name="gender" value="0">
				</div>
				<button class="category" type="button" id="confirmSettings"> Spara </button>
			</div>
		</form>
	</div>
</div>

<?php include 'footer.php'; ?>