<?php

class UsersController {
		
	function _exec($_path,$model,$task) {
		$data = new stdClass;
		$data->task = $task;
		$data->path = $_path;
		
		switch($task) {
			case 'dologin':
				$minsleft = $_SESSION['pass']['user']->minsleft;
				// collect and sanitize the form data
				if ($_POST['user']!='') {
					$data->user = mysql_real_escape_string($_POST['user']);
				}
				if ($_POST['pass']!='') {
					$data->pass = mysql_real_escape_string($_POST['pass']);
				}
				if (isset($_POST['remember'])) {
					$data->remember = 1;
				}
				// pass to model to get data
				$data = $model->dologin($data);
				if ($data->db->numrows>0) {
					// if we find a row update the session and set cookie if user wants username remembered
					while($row = mysql_fetch_object($data->db->result)) {
						$_SESSION['pass']['user'] 	= $row;
						$_SESSION['pass']['user']->minsleft = $minsleft;
						$model->updatelastlogin($row->Rep_ID);
					}
					$_SESSION['pass']['user']->Rep_LoggedIn=1;
					$_SESSION['pass']['user']->loggedInTime=date("Y-m-d H:i:s",strtotime($model->gettime()));
					if ($data->remember==1) {
						// remember username on this computer for 31 days
						setcookie("pass_username", $data->user, time()+2678400);
					} else {
						setcookie("pass_username", $data->user, time()-2678400);
					}
				} else {
					$user = new stdClass;
					$user->error = 1;
					$user->user = $data->user;
					$_SESSION['pass']['user'] = $user;
				}
				break;
			case 'doedit':
				if ($_POST['Rep_ID']!='') {
					$data->Rep_ID = mysql_real_escape_string($_POST['Rep_ID']);
				} else {
					$errors['Rep_ID'] = 'ID is required!';
				}
				if ($_POST['Rep_ContactPhone']!='') {
					$data->Rep_ContactPhone = mysql_real_escape_string($_POST['Rep_ContactPhone']);
				} else {
					$errors['Rep_ContactPhone'] = 'A Primary Phone number is required!';
				}
				if ($_POST['Rep_ContactMobile']!='') {
					$data->Rep_ContactMobile = mysql_real_escape_string($_POST['Rep_ContactMobile']);
				} else {
					$errors['Rep_ContactMobile'] = 'A Mobile Phone number is required!';
				}
				if ($_POST['Rep_ContactFax']!='') {
					$data->Rep_ContactFax = mysql_real_escape_string($_POST['Rep_ContactFax']);
				}
				if ($_POST['Rep_CarRegistration']!='') {
					$data->Rep_CarRegistration = mysql_real_escape_string($_POST['Rep_CarRegistration']);
				}
				if ($_POST['password2']!=''){
					if ($_POST['password2']!=$_POST['Rep_Password']) {
						$errors['password2'] = 'You must confirm your new password by entering it twice!';
					} else {
						$data->Rep_Password = mysql_real_escape_string($_POST['Rep_Password']);
					}
				}
				if (!$errors) {
					$data = $model->doedit($data);
					//$x = mysql_fetch_object($data->db->result); echo print_r($x); exit;
					if ($data->db->updated>0) {
						$this->updateSession($model);
					}
				} else {
					$data->errors = $errors;
				}
				break;
			case 'logout':
				$model->logout($_SESSION['pass']['user']->Rep_ID,$data);
				session_destroy();
				header("location: index.php?c=users");
				break;
			case 'display':
			default:
				break;
		}
		//echo '<pre>'; echo print_r($data); echo '</pre>'; $row = mysql_fetch_object($data->db->result); echo '<pre>'; echo print_r($row); exit;
		return $data;
	}

	function updateSession($model) {
		$data = $model->_loadData(NULL,$_SESSION['pass']['user']->Rep_ID,1);
		$row = mysql_fetch_object($data->db->result);
		$_SESSION['pass']['user'] 	= $row;
		return;
	}
	
}
?>