<?php 
	require_once 'header.php';
 	$dbHandler = new DatabaseHandler();
	$party = $dbHandler->getParty($_GET['partyId']);
	$sitting = $dbHandler->getSitting($party->sittId);
	$guests = $dbHandler->getGuests($_GET['partyId']);
	$creator = $dbHandler->getCreator($_GET['partyId']);
	$dbHandler->disconnect();

	function payedTextify($nr){
		if($nr == 0){
			return 'Nej';
		} else if($nr == 1){
			return 'Bokningsavgift';
		} else if($nr == 2){
			return 'Sittningsavgift';
		}
	}
 ?>

<div class="content">
	<div class="title"><?php echo $party->name; ?></div>
	<div class="party-content">
		<div class="left side">
				<label>Datum</label>
				<p><?php echo $sitting->date; ?></p>
				<label>Sällskapsansvarig</label> 
				<p><?php echo  $creator[0];?></p>
				<p><?php echo  $creator[1];?></p>
				<p><?php echo  $creator[2];?></p>
		</div>
		<div class="right side">
			<table>
				<tr>
					<th>Gäster</th>
					<th>Matpreferens</th>
					<th>Betalat</th>
				</tr>
				<?php 
					foreach ($guests as $key => $g) {
						?>
							<tr>
								<td><?php echo $g->name; ?></td>
								<td><?php echo $g->foodpref; ?></td>
								<td><?php echo payedTextify($g->payed); ?></td>
							</tr>
						<?php
					}
				?>
			</table>
		</div>
	</div>
</div>


<?php include 'footer.php'; ?>