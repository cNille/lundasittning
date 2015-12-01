$("#confirmSettings").click(function(){
	var email = document.getElementById("settingsEmail").value;
	var telephone = document.getElementById("settingsTelephone").value;
	var other = document.getElementById("settingsOther").value;
	
	$.ajax({
		type: 'POST',
		url: SITEURL + '/database/dbAjax.php',
		data: 'action=updateSettings&email=' + email + '&telephone=' + telephone + '&other=' + other + '&userid=4',
		success: function(){
		}
	});
});