<?php 
	require_once 'header.php';
 	$dbHandler = new DatabaseHandler();
	$party = $dbHandler->getParty($_GET['partyId']);
	$sitting = $dbHandler->getSitting($party->sittId);
	$guests = $dbHandler->getGuests($_GET['partyId']);
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
				<h3>Datum: <?php echo date('j/n', strtotime($sitting->date)); ?></h3>
				<p><?php 	echo $guests[0]->fbid; ?></p>
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
		<div class="right side">
			<label>Förmän</label>
			<span><?php 
				foreach ($foreman as $key => $f) {
					echo  $f[0] . '<br />';
				}
			?></span>
			<h4>Meny</h4>
			<label class="mitten">Förrätt</label>
			<span class="mitten"><?php echo $sitting->appetiser; ?></span>
			<label class="mitten">Huvudrätt</label>
			<span class="mitten"><?php echo $sitting->main; ?></span>
			<label class="mitten">Efterrätt</label>
			<span class="mitten"><?php echo $sitting->desert; ?></span>
		</div>
	</div>
</div>


<?php include 'footer.php'; ?>