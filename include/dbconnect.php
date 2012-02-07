<?php
$dbpassword	= $config->dbpass; //"qw17b17ch3n"
$dbname		= $config->dbname; //"printnat_repcal"
$dbusername	= $config->dbuser; //"printnat_dbuser"
$mysql_link = mysql_connect("localhost",$dbusername,$dbpassword);
mysql_select_db($dbname);
?>
