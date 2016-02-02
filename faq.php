<?php 
	require_once "header.php";

 ?>
 <link rel="stylesheet" type="text/css" href="../../css/main.css" />
<div class="content">
	<div class="title">F.A.Q</div>
	<div class="single-sitting">
				<h3>Fråga: ...</h3>
        <p>
          <i>Svar:</i> ...
        </p>
        <hr />
	</div>

	<div class="single-sitting">
				<h3 style="text-align: center;">Hittade du inte vad du sökte? Fråga oss här!</h3>
        <p>
          <form class="myForm" action="<?php echo $nationURL; ?>/scripts.php" method="POST">
            <h4>Namn * </h4>
            <span><input type="text" name="name" value=""></span>
            <h4>Email</h4>
            <span><input type="text" name="email" value=""></span>

            <h4>Fråga</h4>
            <span><input type="text" name="question" value=""></span>

            <input class="primary" type="submit" value="Skicka" name="sendFeedback" />
          </form>
        </p>
        <hr />
	</div>
</div>
<?php include 'footer.php'; ?>
