$('body').on('click', '.event-remove-button', function() {
	// if (!(confirm("Vill du gå emot PQens vilja och minska intäkterna genom att ta bort detta datum?"))) {
// 		return;
//     }
	
	$('#failsafe').dialog({
		modal:true,
		width:450,
		resizable: false,          
		buttons: [{
			text: 'Yes',
			click: function() {}
		}, {
			text: 'No',                
			click: function() {return;};
		}]
	});
	
	var temp = removeEvent(this, "event-window");

	$.ajax({
		type: 'POST',
		url:  SITEURL + '/database/dbAjax.php',
		data: 'action=removeSitting&id=' + temp,
		success: function(data){
			$('#' + temp).remove();
		}
	});
});
        	
function removeEvent (el, cls) {
    while ((el = el.parentElement) && !el.classList.contains(cls));
    return el.id;
}