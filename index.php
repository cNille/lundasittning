<?php include 'header.php'; ?>

<div class="content">
	<div class="title">
		Sittningar HT15
	</div>
	<div class="event-grid">
		<?php for ($i = 0; $i <= 10; $i++) { ?>
			<div class="event-window">
				<div class="event-window-date">
					20/9
				</div>
				<div class="event-window-spots">
					Antal platser: 200
				</div>
				<div class="event-window-button">
					<a href="#"> Se mer </a>
				</div>
			</div>
		<?php } ?>
	</div>
</div>


<?php include 'footer.php'; ?>