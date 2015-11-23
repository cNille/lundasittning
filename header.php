<?php
	require_once 'loginCheck.php';
?>
<!doctype html>

<html>
	<head>
		<title> Sittningsbokning </title>
        <link rel="stylesheet" type="text/css" href="<?php echo $siteURL; ?>/css/main.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href='https://fonts.googleapis.com/css?family=Josefin+Sans:400,100' rel='stylesheet' type='text/css'>
	</head>
	<body style="background-image: url('<?php echo $siteURL; ?>/uploads/<?php echo $restaurant[11]; ?>')">
		<script>
			var RESTAURANT_NAME = '<?php echo $restaurant[0] ?>';
			var RESTAURANT_SIZE = '<?php echo $restaurant[9] ?>';
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
