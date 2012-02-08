<?php

class CompanyController {
		
	function _exec($_path,$model,$task) {
		$data = new stdClass;
		$data->task = $task;
		$data->path = $_path;
		
		switch($task) {
			case 'doadd':
				if ($_POST['Company_Name']!='') {
					$data->Company_Name = mysql_real_escape_string($_POST['Company_Name']);
				} else {
					$errors['Company_Name'] = 'Please add a Name for this Company!';
				}
				$data->Company_AssignedRep   = $_POST['Company_AssignedRep'];
				$data->Company_ParentAccount = $_POST['Company_ParentAccount'];
				$data->Company_ABN           = mysql_real_escape_string($_POST['Company_ABN']);
				$data->Company_Phone         = mysql_real_escape_string($_POST['Company_Phone']);
				$data->Company_Fax           = mysql_real_escape_string($_POST['Company_Fax']);
				$data->Company_Website       = mysql_real_escape_string($_POST['Company_Website']);
				$data->Company_MarketSegment = mysql_real_escape_string($_POST['Company_MarketSegment']);
				$data->Company_EstRevenue    = mysql_real_escape_string($_POST['Company_EstRevenue']);
				$data->Company_SalesRegion   = $_POST['Company_SalesRegion'];
				$data->Company_TypeID        = $_POST['Company_TypeID'];
				$data->Company_StatusID      = $_POST['Company_StatusID'];
				$data->Company_Active        = 1;
				if (!$errors) {
					$data = $model->doadd($data);
				} else {
					$data->errors = $errors;
				}
				break;
			case 'doedit':
				$data->Company_ID = mysql_real_escape_string($_POST['Company_ID']);
				if ($_POST['Company_Name']!='') {
					$data->Company_Name = mysql_real_escape_string($_POST['Company_Name']);
				} else {
					$errors['Company_Name'] = 'Please add a Name for this Company!';
				}
				$data->Company_AssignedRep   = $_POST['Company_AssignedRep'];
				$data->Company_ParentAccount = $_POST['Company_ParentAccount'];
				$data->Company_ABN           = mysql_real_escape_string($_POST['Company_ABN']);
				$data->Company_Phone         = mysql_real_escape_string($_POST['Company_Phone']);
				$data->Company_Fax           = mysql_real_escape_string($_POST['Company_Fax']);
				$data->Company_Website       = mysql_real_escape_string($_POST['Company_Website']);
				$data->Company_MarketSegment = mysql_real_escape_string($_POST['Company_MarketSegment']);
				$data->Company_EstRevenue    = mysql_real_escape_string($_POST['Company_EstRevenue']);
				$data->Company_SalesRegion   = $_POST['Company_SalesRegion'];
				$data->Company_TypeID        = $_POST['Company_TypeID'];
				$data->Company_StatusID      = $_POST['Company_StatusID'];
				$data->Company_Active        = 1;
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
				break;
			case 'doaddopp':
				if ($_POST['Opp_Name']!='') {
					$data->Opp_Name = mysql_real_escape_string($_POST['Opp_Name']);
				} else {
					$errors['Opp_Name'] = 'Please add a Name for this Opportunity!';
				}
				$data->Opp_CompanyID		 = $_POST['Opp_CompanyID'];
				$data->Opp_StageID			 = $_POST['Opp_StageID'];
				$data->Opp_Amount            = mysql_real_escape_string($_POST['Opp_Amount']);
				$data->Opp_StartDate         = mysql_real_escape_string($_POST['Opp_StartDate']);
				$data->Opp_CloseDate         = mysql_real_escape_string($_POST['Opp_CloseDate']);
				if (!isset($_POST['Opp_Active'])) {
					$data->Opp_Active        = 1;
				} else {
					$data->Opp_Active        = $_POST['Opp_Active'];
				}
				if (!$errors) {
					//echo '<pre>'; echo print_r($data); exit;
					$data = $model->save_opp($data);
					if ($_POST['redir']!='') {
						header("Location: ".urldecode($_POST['redir']));
					}
				} else {
					$data->errors = $errors;
				}
				break;
			case 'doeditopp':
				$data->Opp_ID = mysql_real_escape_string($_POST['Opp_ID']);
				if ($_POST['Opp_Name']!='') {
					$data->Opp_Name = mysql_real_escape_string($_POST['Opp_Name']);
				} else {
					$errors['Opp_Name'] = 'Please add a Name for this Opportunity!';
				}
				$data->Opp_CompanyID		 = $_POST['Opp_CompanyID'];
				$data->Opp_StageID			 = $_POST['Opp_StageID'];
				$data->Opp_Amount            = mysql_real_escape_string($_POST['Opp_Amount']);
				$data->Opp_StartDate         = mysql_real_escape_string($_POST['Opp_StartDate']);
				$data->Opp_CloseDate         = mysql_real_escape_string($_POST['Opp_CloseDate']);
				$data->Opp_Active        	 = $_POST['Opp_Active'];
				if (!$errors) {
					$data = $model->edit_opp($data);
					if ($_POST['redir']!='') {
						header("Location: ".urldecode($_POST['redir']));
					}
				} else {
					$data->errors = $errors;
				}
				break;
			case 'doaddnote':
				$data->Note_CompanyID		 = $_POST['Note_CompanyID'];
				$data->Note_RepID			 = $_POST['Note_RepID'];
				if ($_POST['Note_Subject']!='') {
					$data->Note_Subject = mysql_real_escape_string($_POST['Note_Subject']);
				} else {
					$errors['Note_Subject'] = 'Please add a Subject for this Note!';
				}
				$data->Note_Body             = mysql_real_escape_string($_POST['Note_Body']);
				$data->Note_TypeID			 = $_POST['Note_TypeID'];
				$data->Note_AddedBy			 = $_POST['Note_AddedBy'];
				$data->Note_AssignedRepID	 = $_POST['Note_AssignedRepID'];
				$data->Note_NextActionID	 = $_POST['Note_NextActionID'];
				$data->Note_DueDate	 		 = mysql_real_escape_string($_POST['Note_DueDate']).' '.mysql_real_escape_string($_POST['Note_DueDateTime']);
				$data->Note_ReminderDate	 = mysql_real_escape_string($_POST['Note_ReminderDate']).' '.mysql_real_escape_string($_POST['Note_ReminderDateTime']);
				$data->Note_StatusID		 = $_POST['Note_StatusID'];
				$data->Note_Recursive		 = $_POST['Note_Recursive'];
				$data->Note_RecursiveInterval	= $_POST['Note_RecursiveInterval'];
				$data->Note_RecursiveDateTime	= $_POST['Note_RecursiveDateTime'];
				if (!isset($_POST['Note_Active'])) {
					$data->Note_Active        = 1;
				} else {
					$data->Note_Active        = $_POST['Note_Active'];
				}
				if (!$errors) {
					//echo '<pre>'; echo print_r($data); exit;
					$data = $model->save_note($data);
					if ($_POST['redir']!='') {
						header("Location: ".urldecode($_POST['redir']));
					}
				} else {
					$data->errors = $errors;
				}
				break;
			case 'doeditnote':
				$data->Note_ID 				 = mysql_real_escape_string($_POST['Note_ID']);
				$data->Note_CompanyID		 = $_POST['Note_CompanyID'];
				$data->Note_RepID			 = $_POST['Note_RepID'];
				if ($_POST['Note_Subject']!='') {
					$data->Note_Subject 	 = mysql_real_escape_string($_POST['Note_Subject']);
				} else {
					$errors['Note_Subject']  = 'Please add a Subject for this Note!';
				}
				$data->Note_Body             = mysql_real_escape_string($_POST['Note_Body']);
				$data->Note_TypeID			 = $_POST['Note_TypeID'];
				$data->Note_AddedBy			 = $_POST['Note_AddedBy'];
				$data->Note_AssignedRepID	 = $_POST['Note_AssignedRepID'];
				$data->Note_NextActionID	 = $_POST['Note_NextActionID'];
				$data->Note_DueDate	 		 = mysql_real_escape_string($_POST['Note_DueDate']).' '.mysql_real_escape_string($_POST['Note_DueDateTime']);
				$data->Note_ReminderDate	 = mysql_real_escape_string($_POST['Note_ReminderDate']).' '.mysql_real_escape_string($_POST['Note_ReminderDateTime']);
				$data->Note_StatusID		 = $_POST['Note_StatusID'];
				$data->Note_Recursive		 = $_POST['Note_Recursive'];
				$data->Note_RecursiveInterval	= $_POST['Note_RecursiveInterval'];
				$data->Note_RecursiveDateTime	= $_POST['Note_RecursiveDateTime'];
				if (!isset($_POST['Note_Active'])) {
					$data->Note_Active        = 1;
				} else {
					$data->Note_Active        = $_POST['Note_Active'];
				}
				if (!$errors) {
					//echo '<pre>'; echo print_r($data); exit;
					$data = $model->edit_note($data);
					if ($_POST['redir']!='') {
						header("Location: ".urldecode($_POST['redir']));
					}
				} else {
					$data->errors = $errors;
				}
				break;
			case 'display':
			default:
				break;
		}
		return $data;
	}
	
}
?>