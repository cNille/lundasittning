	
    <footer>
        <div class="logocontainer third-column" style="background-image: url('<?php echo $nationURL; ?>/uploads/<?php echo $restaurant[12]; ?>');">
        </div>
                
        <div class="infocontainer third-column">
            <h3><?php echo $restaurant[0]; ?></h3>
            <p><?php echo $restaurant[10]; ?></p>
        </div>
        <div class="contactinformation third-column">
                <p><strong>Email: </strong> <?php echo $restaurant[2] ?> </p>
                <p><strong>Telephone: </strong> <?php echo $restaurant[3]; ?> </p>
                <p><strong>Adress: </strong> <?php echo $restaurant[6]; ?> </p>
                <p><strong>Öppettider: </strong> <?php echo $restaurant[5]; ?> </p>
                <p><strong>Homepage: </strong> <a href="<?php echo $restaurant[4]; ?>"><?php echo $restaurant[4]; ?></a> </p>
            </div>
    </footer>


	<div class="header">
		<a href="<?php echo $nationURL; ?>">Sittning @ <?php echo strtoupper($restaurant[1]); ?></a>
		<button class="header-button" id="open-button" onclick="toggleSide()"><div class="menuloggo"></div></button>
	</div>

	<div class='shadow'></div>
	<div class="sidenav">
        <?php if ($loggedIn): ?> 
            <div class="fb-loggedin">
                <img src="https://graph.facebook.com/<?php echo $fbid; ?>/picture" />
                <span>Inloggad som: <?php echo $fbFullname; ?></span>
            </div>
        <?php else : ?>
            <a class="fb-login" href="<?php echo $siteURL; ?>/facebook-login/fbconfig.php">
                <img src="<?php echo $siteURL; ?>/images/FB-logga.png" />
                <span class="login">Logga in</span>
            </a>
        <?php endif; ?>

		<a href="<?php echo $nationURL; ?>/">Sittningar</a>
		<?php if($loggedIn){ ?>
			<a href="<?php echo $nationURL; ?>/settings.php">Mitt konto</a>
		<?php } ?>
        <?php if($myAccessLevel >=5){ ?>
            <a href="<?php echo $nationURL; ?>/nationsettings.php">Nationsinställningar</a>
            <a href="<?php echo $nationURL; ?>/users.php">Användare</a>
        <?php } ?>
        <?php if($myAccessLevel >=10){ ?>
            <a href="<?php echo $nationURL; ?>/log.php">Log</a>
        <?php } ?>
        <a href="<?php echo $nationURL; ?>/faq.php">F.A.Q</a>
        <a href="<?php echo $siteURL; ?>">Till lundasittning.se</a>
        <?php if ($loggedIn): ?> 
            <a class="fb-logout" href="<?php echo $siteURL; ?>/facebook-login/logout.php">Logga ut</a>
        <?php endif; ?>
        <div class='side-shadow'></div>
	</div>
	</body>
	<script src="<?php echo $nationURL; ?>/javascript/toClipboard.js"></script>
	<script src="<?php echo $nationURL; ?>/javascript/removeEvent.js"></script>
	<script src="<?php echo $nationURL; ?>/javascript/addEvent.js"></script>
	<script src="<?php echo $nationURL; ?>/javascript/saveSettings.js"></script>
    <script src="<?php echo $nationURL; ?>/javascript/main.js"></script>
	<div style="display: none;">Icons made by <a href="http://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a>             is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>
</html>
