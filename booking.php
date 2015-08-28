<?php 
	require_once 'header.php';
 	$dbHandler = new DatabaseHandler();
	$party = $dbHandler->getParty($_GET['partyId']);
	$user = $dbHandler->getUser($fbid);
	$dbHandler->disconnect();


 ?>
<div class="content">
	<div class="title">Intresseanmälan</div>
	<div class="booking-content">
		<h3>Anmälan till; <?php echo $party->name; ?></h3>
		<p>För att lägga en anmälan gör såhär</p> 
		<ol>
			<li>Bekräfta ifyllda fält och fyll i resterande fält. </li>
		</ol>
		<form>
			Namn <br />
			<span><input type="text" name="email" value="<?php echo $userEmail; ?>"></span>
			Datum <br />
			<span><input type="text" name="email" value="<?php echo $userEmail; ?>"></span>
			Epost *<br />
			<span><input type="text" name="email" value="<?php echo $userEmail; ?>"></span>
			Telefonnummer *<br />
			<span><input type="text" name="phone" value="<?php echo $userTelephone; ?>"></span>
			<input type="submit" value="Boka plats"/>
			<button onclick="window.history.back();">Avbryt</button>
		</form>
	</div>
</div>
<?php include 'footer.php'; ?>































