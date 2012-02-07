<?php
	$rows = $data->db->result;
	if ($data->db->updated>=1) {
		$html .= '<div class="alert-message success"><p>Your have deleted the selected lines.</p></div>';
	}
	$html .= '<form action="index.php" method="POST" name="delete-form">';
	$html .= '<input type="hidden" name="c" value="address">';
	$html .= '<input type="hidden" name="task" value="delete">';
	$html .= '<table>';
	$html .= '<thead>';
	$html .= '<tr><th colspan="6" class="tbl-heading"><img src="img/template/icons/addr.png"> <span>Address List for '.$_SESSION['pass']['user']->Rep_FirstName.' '.$_SESSION['pass']['user']->Rep_LastName.'</span></th></tr>';
	$html .= '<tr><th><button name="check-all" id="check-all" class="btn tiny">&#10004;</button></th><th>Description</th><th>Address</th><th class="a-c">Primary</th><th class="a-c">Postal</th><th>&nbsp;</th></tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	while($row = mysql_fetch_object($rows)) {
		$html .= '<tr>
					<td class="w20"><input type="checkbox" name="aid[]" value="'.$row->Address_ID.'" class="check-able"></td>
					<td class="a-l"><b>'.$row->Address_DescriptionLabel.'</b></td>
					<td class="a-l">'.
						$row->Address_Line1.'<br />';
						if ($row->Address_Line2!='' || $row->Address_Line2!=NULL) { $html .= $row->Address_Line2.'<br />'; }
						$html .= $row->Address_Locality.' '.$row->Address_State.' '.$row->Address_Postcode.
					'</td>
					<td class="a-c">'; if ($row->Address_IsPrimary==1) { $html .= '<img src="img/template/icons/small/tick.png" alt="Yes">'; } else { $html .= '<img src="img/template/icons/small/cross.png" alt="No">'; }  $html .= '</td>
					<td class="a-c">'; if ($row->Address_IsPostal==1) { $html .= '<img src="img/template/icons/small/tick.png" alt="Yes">'; } else { $html .= '<img src="img/template/icons/small/cross.png" alt="No">'; }  $html .= '</td>
					<td class="a-r"><a href="index.php?c=address&task=edit&id='.$row->Address_ID.'" class="btn">Edit</a></td>
					</tr>';

	}
	$html .= '</tbody>';
	$html .= '<tfoot><tr><td colspan="6">'.$data->db->pagination.'</td></tr></tfoot>';
	$html .= '</table>';
	$html .= '</form>';
	//$html .= '<div class="alert-message info"><p><b>Address Management</b> <a href="index.php?c=address" class="btn primary">Update your addresses here</a></p></div>';
?>