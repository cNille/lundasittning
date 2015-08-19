<?php 
	require_once 'header.php';
 	$dbHandler = new DatabaseHandler();
	$sitting = $dbHandler->getSitting($_GET['sittId']);
	$parties = $dbHandler->getParties($_GET['sittId']);
	$foreman = $dbHandler->getSittingForeman($_GET['sittId']);
	$dbHandler->disconnect();
	echo 'Hej: ' . $foreman[0][0];
 ?>

<div class="content">
	<div class="title">
		Sittning <?php echo $sitting->date; ?>
	</div>
	<div class="single-sitting">
		<div class="left">
				<h3>Anmälda sällskap</h3>
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
				<h3>Intresserade sällskap</h3>
				<table>
					<tr>
						<th>Sällskap</th>
						<th>Gäster</th>
					</tr>
					<?php 
						$spotsLeft = $restaurant->size;
						foreach ($parties as $key => $p) {
							$prelSpots = $p->prel + $p->payed;

							if($prelSpots == 0){
							?>
								<tr>
									<td><?php echo $p->name; ?></td>
									<td><?php echo $p->prel + $p->payed; ?></td>
								</tr>
							<?php
							}
						}
					?>
				</table>
				<label>Platser kvar: </label><span><?php echo $spotsLeft; ?></span><br />
				<label>Preliminär deadline: </label><span><?php echo $sitting->prelDay; ?></span><br />
				<label>Preliminär deadline: </label><span><?php echo $sitting->payDay; ?></span>
		</div>
		
		<div class="right">
			<label>Förmän</label>
			<span><?php 
				foreach ($foreman as $key => $f) {
					echo '<li>' . $f[0] . '</li>';
				}
			?></span>
		</div>

	</div>
</div>


<?php include 'footer.php'; ?>