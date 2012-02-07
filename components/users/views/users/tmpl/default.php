<?php
	$row = $_SESSION['pass']['user'];
	if ($row->error==1) {
		$html .= '<div class="alert-message danger">No user details found for <strong>"'.$row->user.'"</strong></div>';
		include($data->path.'views/users/tmpl/form.php');
	} else {
		//$html .= '<div class="alert-message info message-fade">You are logged in as <b>"'.$row->Rep_FirstName.' '.$row->Rep_LastName.'"</b></div>';
		if ($data->remember==1) {
			$html .= '<div class="alert-message notice message-fade">Your username <b>"'.$row->Rep_Email.'"</b> will be remembered for next time.</div>';
		}
		$html .= '<table>';
		$html .= '<thead>';
		$html .= '<tr><th colspan="2" class="tbl-heading"><img src="img/template/icons/usr.png"> <span>User Details for '.$_SESSION['pass']['user']->Rep_FirstName.' '.$_SESSION['pass']['user']->Rep_LastName.'</span> <a href="index.php?c=users&task=edit&id='.$row->Rep_ID.'" class="btn">Edit</a></th></tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$html .= '<tr><td class="w80"><b>Name</b></td><td>'.$row->Rep_FirstName.' '.$row->Rep_LastName.'</td></tr>';
		$html .= '<tr><td><b>Email</b></td><td>'.$row->Rep_Email.'</td></tr>';
		$html .= '<tr><td><b>Phone</b></td><td>'.$row->Rep_ContactPhone.'</td></tr>';
		$html .= '<tr><td><b>Mobile</b></td><td>'.$row->Rep_ContactMobile.'</td></tr>';
		$html .= '<tr><td><b>Fax</b></td><td>'.$row->Rep_ContactFax.'</td></tr>';
		$html .= '<tr><td><b>Car</b></td><td>'.$row->Rep_CarRegistration.'</td></tr>';
		$html .= '<tr><td><b>Added to System</b></td><td>'.date("d/m/Y",strtotime($row->Rep_RegisteredDate)).'</td></tr>';
		$html .= '<tr><td><b>Last Login</b></td><td>'.date("d/m/Y H:i a",strtotime($row->Rep_LastLogin)).'</td></tr>';
		$html .= '<tr><td><b>Session Remaining:</b></td><td>'.$row->minsleft.'</td></tr>';
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '<a href="index.php?c=address" class="btn primary icon"><img src="img/template/icons/addr.png"> <span>Update your addresses here</span></a>';
	}
?>