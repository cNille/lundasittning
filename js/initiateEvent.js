$("#event-creator-initiate").click(function(){
	document.getElementById("event-creator-initiate").style.display = "none";
	$("#event-creator").append( "<input type='text' name='date' id='newDate' placeholder='DD/MM' maxlength='5' autocomplete='off' >");
	document.getElementById("newDate").focus();
	
	$("#event-creator").append( "<button id='reject'>Y</button>");
	$("#event-creator").append( "<button id='confirm'>Y</button>");
});
            	
function addEvent (el, cls) {
    while ((el = el.parentElement) && !el.classList.contains(cls));
    el.style.display = "none";
    return el.id;
}