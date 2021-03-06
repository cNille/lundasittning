<?php 
	require_once 'header.php';
 	$dbHandler = new DatabaseHandler();

 	$access = $dbHandler->getAccessLevel($fbid, $restaurant[0]);

    // Requires accesslevel of 5 or else redirects to index.php
 	requireAccessLevel(5, $access, $nationURL);

 	$users = $dbHandler->getParticipants($restaurant[0]);
 	$userTypes = $dbHandler->getUserTypes($access);
	$dbHandler->disconnect();
 ?>
<div class="content">
	<?php echo "<h2>Användare vid $restaurant[0]</h2>"; ?>
	<div class="section">
		<h3></h3>
		
		<form action="<?php echo $nationURL; ?>/scripts.php" method="POST">
		<table class="fancy">
			<tr>
				<th>Namn</th>
				<th>Epost</th>
				<th>Telefon</th>
				<th>Användartyp</th>
                <th></th>
			</tr>
			<?php
                $c = false;
				foreach ($users as $key => $u) {
					$type = $u[5] != "" ? $u[5] : "Användare"
					?>
						<tr <?php echo (($c = !$c)?' class="odd"':''); ?>>
							<?php echo "<td>$u[1]</td>"; ?>
							<?php echo "<td>$u[2]</td>"; ?>
							<?php echo "<td>$u[3]</td>"; ?>
							<?php echo "<td>$u[5]</td>"; ?>
							<?php echo "<td><input type='checkbox' class='typeBox' value='$u[0]' name='user[]' /></td>"; ?>
						</tr>
					<?php
				}
			?>
		</table>
		<input type="submit" name="updateUserType" value="Uppdatera markerade användare till" />
		<select name="userType">
			<?php
				foreach ($userTypes as $key => $ut) {
					echo "<option value='$ut[0]'>$ut[0]</option>";
				}
			?>
		</select>
	</form>
	</div>
</div>


<?php include 'footer.php'; ?>
