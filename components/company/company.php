<?php

$_path = $config->componentpath.$config->ds.$c.$config->ds;

// Require the base controller
require_once ($_path.'controller.php');

// Create the controller
$controller = new CompanyController();

// Require the base view
require_once ($_path.'views'.$config->ds.$c.$config->ds.'view.html.php');

// Create the view
$view = new CompanyViewCompany();

require_once($_path.'models/company.php');
$model = new CompanyModelCompany;

// set the task
$task = $_REQUEST['task'];
if ($task=='' || !isset($task)) { $task = '_displayForm'; }

// Perform the Request task
if ($passloggedin==1) {
	$data = $controller->_exec($_path,$model,$task);
	$html .= $view->display($data,$model);
} else {
	header("Location: index.php?c=users");
}
//$controller->execute( JRequest::getCmd('task'));

// Redirect if set by the controller
//$controller->redirect();