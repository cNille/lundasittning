$("#confirmSettings").click(function(){
		$.ajax({
			type: 'POST',
			url: 'db/dbAjax.php',
			data: 'action=addSitting&date=' + realDate + '&preldate=' + prelDate + '&paydate=' + payDate+ '&resName=' + RESTAURANT_NAME + '&resSize=' + RESTAURANT_SIZE,
			success: function(sittId){
				
			}
		});
	});
});