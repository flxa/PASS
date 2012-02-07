<?php
	if (($data->task=='doaddopp' && (is_array($data->error)) || $_REQUEST['id']!='')) {
		//echo $_REQUEST['id'].' TOLDYA'; exit;
		$data = $model->get_opportunities($_REQUEST['Company_ID'],$_REQUEST['id']);
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
	if (!isset($row->Opp_CompanyID) || $row->Opp_CompanyID=='') {
		$Opp_CompanyID = $_REQUEST['Company_ID'];
	} else {
		$Opp_CompanyID = $row->Opp_CompanyID;
	}
	$html .= '<input type="hidden" name="Opp_CompanyID" value="'.$Opp_CompanyID.'">';
	if ($_REQUEST['redir']!='') {
		$html .= '<input type="hidden" name="redir" value="'.$_REQUEST['redir'].'">';
		$cancel = $_REQUEST['redir'];
	} else {
		$cancel = 'index.php?c=company&task=view&id='.$_REQUEST['Company_ID'];
	}
	//echo $cancel; exit;
	$html .= '<input type="hidden" name="Opp_ID" value="'.$row->Opp_ID.'">';
	if (is_array($data->errors)) {
		foreach($data->errors as $e => $msg) {
			$html .= '<div class="alert-message danger"><p><strong>Error:</strong> '.$msg.'</p></div>';
		}
		$html .= '<div class="alert-message notice"><p>The Opportunity has <b>NOT</b> been added! Please fix the above error to continue.</p></div>';
	}
	if ($data->db->updated==1) {
		$html .= '<div class="alert-message success"><p>The Opportunity has been successfully <strong>Added</strong></p></div>';
	} else {
		$html .= '<div class="alert-message info"><p><strong>To add an Opportunity, please enter the details below and press Save.</strong></p></div>';
	}
	$html .= '<table>';
	$html .= '<thead>';
	$html .= '<tr><th colspan="2" class="tbl-heading"><img src="img/template/icons/opp.png"> <span>Add Opportunity</span></th></tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	$html .= '<tr><td class="w80"><b>Opportunity</b></td><td><input type="text" name="Opp_Name" value="'.$row->Opp_Name.'"'; 
		if ($data->errors['Opp_Name']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td><b>Stage</b></td><td>'; $html .= $this->opp_stage_list($model,$row->Opp_StageID); $html .= '</td></tr>';
	$html .= '<tr><td><b>Amount</b></td><td><div class="input"><div class="input-prepend"><span class="add-on">$</span>
			<input type="text" name="Opp_Amount" placeholder="0.00" value="';
	if ($row->Opp_Amount!='') {
		$html .= number_format($row->Opp_Amount,2,'.','');
	}
	$html .= '"'; if ($data->errors['Opp_Amount']!='') { $html .= ' class="danger"'; } $html .= '>
		</div></div></td></tr>';
	$format = "Y-m-d";
	if ($row->StartDate!='') {
		$startDate = date($format,strtotime($row->StartDate));
	} else {
		$startDate = date($format,strtotime(now));
	}
	if ($row->CloseDate!='') {
		$closeDate = date($format,strtotime($row->CloseDate));
	} else {
		$closeDate = date($format,strtotime('+1 week'));
	}
	$html .= '<tr><td><b>Start Date</b></td><td><input name="Opp_StartDate" data-datepicker="datepicker" class="small" type="text" value="'.$startDate.'"'; 
		if ($data->errors['startDate']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td><b>Close Date</b></td><td><input name="Opp_CloseDate" data-datepicker="datepicker" class="small" type="text" value="'.$closeDate.'"'; 
		if ($data->errors['closeDate']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	if ($data->task!='addopp' && $data->task!='doaddopp') {
		$html .= '<tr><td><b>Active</b></td><td'; if ($data->errors['Opp_Active']!='') { $html .= ' class="danger"'; } $html .= '>Yes <input type="radio" name="Opp_Active" value="1"'; if ($row->Opp_Active=='1' || !isset($row->Opp_Active)) { $html .= ' checked'; } $html .= '> No <input type="radio" name="Opp_Active" value="0"'; if ($row->Opp_Active=='0') { $html .= ' checked'; } $html .= '> 
			<div class="warning">NB: marking an opportunity inactive will remove it from the list.</div></td></tr>';
	}
	$html .= '</tbody>';
	$html .= '<tfoot>';
	$html .= '<tr><td colspan=2><input type="submit" name="submit" value="Save" class="btn success" /> <a href="'.$cancel.'" class="btn">Cancel</a></td></tr>';
	$html .= '</tfoot>';
	$html .= '</table>';
	$html .= '</form>';
?>