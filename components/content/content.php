<?php

// Require the base controller
require_once ($config->componentpath.$config->ds.$c.$config->ds.'controller.php');

// Create the controller
$controller = new ContentController();

// Perform the Request task
$html .= $controller->display();
//$controller->execute( JRequest::getCmd('task'));

// Redirect if set by the controller
//$controller->redirect();