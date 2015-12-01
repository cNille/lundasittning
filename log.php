<?php 
	require_once 'header.php';
 	$dbHandler = new DatabaseHandler();

 	$access = $dbHandler->getAccessLevel($fbid, $restaurant[0]);
 	requireAccessLevel(10, $access); // Requires accesslevel of 10 or else redirects to index.php

 	$log = $dbHandler->getLog();
	$dbHandler->disconnect();
 ?>
<div class="content">
	<?php echo "<h2>Log</h2>"; ?>
	<div class="section">
	<h3></h3>
	<table class="fancy">
		<tr>
			<th>LogId</th>
			<th>AnvändarId</th>
			<th>Event</th>
			<th>Datum</th>
            <th>Resturang</th>
		</tr>
		<?php
            $c = false;
			foreach ($log as $key => $l) {
				?> 
				<tr <?php echo (($c = !$c) ? " class='odd'" : ''); ?> >
					<?php echo "<td>$l[0]</td>"; ?>
					<?php echo "<td>$l[1]</td>"; ?>
					<?php echo "<td>$l[2]</td>"; ?>
					<?php echo "<td>$l[3]</td>"; ?>
					<?php echo "<td>$l[4]</td>"; ?>
				</tr>
				<?php
			}
		?>
	</table>
	</div>
</div>


<?php include 'footer.php'; ?>
