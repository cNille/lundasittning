	

	<div class="fb-login">
		<img src="images/FB-logga.png" />
		<span>Logga in</span>
	</div>


	<?php if ($_SESSION['FBID']): ?>      <!--  After user login  -->
		<div class="container">
		<div class="hero-unit">
		  <h1>Hello <?php echo $_SESSION['USERNAME']; ?></h1>
		  <p>Welcome to "facebook login" tutorial</p>
		  </div>
		<div class="span4">
		 <ul class="nav nav-list">
		<li class="nav-header">Image</li>
		 <li><img src="https://graph.facebook.com/<?php echo $_SESSION['USERNAME']; ?>/picture"></li>
		<li class="nav-header">Facebook ID</li>
		<li><?php echo  $_SESSION['FBID']; ?></li>
		<li class="nav-header">Facebook fullname</li>
		<li><?php echo $_SESSION['FULLNAME']; ?></li>
		<div><a href="facebook-login/logout.php">Logout</a></div>
		</ul></div></div>
	<?php endif; ?>

	<div class='shadow'></div>
	<div class="sidenav">
		<h1>Menu</h1>
		<ul>
			<li>Boka sittning</li>
			<li>Mina sittningar</li>
			<li>Mitt konto</li>
			<li>F.A.Q</li>
			<li>Logga ut</li>
		</ul>
	</div>
	</body>
	<script src="js/removeEvent.js"></script>
	<script src="js/addEvent.js"></script>
	<div style="display: none;">Icons made by <a href="http://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a>             is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>
	<script src="js/main.js"></script>
</html>
