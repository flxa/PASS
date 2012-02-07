<?php
	//echo $data->db->query; exit;
	$row = mysql_fetch_object($data->db->result);
	$redir = urlencode('index.php?c=client&task=view&id='.$row->Client_ID);
	//echo '<pre>'; echo print_r($row); exit;
	$html .= '<table>';
	$html .= '<thead>';
	$html .= '<tr><th colspan="4" class="tbl-heading"><img src="img/template/icons/cmp.png"> <span>Client Detail <a href="index.php?c=client&task=edit&id='.$row->Client_ID.'&redir='.$redir.'" class="btn">Edit</a> <a href="index.php?c=client" class="btn">Close</a></span></th></tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	$html .= '<tr>
				<td class="w80"><b>Name</b></td><td>'.$row->Client_FirstName.' '.$row->Client_Surname.'</td>
				<td class="w80"><b>Company</b></td><td><a href="index.php?c=company&task=view&id='.$row->Client_CompanyID.'" class="btn">'.$row->Company_Name.'</a></td>
			</tr>';
	$html .= '<tr>
				<td class="w80"><b>Role</b></td><td colspan="3">'.$row->Client_RoleName.'</td>
			</tr>';
	$html .= '<tr>
				<td><b>Phone</b></td><td>'; $html .= $row->Client_ContactPhone; $html .= '</td>
				<td><b>Fax</b></td><td>'; $html .= $row->Client_ContactFax; $html .= '</td>
			</tr>';
	$html .= '<tr>
				<td><b>Mobile</b></td><td>'.$row->Client_ContactMobile.'</td>
				<td><b>Email</b></td><td>'.$row->Client_Email.'</td>
			</tr>';
	$html .= '</tbody>';
	$html .= '</table>';

	/*************************/
	/**** Address Details ****/
	/*************************/
	$html .= '<table>';
	$html .= '<thead>';
	$html .= '<tr><th colspan="5" class="tbl-heading"><img src="img/template/icons/addr.png"> <span>Address Details <a href="index.php?c=address&task=add&Address_CompanyID='.$row->Client_Company_ID.'&type=3&redir='.$redir.'" class="btn success icon"><img src="img/template/icons/small/add.png"> <span>New</span></a></span></th></tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	$html .= '<tr><th>Description</th><th>Address</th><th class="a-c">Primary</th><th class="a-c">Postal</th><th>&nbsp;</th></tr>';
	$addr_result = $addr->address_list($row->Client_Company_ID,3); // 2 = company type of address
	//$addr_row = mysql_fetch_object($addr_result);
	//echo '<pre>'; echo print_r($addr_row); exit;
	while($addr_row = mysql_fetch_object($addr_result)){
		$html .= '<tr>
					<td class="a-l"><b>'.$addr_row->Address_DescriptionLabel.'</b></td>
					<td class="a-l">'.
						$addr_row->Address_Line1.'<br />';
						if ($addr_row->Address_Line2!='' || $addr_row->Address_Line2!=NULL) { $html .= $addr_row->Address_Line2.'<br />'; }
						$html .= $addr_row->Address_Locality.' '.$addr_row->Address_State.' '.$addr_row->Address_Postcode.
					'</td>
					<td class="a-c">'; if ($addr_row->Address_IsPrimary==1) { $html .= '<img src="img/template/icons/small/tick.png" alt="Yes">'; } else { $html .= '<img src="img/template/icons/small/cross.png" alt="No">'; }  $html .= '</td>
					<td class="a-c">'; if ($addr_row->Address_IsPostal==1) { $html .= '<img src="img/template/icons/small/tick.png" alt="Yes">'; } else { $html .= '<img src="img/template/icons/small/cross.png" alt="No">'; }  $html .= '</td>
					<td class="a-r"><a href="index.php?c=address&task=edit&id='.$addr_row->Address_ID.'&redir='.urlencode('index.php?c=company&task=view&id='.$row->Company_ID).'" class="btn">Edit</a></td>
					</tr>';
	}
	$html .= '</tfoot>';
	$html .= '</table>';
?>