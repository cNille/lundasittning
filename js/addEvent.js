$("#event-creator-initiate").click(function(){
	document.getElementById("event-creator-initiate").style.display = "none";
	$("#event-creator").append( "<input type='text' name='date' id='newDate' placeholder='DD/MM' maxlength='5' autocomplete='off' >");
	document.getElementById("newDate").focus();
	
	$("#event-creator").append( "<button id='reject'>X</button>");
	$("#event-creator").append( "<button id='confirm'>Y</button>");
});

$("#reject").click(function(){
	var temp = addEvent(this, "event-window");

	$.ajax({
		type: 'POST',
		url: 'db/dbAjax.php',
		data: 'action=addSitting&date=' + temp,
		success: function(data){
			// If you want, alert whatever your PHP script outputs
		}
	});
});

$("#confirm").click(function(){
	var temp = addEvent(this, "event-window");

	$.ajax({
		type: 'POST',
		url: 'db/dbAjax.php',
		data: 'action=addSitting&date=' + temp,
		success: function(data){
			// If you want, alert whatever your PHP script outputs
		}
	});
});


            	
function addEvent (el, cls) {
    while ((el = el.parentElement) && !el.classList.contains(cls));
    el.style.display = "none";
    return el.id;
}

function stopCreation (){
}