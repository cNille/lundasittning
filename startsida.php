<?php 
    require_once 'header.php';

 	$dbHandler = new DatabaseHandler();
 	$restaurants = $dbHandler->getRestaurants(1);
	$dbHandler->disconnect();
 ?>

<div class="content">
	<div class="title">
		Lunds nationer
	</div>
	<div class="event-grid">
		<?php 
			foreach($restaurants as $row => $s) {
				?>
				<div class="event-window" id="<?php echo $s[0]; ?>">
					<a href="#" class="event-window-link">
					<?php echo $s[0] ?>
					</a>
				</div>
		<?php } ?>
	</div>
</div>
<div style="clear:both;"></div>


<?php include 'footer.php'; ?>
