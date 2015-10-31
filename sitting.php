<?php 
	require_once 'header.php';
 	$dbHandler = new DatabaseHandler();
 	$sittId = $_GET['sittId'];
	$sitting = $dbHandler->getSitting($sittId);
	$parties = $dbHandler->getParties($sittId);
	$partiesPayStatus = $dbHandler->getPartiesPayStatus($sittId);
	$myParties = $dbHandler->getPartiesByParticipant($user[0]);
    $allSittingUsers = $dbHandler->getPartyParticipantFromSitting($sittId);
	$foreman = $dbHandler->getSittingForeman($sittId);
	$resForeman = $dbHandler->getSittingForemanFromRes($resName);

    $foodStatistics = array();
    $sittingUsersWithFoodPref = array();
	foreach ($allSittingUsers as $key => $g) {
		$g[] = '';
		$myFoodPref = $dbHandler->getMyFoodpref($g[1]);
		foreach ($myFoodPref as $key => $food) {
			$g[4] = $g[4]. $food[0] . ', ';
		}
		$g[4] = substr($g[4], 0, -2);
        if(count($myFoodPref) > 0){
            $foodStatistics[$g[4]]++;
        }
        $sittingUsersWithFoodPref[] = $g;
	}
	$dbHandler->disconnect();

	$isSittingForeman = false;
	foreach ($foreman as $key => $f) {
		if($f[1] == $user[0]){
			$isSittingForeman = true;
		}
	}

	$spotsLeft = $restaurant->size;
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
						<th></th>
					</tr>
					<?php 
	                    $hasInterestedParties = false;
						foreach ($parties as $key => $p) {
							$isParticipating = false;
							foreach ($myParties as $key => $mp) {
								if($mp[0] == $p->id){
									$isParticipating = true;
								}
							}
							$prelSpots = 0;
							$totalSpots = 0;
							foreach ($partiesPayStatus as $key => $pps) {
								if($pps[0] == $p->id){  
                                    if($pps[2] != "Nej" && $pps[2] != "Insamlat"){
										$prelSpots += $pps[3];
									}
									$totalSpots += $pps[3];
								}
							}
							if($prelSpots == 0){
                                $hasInterestedParties = true;
                            } else {
								?>
								<tr>
									<?php 
										if($isParticipating || $myAccessLevel >= 5 || $isSittingForeman){
											echo '<td><a href="' . $p->key . '">' . $p->name . '</a></td>';
										} else {
											echo '<td>' . $p->name . '</td>';
										}
									?>
									<td><?php echo "$p->interest platser ($prelSpots betalat, $totalSpots anmälda)"; ?></td>
								</tr>
								<?php
							}
						}
					?>
				</table>
				<?php if($hasInterestedParties) : ?>
				<table>
					<tr>
						<th>Intresserade sällskap</th>
						<th></th>
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
							$totalSpots = 0;
							$prelSpots = 0;
							foreach ($partiesPayStatus as $key => $pps) {
								if($pps[0] == $p->id){
									if($pps[2] != "Nej" && $pps[2] != "Insamlat"){
										$prelSpots += $pps[3];
									}
									$totalSpots += $pps[3];
								}
							}
							if($prelSpots == 0){
							?>
                            <tr>
								<?php 
									if($isParticipating || $myAccessLevel >= 5 || $isSittingForeman){
										echo '<td><a href="' . $p->key . '">' . $p->name . '</a></td>';
									} else {
										echo '<td>' . $p->name . '</td>';
									}
								?>
								<td><?php echo "$p->interest platser ($totalSpots anmälda)"; ?></td>
							</tr>
							<?php
							}
						}
					?>
				</table>
				<?php endif; ?>
		</div>
		<div class="right side">
			<h4>Förmän</h4>
			<span>
			<?php 
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
				echo 'class="button primary"  onclick="location.href=\'interest.php?sittId=' . $sitting->id . '\';"'; 
			} else { 
				echo 'class="button disabled" title="Du måste vara inloggad för att kunna lägga en anmälan."'; 
			} ?> 
		>
		<span>+ Lägg intresseanmälan</span>
	</div>
	<?php 
	if($myAccessLevel >= 5 || $isSittingForeman) : ?>
        <div class="single-sitting">
            <h2>Inställningar för sittningen</h2>
            <form action="scripts.php" method="POST">
                <h3>Menyn</h3>
                <h4>Förrätt</h4> 
                <input type="text" name="appetiser" value="<?php echo $sitting->appetiser; ?>" />
                <br />
                <h4>Huvudrätt</h4> 
                <input type="text" name="main" value="<?php echo $sitting->main; ?>"/>
                <br />
                <h4>Efterrätt</h4> 
                <input type="text" name="desert" value="<?php echo $sitting->desert; ?> "/>
                <br />
                <input type='hidden' value="<?php echo $sittId; ?>" name="sittId" />
                <input type="submit" value="Uppdatera Meny" name="updateSittingMenu" />
            </form>
                <?php if($myAccessLevel >= 5){ ?>
                    <form action="scripts.php" method="POST">
                        <h3>Förmän</h3>
                        <select name="user">
                        <?php
                            foreach ($resForeman as $key => $rf) {
                                echo "<option value='$rf[0]'>$rf[1]</option>";
                            }
                        ?>
                        </select><br />
                        <input type='submit' name="addSittingForeman" value="Lägg till">
                        <input type='submit' name="removeSittingForeman" value="Ta bort">
                        <input type='hidden' name='sittId' value="<?php echo $sitting->id; ?>">
                        <br /><br />
                    </form>
                <?php } ?>
            
            <h3>Matstatistik</h3>
            <table class="fancy">
                <tr>
                    <th>Matpreferens</th>
                    <th>Antal</th>
                </tr>
            <?php
                $c = false;
                foreach($foodStatistics as $key => $s){
                    $alt = $toogle % 2 ? "alt" : "e";
                    echo "<tr".(($c = !$c)?' class="odd"':'')."><td>$key</td><td>$s</td></tr>";
                }

            ?>
            </table>

            <h3>Anmälda gäster</h3>
			<table class="fancy">
				<tr>
					<th>#</th>
					<th>Sällskap</th>
					<th>Gäster</th>
					<th>Matpreferens</th>
				</tr>
				<?php 
					$i = 1;
					foreach ($sittingUsersWithFoodPref as $key => $g) {
						?>
						<tr <?php echo (($c = !$c)?' class="odd"':''); ?>>
							<td><?php echo $i; ?></td>
							<td><?php echo $g[0]; ?></td>
							<td><?php echo $g[2]; ?></td>
                            <td><?php echo $g[4]; ?></td>
						</tr>
						<?php
						$i++;
					}
				?>
			</table>
        </div>
	<?php endif; ?>
</div>
<?php include 'footer.php'; ?>
