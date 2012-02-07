<?php
	$html .= '<form action="index.php" method="POST">';
	$html .= '<input type="hidden" name="m" value="client">';
	$html .= '<input type="hidden" name="v" value="client">';
	$html .= '<input type="hidden" name="c" value="client">';
	$html .= '<input type="hidden" name="task" value="doadd">';
	if ($_REQUEST['redir']!='') {
		$html .= '<input type="hidden" name="redir" value="'.$_REQUEST['redir'].'">';
		$cancel = $_REQUEST['redir'];
	} else {
		$cancel = 'index.php?c=client';
	}
	if ($data->task=='add' && (is_array($data->error) || $data->Company_ID!='')) {
		$row = mysql_fetch_object($data->db->result);
	} else {
		$row = $data;
	}
	$html .= '<input type="hidden" name="Client_ID" value="'.$row->Client_ID.'">';
	if (is_array($data->errors)) {
		foreach($data->errors as $e => $msg) {
			$html .= '<div class="alert-message danger"><p><strong>Error:</strong> '.$msg.'</p></div>';
		}
		$html .= '<div class="alert-message notice"><p>The Client has <b>NOT</b> been added! Please fix the above error to continue.</p></div>';
	}
	if ($data->db->updated==1) {
		$html .= '<div class="alert-message success"><p>The Client has been successfully <strong>Added</strong></p></div>';
	} else {
		$html .= '<div class="alert-message info"><p><strong>To add a Client, please enter the details below and press Save.</strong></p></div>';
	}
	$html .= '<table>';
	$html .= '<thead>';
	$html .= '<tr><th colspan="2" class="tbl-heading"><img src="img/template/icons/cnt.png"> <span>Add Client</span></th></tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	if (isset($_REQUEST['Client_CompanyID'])) { $company_id = $_REQUEST['Client_CompanyID']; } else { $company_id = $data->Client_Company_ID; }
	$html .= '<tr><td class="w80">Account</td><td>'; $html .= $this->company_select_list($model,$company_id); $html .= ' <a href="index.php?c=company&task=add" class="btn success" data-controls-modal="modal-from-dom" data-backdrop="true" data-keyboard="true">Add New</a></td></tr>';
	$html .= '<tr><td>First Name</td><td><input type="text" name="Client_FirstName" value="'.$row->Client_FirstName.'"'; if ($data->errors['Client_FirstName']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td>Last Name</td><td><input type="text" name="Client_Surname" value="'.$row->Client_Surname.'"'; if ($data->errors['Client_Surname']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	// Client Role SELECT + AJAX
	$html .= '<tr><td>Client Role</td><td>'.$this->get_roles_list($model,$row->Client_RoleID); $html .= ' <a href="index.php?c=client&task=addrole" class="btn success" data-controls-modal="modal-from-dom-2" data-backdrop="true" data-keyboard="true">Add New</a></td></tr>';
	
	$html .= '<tr><td>Contact Phone</td><td><input type="text" name="Client_ContactPhone" value="'.$row->Client_ContactPhone.'"'; if ($data->errors['Client_ContactPhone']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td>Contact Fax</td><td><input type="text" name="Client_ContactFax" value="'.$row->Client_ContactFax.'"'; if ($data->errors['Client_ContactFax']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td>Contact Mobile</td><td><input type="text" name="Client_ContactMobile" value="'.$row->Client_ContactMobile.'"'; if ($data->errors['Client_ContactMobile']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td>Contact Email</td><td><input type="text" name="Client_Email" value="'.$row->Client_Email.'"'; if ($data->errors['Client_Email']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '</tbody>';
	$html .= '<tfoot>';
	$html .= '<tr><td colspan=2><input type="submit" name="submit" value="Save" class="btn success" /> <a href="'.$cancel.'" class="btn">Cancel</a></td></tr>';
	$html .= '</tfoot>';
	$html .= '</table>';
	$html .= '</form>';
	/****************************************/
	// DOM MODAL for Account (Company)
	/****************************************/
	$html .= '<div id="modal-from-dom" class="modal hide fade">
				<div class="modal-header">
					<h3>Add Account</h3>
				</div>
				<div class="modal-body" id="mod-body">';
		$html .= '<form action="index.php" method="POST" id="ajax-form" name="ajax-form">';
		$html .= '<input type="hidden" name="m" value="company">';
		$html .= '<input type="hidden" name="v" value="company">';
		$html .= '<input type="hidden" name="c" value="company">';
		$html .= '<input type="hidden" name="task" value="doadd">';
		if ($data->task=='add' && (is_array($data->error) || $data->Company_ID!='')) {
			$row = mysql_fetch_object($data->db->result);
		} else {
			$row = $data;
		}
		$html .= '<input type="hidden" name="Company_ID" value="'.$row->Company_ID.'">';
		$html .= '<input type="hidden" name="AjaxType" id="AjaxType" value="company">';
		if (is_array($data->errors)) {
			foreach($data->errors as $e => $msg) {
				$html .= '<div class="alert-message danger"><p><strong>Error:</strong> '.$msg.'</p></div>';
			}
			$html .= '<div class="alert-message notice"><p>The Account has <b>NOT</b> been added! Please fix the above error to continue.</p></div>';
		}
		if ($data->db->updated==1) {
			$html .= '<div class="alert-message success"><p>The Account has been successfully <strong>Added</strong></p></div>';
		}
		$html .= '<table>';
		$html .= '<tbody>';
		$html .= '<tr><td class="w80">Company Name</td><td><input type="text" name="Company_Name" id="Company_Name" value="'.$row->Company_Name.'"'; if ($data->errors['Company_Name']!='') { $html .= ' class="danger"'; } 
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
	
	/****************************************/
	// DOM MODAL for Roles (Client Roles)
	/****************************************/
	$html .= '<div id="modal-from-dom-2" class="modal hide fade">
				<div class="modal-header">
					<h3>Add Client Role</h3>
				</div>
				<div class="modal-body" id="mod-body-2">';
		$html .= '<form action="index.php" method="POST" id="ajax-form-2" name="ajax-form-2">';
		$html .= '<input type="hidden" name="m" value="client">';
		$html .= '<input type="hidden" name="v" value="client">';
		$html .= '<input type="hidden" name="c" value="client">';
		$html .= '<input type="hidden" name="task" value="doadd-role">';
		//if ($data->task=='add' && (is_array($data->error) || $data->Company_ID!='')) { $row = mysql_fetch_object($data->db->result); } else { $row = $data; }
		$html .= '<input type="hidden" name="Client_RoleID" value="'.$row->Company_ID.'">';
		$html .= '<input type="hidden" name="AjaxType-2" id="AjaxType-2" value="client-role">';
		if (is_array($data->errors)) {
			foreach($data->errors as $e => $msg) {
				$html .= '<div class="alert-message danger"><p><strong>Error:</strong> '.$msg.'</p></div>';
			}
			$html .= '<div class="alert-message notice"><p>The Client Role has <b>NOT</b> been added! Please fix the above error to continue.</p></div>';
		}
		if ($data->db->updated==1) {
			$html .= '<div class="alert-message success"><p>The Client Role has been successfully <strong>Added</strong></p></div>';
		}
		$html .= '<table>';
		$html .= '<tbody>';
		$html .= '<tr><td class="w80">Client Role</td><td><input type="text" name="Client_RoleName" id="Client_RoleName" value="'.$row->Client_RoleName.'"'; if ($data->errors['Client_RoleName']!='') { $html .= ' class="danger"'; } 
		$html .= '></td></tr>';
		$html .= '</tbody>';
		$html .= '</table>';
	$html .= '</div>
				<div class="modal-footer">
					<a href="#" id="save-ajax-2" class="btn success">Save</a>
					<a href="#" id="close-modal-2" class="btn">Close</a>
					</form>
				</div>
			</div>';
?>