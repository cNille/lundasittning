<?php 
    require_once 'header.php';

 	$dbHandler = new DatabaseHandler();
    $restaurants = $dbHandler->getRestaurants();
	$dbHandler->disconnect();
 ?>

<div class="content">
	<div class="title">
		Lundasittning
	</div>
	<p class="white">
		Välkommen till Lundasittning, din guide för sittningar i Lund!
	</p>
	<p class="white" >
		Här nedan kan du se nationer som är anknutna till vår sida. 
		Klicka dig in på dem för att kunna se deras sittningar.
		<br />
		// Frallan & Nille
	</p>
	<div class="restaurant-grid">
		
		<?php 
			foreach($restaurants as $row => $r) {
				$name = $r[0];
				$nickname = $r[1];
				$loggo = $r[2];
				?>
					<a href="<? echo $siteURL . '/' . $nickname; ?>">
						<div class="restaurant">
							<div class="loggo" style="background-image: url('uploads/<?php echo $loggo; ?>')"></div>
							<h3>
								<?php echo $name; ?>
							</h3>
						</div>
					</a>
		<?php } ?>
	</div>
</div>
<div style="clear:both;"></div>
<?php //include 'footer.php'; ?>
