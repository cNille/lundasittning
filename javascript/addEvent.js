$("#event-creator-initiate").click(function(){
	document.getElementById("event-creator-initiate").style.display = "none";
	$("#event-creator").append( "<input type='text' name='date' id='newDate' placeholder='DD/MM' minlength='3' maxlength='5' autocomplete='off' onkeydown='if (event.keyCode == 13) { fakeClick(); }'>");
	document.getElementById("newDate").focus();
	
	$("#event-creator").append( "<button id='reject'>X</button>");
	$("#event-creator").append( "<button id='confirm'>Y</button>");
	
	$("#reject").click(function(){
		resetCreation();
	});

	$("#confirm").click(function(){
		var date = document.getElementById("newDate").value;
		if(!(date.indexOf("/") > -1)){
			return;
		}
		var arr = date.split('/');
		
		if(arr[0] > 31 || arr[0] < 1 || arr[1] > 12 || arr[1] < 1){
			return;
		}
		
		var currentDate = new Date();
		var monthNumber = currentDate.getMonth();
		var yearNumber = currentDate.getFullYear();
		
		if(arr[0].length < 2){
			arr[0] = "0" + arr[0];
		}
		if(arr[1].length < 2){
			arr[1] = "0" + arr[1];
		}

		if(arr[1] < monthNumber){
			var realDate = (yearNumber + 1) + "-" + arr[1] + "-" + arr[0];
		}
		else{
			var realDate = yearNumber + "-" + arr[1] + "-" + arr[0];
		}

		$.ajax({
			type: 'POST',
			url: SITEURL + '/database/dbAjax.php',
			data: 'action=addSitting&date=' + realDate + '&resName=' + RESTAURANT_NAME,
			success: function(sittId){
				var sittIdFin = sittId.replace(/[^0-9]/, '');
				$(".firsteventgrid .event-window:nth-last-child(2)").removeClass("created show");
				$(".firsteventgrid .event-window:nth-last-child(2)").clone().insertBefore("#event-creator");
				$(".firsteventgrid .event-window:nth-last-child(2)").addClass("created");
				$(".firsteventgrid .event-window:nth-last-child(2)").attr("id",sittIdFin);
				$(".firsteventgrid .event-window:nth-last-child(2)").attr("style","block");
				var temp = $(".firsteventgrid .event-window:nth-last-child(2)").find(".event-window-link");
				temp.attr("href", NATIONURL + '/sittning/' + sittIdFin);
				$(".firsteventgrid .event-window:nth-last-child(2)").find(".event-window-date").html(date);
				$(".firsteventgrid .event-window:nth-last-child(2)").find(".event-window-spots").html("Platser kvar: " + RESTAURANT_SIZE);
				resetCreation();
				$(".firsteventgrid .event-window:nth-last-child(2)").addClass("show");
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

function fakeClick(){
	$('#confirm').trigger('click');
}
