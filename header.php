<?php
	require_once 'loginCheck.php';

?>
<!doctype html>

<html>
	<head>
		<title> Lundasittning </title>
        <link rel="stylesheet" type="text/css" href="<?php echo $siteURL; ?>/css/main.css" />
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href='https://fonts.googleapis.com/css?family=Josefin+Sans:400,100' rel='stylesheet' type='text/css'>
    <link rel="icon" href="<?php echo $siteURL; ?>/images/lundasittning_logga_blackx32.png" />

    <script type="text/javascript">
    $(document).ready(function() {
            // Tooltip only Text
            $('.masterTooltip').hover(function(){
                    // Hover over code
                    var title = $(this).attr('title');
                    $(this).data('tipText', title).removeAttr('title');
                    $('<p class="tooltip"></p>')
                    .text(title)
                    .appendTo('body')
                    .fadeIn('slow');
            }, function() {
                    // Hover out code
                    $(this).attr('title', $(this).data('tipText'));
                    $('.tooltip').remove();
            }).mousemove(function(e) {
                    var mousex = e.pageX + 20; //Get X coordinates
                    var mousey = e.pageY + 10; //Get Y coordinates
                    $('.tooltip')
                    .css({ top: mousey, left: mousex })
            });
    });
    </script>
  

	</head>
	<body style="background-image: url('<?php echo $siteURL; ?>/uploads/<?php echo $restaurant[11]; ?>')">
		<script>
			var RESTAURANT_NAME = '<?php echo $restaurant[0] ?>';
            var RESTAURANT_SIZE = '<?php echo $restaurant[9] ?>';
            var SITEURL = '<?php echo $siteURL; ?>';
            var NATIONURL = '<?php echo $nationURL; ?>';
		</script>



    <?php
        if(isset($_SESSION['message'])) :
            $msgType = "Meddelande";
            if(isset($_SESSION['messagetype'])){
                $msgType = $_SESSION['messagetype']; 
            }
            $msg = $_SESSION['message']; 
            unset($_SESSION['message']);
            $_SESSION['messagetype'] = '';
    ?>

    <div class="message">
        <span class="close">X</span>
        <h4><?php echo $msgType; ?></h4>
        <p class="msg"><?php echo $msg; ?></p>
        <span class="msg">(Klicka för att ta bort)</span>
    </div>
    <script>
        $('.message').click(function(){
            $('.message').fadeOut();
        });
    </script>
    <?php endif;?>
