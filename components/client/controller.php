<?php

class ClientController {
		
	function _exec($_path,$model,$task) {
		$data = new stdClass;
		$data->task = $task;
		$data->path = $_path;
		
		switch($task) {
			case 'doadd':
				$data->Client_Company_ID = mysql_real_escape_string($_POST['Client_Company_ID']);
				if ($_POST['Client_FirstName']!='') {
					$data->Client_FirstName = mysql_real_escape_string($_POST['Client_FirstName']);
				} else {
					$errors['Client_FirstName'] = 'Please add a First Name for this Client!';
				}
				if ($_POST['Client_Surname']!='') {
					$data->Client_Surname = mysql_real_escape_string($_POST['Client_Surname']);
				} else {
					$errors['Client_Surname'] = 'Please add a Last Name for this Client!';
				}
				if ($_POST['Client_ContactPhone']!='') {
					$data->Client_ContactPhone = mysql_real_escape_string($_POST['Client_ContactPhone']);
				} else {
					$errors['Client_ContactPhone'] = 'Please add a Phone Number for this Client!';
				}
				$data->Client_ContactFax = mysql_real_escape_string($_POST['Client_ContactFax']);
				$data->Client_ContactMobile = mysql_real_escape_string($_POST['Client_ContactMobile']);
				$data->Client_Email = mysql_real_escape_string($_POST['Client_Email']);
				$data->Client_RoleID = mysql_real_escape_string($_POST['Client_RoleID']);
				$data->Client_Active = 1;
				if (!$errors) {
					$data = $model->doadd($data);
					if ($_POST['redir']!='') {
						header("Location: ".urldecode($_POST['redir']));
					}
				} else {
					$data->errors = $errors;
				}
				break;
			case 'doedit':
				$data->Client_ID = mysql_real_escape_string($_POST['Client_ID']);
				$data->Client_Company_ID = mysql_real_escape_string($_POST['Client_Company_ID']);
				if ($_POST['Client_FirstName']!='') {
					$data->Client_FirstName = mysql_real_escape_string($_POST['Client_FirstName']);
				} else {
					$errors['Client_FirstName'] = 'Please add a First Name for this Client!';
				}
				if ($_POST['Client_Surname']!='') {
					$data->Client_Surname = mysql_real_escape_string($_POST['Client_Surname']);
				} else {
					$errors['Client_Surname'] = 'Please add a Last Name for this Client!';
				}
				if ($_POST['Client_ContactPhone']!='') {
					$data->Client_ContactPhone = mysql_real_escape_string($_POST['Client_ContactPhone']);
				} else {
					$errors['Client_ContactPhone'] = 'Please add a Phone Number for this Client!';
				}
				$data->Client_ContactFax = mysql_real_escape_string($_POST['Client_ContactFax']);
				$data->Client_ContactMobile = mysql_real_escape_string($_POST['Client_ContactMobile']);
				$data->Client_Email = mysql_real_escape_string($_POST['Client_Email']);
				$data->Client_RoleID = mysql_real_escape_string($_POST['Client_RoleID']);
				$data->Client_Active = 1;
				if (!$errors) {
					$data = $model->doedit($data);
					if ($_POST['redir']!='') {
						header("Location: ".urldecode($_POST['redir']));
					}
				} else {
					$data->errors = $errors;
				}
				break;
			case "delete":
				$data = $model->delete($data,$_REQUEST['aid']);
			case 'display':
			default:
				break;
		}
		return $data;
	}
	
}
?>