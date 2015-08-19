$("#event-creator-initiate").click(function(){
	document.getElementById("event-creator-initiate").style.display = "none";
	$("#event-creator").append( "<input type='text' name='date' id='newDate' placeholder='DD/MM' minlength='3' maxlength='5' autocomplete='off' >");
	document.getElementById("newDate").focus();
	
	$("#event-creator").append( "<button id='reject'>X</button>");
	$("#event-creator").append( "<button id='confirm'>Y</button>");
	
	$("#reject").click(function(){
		resetCreation();
	});

	$("#confirm").click(function(){
		var date = document.getElementById("newDate").value;
		var arr = date.split('/');
		
		var currentDate = new Date();
		var monthNumber = currentDate.getMonth();
		
		if(arr[0].length < 2){
			arr[0] = "0" + arr[0];
		}
		if(arr[1].length < 2){
			arr[1] = "0" + arr[1];
		}

		if(arr[1] < monthNumber){
			var realDate = "2016-" + arr[1] + "-" + arr[0];
		}
		else{
			var realDate = "2015-" + arr[1] + "-" + arr[0];
		}
		
		var prelDate = new Date(realDate);
		prelDate.setDate(prelDate.getDate() - 14);
		prelDate = formatDate(prelDate);
		
		var payDate = new Date(realDate);
		payDate.setDate(payDate.getDate() - 10);
		payDate = formatDate(payDate);

		$.ajax({
			type: 'POST',
			url: 'db/dbAjax.php',
			data: 'action=addSitting&date=' + realDate + '&preldate=' + prelDate + '&paydate=' + payDate+ '&resName=' + RESTAURANT_NAME + '&resSize=' + RESTAURANT_SIZE,
			success: function(sittId){
				$(".event-window:nth-last-child(2)").clone().insertBefore("#event-creator");
				$(".event-window:nth-last-child(2)").attr("id",sittId);
				$(".event-window:nth-last-child(2)").find(".event-window-date").html(date);
				$(".event-window:nth-last-child(2)").find(".event-window-spots").html('Antal platser: ' +RESTAURANT_SIZE);
				resetCreation()
			}
		});
	});
});

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

function resetCreation(){
	$('#newDate').remove();
	$('#reject').remove();
	$('#confirm').remove();
	document.getElementById("event-creator-initiate").style.display = "block";
}