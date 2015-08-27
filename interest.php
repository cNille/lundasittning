<?php 
	require_once 'header.php';
 	$dbHandler = new DatabaseHandler();
	$sitting = $dbHandler->getSitting($_GET['sittId']);
	$dbHandler->disconnect();

 ?>


<div class="content">
	<div class="title">Intresseanmälan</div>

	<div class="interest-content">
		<p>
			För att enklast lägga en beställning gör såhär;
		</p>
		<ol>
			<li>Ladda ner sittningsmallen.</li>
			<li>Fyll i den och spara som en tab-separerad-fil (med ändelsen '.tsv')</li>
			<li>Ladda upp filen och tryck på klar.</li>
			<li>Mail kommer att skickas till nationen och en bekräftelse till dig</li>
		</ol>
		<a href='./files/SittningsMall.xlsx' target="_blank">Ladda ner mall</a>


		<style>
		  #byte_content {
		    margin: 5px 0;
		    max-height: 100px;
		    overflow-y: auto;
		    overflow-x: hidden;
		  }
		  #byte_range { margin-top: 5px; }
		</style>
		<h3>Välj fil</h3>
		<input type="file" id="files" name="file" /> 
		<span class="readBytesButtons" style="display: block; padding-top:30px;">
		  <button>Klar</button>
		</span>
		<div id="byte_content"></div>
		<h2>Gästlista</h2>
		<table class="generatedTable">
		</table>		
	</div>
</div>


<script>
	var guestList;

	//Triggers when generate-button is pressed.
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

	function dataToObjects(dataString){
		var dataRows = dataString.split("\n");
		guestList = [];

		var dateRow = dataRows[2].split("\t");
		var bookerRow = dataRows[3].split("\t");
		var date = dateRow[2];
		var booker = bookerRow[2];

		var guestName, guestPreferens;
		for(var i = 7; i < dataRows.length; i++){
			dataCol = dataRows[i].split("\t");
			guestName = dataCol[1];
			if(guestName != ""){
				guestList.push({ 'name' : guestName, 'preferens' : dataCol[2] });
			}
		}
	}

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































