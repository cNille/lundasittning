<?php 
	require_once 'header.php';
 	$dbHandler = new DatabaseHandler();
	$sitting = $dbHandler->getSitting($_GET['sittId']);
	$user = $dbHandler->getUser($fbid);
	$dbHandler->disconnect();
	$userName = $user[2];
	$userEmail = $user[3];
	$userTelephone = $user[4];
 ?>
<div class="content">
	<div class="title">Intresseanmälan</div>
	<div class="interest-content">
		<h2>Sittning <?php echo datePrettify($sitting->date);?></h2>
		<p>För att lägga en anmälan gör såhär</p> 
		<ol>
			<li>Bekräfta ifyllda fält och fyll i resterande fält.</li>
			<li>Ladda ner sittningsmallen.</li>
			<li>Fyll i gästlistan och spara som en tab-separerad-fil eller komma-sepererad-fil (med ändelsen '.tsv' eller '.csv')</li>
			<li>Ladda upp filen och tryck på klar.</li>
			<li>Mail kommer att skickas till nationen och en bekräftelse med mer info till dig</li>
		</ol>
		<a href='./files/SittningsMall.xlsx' target="_blank">Ladda ner mall</a>
		<form>
			Bokare <br />
			<span><?php echo $userName; ?></span>
			Datum <br />
			<span><?php echo $sitting->date; ?></span>
			Epost *<br />
			<span><input type="text" name="email" value="<?php echo $userEmail; ?>"></span>
			Telefonnummer *<br />
			<span><input type="text" name="phone" value="<?php echo $userTelephone; ?>"></span>
		</form>
		<p>
			Välj fil med gästlista
			<input type="file" id="files" name="file" /> 
			<span class="readBytesButtons" style="display: block; padding-top:30px;">
			  <button>Skicka anmälan</button>
			</span>
		</p>
		<div id="byte_content"></div>
		<h2>Gästlista</h2>
		<table class="generatedTable">
		</table>		
	</div>
</div>
<script>
	var guestList;
	var seperator;
	String.prototype.endsWith = function(suffix) { return this.indexOf(suffix, this.length - suffix.length) !== -1; };

	//Adds a eventlistener for when the button is pressed.
	document.querySelector('.readBytesButtons').addEventListener('click', function(evt) {
		guestList = Array();
		if (evt.target.tagName.toLowerCase() == 'button') {
			var startByte = evt.target.getAttribute('data-startbyte');
			var endByte = evt.target.getAttribute('data-endbyte');
	    	readData(startByte, endByte);
	    }
	}, false);
	
	//Load data from file.
	function readData(opt_startByte, opt_stopByte) {
		var files = document.getElementById('files').files;
		if (!files.length) {
		  alert('Please select a file!');
		  return;
		}
		var file = files[0];
		if(file.name.endsWith(".tsv")){
			seperator = '\t';
		} else if(file.name.endsWith(".csv")){
			seperator = ';';
		} else {
			alert('Fel format! Ska sluta på .tsv eller .csv');
		  	return;
		}
		var reader = new FileReader();
		// If we use onloadend, we need to check the readyState.
		reader.onloadend = function(evt) {
			if (evt.target.readyState == FileReader.DONE) { // DONE == 2
				dataToObjects(evt.target.result);  
				fillTable();
			}
		};
		reader.readAsBinaryString(file);
	}

	//Reads the data from the rows and transforms to object.
	function dataToObjects(dataString){
		var dataRows = dataString.split("\n");
		guestList = [];

		var dateRow = dataRows[2].split(seperator);
		var bookerRow = dataRows[3].split(seperator);
		var date = dateRow[2];
		var booker = bookerRow[2];

		var guestName, guestPreferens;
		for(var i = 7; i < dataRows.length; i++){
			dataCol = dataRows[i].split(seperator);
			guestName = dataCol[1];
			if(guestName != ""){
				guestList.push({ 'name' : guestName, 'preferens' : dataCol[2] });
			}
		}
	}
	
	// Temp function. Fills up a table on page with guestlist.
	function fillTable(){
		$('.generatedTable').empty();
		$('.generatedTable').append('<tr><th>Nr</th><th>Namn</th><th>Preferens</th></tr>');
		var y;
		for(x in guestList){
			y = parseInt(x) + 1;
			$('.generatedTable').append('<tr><td>' + y + '</td><td>' + guestList[x].name + '</td><td>' + guestList[x].preferens + '</td></tr>');
		}
	}
</script>
<?php include 'footer.php'; ?>































