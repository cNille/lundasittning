$(".event-remove-button").click(function(){
	var temp = removeEvent(this, "event-window");

	$.ajax({
		type: 'POST',
		url: 'db/dbAjax.php',
		data: 'action=removeSitting&date=' + temp,
		success: function(data){
			alert(data);
			// If you want, alert whatever your PHP script outputs
		}
	});
});
            	
function removeEvent (el, cls) {
    while ((el = el.parentElement) && !el.classList.contains(cls));
    el.style.display = "none";
    return el.id;
}