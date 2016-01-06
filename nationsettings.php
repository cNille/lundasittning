<?php 
	require_once 'header.php';
	$dbHandler = new DatabaseHandler();

 	$access = $dbHandler->getAccessLevel($fbid, $restaurant[0]);
 	requireAccessLevel(5, $access, $nationURL);
	$dbHandler->disconnect();



?>

<div class="content">
	<div class="title">
	    Nationsinställningar
	</div>
	<div class="userSettings">
		<form action="<?php echo $nationURL; ?>/scripts.php" enctype="multipart/form-data" method="POST">
			<div style="max-width: 280px; margin: auto;">
				<h3>
	 		        <?php echo $restaurant[0]; ?>
                    <input type="hidden" name="name" value="<?php echo $restaurant[0]; ?>" />
				</h3>
				<div class="category">
                    <h4>Bakgrundsbild</h4>
                    <input type="file" id="bgimageinput" name="backgroundimage" accept="image/*" />
                    <div id="backgroundgallery">
                        <img id="bgimage" src="uploads/<?php echo $restaurant[11]; ?>" onerror="this.src='./images/reject.png';" />
                    </div>
				</div>
				<div class="category">
                    <h4>Nationslogga</h4>
                    <input type="file" id="loggoimageinput" name="nationloggo" accept="image/*" />
                    <div id="loggogallery">
                        <img id="loggoimage" src="uploads/<?php echo $restaurant[12]; ?>" onerror="this.src='./images/reject.png';" />
                    </div>
				</div>
                <br /><br /><br />
                <br /><br /><br />
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
                    <textarea rows="4" cols="50" name="summary" maxlength="1000"><?php echo $restaurant[10]; ?></textarea>
                </div>


				<input class="primary category" type="submit" value="Spara" name="updateNationSettings" />
			</div>
			<input type="hidden" name="userId" value="<?php echo $user[0]; ?>" />

		</form>
	</div>
</div>
<script>
$('#bgimageinput').change(function(){
    var file = this.files[0];
    var img = document.getElementById("bgimage");
    img.file = file;

    // Using FileReader to display the image content
    var reader = new FileReader();
    reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
    reader.readAsDataURL(file);

});
$('#loggoimageinput').change(function(){
    var file = this.files[0];
    var img = document.getElementById("loggoimage");
    img.file = file;

    var reader = new FileReader();
    reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
    reader.readAsDataURL(file);
});
</script>
 <style>
    #gallery .thumbnail{
        position: relative;
        display: block;
        width: 100%;
        height: 150px;
        float:left;
        margin:2px;
    }
    #gallery .thumbnail img{
        position: relative;
        display: block;
        width: 100%;
        height: 150px;
    }
</style>

<?php include 'footer.php'; ?>
