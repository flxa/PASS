<?php
	$html .= '<form action="index.php" method="POST">';
	$html .= '<input type="hidden" name="m" value="address">';
	$html .= '<input type="hidden" name="v" value="address">';
	$html .= '<input type="hidden" name="c" value="address">';
	$html .= '<input type="hidden" name="task" value="doedit">';
	if ($_REQUEST['redir']!='') {
		$html .= '<input type="hidden" name="redir" value="'.$_REQUEST['redir'].'">';
		$cancel = $_REQUEST['redir'];
	} else {
		$cancel = 'index.php?c=address';
	}
	$row = mysql_fetch_object($data->db->result);
	$html .= '<input type="hidden" name="Address_ID" value="'.$row->Address_ID.'">';
	$html .= '<input type="hidden" name="Address_Type" value="'.$row->Address_Type.'">';
	$html .= '<input type="hidden" name="Address_RepID" value="'.$_SESSION['pass']['user']->Rep_ID.'">';
	$html .= '<input type="hidden" name="Address_CompanyID" value="'.$row->Address_CompanyID.'">';
	if (is_array($data->errors)) {
		foreach($data->errors as $e => $msg) {
			$html .= '<div class="alert-message danger"><p><strong>Error:</strong> '.$msg.'</p></div>';
		}
		$html .= '<div class="alert-message notice"><p>Your Address Details have <b>NOT</b> been updated! Please fix the above error to continue.</p></div>';
	}
	if ($data->db->updated==1) {
		$html .= '<div class="alert-message success"><p>Your Address details have been successfully <b>Updated</b></p></div>';
	} else {
		$html .= '<div class="alert-message info"><p><strong>To edit an address, please change the details below and press Save.</strong></p></div>';
	}
	$html .= '<table>';
	$html .= '<thead>';
	$html .= '<tr><th colspan="2" class="tbl-heading"><img src="img/template/icons/addr.png"> <span>Edit Address</span></th></tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	$html .= '<tr><td class="w80"><b>Address Name</b></td><td><input type="text" name="Address_DescriptionLabel" value="'.$row->Address_DescriptionLabel.'"'; if ($data->errors['Address_DescriptionLabel']!='') {
	$html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td><b>Line 1</b></td><td><input type="text" name="Address_Line1" value="'.$row->Address_Line1.'"'; if ($data->errors['Address_Line1']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td><b>Line 2</b></td><td><input type="text" name="Address_Line2" value="'.$row->Address_Line2.'"'; if ($data->errors['Address_Line2']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td><b>Locality</b></td><td><input type="text" name="Address_Locality" value="'.$row->Address_Locality.'"'; if ($data->errors['Address_Locality']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td><b>State</b></td>
		<td><select name="Address_State"'; if ($data->errors['Address_State']!='') { $html .= ' class="danger"'; } $html .= '>
			<option value="NSW"'; if ($row->Address_State=='NSW') { $html .= ' selected'; } $html .= '>NSW</option>
			<option value="ACT"'; if ($row->Address_State=='ACT') { $html .= ' selected'; } $html .= '>ACT</option>
			<option value="VIC"'; if ($row->Address_State=='VIC') { $html .= ' selected'; } $html .= '>VIC</option>
			<option value="QLD"'; if ($row->Address_State=='QLD') { $html .= ' selected'; } $html .= '>QLD</option>
			<option value="SA"'; if ($row->Address_State=='SA') { $html .= ' selected'; } $html .= '>SA</option>
			<option value="WA"'; if ($row->Address_State=='WA') { $html .= ' selected'; } $html .= '>WA</option>
			<option value="TAS"'; if ($row->Address_State=='TAS') { $html .= ' selected'; } $html .= '>TAS</option>
			<option value="NT"'; if ($row->Address_State=='NT') { $html .= ' selected'; } $html .= '>NT</option>
			</select>
		</td></tr>';
	$html .= '<tr><td><b>Postcode</b></td><td><input type="text" name="Address_Postcode" value="'.$row->Address_Postcode.'"'; if ($data->errors['Address_Postcode']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td><b>Primary?</b></td><td><input type="checkbox" name="Address_IsPrimary" value="1"'; if ($row->Address_IsPrimary==1) { $html .= ' checked'; } $html .= '></td></tr>';
	$html .= '<tr><td><b>Postal?</b></td><td><input type="checkbox" name="Address_IsPostal" value="1"'; if ($row->Address_IsPostal==1) { $html .= ' checked'; } $html .= '></td></tr>';
	$html .= '<tr><td><b>Active?</b></td><td><input type="radio" name="Address_Active" value="1"'; if ($row->Address_Active==1) { $html .= ' checked'; } $html .= '> Yes <input type="radio" name="Address_Active" value="0"'; if ($row->Address_Active==0) { $html .= ' checked'; } $html .= '> No</td></tr>';
	$html .= '</tbody>';
	$html .= '<tfoot>';
	$html .= '<tr><td colspan=2><input type="submit" name="submit" value="Save" class="btn success"> <a href="'.$cancel.'" class="btn">Cancel</a></td></tr>';
	$html .= '</tfoot>';
	$html .= '</table>';
	$html .= '</form>';
?>