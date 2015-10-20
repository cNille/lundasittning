<?php 
	require_once 'header.php';
	$key = $_GET['partyKey'];
 	$dbHandler = new DatabaseHandler();
	$party = $dbHandler->getPartyFromKey($key);
	$id = $party->id;
	$isParticipating = $dbHandler->isParticipating($id, $user[0]);
	$sitting = $dbHandler->getSitting($party->sittId);
	$partyUsers = $dbHandler->getPartyUsers($id);
	$partyGuests = $dbHandler->getPartyGuests($id);
	$creator = $dbHandler->getCreator($id);
    $payStatus = $dbHandler->getPayStatus($myAccessLevel);
	$isCreator = $creator[0] == $user[0];
	foreach ($partyUsers as $key => $g) {
		$g->foodpref = '';
		$myFoodPref = $dbHandler->getMyFoodpref($g->id);
		foreach ($myFoodPref as $key => $food) {
			$g->foodpref = $g->foodpref . $food[0] . '<br />';
		}
		$g->foodpref = substr($g->foodpref, 0, -1);
	}

	$dbHandler->disconnect();

	$isQuratel = $myAccessLevel >= 5;
 ?>

<div class="content">
	<div class="title"><?php echo $party->name; ?></div>
	<div class="party-content">
		<div class="left side">
				<h4>Datum</h4>
				<p><?php echo $sitting->date; ?></p>
				<h4>Sällskapsansvarig</h4> 
				<p><?php echo  $creator[1];?></p>
				<p><?php echo  $creator[2];?></p>
				<p><?php echo  $creator[3];?></p>
				<?php if($isCreator) : ?>
				<h4>Anmälningslänk</h4> 
				<p id="toClipboard" onClick="CopyToClipboard();"><?php echo 'http://' .$_SERVER[HTTP_HOST] . '/sittning/' . $party->key;?></p>
				<?php endif; ?>
				<h4>Meddelande</h4> 
				<?php 
					if($isCreator){
						?>
						<form action="scripts.php" method="POST">
							<textarea rows="4" cols="50" name="message" maxlength="250"><?php echo $party->message; ?></textarea>
							<br />
							<input type='hidden' value="<?php echo $id; ?>" name="partyId" />
							<input type="submit" value="Redigera" name="updatePartyMsg" />
						</form>
						<?php
					} else {
						echo "<p>$party->message</p>";
					}

				?>
				
		</div>
		<div class="right side">
			<?php if(!$isParticipating) : ?>
				<?php if($loggedIn) : ?>
					<a class="btn primary" href="partybook.php?partyId=<?php echo $id; ?>&guestMode=0">
						<span>Anmäl dig</span>
					</a>
				<?php else : ?>
					<?php $_SESSION['LAST_PAGE'] = '../' . $party->key; ?>
					<a class="btn primary" href="facebook-login/fbconfig.php">
						<span>Anmäl dig via inlogg</span>
					</a>
					<a class="btn"  href="partybook.php?guestMode=1&partyId=<?php echo $id; ?>">
						<span>Anmäl dig via gästinlogg</span>
					</a>
				<?php endif; ?>
			<?php endif; ?>
			<?php if($isCreator) : ?>
				<a class="btn"  href="partybook.php?guestMode=1&partyId=<?php echo $id; ?>">
					<span>Anmäl dina gäster här</span>
				</a>
			<?php endif; ?>
			<?php
				if($isQuratel){
					echo "<form action='scripts.php' method='POST'>";
				}
			?>
			<table>
				<tr>
					<th>#</th>
					<th>Gäster</th>
					<th>Matpreferens</th>
					<th>Betalat</th>
                    <?php
                        if($isQuratel){
                            echo "<th><p class='listtoggle'>Välj alla</p></th>";
                        }
                    ?>
				</tr>
				<?php 
					$i = 1;
					foreach ($partyUsers as $key => $g) {
						?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $g->name; ?></td>
							<td><?php echo $g->foodpref; ?></td>
                            <td><?php echo $g->payed; ?></td>
							<?php
								if($isQuratel){
									echo "<td><input type='checkbox' class='chbx' name='userId[]' value='$g->id' /></td>";
								}
							?>
						</tr>
						<?php
						$i++;
					}
					foreach ($partyGuests as $key => $g) {
						?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $g[1]; ?></td>
							<td><?php echo $g[3]; ?></td>
                            <td><?php echo $g[4]; ?></td>
							<?php
								if($isQuratel){
									echo "<td><input type='checkbox' class='chbx' name='guestId[]' value='$g[0]' /></td>";
								}
							?>
						</tr>
						<?php
						$i++;
					}
				?>
			</table>
			<?php
				if($isQuratel){
                    ?>
                    <input type="hidden" name="partykey" value="<?php echo $party->key; ?>">
                    <input type="hidden" name="partyid" value="<?php echo $party->id; ?>">
					<input type='submit' name='partyUpdatePay' value='Uppdatera till'>
                    <select name='payStatus'>
                        <?php
                            foreach ($payStatus as $key => $p) {
                                echo "<option value='$p[0]'>$p[0]</option>";
                            }
                        ?>
                    </select>
					</form>
                    <?php
				}
			?>
		</div>
	</div>
</div>

<script>
    var toggle = false;
    $(document).ready(function() { 
    $(".listtoggle").click(function() {
        $('.chbx').prop("checked", !toggle);
        toggle = !toggle; 
    });                 
});
</script>

<?php include 'footer.php'; ?>
