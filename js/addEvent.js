$("#event-creator-initiate").click(function(){
	document.getElementById("event-creator-initiate").style.display = "none";
	$("#event-creator").append( "<input type='text' name='date' id='newDate' placeholder='DD/MM' minlength='3' maxlength='5' autocomplete='off' >");
	document.getElementById("newDate").focus();
	
	$("#event-creator").append( "<button id='reject'>X</button>");
	$("#event-creator").append( "<button id='confirm'>Y</button>");
	
	$("#reject").click(function(){
		$('#newDate').remove();
		$('#reject').remove();
		$('#confirm').remove();
		document.getElementById("event-creator-initiate").style.display = "block";
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
		
		var preldate = date('Y-m-d', strtotime(realDate. ' - 14 days'));
		var paydate = date('Y-m-d', strtotime(realDate. ' - 10 days'));
		
		$(".event-window:nth-last-child(2)").clone().insertBefore("#event-creator");
		$(".event-window:nth-last-child(2)").attr("id",realDate);
		$(".event-window:nth-last-child(2)").find(".event-window-date").html(date);

		$.ajax({
			type: 'POST',
			url: 'db/dbAjax.php',
			data: 'action=addSitting&date=' + realDate + '&preldate=' + preldate + '&paydate=' + paydate,
			success: function(data){
				// If you want, alert whatever your PHP script outputs
			}
		});
	});
});