<?php 
	include 'header.php';
 	include 'db/dbHandler.php';
 	
 	$dbHandler = new DatabaseHandler();

	$dbHandler->connect();

	$sittings = $dbHandler->getSittings();
	
	$dbHandler->disconnect();
	
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