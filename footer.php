	
    <footer>
        <div class="logocontainer" style="background-image: url('uploads/<?php echo $restaurant[12]; ?>');">
        </div>
                
        <div class="infocontainer">
            <h3><?php echo $restaurant[0]; ?></h3>
            <p><?php echo $restaurant[10]; ?></p>
            <div class="contactinformation">
                <p><strong>Email: </strong> <?php echo $restaurant[2] ?> </p>
                <p><strong>Telephone: </strong> <?php echo $restaurant[3]; ?> </p>
                <p><strong>Adress: </strong> <?php echo $restaurant[6]; ?> </p>
                <p><strong>Öppettider: </strong> <?php echo $restaurant[5]; ?> </p>
                <p><strong>Homepage: </strong> <a href="<?php echo $restaurant[4]; ?>"><?php echo $restaurant[4]; ?></a> </p>
            </div>
        </div>

    </footer>

    <?php if ($loggedIn): ?> 
        <div class="fb-login">
            <a href="facebook-login/logout.php">
            <img src="https://graph.facebook.com/<?php echo $fbid; ?>/picture" />
            <span><?php echo $fbFullname; ?></span>
            <br />
            Logga ut</a>
        </div>
    <?php else : ?>
        <div class="fb-login">
            <img src="images/FB-logga.png" />
            <span class="login">Logga in</span>
        </div>
    <?php endif; ?>


	<div class="header">
		<a href="index.php">Sittning @ <?php echo $restaurant[1]; ?></a>
		<button class="header-button" id="open-button" onclick="toggleSide()">Open Menu</button>
	</div>

	<div class='shadow'></div>
	<div class="sidenav">
		<h1>Menu</h1>
		<a href="index.php">Sittningar</a>
		<?php if($loggedIn){ ?>
			<a href="settings.php">Mitt konto</a>
		<?php } ?>
		<?php if($myAccessLevel >=5){ ?>
			<a href="nationsettings.php">Nationsinställningar</a>
			<a href="users.php">Användare</a>
		<?php } ?>
		<a href="faq.php">F.A.Q</a>
		<a href="feedback.php">Skicka Feedback</a>
	</div>
	</body>
	<script src="js/toClipboard.js"></script>
	<script src="js/removeEvent.js"></script>
	<script src="js/addEvent.js"></script>
	<script src="js/saveSettings.js"></script>
	<div style="display: none;">Icons made by <a href="http://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a>             is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>
	<script src="js/main.js"></script>
</html>
