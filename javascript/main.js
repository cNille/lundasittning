$( ".shadow" ).click(function() {
  toggleSide();
});

function toggleSide(){
	var right = parseInt($('.sidenav').css('right'));
	var width = parseInt($('.sidenav').css('width'));
	$('.sidenav').css('right', Math.abs(right) - width);
	$('.header-button').css('margin-right', Math.abs(right));
	if(right != 0){
		$('.shadow').addClass('active');		
	} else {
		$('.shadow').removeClass('active');
	}
}

$('.fb-login').click(function(){
	window.location.href = "<?php echo $siteURL; ?>/facebook/login.php";
});




