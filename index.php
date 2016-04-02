<?php 
    require_once 'header.php';
    include_once("analyticstracking.php");

 	$dbHandler = new DatabaseHandler();
    $restaurants = $dbHandler->getRestaurants();
	$dbHandler->disconnect();
 ?>

<div class="content">

		<img src="<?php echo $siteURL; ?>/images/lundasittning_logga_whitex800.png" height="200px" style="margin: auto; display: block;" />
	<div class="title">
		Lundasittning
	</div>
	<p class="white">

		Välkommen till Lundasittning, din guide för sittningar i Lund!
	</p>
	<p class="white" >
		Tjänsten är fortfarande ny och mycket kvar att växa. Vår förhoppning är att
    fler nationer ansluter för att ge er en sådan komplett guide som möjligt!
		<br />
    Ge oss gärna feedback på hur vi kan förbättra sidan via; info@lundasittning.se
	</p>
	<div class="restaurant-grid">
		
		<?php 
			foreach($restaurants as $row => $r) {
				$name = $r[0];
				$nickname = $r[1];
				$loggo = $r[2];
				?>
					<a href="<? echo $siteURL . '/' . $nickname; ?>">
						<div class="restaurant">
							<div class="loggo" style="background-image: url('uploads/<?php echo $loggo; ?>')"></div>
							<h3>
								<?php echo $name; ?>
							</h3>
						</div>
					</a>
		<?php } ?>
	</div>
  <?php if(false) : ?>
    <p class="white">
      Vill din studentförening gå med i Lundasittning? Just nu är vår tjänst anpassade till nationer, 
      men gå gärna med så kan vi försöka utforma så att den även passar din förening! 
      <br />
      <br />
      <?php if($loggedIn) : ?>
        <a class="btn primary" href="<?php echo $siteURL; ?>/registration.php/">
          <span>Registrera studentförening</span>
        </a>
      <?php else : ?>
        <?php $_SESSION['FB_REDIRECT'] =  $siteURL . '/registration.php' ?>
        <?php $_SESSION['LAST_PAGE'] = '' ?>
        <a class="btn primary" href="<?php echo $siteURL; ?>/facebook-login/fbconfig.php">
          <span>Logga in via FB för att registrera studentförening</span>
        </a>
      <?php endif; ?>
    </p>
  <?php endif; ?>
</div>
<div style="clear:both;"></div>
<?php //include 'footer.php'; ?>
