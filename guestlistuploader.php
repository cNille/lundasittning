<?php 
	require_once 'header.php';
	$id = $_GET['partyid'];
 	$dbHandler = new DatabaseHandler();
 	$party = $dbHandler->getParty($id);
 	$dbHandler->disconnect();

 	$key = $party->key;
 ?>
<div class="content">
	<div class="title">Ladda upp Gästlista</div>
	<div class="interest-content">
		<a class="btn" href="<?php echo $nationURL; ?>/sallskap/<?php echo $key; ?>">Gå tillbaka</a>
		<p>För att läsa in en gästlista gör såhär</p> 
		<ol>
			<li>Ladda ner sittningsmallen.</li>
			<li>Fyll i gästlistan och spara som en tab-separerad-fil eller komma-sepererad-fil (med ändelsen '.tsv' eller '.csv')</li>
			<li>Ladda upp filen. </li>
			<li>Läs in filen. </li>
			<li>Dubbelkolla att allt blev inläst korrekt, annars ändra i filen och ladda upp igen. </li>
			<li>Tryck på klar.</li>
		</ol>
		<a href='<?php echo $siteURL; ?>/files/Gastlista.xlsx' class="btn primary" target="_blank">Ladda ner mall</a>
        <br />
		<p>
			Välj fil med gästlista
			<input type="file" id="files" name="file" /> 
			<span class="readBytesButtons" style="display: block; padding-top:30px;">
			  <button class="btn">Läs in fil</button>
			</span>
		</p>
        <button id="saveButton" class="btn primary" onclick="addListToParty()">Spara</button>
		<div id="byte_content"></div>
		<h2 id="guestListHeader"></h2>
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
			//return if no file selected.
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

    function swedify(str){
        str = str.replace("Ã¥", "å");
        str = str.replace("Ã¤", "ä");
        str = str.replace("Ã¶", "ö");
        return str
    }

	//Reads the data from the rows and transforms to object.
	function dataToObjects(dataString){
		var dataRows = dataString.split("\n");
		guestList = [];

		var dateRow = dataRows[2].split(seperator);
		var bookerRow = dataRows[3].split(seperator);
		var date = dateRow[2];
		var booker = bookerRow[2];

		var guestName, preferens, other;
		for(var i = 7; i < dataRows.length; i++){
			dataCol = dataRows[i].split(seperator);
			guestName = dataCol[1];
			if(guestName != ""){
                guestName = swedify(guestName);
                preferens = swedify(dataCol[2]);
                other = swedify(dataCol[3]);
                
				guestList.push({ 'name' : guestName, 'preferens' : preferens, 'other' : other});
			}
		}
	}
	
	// Temp function. Fills up a table on page with guestlist.
	function fillTable(){
        $("#guestListHeader").text('Gästlista');
		$('.generatedTable').empty();
		$('.generatedTable').append('<tr><th>#</th><th>Namn</th><th>Preferens</th><th>Annat</th></tr>');
		var y;
		for(x in guestList){
			y = parseInt(x) + 1;
			$('.generatedTable').append('<tr><td>' + y + '</td><td>' + guestList[x].name + '</td><td>' + guestList[x].preferens + '</td><td>' + guestList[x].other + '</td></tr>');
		}
	}

    function addListToParty(){
        
        var guestStr = JSON.stringify(guestList);
        var partyId = <?php echo $_GET["partyid"]; ?>;
		$.ajax({
			type: 'POST',
			url: 'db/dbAjax.php',
			data: 'action=addGuestList&partyId=' + partyId + '&guestList=' + guestStr,
			success: function(partyKey){

                if(partyKey == "notCreator"){
                    alert('Error: Du är inte skapare av detta sällskap.');
                } else {
                    $("#saveButton").text("Sparat");
                    $("#saveButton").removeClass("primary");

                }
			}
		});
    }

    function done(){
        ;
    }


</script>
<?php include 'footer.php'; ?>
