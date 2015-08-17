<?php include 'header.php'; ?>

<div class="content">
	<div class="title">
		Sittningar HT15
	</div>
	<div class="event_grid">
		<?php for ($i = 0; $i <= 5; $i++) { ?>
			<div class="event_window">
				<div class="event_window_date">
					20/9
				</div>
				<div class="event_window_spots">
					200
				</div>
				<div class="event_window_button">
					<a href="#"> Klicka här </a>
				</div>
			</div>
		<?php } ?>
	</div>
</div>


<?php include 'footer.php'; ?>