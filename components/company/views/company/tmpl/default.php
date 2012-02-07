<?php
	$rows = $data->db->result;
	if ($data->db->updated>=1) {
		$html .= '<div class="alert-message success"><p>Your have deleted the selected lines.</p></div>';
	}
	$html .= '<form action="index.php" method="POST" name="delete-form">';
	$html .= '<input type="hidden" name="c" value="company">';
	$html .= '<input type="hidden" name="task" value="delete">';
	$html .= '<table>';
	$html .= '<thead>';
	$html .= '<tr><th colspan="6" class="tbl-heading"><img src="img/template/icons/cmp.png"> <span>Account List for '.$_SESSION['pass']['user']->Rep_FirstName.' '.$_SESSION['pass']['user']->Rep_LastName.'</span></th></tr>';
	$html .= '<tr><th><button name="check-all" id="check-all" class="btn tiny">&#10004;</button></th><th>ID</th><th>Description</th><th>Type</th><th>&nbsp;</th><th>&nbsp;</th></tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	while($row = mysql_fetch_object($rows)) {
		$html .= '<tr>';
		$html .= '<td class="w20"><input type="checkbox" name="aid[]" value="'.$row->Company_ID.'" class="check-able"></td>';
		$html .= '<td class="w20">'.$row->Company_ID.'</td>';
		$html .= '<td>'.$row->Company_Name.'</td>';
		$html .= '<td>'.$row->Company_TypeName.'</td>';
		$html .= '<td class="w40"><a href="index.php?c=company&task=edit&id='.$row->Company_ID.'" class="btn">Edit</a></td>';
		$html .= '<td class="w40"><a href="index.php?c=company&task=view&id='.$row->Company_ID.'" class="btn">View</a></td>';
		$html .= '</tr>';
	}
	$html .= '</tbody>';
	$html .= '<tfoot><tr><td colspan="6">'.$data->db->pagination.'</td></tr></tfoot>';
	$html .= '</table>';
	$html .= '</form>';
	//$html .= '<div class="alert-message info"><p><b>Address Management</b> <a href="index.php?c=address" class="btn primary">Update your addresses here</a></p></div>';
?>