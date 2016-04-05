<?php 
	require_once 'header.php';
 	$dbHandler = new DatabaseHandler();
 	
 	$access = $dbHandler->getAccessLevel($fbid, $restaurant[0]);

    // Requires accesslevel of 5 or else redirects to index.php
 	requireAccessLevel(5, $access, $nationURL);
 	
 	$accordionTitles = $dbHandler->getRestaurantTitles($restaurant[0]);
 ?>
<link rel="stylesheet" type="text/css" href="../../css/main.css" />

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  
<script>
	$(function() {
		$("#accordion").accordion({
				autoHeight: false,
				collapsible: true,
				heightStyle: "content",
				active: 0,
				animate: 300 // collapse will take 300ms
		});
		$('#accordion h3').bind('click',function(){
			var self = this;
			setTimeout(function() {
				theOffset = $(self).offset();
				$('body,html').animate({ scrollTop: theOffset.top - 100 });
			}, 310); // ensure the collapse animation is done
		});
	});
</script>

<div class="content">
	<h2>Överblick</h2>
	<div class="section">
		<div id="accordion">
			<?php
			foreach($accordionTitles as $key => $t){
			?>
				<h3 style="outline: none;"><?php echo $t[0]; ?> <?php echo $t[1]; ?>, <?php echo $t[3]; ?>/<?php echo $t[2]; ?> har betalat</h3>
				<div>
					<a class="btn" href="http://www.lundasittning.se/kr/sallskap/<?php echo $t[5]?>">Gå till sällskap</a>
					<br></br>
					<table class="fancy">
						<tr>
							<th>Namn</th>
							<th>Betalat</th>
						</tr>
						<?php
						$guests = $dbHandler->getRestaurantTitleContent($t[1], $restaurant[0]);
						foreach($guests as $key => $g){
						?>
							<tr>
								<td><?php echo $g[0]; ?></td>
								<td><?php echo $g[1]; ?></td>
							</tr>
						<?
						}
						?>
					</table>
				</div>
			<?php
			}
			$dbHandler->disconnect();
			?>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>
