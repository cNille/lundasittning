<?php
	mysql_select_db( "sittning" ) or die( 'Error'. mysql_error() );
	$date = $_POST['date'];
	$result = mysql_query("DELETE FROM sitting WHERE sittDate = '" . $date . "'");
?>