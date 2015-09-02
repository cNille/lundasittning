<?php 
	require_once 'header.php';
	$key = $_GET['partyKey'];
 	$dbHandler = new DatabaseHandler();
	$party = $dbHandler->getPartyFromKey($key);
	$id = $party->id;
	$isParticipating = $dbHandler->isParticipating($id, $user[0]);
	$sitting = $dbHandler->getSitting($party->sittId);
	$guests = $dbHandler->getGuests($id);
	$creator = $dbHandler->getCreator($id);
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
				<h4>Datum</h4>
				<p><?php echo $sitting->date; ?></p>
				<h4>Sällskapsansvarig</h4> 
				<p><?php echo  $creator[0];?></p>
				<p><?php echo  $creator[1];?></p>
				<p><?php echo  $creator[2];?></p>
				<h4>Meddelande</h4> 
				<p><?php echo  $party->message;?></p>
		</div>
		<div class="right side">
			<?php if(!$isParticipating) : ?>
				<?php if($loggedIn) : ?>
					<a class="btn primary" href="partybook.php?partyId=<?php echo $id; ?>&guestMode=0">
						<span>Anmäl dig</span>
					</a>
				<?php else : ?>
					<a class="btn primary" href="partybook.php?guestMode=0&partyId=<?php echo $id; ?>">
						<span>Anmäl dig via inlogg</span>
					</a>
					<a class="btn"  href="partybook.php?guestMode=1&partyId=<?php echo $id; ?>">
						<span>Anmäl dig via gästinlogg</span>
					</a>
				<?php endif; ?>
			<?php endif; ?>

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