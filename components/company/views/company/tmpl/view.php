<?php
	$row = mysql_fetch_object($data->db->result);
	$redir = urlencode('index.php?c=company&task=view&id='.$row->Company_ID);
	//echo '<pre>'; echo print_r($row); exit;
	$html .= '<table>';
	$html .= '<thead>';
	$html .= '<tr><th colspan="4" class="tbl-heading"><img src="img/template/icons/cmp.png"> <span>Account Detail <a href="index.php?c=company&task=edit&id='.$row->Company_ID.'&redir='.$redir.'" class="btn">Edit</a> <a href="index.php?c=company" class="btn">Close</a></span></th></tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	$html .= '<tr>
				<td class="w80"><b>Company Name</b></td><td>'.$row->Company_Name.'</td>
				<td class="w80"><b>Parent Company</b></td><td>'; 
				if ($row->Company_ParentAccount!=0) { $html .= $model->get_company_name($row->Company_ParentAccount); } else { $html .= 'N/A'; } $html .= '</td>
			</tr>';
	$html .= '<tr>
				<td><b>Type</b></td><td>'; $html .= $row->Company_TypeName; $html .= '</td>
				<td><b>Status</b></td><td>'; $html .= $row->Company_StatusName; $html .= '</td>
			</tr>';
	$html .= '<tr>
				<td><b>Assigned to</b></td><td>'; $html .= $row->Rep_FirstName.' '.$row->Rep_LastName; $html .= '</td>
				<td>&nbsp;</td><td>&nbsp;</td>
			</tr>';
	$html .= '<tr>
				<td><b>Phone</b></td><td>'; $html .= $row->Company_Phone.'</td>
				<td><b>Fax</b></td><td>'; $html .= $row->Company_Fax.'</td>
			</tr>';
	$html .= '<tr>
				<td><b>ABN</b></td><td>'; $html .= $row->Company_ABN; $html .= '</td>
				<td><b>Website</b></td><td>'; $html .= $row->Company_Website.'</td>
			</tr>';
	$html .= '<tr>
				<td><b>Market Segment</b></td><td>'; $html .= $row->Company_MarketSegmentName; $html .= '</td>
				<td><b>Sales Region</b></td><td>'; $html .= $row->Company_RegionName.'</td>
			</tr>';
	$html .= '<tr>
				<td><b>Est Revenue</b></td><td>$'; $html .= number_format($row->Company_EstRevenue,2); $html .= '</td>
				<td>&nbsp;</td><td>&nbsp;</td>
			</tr>';
	$html .= '</tbody>';
	$html .= '</table>';

	/*************************/
	/********* Notes *********/
	/*************************/
	$html .= '<table>';
	$html .= '<thead>';
	$html .= '<tr><th colspan="6" class="tbl-heading"><img src="img/template/icons/note.png"> <span>Notes <a href="index.php?c=company&task=addnote&Company_ID='.$row->Company_ID.'&redir='.$redir.'" class="btn success icon"><img src="img/template/icons/small/add.png"> <span>New</span></a></span></th></tr>';
	$html .= '</thead>';
	$html .= '<tbody id="notes">';
	$note_object = $model->get_notes(NULL,NULL,$row->Company_ID,NULL);
	if ($note_object->numrows>0) {
		$html .= '<tr><th>Subject</th><th class="a-l">Status</th><th class="a-l">Due Date</th><th>&nbsp;</th></tr>';
		$i=1;
		while($note = mysql_fetch_object($note_object->result)){
			$html .= '<tr id="nb'.$i.'">
						<td class="a-l"><b>'.$note->Note_Subject.'</b></td>
						<td class="a-l">'.$note->Note_StatusName.'</td>
						<td class="a-l">'.date('d/m/Y',strtotime($note->Note_DueDate)).'</td>
						<td class="a-r"><a href="index.php?c=company&task=editnote&Company_ID='.$row->Company_ID.'&id='.$note->Note_ID.'&redir='.urlencode('index.php?c=company&task=view&id='.$row->Company_ID).'" class="btn">Edit</a></td>
						</tr>';
			$i++;
		}
	}
	$html .= '</tbody>';
	if ($note_object->totalrows>$note_object->numrows) {
		$html .= '<tfoot id="noteLoadMoreTfoot">';
		$html .= '<tr><td colspan="5" style="text-align:center;">
						<input type="hidden" id="Note_ID" value="'.$row->Company_ID.'">
						<input type="hidden" id="Note_LimitStart" value="'.$note_object->Note_LimitStart.'">
						<button class="btn" id="noteLoadmore">Load More</button>
					</td></tr>';
		$html .= '</tfoot>';
	}
	$html .= '</table>';

	/*************************/
	/***** Opportunities *****/
	/*************************/
	$html .= '<table>';
	$html .= '<thead>';
	$html .= '<tr><th colspan="6" class="tbl-heading"><img src="img/template/icons/opp.png"> <span>Opportunities <a href="index.php?c=company&task=addopp&Company_ID='.$row->Company_ID.'&redir='.$redir.'" class="btn success icon"><img src="img/template/icons/small/add.png"> <span>New</span></a></span></th></tr>';
	$html .= '</thead>';
	$html .= '<tbody id="opportunities">';
	$opp_object = $model->get_opportunities($row->Company_ID);
	if ($opp_object->numrows>0) {
		$html .= '<tr><th>Name</th><th class="a-l">Stage</th><th class="a-r">Amount</th><th class="a-l">Close Date</th><th>&nbsp;</th></tr>';
		$i=1;
		while($opp = mysql_fetch_object($opp_object->result)){
			$html .= '<tr id="tr'.$i.'">
						<td class="a-l"><b>'.$opp->Opp_Name.'</b></td>
						<td class="a-l">'.$opp->Opp_StageName.'</td>
						<td class="a-r">$'.number_format($opp->Opp_Amount).'</td>
						<td class="a-l">'.date('d/m/Y',strtotime($opp->Opp_CloseDate)).'</td>
						<td class="a-r"><a href="index.php?c=company&task=editopp&Company_ID='.$row->Company_ID.'&id='.$opp->Opp_ID.'&redir='.urlencode('index.php?c=company&task=view&id='.$row->Company_ID).'" class="btn">Edit</a></td>
						</tr>';
			$i++;
		}
	}
	$html .= '</tbody>';
	if ($opp_object->totalrows>$opp_object->numrows) {
		$html .= '<tfoot id="loadMoreTfoot">';
		$html .= '<tr><td colspan="5" style="text-align:center;">
						<input type="hidden" id="Company_ID" value="'.$row->Company_ID.'">
						<input type="hidden" id="Opp_LimitStart" value="'.$opp_object->Opp_LimitStart.'">
						<button class="btn" id="loadmore">Load More</button>
					</td></tr>';
		$html .= '</tfoot>';
	}
	$html .= '</table>';

	/*************************/
	/***** Client Details ****/
	/*************************/
	$html .= '<table>';
	$html .= '<thead>';
	$html .= '<tr><th colspan="6" class="tbl-heading"><img src="img/template/icons/cnt.png"> <span>Client Details <a href="index.php?c=client&task=add&Client_CompanyID='.$row->Company_ID.'&redir='.$redir.'" class="btn success icon"><img src="img/template/icons/small/add.png"> <span>New</span></a></span></th></tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	$html .= '<tr><th>Name</th><th class="a-l">Phone</th><th class="a-l">Mobile</th><th class="a-l">Email</th><th>&nbsp;</th></tr>';
	$client_result = $client->client_list($row->Company_ID);
	while($client = mysql_fetch_object($client_result)){
		$html .= '<tr>
					<td class="a-l"><b>'.$client->Client_FirstName.' '.$client->Client_Surname.'</b></td>
					<td class="a-l">'.$client->Client_ContactPhone.'</td>
					<td class="a-l">'.$client->Client_ContactMobile.'</td>
					<td class="a-l">'.$client->Client_Email.'</td>
					<td class="a-r"><a href="index.php?c=client&task=edit&id='.$client->Client_ID.'&redir='.urlencode('index.php?c=company&task=view&id='.$row->Company_ID).'" class="btn">Edit</a></td>
					<td class="a-r"><a href="index.php?c=client&task=view&id='.$client->Client_ID.'&redir='.urlencode('index.php?c=company&task=view&id='.$row->Company_ID).'" class="btn">View</a></td>
					</tr>';
	}
	$html .= '</tfoot>';
	$html .= '</table>';

	/*************************/
	/**** Address Details ****/
	/*************************/
	$html .= '<table>';
	$html .= '<thead>';
	$html .= '<tr><th colspan="5" class="tbl-heading"><img src="img/template/icons/addr.png"> <span>Address Details <a href="index.php?c=address&task=add&Address_CompanyID='.$row->Company_ID.'&type=2&redir='.$redir.'" class="btn success icon"><img src="img/template/icons/small/add.png"> <span>New</span></a></span></th></tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	$html .= '<tr><th>Description</th><th>Address</th><th class="a-c">Primary</th><th class="a-c">Postal</th><th>&nbsp;</th></tr>';
	$addr_result = $addr->address_list($row->Company_ID,2); // 2 = company type of address
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