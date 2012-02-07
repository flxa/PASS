<?php 
date_default_timezone_set('Australia/Sydney');
session_start();
// Get the configuration class
require_once('configuration.php');
$config = new Config;
// connect to the database
require_once('include/dbconnect.php');
// Get the component class
require_once('include/component.php');
$component = new Component;

// look for a component to include and default if none found
// model
$m = $_REQUEST['m'];
if ($m=='') { $m = 'content'; }
// view
$v = $_REQUEST['v'];
if ($v=='') { $c = 'content'; }
// controller
$c = $_REQUEST['c'];
if ($c=='') { $c = 'content'; }

// Build the path to the components main file
$componentpath = $config->componentpath.$config->ds.$c.$config->ds.$c.'.php';

// Check the last login time and boot the user if they have been on too long
$sst = new DateTime($_SESSION['pass']['user']->loggedInTime);
$chk = new DateTime("-".$config->sessionTimeout." minutes");
$stl = $chk->diff($sst);
//echo '<pre>'; echo print_r($stl); exit;
if (strlen($stl->s)==1) { $seconds = '0'.$stl->s; } else { $seconds = $stl->s; }
$_SESSION['pass']['user']->minsleft = $stl->i.':'.$seconds;

// check if the user is logged in
if ($_SESSION['pass']['user']->Rep_LoggedIn==1) {
	$passloggedin = 1;
	if ($stl->invert==1) {
		$passloggedin = 0;
		include('components/users/models/users.php');
		$model = new UsersModelUsers;
		$model->logout($_SESSION['pass']['user']->Rep_ID,$data);
		session_destroy();
		header("location: index.php?c=users");
		exit;
	}
} else {
	$passloggedin = 0;
}

include($componentpath);

?>