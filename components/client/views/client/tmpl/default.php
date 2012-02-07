<?php
	$rows = $data->db->result;
	if ($data->db->updated>=1) {
		$html .= '<div class="alert-message success"><p>Your have deleted the selected lines.</p></div>';
	}
	$html .= '<form action="index.php" method="POST" name="delete-form">';
	$html .= '<input type="hidden" name="c" value="client">';
	$html .= '<input type="hidden" name="task" value="delete">';
	$html .= '<table>';
	$html .= '<thead>';
	$html .= '<tr><th colspan="7" class="tbl-heading"><img src="img/template/icons/cnt.png"> <span>Client List for '.$_SESSION['pass']['user']->Rep_FirstName.' '.$_SESSION['pass']['user']->Rep_LastName.'</span></th></tr>';
	$html .= '<tr><th><button name="check-all" id="check-all" class="btn tiny">&#10004;</button></th>
		<th>ID</th>
		<th>Last Name</th>
		<th>First Name</th>
		<th>Company</th>
		<th>&nbsp;</th></tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	while($row = mysql_fetch_object($rows)) {
		$html .= '<tr>';
		$html .= '<td class="w20"><input type="checkbox" name="aid[]" value="'.$row->Client_ID.'" class="check-able"></td>';
		$html .= '<td class="w20">'.$row->Client_ID.'</td>';
		$html .= '<td>'.$row->Client_Surname.'</td>';
		$html .= '<td>'.$row->Client_FirstName.'</td>';
		$html .= '<td>'.$row->Company_Name.'</td>';
		$html .= '<td class="w40"><a href="index.php?c=client&task=edit&id='.$row->Client_ID.'" class="btn">Edit</a></td>';
		$html .= '<td class="w40"><a href="index.php?c=client&task=view&id='.$row->Client_ID.'" class="btn">View</a></td>';
		$html .= '</tr>';
	}
	$html .= '</tbody>';
	$html .= '<tfoot><tr><td colspan="7">'.$data->db->pagination.'</td></tr></tfoot>';
	$html .= '</table>';
	$html .= '</form>';
	//$html .= '<div class="alert-message info"><p><b>Address Management</b> <a href="index.php?c=address" class="btn primary">Update your addresses here</a></p></div>';
?>