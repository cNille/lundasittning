<?php 
    require_once 'header.php';
    include_once("analyticstracking.php");

 	$dbHandler = new DatabaseHandler();
    $sittings = $dbHandler->getSittings(1, $restaurant[0]);
    $sittingSpotsTaken = $dbHandler->getSittingsSpots(1);
	$dbHandler->disconnect();	

	
    function spotsLeftTextify($spotsLeft, $resSize){
        // För översikt under testning, ta bort sen.
        //return "Platser kvar: " . $spotsLeft;

        if( $resSize - $spotsLeft < 10){
            return "Ledig";
        } else if ($spotsLeft == 0){
            return "Fullt";
        } else if ($spotsLeft < 5){
            return "Fåtal platser kvar";
        }
        return "Platser kvar: " . $spotsLeft;
    }
  function dateToSemester($timeStamp){
    $year = date('y', strtotime($timeStamp));
    $month = date('n', strtotime($timeStamp));
    return ($month < 7 ? "VT" : "HT") . $year;
  }

  $sittingGroups = array();
  foreach($sittings as $row => $s) {
    $sem = dateToSemester($s[1]);
    
    foreach($sittingGroups as $key => $g){
      if($sittingGroups[$sem] != null){
        array_push($sittingGroups[$sem], $s);
      }
    } 
    if($sittingGroups[$sem] == null){
      $sittingGroups[$sem] = array($s);
    }
  }
  if(count($sittingGroups) == 0){
    $sittingGroups[""] = array();
  }
 ?>

<?php 
  $first = true;
  foreach($sittingGroups as $key => $sittingArray) {
?>
<div class="<?php if($first){ echo "content"; $first = false;} else{echo "content sittcontent";}?>" >
	<div class="title">
		Sittningar <?php echo $key;?>
	</div>
	<div class="event-grid">
		<div class="event-window" id="" style="display: none;">
			<a href="" class="event-window-link">
				<div class="width">
					<h1 class="event-window-date">
					</h1>
					<div class="event-window-spots">
						Ledig
					</div>
					<div class="event-window-button">
						Se mer
					</div>
				</div>
			</a>
			<?php if($myAccessLevel >= 5){ ?>
				<button class="event-remove-button">X</button>
			<?php } ?>
		</div>
    <?php
			foreach($sittingArray as $row => $s) {
				$date = date('j/n', strtotime($s[1]));

        $spotsTaken = 0;
        if($s[3] != 0){
          $spotsTaken= $s[3];
        } else {
          foreach ($sittingSpotsTaken as $key => $sst) {
            if($sst[0] == $s[0]){
              $spotsTaken = $sst[1];
            }
          } 
        }

        $spotsLeft = $restaurant[9] - $spotsTaken;
				?>
					<div class="event-window" id="<?php echo $s[0]; ?>">
						<a href="<?php echo "$nationURL/sittning/$s[0]"; ?>" class="event-window-link">
							<div class="width">
								<h1 class="event-window-date">
									<?php echo $date; ?>
								</h1>
								<div class="event-window-spots masterTooltip" title="Antalet platser där sittningsavgiften inte har inkommit">
									<?php echo spotsLeftTextify($spotsLeft, $restaurant[9]);?>
								</div>
								<div class="event-window-button">
									 Se mer
								</div>
							</div>
						</a>
						<?php if($myAccessLevel >= 5){ ?>
							<button class="event-remove-button">X</button>
						<?php } ?>
					</div>
		<?php } ?>
		<?php if($myAccessLevel >= 5){ ?>
			<div class="event-window" id="event-creator">
				<p id="event-creator-initiate"> + </p>
			</div>
		<?php } ?>
	</div>
</div>
    <?php } ?>
<div style="clear:both;"></div>


<?php include 'footer.php'; ?>
