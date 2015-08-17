<?php include 'header.php'; ?>
<?php include 'dbconfig.php'; ?>

<div class="content">
	<div class="title">
		Sittningar HT15
	</div>
	<div class="event-grid">
		<?php 
			$result = mysql_query("SELECT * FROM sitting ORDER BY sittDate");
	
			while($row = mysql_fetch_assoc($result)) {
			$date = $row["sittDate"];
			?>
			<div class="event-window" id="<?php echo $date; ?>">
				<div class="event-window-date">
					<?php echo $date; ?>
				</div>
				<div class="event-window-spots">
					Antal platser: 200
				</div>
				<div class="event-window-button">
					<a href="#"> Se mer </a>
				</div>
				<button class="event-remove-button">Remove</button>
			</div>
		<?php } ?>
	</div>
</div>


<?php include 'footer.php'; ?>