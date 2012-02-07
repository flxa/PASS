<?php
	$html .= '<form action="index.php" method="POST">';
	$html .= '<input type="hidden" name="m" value="company">';
	$html .= '<input type="hidden" name="v" value="company">';
	$html .= '<input type="hidden" name="c" value="company">';
	$html .= '<input type="hidden" name="task" value="doedit">';
	if ($_REQUEST['redir']!='') {
		$html .= '<input type="hidden" name="redir" value="'.$_REQUEST['redir'].'">';
		$cancel = $_REQUEST['redir'];
	} else {
		$cancel = 'index.php?c=company';
	}
	$row = mysql_fetch_object($data->db->result);
	$html .= '<input type="hidden" name="Company_ID" value="'.$row->Company_ID.'">';
	if (is_array($data->errors)) {
		foreach($data->errors as $e => $msg) {
			$html .= '<div class="alert-message danger"><p><strong>Error:</strong> '.$msg.'</p></div>';
		}
		$html .= '<div class="alert-message notice"><p>The Company has <b>NOT</b> been updated! Please fix the above error to continue.</p></div>';
	}
	if ($data->db->updated==1) {
		$html .= '<div class="alert-message success"><p>The Company has been successfully <strong>Added</strong></p></div>';
	} else {
		$html .= '<div class="alert-message info"><p><strong>To edit this Company, please change the details below and press Save.</strong></p></div>';
	}
	$html .= '<table>';
	$html .= '<thead>';
	$html .= '<tr><th colspan="2" class="tbl-heading"><img src="img/template/icons/cmp.png"> <span>Edit Account</span></th></tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	$html .= '<tr><td class="w80"><b>Company Name</b></td><td><input type="text" name="Company_Name" value="'.$row->Company_Name.'"'; 
		if ($data->errors['Company_Name']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td><b>Parent Account</b></td><td>'; $html .= $this->parent_acc_list($model,$row->Company_ParentAccount); $html .= '</td></tr>';
	$html .= '<tr><td><b>Type</b></td><td>'; $html .= $this->company_type_list($model,$row->Company_TypeID); $html .= '</td></tr>';
	$html .= '<tr><td><b>Status</b></td><td>'; $html .= $this->status_list($model,$row->Company_StatusID); $html .= '</td></tr>';
	$html .= '<tr><td><b>Assigned Rep</b></td><td>'; $html .= $this->rep_list($model,$row->company_XREF_UserID); $html .= '</td></tr>';
	$html .= '<tr><td><b>Company ABN</b></td><td><input type="text" name="Company_ABN" value="'.$row->Company_ABN.'"'; 
		if ($data->errors['Company_ABN']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td><b>Company Phone</b></td><td><input type="text" name="Company_Phone" value="'.$row->Company_Phone.'"'; 
		if ($data->errors['Company_Phone']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td><b>Company Fax</b></td><td><input type="text" name="Company_Fax" value="'.$row->Company_Fax.'"'; 
		if ($data->errors['Company_Fax']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td><b>Company Website</b></td><td><input type="text" name="Company_Website" value="'.$row->Company_Website.'"'; 
		if ($data->errors['Company_Website']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td><b>Est Anual Revenue</b></td><td><input type="range" name="Company_EstRevenue" value="'.$row->Company_EstRevenue.'" min="0" max="1000000" step="10000" value="0" id="range-in"><span id="range-out" class="range-value">$'.number_format($row->Company_EstRevenue,2).'</span></td></tr>';
	$html .= '<tr><td><b>Company Region</b></td><td>'; $html .= $this->region_list($model,$row->Company_SalesRegion); $html .= '</td></tr>';
	$html .= '<tr><td><b>Market Segment</b></td><td>'; $html .= $this->segment_list($model,$row->Company_MarketSegment); $html .= ' <a href="#" class="btn success icon" data-controls-modal="modal-from-dom" data-backdrop="true" data-keyboard="true">Add New</a></td></tr>'; $html .= '</td></tr>';
	$html .= '</tbody>';
	$html .= '<tfoot>';
	$html .= '<tr><td colspan=2><input type="submit" name="submit" value="Save" class="btn success"> <a href="'.$cancel.'" class="btn">Cancel</a></td></tr>';
	$html .= '</tfoot>';
	$html .= '</table>';
	$html .= '</form>';
	/****************************************/
	// DOM MODAL
	/****************************************/
	$html .= '<div id="modal-from-dom" class="modal hide fade">
				<div class="modal-header">
					<h3>Add Market Segment</h3>
				</div>
				<div class="modal-body" id="mod-body">';
		$html .= '<form action="index.php" method="POST" id="ajax-form" name="ajax-form">';
		$html .= '<input type="hidden" name="AjaxType" id="AjaxType" value="market-segment">';
		if ($data->task=='add' && (is_array($data->error) || $data->Company_ID!='')) {
			$row = mysql_fetch_object($data->db->result);
		} else {
			$row = $data;
		}
		if (is_array($data->errors)) {
			foreach($data->errors as $e => $msg) {
				$html .= '<div class="alert-message danger"><p><strong>Error:</strong> '.$msg.'</p></div>';
			}
			$html .= '<div class="alert-message notice"><p>The Market Segment has <b>NOT</b> been added! Please fix the above error to continue.</p></div>';
		}
		if ($data->db->updated==1) {
			$html .= '<div class="alert-message success"><p>The Market Segment has been successfully <strong>Added</strong></p></div>';
		}
		$html .= '<table>';
		$html .= '<tbody>';
		$html .= '<tr><td class="w80">Market Segment Name</td><td><input type="text" name="Company_MarketSegmentName" id="Company_MarketSegmentName" value="'.$row->Company_MarketSegmentName.'"'; if ($data->errors['Company_MarketSegmentName']!='') { $html .= ' class="danger"'; } 
		$html .= '></td></tr>';
		$html .= '</tbody>';
		$html .= '</table>';
	$html .= '</div>
				<div class="modal-footer">
					<a href="#" id="save-ajax" class="btn success">Save</a>
					<a href="#" id="close-modal" class="btn">Close</a>
					</form>
				</div>
			</div>';
?>