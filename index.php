<?php 
	require_once 'header.php';

 	$dbHandler = new DatabaseHandler();
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
				$date = date('j/n', strtotime($s->date));
				?>
				<div class="event-window" id="<?php echo $s->id; ?>">
					<div class="event-window-date">
						<?php echo $date; ?>
					</div>
					<div class="event-window-spots">
						Antal platser: <?php echo $s->spotsLeft;?>
					</div>
					<div class="event-window-button">
						<a href="./sitting.php?sittId=<?php echo $s->id; ?>"> Se mer </a>
					</div>
					<?php if($accessLevel >= 5){ ?>
						<button class="event-remove-button">Remove</button>
					<?php } ?>
				</div>
		<?php } ?>
			<?php if($accessLevel >= 5){ ?>
				<div class="event-window" id="event-creator">
					<p id="event-creator-initiate"> + </p>
				</div>
			<?php } ?>
	</div>
</div>


<?php include 'footer.php'; ?>