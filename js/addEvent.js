$(".event-add-button").click(function(){
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