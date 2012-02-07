<?php
$dbpassword	= $config->dbpass;
$dbname		= $config->dbname;
$dbusername	= $config->dbuser;
$mysql_link = mysql_connect("localhost",$dbusername,$dbpassword);
mysql_select_db($dbname);
?>
