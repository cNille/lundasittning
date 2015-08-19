<?php 
	require_once 'header.php';
 	$dbHandler = new DatabaseHandler();
	$restaurant = $dbHandler->getRestaurant('Nilles nation');
	$sitting = $dbHandler->getSitting($_GET['sittDate']);
	$parties = $dbHandler->getParties($_GET['sittDate']);
	$dbHandler->disconnect();

 ?>

<div class="content">
	<div class="title">
		Sittning <?php echo $sitting->date; ?>
	</div>
	<div class="single-sitting">
		<div class="left">
				<h1>Välkomna!</h1>
				<table>
					<tr>
						<th>Sällskap</th>
						<th>Gäster</th>
					</tr>
					<?php 
						$spotsLeft = $restaurant->size;
						foreach ($parties as $key => $p) {
							$spotsLeft = $spotsLeft - $p->prel - $p->payed;
							?>
								<tr>
									<td><?php echo $p->name; ?></td>
									<td><?php echo $p->prel + $p->payed; ?></td>
								</tr>
							<?php
						}
					?>
				</table>
				<label>Platser kvar: </label><span><?php echo $spotsLeft; ?></span>
		</div>
		
		<div class="right">
		</div>

	</div>
</div>


<?php include 'footer.php'; ?>