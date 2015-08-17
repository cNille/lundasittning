<?php
define('DB_SERVER', 'mysql://$OPENSHIFT_MYSQL_DB_HOST:$OPENSHIFT_MYSQL_DB_PORT/');
define('DB_USERNAME', 'adminxxb8b4L');    // DB username
define('DB_PASSWORD', 'mw7h4dXVzl4I');    // DB password
define('DB_DATABASE', 'sittning');      // DB name
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die( "Unable to connect");
$database = mysql_select_db(DB_DATABASE) or die( "Unable to select database");
?>