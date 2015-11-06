<?php 
	require_once 'header.php';
	$dbHandler = new DatabaseHandler();

 	$access = $dbHandler->getAccessLevel($fbid, $restaurant[0]);
 	requireAccessLevel(5, $access);
	$dbHandler->disconnect();



?>

<div class="content">
	<div class="title">
	    Nationsinställningar
	</div>
	<div class="userSettings">
		<form action="scripts.php" method="POST">
			<div style="max-width: 280px; margin: auto;">
				<h3>
	 		        <?php echo $restaurant[0]; ?>
                    <input type="hidden" name="name" value="<?php echo $restaurant[0]; ?>" />
				</h3>
				<div class="category">
			        Smeknamn <input type="text" name="nickname" value="<?php echo $restaurant[1]; ?>">
				</div>
				<div class="category">
					E-mail <input type="text" name="email" value="<?php echo $restaurant[2]; ?>">
				</div>
				<div class="category">
					Telefonnummer <input type="text" name="phone" value="<?php echo $restaurant[3]; ?>">
				</div>
                <div class="category">
                    Hemsida <input type="text" name="homepage" placeholder="http://..." value="<?php echo $restaurant[4]; ?>">
                </div>
                <div class="category">
                    Öppettider <input type="text" name="hours" value="<?php echo $restaurant[5]; ?>">
                </div>
                <div class="category">
                    Adress <input type="text" name="address" value="<?php echo $restaurant[6]; ?>">
                </div>
                <div class="category">
                    Bokningsavgift <input type="number" name="deposit" value="<?php echo $restaurant[7]; ?>">
                </div>
                <div class="category">
                    Sittningsavgift <input type="number" name="price" value="<?php echo $restaurant[8]; ?>">
                </div>
                <div class="category">
                    Max antal gäster per sittning <input type="number" name="size" value="<?php echo $restaurant[9]; ?>">
                </div>
                <div class="category">
                    Kort beskrivande text för nationen                 
                    <textarea rows="4" cols="50" name="summary" maxlength="250"><?php echo $restaurant[10]; ?></textarea>
                </div>
				<input class="primary category" type="submit" value="Spara" name="updateNationSettings" />
			</div>
			<input type="hidden" name="userId" value="<?php echo $user[0]; ?>" />
		</form>
	</div>
</div>

<?php include 'footer.php'; ?>
