<?php
	if (($data->task=='doaddnote' && (is_array($data->error)) || $_REQUEST['id']!='')) {
		//echo $_REQUEST['id'].' TOLDYA'; exit;
		$data = $model->get_notes($_REQUEST['id'],NULL,$_REQUEST['Company_ID'],NULL);
		$row = mysql_fetch_object($data->result);
		//echo '<pre>'; echo print_r($row); exit;
	}
	$html .= '<form action="index.php" method="POST">';
	$html .= '<input type="hidden" name="m" value="company">';
	$html .= '<input type="hidden" name="v" value="company">';
	$html .= '<input type="hidden" name="c" value="company">';
	if (!isset($_REQUEST['nexttask'])) {
		$nexttask = 'do'.$_REQUEST['task'];
	}
	$html .= '<input type="hidden" name="task" value="'.$nexttask.'">';
	if (!isset($row->Note_CompanyID) || $row->Note_CompanyID=='') {
		$Note_CompanyID = $_REQUEST['Company_ID'];
	} else {
		$Note_CompanyID = $row->Note_CompanyID;
	}
	if (!isset($row->Note_RepID) || $row->Rep_CompanyID=='') {
		$Note_RepID = $_SESSION['pass']['user']->Rep_ID;
	} else {
		$Note_RepID = $row->Note_RepID;
	}
	if (!isset($row->Note_AssignedRepID)) { //|| $row->Note_AssignedRepID==''
		$Note_AssignedRepID = $_SESSION['pass']['user']->Rep_ID;
	} else {
		$Note_AssignedRepID = $row->Note_AssignedRepID;
	}
	$html .= '<input type="hidden" name="Note_ID" value="'.$row->Note_ID.'">';
	$html .= '<input type="hidden" name="Note_CompanyID" value="'.$Note_CompanyID.'">';
	$html .= '<input type="hidden" name="Note_RepID" value="'.$Note_RepID.'">';
	$html .= '<input type="hidden" name="Note_AddedBy" value="'.$Note_RepID.'">';
	if ($_REQUEST['redir']!='') {
		$html .= '<input type="hidden" name="redir" value="'.$_REQUEST['redir'].'">';
		$cancel = $_REQUEST['redir'];
	} else {
		$cancel = 'index.php?c=company&task=view&id='.$_REQUEST['Company_ID'];
	}
	if (is_array($data->errors)) {
		foreach($data->errors as $e => $msg) {
			$html .= '<div class="alert-message danger"><p><strong>Error:</strong> '.$msg.'</p></div>';
		}
		$html .= '<div class="alert-message notice"><p>The Note has <b>NOT</b> been added! Please fix the above error to continue.</p></div>';
	}
	if ($data->db->updated==1) {
		$html .= '<div class="alert-message success"><p>The Note has been successfully <strong>Added</strong></p></div>';
	} else {
		$html .= '<div class="alert-message info"><p><strong>To add an Note, please enter the details below and press Save.</strong></p></div>';
	}
	$html .= '<table>';
	$html .= '<thead>';
	$html .= '<tr><th colspan="2" class="tbl-heading"><img src="img/template/icons/note.png"> <span>Add Note</span></th></tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	$html .= '<tr><td class="w80"><b>Type</b></td><td>'; $html .= $this->note_types_list($model,$row->Opp_StageID); $html .= '</td></tr>';
	$html .= '<tr><td><b>Subject</b></td><td><input type="text" name="Note_Subject" value="'.$row->Note_Subject.'"'; 
		if ($data->errors['Note_Subject']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	
	$html .= '<tr><td><b>Detail</b></td><td><textarea name="Note_Body">'.$row->Note_Body; 
	if ($data->errors['Note_Body']!='') { $html .= ' class="danger"'; }
	$html .= '</textarea></td></tr>';
	$html .= '<tr><td><b>Next Action</b></td><td>'; $html .= $this->note_actions_list($model,$Note_NextActionID); $html .= '</td></tr>';
	$html .= '<tr><td><b>Assigned To</b></td><td>'; $html .= $this->note_AssigndRepID_list($model,$Note_AssignedRepID); $html .= '</td></tr>';
	$format = "Y-m-d";
	if ($row->Note_DueDate!='') {
		$Note_DueDate = date($format,strtotime($row->Note_DueDate));
	} else {
		$Note_DueDate = date($format,strtotime(now));
	}
	if ($row->Note_ReminderDate!='') {
		$Note_ReminderDate = date($format,strtotime($row->Note_ReminderDate));
	} else {
		$Note_ReminderDate = date($format,strtotime(now));
	}
	$html .= '<tr><td><b>Due Date</b></td><td><input name="Note_DueDate" data-datepicker="datepicker" class="small" type="text" value="'.$Note_DueDate.'"'; 
		if ($data->errors['Note_DueDate']!='') { $html .= ' class="danger"'; } $html .= '>
		 <span class="timespan">Time: <input type="text" name="Note_DueDateTime" value="'.date('H:i',strtotime($row->Note_DueDate)).'" class="small"></span></td></tr>';
	$html .= '<tr><td><b>Reminder Date</b></td><td><input name="Note_ReminderDate" data-datepicker="datepicker" class="small" type="text" value="'.$Note_ReminderDate.'"'; 
		if ($data->errors['Note_ReminderDate']!='') { $html .= ' class="danger"'; } $html .= '>
		<span class="timespan">Time: <input type="text" name="Note_ReminderTime" value="'.date('H:i',strtotime($row->Note_ReminderDate)).'" class="small"></span></td></tr>';
	$html .= '<tr><td><b>Status</b></td><td>'; $html .= $this->note_status_list($model,$Note_StatusID); $html .= '</td></tr>';

	if ($data->task!='addnote' && $data->task!='doaddnote') {
		$html .= '<tr><td><b>Active</b></td><td'; if ($data->errors['Note_Active']!='') { $html .= ' class="danger"'; } $html .= '>Yes <input type="radio" name="Note_Active" value="1"'; if ($row->Note_Active=='1' || !isset($row->Note_Active)) { $html .= ' checked'; } $html .= '> No <input type="radio" name="Note_Active" value="0"'; if ($row->Note_Active=='0') { $html .= ' checked'; } $html .= '> 
			<div class="warning">NB: marking a note inactive will remove it from the list.</div></td></tr>';
	}
	$html .= '</tbody>';
	$html .= '<tfoot>';
	$html .= '<tr><td colspan=2><input type="submit" name="submit" value="Save" class="btn success" /> <a href="'.$cancel.'" class="btn">Cancel</a></td></tr>';
	$html .= '</tfoot>';
	$html .= '</table>';
	$html .= '</form>';
?>