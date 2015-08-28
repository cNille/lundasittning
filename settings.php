<?php 
	require_once 'header.php';
 	$dbHandler = new DatabaseHandler();
	$sitting = $dbHandler->getSettings($_GET['userId']);
	$dbHandler->disconnect();
 ?>

<div class="content">
	<div class="title">
		Inställningar
	</div>
	<div class="userSettings">
		<div class="left">
			<div id="name">
			</div>
			<div id="email">
			</div>
			<div id="telephone">
			</div>
			<div id="gender">
			</div>
		</div>
	</div>
</div>


<?php include 'footer.php'; ?>