<?php 
	require_once 'header.php';
 	$dbHandler = new DatabaseHandler();
 	$sittId = $_GET['sittId'];
	$sitting = $dbHandler->getSitting($sittId);
	$user = $dbHandler->getUser($fbid);
	$dbHandler->disconnect();
	$userName = $user[2];
	$userEmail = $user[3];
	$userTelephone = $user[4];
 ?>
<div class="content">
	<div class="title">Intresseanmälan</div>
	<div class="interest-content">
		<h2>Bekräfta</h2>
		<form action="scripts.php" method="POST">
			<input type="hidden" name="userId" value="<?php echo $user[0]?>" />
			<input type="hidden" name="sittId" value="<?php echo $sittId?>" />
			Sittningsdatum <br />
			<span><?php echo date('j/n', strtotime($sitting->date)); ?></span>
			Bokare <br />
			<span><?php echo $userName; ?></span>
			Datum <br />
			<span><?php echo $sitting->date; ?></span>
			Epost *<br />
			<span><input type="email" name="email" value="<?php echo $userEmail; ?>" required></span>
			Telefonnummer *<br />
			<span><input type="tel" name="phone" value="<?php echo $userTelephone; ?>" required></span>
			Antal sittningsplatser ni är intresserade utav *<br />
			<span><input type="number" name="interestedSpots" value="" required></span>
			Namn på sällskapet *<br />
			<span><input type="text" name="partyName" value="" required></span>
			<label>Meddelande till gästerna (250 tecken)</label>			
			<textarea rows="4" cols="50" name="message" maxlength="250"></textarea>
			<input type="submit" value="Skicka" name="createInterestParty" />
		</form>
	</div>
</div>
<?php include 'footer.php'; ?>