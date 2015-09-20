<?php 
	require_once 'header.php';
 	$dbHandler = new DatabaseHandler();
	$sitting = $dbHandler->getSitting($_GET['sittId']);
	$parties = $dbHandler->getParties($_GET['sittId']);
	$myParties = $dbHandler->getPartiesByUser($user[0]);
	$foreman = $dbHandler->getSittingForeman($_GET['sittId']);
	$dbHandler->disconnect();

	$isSittingForeman = false;
	foreach ($foreman as $key => $f) {
		if($f[1] == $user[0]){
			$isSittingForeman = true;
		}
	}

	$spotsLeft = $restaurant->size;
	$hasInterestedParties = false;
	foreach ($parties as $key => $p) {
		$spotsLeft = $spotsLeft - $p->prel - $p->payed;
		if($p->prel + $p->payed == 0){
			$hasInterestedParties = true;
		}
	}
 ?>
<div class="content">
	<div class="title">Sittning</div>
	<div class="single-sitting">
		<div class="left side">
				<h3><?php echo date('j/n', strtotime($sitting->date)); ?></h3>
				<label>Platser kvar: </label><span><?php echo $spotsLeft; ?></span><br />
				<label>Preliminär deadline: </label><span><?php echo $sitting->prelDay; ?></span><br />
				<label>Preliminär deadline: </label><span><?php echo $sitting->payDay; ?></span>
				<table>
					<tr>
						<th>Anmälda sällskap</th>
						<th>Gäster</th>
					</tr>
					<?php 
						foreach ($parties as $key => $p) {
							$isParticipating = false;
							foreach ($myParties as $key => $mp) {
								if($mp[0] == $p->id){
									$isParticipating = true;
								}
							}
							$prelSpots = $p->prel + $p->payed;
							if($prelSpots != 0){
								?>
									<tr>
										<?php 
											if($isParticipating || $isSittingForeman){
												echo '<td><a href="party.php?partyKey=' . $p->key . '">' . $p->name . '</a></td>';
											} else {
												echo '<td>' . $p->name . '</td>';
											}
										?>
										
										<td><?php echo $p->prel + $p->payed; ?></td>
										
									</tr>
								<?php
							}
						}
					?>
				</table>
				<?php if($hasInterestedParties) : ?>
				<table>
					<tr>
						<th>Intresserade Sällskap</th>
						<th>Gäster</th>
					</tr>
					<?php 
						$spotsLeft = $restaurant->size;
						foreach ($parties as $key => $p) {
							$isParticipating = false;
							foreach ($myParties as $key => $mp) {
								if($mp[0] == $p->id){
									$isParticipating = true;
								}
							}
							$prelSpots = $p->prel + $p->payed;
							if($prelSpots == 0){
							?>
								<tr>
									<?php 
											if($isParticipating){
												echo '<td><a href="party.php?partyKey=' . $p->key . '">' . $p->name . '</a></td>';
											} else {
												echo '<td>' . $p->name . '</td>';
											}
										?>
									<td><?php echo $p->interest; ?></td>
								</tr>
							<?php
							}
						}
					?>
				</table>
				<?php endif; ?>
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
	<div <?php 
			if($loggedIn){ 
				echo 'class="button"  onclick="location.href=\'interest.php?sittId=' . $sitting->id . '\';"'; 
			} else { 
				echo 'class="button disabled" title="Du måste vara inloggad för att kunna lägga en anmälan."'; 
			} ?> 
		>
		<span>+ Lägg intresseanmälan</span>
	</div>
</div>


<?php include 'footer.php'; ?>