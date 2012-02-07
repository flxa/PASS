<?php
	$html .= '<form action="index.php" method="POST">';
	$html .= '<input type="hidden" name="m" value="users">';
	$html .= '<input type="hidden" name="v" value="users">';
	$html .= '<input type="hidden" name="c" value="users">';
	$html .= '<input type="hidden" name="task" value="doedit">';
	$row = mysql_fetch_object($data->db->result);
	$html .= '<input type="hidden" name="Rep_ID" value="'.$row->Rep_ID.'">';
	if (is_array($data->errors)) {
		foreach($data->errors as $e => $msg) {
			$html .= '<div class="alert-message danger"><p><strong>Error:</strong> '.$msg.'</p></div>';
		}
		$html .= '<div class="alert-message notice"><p>Your User Details have <b>NOT</b> been updated! Please fix the above error to continue.</p></div>';
	}
	if ($data->db->updated==1) {
		$html .= '<div class="alert-message success"><p>Your User Details have been successfully <strong>Updated</strong></p></div>';
	} else {
		$html .= '<div class="alert-message info"><p><strong>To edit your User Details, please make changes below and press Save.</strong></p></div>';
	}
	$html .= '<table>';
	$html .= '<thead>';
	$html .= '<tr><th colspan="2" class="tbl-heading"><img src="img/template/icons/usr.png"> <span>Edit User Details</span></th></tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	$html .= '<tr><td class="w80">Name</td><td>'.$row->Rep_FirstName.' '.$row->Rep_LastName.'</td></tr>';
	$html .= '<tr><td>Email</td><td>'.$row->Rep_Email.'</td></tr>';
	$html .= '<tr><td>Phone</td><td><input type="phone" name="Rep_ContactPhone" value="'.$row->Rep_ContactPhone.'"'; if ($data->errors['Rep_ContactPhone']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td>Mobile</td><td><input type="phone" name="Rep_ContactMobile" value="'.$row->Rep_ContactMobile.'"'; if ($data->errors['Rep_ContactMobile']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '<tr><td>Fax</td><td><input type="phone" name="Rep_ContactFax" value="'.$row->Rep_ContactFax.'"></td></tr>';
	$html .= '<tr><td>Car Registration</td><td><input type="text" name="Rep_CarRegistration" value="'.$row->Rep_CarRegistration.'"></td></tr>';
	$html .= '<thead>';
	$html .= '<tr><th colspan=2>Change Password</th></tr>';
	$html .= '</thead>';
	$html .= '<tr><td>Password:</td><td><input type="password" name="Rep_Password" value="'.$row->Rep_Password.'"></td></tr>';
	$html .= '<tr><td>ReType Password:</td><td><input type="password" name="password2" value=""'; if ($data->errors['password2']!='') { $html .= ' class="danger"'; } $html .= '></td></tr>';
	$html .= '</tbody>';
	$html .= '<tfoot>';
	$html .= '<tr><td colspan=2><input type="submit" name="submit" value="Save" class="btn success"> <a href="index.php?c=users" class="btn">Cancel</a></td></tr>';
	$html .= '</tfoot>';
	$html .= '</table>';
	$html .= '</form>';
?>