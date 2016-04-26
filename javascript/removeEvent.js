$('body').on('click', '.event-remove-button', function(event) {
	// if (!(confirm("Vill du gå emot PQens vilja och minska intäkterna genom att ta bort detta datum?"))) {
// 		return;
//     }

	var temp = removeEvent(this, "event-window");
	
	var dynamicDialog = $('<div id="conformBox">'+
	'<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;">'+
	'</span>Vill du gå emot PQens vilja och minska intäkterna genom att ta bort detta datum?</div>');

	dynamicDialog.dialog({
			dialogClass: "clickoncloseoutside",
			closeOnEscape: true,
			width: 300,
			modal : true,

			buttons : 
					[{
							text : "Ja",
							click : function() {
									deleteDate(temp);
									$(this).dialog("close");
							}
					},
					{
							text : "Nej",
							click : function() {
									$(this).dialog("close");
							}
					}],
			close: function (event, ui) {
            	$(this).remove();
        	}
	});
});

function removeEvent (el, cls) {
    while ((el = el.parentElement) && !el.classList.contains(cls));
    return el.id;
}

function deleteDate(temp){
	$.ajax({
		type: 'POST',
		url:  SITEURL + '/database/dbAjax.php',
		data: 'action=removeSitting&id=' + temp,
		success: function(data){
			$('#' + temp).remove();
		}
	});
}

$("body").on("click", "div.ui-widget-overlay:visible", function() {
	$(".ui-dialog.clickoncloseoutside:visible").find(".ui-dialog-content").dialog("close");
}); 	
