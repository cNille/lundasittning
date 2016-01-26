<?php 
	require_once "header.php";

 	$dbHandler = new DatabaseHandler();
 	$sittId = $_GET['sittId'];
	$sitting = $dbHandler->getSitting($sittId);
	$parties = $dbHandler->getParties($sittId);

	$sittingSpotsTaken = $dbHandler->getSittingsSpots(1);

	$partiesPayStatus = $dbHandler->getPartiesPayStatus($sittId);
	$myParties = $dbHandler->getPartiesByParticipant($user[0]);
    $allSittingUsers = $dbHandler->getPartyParticipantFromSitting($sittId);
	$foreman = $dbHandler->getSittingForeman($sittId);
	$resForeman = $dbHandler->getSittingForemanFromRes($restaurant[0]);

    $foodStatistics = array();
    $sittingUsersWithFoodPref = array();
	foreach ($allSittingUsers as $key => $g) {
		$g[] = '';
		$myFoodPref = $dbHandler->getMyFoodpref($g[1]);
		foreach ($myFoodPref as $key => $food) {
			$g[5] = $g[5]. $food[0] . ', ';
		}
		$g[5] = substr($g[5], 0, -2);
        if(count($myFoodPref) > 0){
            $foodStatistics[$g[5]]++;
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

	// Get spotsleft.
	$spotsTaken = 0;
	foreach ($sittingSpotsTaken as $key => $sst) {
		if($sst[0] == $sittId){
			$spotsTaken = $sst[1];
		}
	}

    $spotsLeft = $restaurant[9] - $spotsTaken;

 ?>
 <link rel="stylesheet" type="text/css" href="../../css/main.css" />
<div class="content">
	<div class="title">Sittning</div>
	<div class="single-sitting">
		<div class="left side">
				<h3><?php echo date('j/n', strtotime($sitting->date)); ?></h3>
				<label class="bold">Platser kvar: </label><span><?php echo $spotsLeft; ?></span><br />
				<label class="bold">Bokningsavgift-deadline: </label><span><?php echo date('j/n - Y', strtotime($sitting->date . "-$restaurant[14] days")); ?></span><br />
				<label class="bold">Sittningsavgift-deadline: </label><span><?php echo date('j/n - Y', strtotime($sitting->date . "-$restaurant[15] days")); ?></span>
                <br /><br />
				<table>
					<tr>
						<th class="masterTooltip" title="Sällskap där minst en har betalat bokningsavgiften">Anmälda sällskap</th>
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
											echo '<td><a href="' . $nationURL . '/sallskap/' . $p->key . '">' . $p->name . '</a></td>';
										} else {
											echo '<td>' . $p->name . '</td>';
										}
									?>
									<td class="right"><?php echo "$p->interest platser"; ?></td>
								</tr>
								<?php
							}
						}
					?>
				</table>
				<?php if($hasInterestedParties) : ?>
				<table>
					<tr>
						<th class="masterTooltip" title="Sällskap som än inte betalat in bokningsavgift">Intresserade sällskap</th>
						<th></th>
					</tr>
					<?php 
						$spotsLeft = $restaurant[6];
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
										echo '<td><a href="' . $nationURL . '/sallskap/' . $p->key . '">' . $p->name . '</a></td>';
									} else {
										echo '<td>' . $p->name . '</td>';
									}
								?>
								<td class="right"><?php echo "$p->interest platser"; ?></td>
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

	<?php if($loggedIn) : ?>
        <a class="button primary"  href="<?php echo $nationURL; ?>/interest/<?php echo $sitting->id; ?>">
            <span>+ Lägg en intresseanmälan</span>
        </a>
        <?php else : ?>
            <a class="button primary"  href="<?php echo $siteURL; ?>/facebook-login/fbconfig.php">
                <span>Logga in för att kunna lägga en intresseanmälan</span>
            </a>
        <?php endif; ?>
	<?php 

	if($myAccessLevel >= 5 || $isSittingForeman) : ?>
        <div class="single-sitting">
            <h2>Vy för Sittningsförmän</h2>
            <form action="<?php echo $nationURL; ?>/scripts.php" method="POST">
                <h3>Meny</h3>
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
            <h3>Sällskap</h3>
            <table class="fancy">
                <tr>
                    <th>Sällskap</th>
                    <th>Antal platser begärt</th>
                    <th>Antal platser bokade</th>
                    <th>Antal anmälda just nu</th>
                </tr>
            <?php
                $c = false;
                foreach($parties as $key => $p){
                    $signedUp = 0;
                    $booked = 0;
                    foreach ($partiesPayStatus as $key => $pps) {
                        if($pps[0] == $p->id){
                            if($pps[2] == "Halvt" || $pps[2] == "Ja"){
                                $booked += $pps[3];
                            } 
                            $signedUp += $pps[3];
                        }
                    }
                    ?>
                    <tr>
                        <td><?php echo $p->name; ?></td>
                        <td><?php echo $p->interest; ?></td>
                        <td><?php echo $booked; ?></td>
                        <td><?php echo $signedUp; ?></td>
                    </tr>
                    <?php
                }

            ?>
            </table>
            <h3>Matstatistik</h3>
            <table class="fancy">
                <tr>
                    <th>Matpreferens</th>
                    <th>Antal</th>
                </tr>
            <?php
                $c = false;
                foreach($foodStatistics as $key => $s){
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
					<th>Annat</th>
				</tr>
				<?php 
					$i = 1;
					foreach ($sittingUsersWithFoodPref as $key => $g) {
						?>
						<tr <?php echo (($c = !$c)?' class="odd"':''); ?>>
							<td><?php echo $i; ?></td>
							<td><?php echo $g[0]; ?></td>
							<td><?php echo $g[2]; ?></td>
                            <td><?php echo $g[5]; ?></td>
                            <td><?php echo $g[4]; ?></td>
						</tr>
						<?php
						$i++;
					}
				?>
			</table>
        </div>
    <?php endif; ?>
	<?php if($myAccessLevel >= 5) : ?>
        <div class="single-sitting">
            <h2>Vy för Quratel</h2>
                <form action="<?php echo $nationURL; ?>/scripts.php" method="POST">
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
        </div>
	<?php endif; ?>
</div>
<?php include 'footer.php'; ?>
