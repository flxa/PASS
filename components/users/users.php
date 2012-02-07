<?php

$_path = $config->componentpath.$config->ds.$c.$config->ds;

// Require the base controller
require_once ($_path.'controller.php');

// Create the controller
$controller = new UsersController();

// Require the base view
require_once ($_path.'views'.$config->ds.$c.$config->ds.'view.html.php');

// Create the view
$view = new UsersViewUsers();

require_once($_path.'models/users.php');
$model = new UsersModelUsers;

// set the task
$task = $_REQUEST['task'];
if ($task=='' || !isset($task)) { $task = '_displayForm'; }

// Perform the Request task
if ($passloggedin==1) {
	$data = $controller->_exec($_path,$model,$task);
	$html .= $view->display($data,$model);
} else {
	$data = $controller->_exec($_path,$model,$task);
	$html .= $view->display($data,$model);
}

?>