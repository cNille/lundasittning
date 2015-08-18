<?php 
	include 'header.php';
 	require_once 'dbconfig.php'; 
 	require_once 'database.php';
 	$db = new Database(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	$db->openConnection();

	if(!$db->isConnected()) {
		header("Location: cannotConnect.php");
		exit();
	}
			
	$sittings = $db->getSittings();
	
	$db->closeConnection();

 ?>

<div class="content">
	<div class="title">
		Sittningar HT15
	</div>
	<div class="event-grid">
		<?php 
			foreach($sittings as $row => $s) {
				$date = date('j/n', strtotime($s[0]));
				?>
				<div class="event-window" id="<?php echo $date; ?>">
					<div class="event-window-date">
						<?php echo $date; ?>
					</div>
					<div class="event-window-spots">
						Antal platser: 200
					</div>
					<div class="event-window-button">
						<a href="#"> Se mer </a>
					</div>
					<button class="event-remove-button">Remove</button>
				</div>
		<?php } ?>
	</div>
</div>


<?php include 'footer.php'; ?>