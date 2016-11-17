<?php 
	require_once 'header.php';
	$key = $_GET['partyKey'];
 	$dbHandler = new DatabaseHandler();
	$party = $dbHandler->getPartyFromKey($key);
	$id = $party->id;
	$isParticipating = $dbHandler->isParticipating($id, $user[0]);
	$sitting = $dbHandler->getSitting($party->sittId);
	$partyUsers = $dbHandler->getPartyParticipant($id);
	$creator = $dbHandler->getCreator($id);
  $payStatus = $dbHandler->getPayStatus($myAccessLevel);
	$isCreator = $creator[0] == $user[0];
	
	$deposit = $restaurant[7];
	$price = $restaurant[8];


	$total = count($partyUsers)*($price+$deposit);
	foreach ($partyUsers as $key => $g) {
		$g->foodpref = '';
		$myFoodPref = $dbHandler->getMyFoodpref($g->id);
		foreach ($myFoodPref as $key => $food) {
			$g->foodpref = $g->foodpref . $food[0] . '<br />';
		}
    // If there is 'other' add it to end of foodpref. Otherwise remove last <br>.
    $g->foodpref = $g->other ? $g->foodpref . $g->other : substr($g->foodpref, 0, -6);
		
		if($g->payed == "Ja"){
			$sum += $price + $deposit;
		}
		else if($g->payed == "Halvt"){
			$sum += $deposit;
		}
	}
	$dbHandler->disconnect();


  
  if($party->partyPayed == 'Halvt'){
    $total = $party->interest * ($price+$deposit);
    $sum = $party->interest * $deposit;
    var_dump($party->interest);
    var_dump($price);
    var_dump($deposit);
    var_dump($total);
    var_dump($sum);
  }
  if($party->partyPayed == 'Ja'){
    $sum = $total;
  }

	$isQuratel = $myAccessLevel >= 5;
  $isOpen = $sitting->open; 
?>
<link rel="stylesheet" type="text/css" href="../../css/main.css" />

<div class="content">
	<div class="title"><?php echo $party->name; ?></div>


	<div class="party-content">
		<div class="left side">
            <h4>Datum</h4>
            <p><?php echo $sitting->date; ?></p>
            <h4>Platser anmälda</h4>
            <p><?php echo $party->interest; ?> platser</p>
            <h4>Sällskapsansvarig</h4> 
            <p><?php echo  $creator[1];?></p>
            <p><?php echo  $creator[2];?></p>
            <p><?php echo  $creator[3];?></p>
            <h4>Meddelande</h4> 
            <p><?php echo $party->message; ?></p>
		</div>
		<div class="right side">
      <?php if($isOpen) : ?>
        <?php if(!$isParticipating) : ?>
          <?php if($loggedIn) : ?>
            <a class="btn primary" href="<?php echo $nationURL; ?>/partybooking/<?php echo $id; ?>/0">
              <span>Anmäl dig</span>
            </a>
          <?php else : ?>
            <?php $_SESSION['LAST_PAGE'] = '../' . $party->key; ?>
            <a class="btn primary" href="<?php echo $nationURL; ?>/facebook-login/fbconfig.php">
              <span>Anmäl dig via inlogg</span>
            </a>
            <a class="btn"  href="<?php echo $nationURL; ?>/partybooking/<?php echo $id; ?>/1">
              <span>Anmäl dig utan inlogg</span>
            </a>
          <?php endif; ?>
        <?php else : ?>
                  <span class="btn primary" style="cursor: default;">
                      Du är redan anmäld
                  </span>
        <?php endif; ?>
      <?php elseif($isParticipating) : ?>
        <span class="btn primary" style="cursor: default;">
          Du är redan anmäld
        </span>
      <?php else : ?>
        <span class="btn primary" style="cursor: default;">
          Anmälan är stängd
        </span>
			<?php endif; ?>
      <table>
				<tr>
					<th>#</th>
					<th>Gäster</th>
				</tr>
				<?php 
                $i = 1;
                foreach ($partyUsers as $key => $g) {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $g->name; ?></td>
                    </tr>
                    <?php
                    $i++;
                }
				?>
			</table>
		</div>
	</div>


    <a href="<?php echo $nationURL; ?>/sittning/<?php echo $party->sittId; ?>" class="button primary">Tillbaka till sittningen</a>


	<?php if($isCreator || $isQuratel) : ?>
    <div class="party-content">
        <div class="left side">
        <h3>Vy för Sällskapsskaparen</h3>
            <h4>Platser anmälda</h4>
            <p class="masterTooltip" title="För att uppdatera detta, kontakta nationen"><?php echo $party->interest; ?> platser</p>
            <h4>Kvar att betala</h4>
            <p class="masterTooltip" title="Tänk på att summan kan bli lägre efter förmannarabatt"> <?php echo $total-$sum ?> kr</p>
            <h4>Anmälningslänk</h4> 
            <p id="toClipboard" class="masterTooltip" title="Klicka för att kopiera." onClick="CopyToClipboard();" style="font-size: 13px; cursor: pointer"><?php echo $nationURL . '/sallskap/' . $party->key;?></p>
            <h4>Meddelande</h4> 
            <form action="<?php echo $nationURL; ?>/scripts.php" method="POST">
                <textarea rows="4" cols="50" name="message" maxlength="250"><?php echo $party->message; ?></textarea>
                <br />
                <input type='hidden' value="<?php echo $id; ?>" name="partyId" />
                <input type="submit" value="Uppdatera meddelande" name="updatePartyMsg" />
            </form>
        </div>
        <div class="right side">
            <a class="btn"  href="<?php echo $nationURL; ?>/partybooking/<?php echo $id; ?>/1">
                <span>Anmäl en gäst här</span>
            </a>
            <a class="btn"  href="<?php echo $nationURL; ?>/guestlistuploader/<?php echo $id; ?>">
                <span>Ladda in gästlista från Excel</span>
            </a>

			<form action="<?php echo $nationURL; ?>/scripts.php" method='POST'>
			<table>
				<tr>
					<th>#</th>
					<th>Gäster</th>
                    <th>Matpreferens</th>
                    <th>Betalat</th>
                    <th><p class='listtoggle'>Välj alla</p></th>
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
								<td><input type='checkbox' class='chbx' name='userId[]' value='<?php echo $g->id; ?>' /></td>
						</tr>
						<?php
						$i++;
					}
				?>
			</table>
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
            <input type='submit' name='partyDeleteParticipant' value='Ta bort markerade'>
            </form>
        </div>
    </div>
	<?php endif; ?>


    <?php if($isQuratel) : ?>
    <div class="party-content">
        <h3>Vy för Quratel</h3>
        <h4>Platser anmälda</h4>
        <form action="<?php echo $nationURL; ?>/scripts.php" method="POST">
            <input type="number" name="interest" value="<?php echo $party->interest; ?>" />
            <input type="hidden" name="partyId" value="<?php echo $party->id; ?>" />
            <input type="submit" name="updatePartyInterest" value="Uppdatera platser" />

            <hr />
            <h3>Ta bort sällskap<h3>
            <input type="submit" name="deleteParty" value="Radera Sällskap" />
            <input type="hidden" name="sittId" value="<?php echo $party->sittId; ?>" />

        </form>
        <form action="<?php echo $nationURL; ?>/scripts.php" method="POST">
            <h3>Betalat (hela sällskapet)</h3>
            <input type='radio' name='partypayed' value='Nej' <?php if($party->partyPayed == 'Nej'){ echo "checked";} ?>>Nej</input><br />
            <input type='radio' name='partypayed' value='Halvt' <?php if($party->partyPayed == 'Halvt'){ echo "checked";} ?>>Halvt</input><br />
            <input type='radio' name='partypayed' value='Ja' <?php if($party->partyPayed == 'Ja'){ echo "checked";} ?>>Ja</input><br />
            <input type='submit' name="updatePartyPayed" value="Uppdatera">
            <input type='hidden' name='partyId' value="<?php echo $party->id; ?>">
            <input type='hidden' name='partyKey' value="<?php echo $party->key; ?>">
            <br /><br />
        </form>
    </div>
	<?php endif; ?>


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
