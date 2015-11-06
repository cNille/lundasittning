<?php 
    require_once 'header.php';

 	$dbHandler = new DatabaseHandler();
    $sittings = $dbHandler->getSittings(1);
    $sittingSpotsTaken = $dbHandler->getSittingsSpots(1);
	$dbHandler->disconnect();

	function spotsLeftTextify($spotsLeft, $resSize){
		// För översikt under testning, ta bort sen.
		return "Platser kvar: " . $spotsLeft;

		if($spotsLeft > $resSize * 0.7){
			return "Ledig";
		} else if ($spotsLeft < 5){
			return "Fåtal platser kvar";
		}
		return "Platser kvar: " . $spotsLeft;
	}
	
 ?>

<div class="content">
	<div class="title">
		Sittningar HT15
	</div>
	<div class="event-grid">
		<div class="event-window" id="" style="display: none;">
			<a href="" class="event-window-link">
			<div class="width">
				<div class="event-window-date">
				</div>
				<div class="event-window-spots">
					Ledig
				</div>
				<div class="event-window-button">
					Se mer
				</div>
				<?php if($myAccessLevel >= 5){ ?>
					<button class="event-remove-button">X</button>
				<?php } ?>
			</div>
			</a>
		</div>
		<?php 
			foreach($sittings as $row => $s) {
				$date = date('j/n', strtotime($s[1]));

				$spotsTaken = 0;
				foreach ($sittingSpotsTaken as $key => $sst) {
					if($sst[0] == $s[0]){
						$spotsTaken = $sst[1];
					}
				}

                $spotsLeft = $restaurant[9] - $spotsTaken;
				?>
					<div class="event-window" id="<?php echo $s[0]; ?>">
					<a href="./sitting.php?sittId=<?php echo $s[0]; ?>" class="event-window-link">
						<div class="width">
							<div class="event-window-date">
								<?php echo $date; ?>
							</div>
							<div class="event-window-spots">
								<?php echo spotsLeftTextify($spotsLeft, $restaurant[6]);?>
							</div>
							<div class="event-window-button">
								 Se mer
							</div>
							<?php if($myAccessLevel >= 5){ ?>
								<button class="event-remove-button">X</button>
							<?php } ?>
						</div>
					</a>
					</div>
		<?php } ?>
		<?php if($myAccessLevel >= 5){ ?>
			<div class="event-window" id="event-creator">
				<p id="event-creator-initiate"> + </p>
			</div>
		<?php } ?>
	</div>
</div>
<div style="clear:both;"></div>


<?php include 'footer.php'; ?>
