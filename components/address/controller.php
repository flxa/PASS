<?php

class AddressController {
		
	function _exec($_path,$model,$task) {
		$data = new stdClass;
		$data->task = $task;
		$data->path = $_path;
		
		switch($task) {
			case 'doadd':
				$data->Address_CompanyID = mysql_real_escape_string($_POST['Address_CompanyID']);
				$data->Address_Type = mysql_real_escape_string($_POST['Address_Type']);
				if ($data->Address_Type==1) {
					$data->Address_RepID = mysql_real_escape_string($_SESSION['pass']['user']->Rep_ID);
				} else {
					$data->Address_RepID = NULL;
				}
				if ($_POST['Address_DescriptionLabel']!='') {
					$data->Address_DescriptionLabel = mysql_real_escape_string($_POST['Address_DescriptionLabel']);
				} else {
					$errors['Address_DescriptionLabel'] = 'Please add a descriptive name for this address!';
				}
				if ($_POST['Address_Line1']!='') {
					$data->Address_Line1 = mysql_real_escape_string($_POST['Address_Line1']);
				} else {
					$errors['Address_Line1'] = 'Please add an Address Line 1!';
				}
				$data->Address_Line2 = mysql_real_escape_string($_POST['Address_Line2']);
				if ($_POST['Address_Locality']!='') {
					$data->Address_Locality = mysql_real_escape_string($_POST['Address_Locality']);
				} else {
					$errors['Address_Locality'] = 'Please add a Locality (Suburb/Town/City) for this address!';
				}
				if ($_POST['Address_State']!='') {
					$data->Address_State = mysql_real_escape_string($_POST['Address_State']);
				} else {
					$errors['Address_State'] = 'Please choose a State for this address!';
				}
				if ($_POST['Address_Postcode']!='') {
					$data->Address_Postcode = mysql_real_escape_string($_POST['Address_Postcode']);
				} else {
					$errors['Address_Postcode'] = 'Please add a Postcode for this address!';
				}
				$data->Address_IsPrimary = mysql_real_escape_string($_POST['Address_IsPrimary']);
				$data->Address_IsPostal = mysql_real_escape_string($_POST['Address_IsPostal']);
				$data->Address_Active = 1;
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
				$data->Address_ID = mysql_real_escape_string($_POST['Address_ID']);
				$data->Address_CompanyID = mysql_real_escape_string($_POST['Address_CompanyID']);
				$data->Address_Type = mysql_real_escape_string($_POST['Address_Type']);
				if ($data->Address_Type==1) {
					$data->Address_RepID = mysql_real_escape_string($_SESSION['pass']['user']->Rep_ID);
				} else {
					$data->Address_RepID = NULL;
				}
				if ($_POST['Address_DescriptionLabel']!='') {
					$data->Address_DescriptionLabel = mysql_real_escape_string($_POST['Address_DescriptionLabel']);
				} else {
					$errors['Address_DescriptionLabel'] = 'Please add a descriptive name for this address!';
				}
				if ($_POST['Address_Line1']!='') {
					$data->Address_Line1 = mysql_real_escape_string($_POST['Address_Line1']);
				} else {
					$errors['Address_Line1'] = 'Please add an Address Line 1!';
				}
				$data->Address_Line2 = mysql_real_escape_string($_POST['Address_Line2']);
				if ($_POST['Address_Locality']!='') {
					$data->Address_Locality = mysql_real_escape_string($_POST['Address_Locality']);
				} else {
					$errors['Address_Locality'] = 'Please add a Locality (Suburb/Town/City) for this address!';
				}
				if ($_POST['Address_State']!='') {
					$data->Address_State = mysql_real_escape_string($_POST['Address_State']);
				} else {
					$errors['Address_State'] = 'Please choose a State for this address!';
				}
				if ($_POST['Address_Postcode']!='') {
					$data->Address_Postcode = mysql_real_escape_string($_POST['Address_Postcode']);
				} else {
					$errors['Address_Postcode'] = 'Please add a Postcode for this address!';
				}
				$data->Address_IsPrimary = mysql_real_escape_string($_POST['Address_IsPrimary']);
				$data->Address_IsPostal = mysql_real_escape_string($_POST['Address_IsPostal']);
				$data->Address_Active = mysql_real_escape_string($_POST['Address_Active']);
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