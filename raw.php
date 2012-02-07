<?php
require_once('configuration.php');
$config = new Config;
require_once('include/dbconnect.php');

$type = $_REQUEST['type'];
$ajax = new ajax;
switch ($type) {
	/*********************************/
	/******* Save New Company ********/
	/*********************************/
	case 'SaveCompany':
		# Save a new company via ajax
		echo $ajax->SaveCompany();
		break;
	case 'CompanySelectList':
		# refresh the company select list with the new company selected
		echo $ajax->CompanySelectList();
		break;
	/*********************************/
	/*** Add a new Market Segment ****/
	/*********************************/
	case 'SaveMarketSegment':
		# Save a new company via ajax
		echo $ajax->SaveMarketSegment();
		break;
	case 'MarketSegmentSelectList':
		# refresh the company select list with the new company selected
		echo $ajax->MarketSegmentSelectList();
		break;
	case 'SaveClientRole':
		# refresh the company select list with the new company selected
		echo $ajax->SaveClientRole();
		break;
	case 'ClientRoleList':
		# refresh the company select list with the new company selected
		echo $ajax->ClientRoleList();
		break;
	case 'loadMoreOpps':
		# load more opportunities in the opportunities table for the company (account)
		echo $ajax->loadMoreOpps();
	default:
		break;
}

class ajax {
	/*********************************/
	/******* Save New Company ********/
	/*********************************/
	function SaveCompany() {
		$Company_Name = $_REQUEST['Company_Name'];
		$query = "INSERT INTO company (Company_ID,Company_Name,Company_Active) VALUES (NULL,'$Company_Name',1)";
		$result = mysql_query($query);
		if (mysql_affected_rows()>0) {
			$res .= 1;
			$id = mysql_insert_id();
		} else {
			$res .= 0;
			$id = NULL;
		}
		return $id;
	}

	function CompanySelectList(){
		$id = $_REQUEST['id'];
		$datalist = $this->GetCompanies();
		$html = '<select name="Client_Company_ID" id="CCI">';
		while($row = mysql_fetch_object($datalist)) {
			$html .= '<option value="'.$row->Company_ID.'"'; if ($row->Company_ID==$id) { $html .= ' selected'; } $html .= '>'.$row->Company_Name.'</option>';
		}
		$html .= '</select>';
		return $html;
	}

	function GetCompanies() {
		$query 	= "SELECT Company_ID,Company_Name FROM company WHERE Company_Active!=0 ";
		$query .= "ORDER BY Company_Name";
		$result = mysql_query($query);
		return $result;
	}

	/*********************************/
	/*** Add a new Market Segment ****/
	/*********************************/
	function SaveMarketSegment() {
		$Company_MarketSegmentName = $_REQUEST['Company_MarketSegmentName'];
		$query = "INSERT INTO company_market_segments (Company_MarketSegmentID,Company_MarketSegmentName,Company_MarketSegmentActive) VALUES (NULL,'$Company_MarketSegmentName',1)";
		$result = mysql_query($query);
		if (mysql_affected_rows()>0) {
			$res .= 1;
			$id = mysql_insert_id();
		} else {
			$res .= 0;
			$id = NULL;
		}
		return $id;
	}

	function MarketSegmentSelectList(){
		$id = $_REQUEST['id'];
		$datalist = $this->GetMarketSegments();
		$html = '<select name="Company_MarketSegment" id="CMS">';
		while($row = mysql_fetch_object($datalist)) {
			$html .= '<option value="'.$row->Company_MarketSegmentID.'"'; if ($row->Company_MarketSegmentID==$id) { $html .= ' selected'; } $html .= '>'.$row->Company_MarketSegmentName.'</option>';
		}
		$html .= '</select>';
		return $html;
	}

	function GetMarketSegments() {
		$query 	= "SELECT Company_MarketSegmentID,Company_MarketSegmentName FROM company_market_segments WHERE Company_MarketSegmentActive!=0 ";
		$query .= "ORDER BY Company_MarketSegmentName";
		$result = mysql_query($query);
		return $result;
	}

	/*********************************/
	/***** Add a new Client Role *****/
	/*********************************/
	function SaveClientRole() {
		$Client_RoleName = $_REQUEST['Client_RoleName'];
		$query = "INSERT INTO client_roles (Client_RoleID,Client_RoleName,Client_RoleActive) VALUES (NULL,'$Client_RoleName',1)";
		$result = mysql_query($query);
		if (mysql_affected_rows()>0) {
			$res .= 1;
			$id = mysql_insert_id();
		} else {
			$res .= 0;
			$id = NULL;
		}
		return $id;
	}

	function ClientRoleList(){
		$id = $_REQUEST['id'];
		$datalist = $this->GetClientRoleList();
		$html = '<select name="Client_RoleID" id="CRI">';
		while($row = mysql_fetch_object($datalist)) {
			$html .= '<option value="'.$row->Client_RoleID.'"'; if ($row->Client_RoleID==$id) { $html .= ' selected'; } $html .= '>'.$row->Client_RoleName.'</option>';
		}
		$html .= '</select>';
		return $html;
	}

	function GetClientRoleList() {
		$query 	= "SELECT Client_RoleID,Client_RoleName FROM client_roles WHERE Client_RoleActive!=0 ";
		$query .= "ORDER BY Client_RoleName";
		$result = mysql_query($query);
		return $result;
	}

	function loadMoreOpps() {
		$Company_ID = $_REQUEST['Company_ID'];
		$Opp_LimitStart = $_REQUEST['Opp_LimitStart'];
		$limit = 5;
		$query 	= "SELECT Opp_ID,Opp_Name,opportunities.Opp_StageID,opportunities_stages.Opp_StageName,Opp_Amount,Opp_StartDate,Opp_CloseDate,Opp_Active 
			FROM opportunities ";
		$querywhere .= "LEFT JOIN opportunities_stages ON opportunities_stages.Opp_StageID=opportunities.Opp_StageID 
			WHERE Opp_Active!=0 AND Opp_CompanyID='".$Company_ID."'";
		//$queryorder .= " ORDER BY Opp_CloseDate ASC";
		$querylimit .= " LIMIT $Opp_LimitStart,5";
		$result = mysql_query($query.$querywhere.$queryorder.$querylimit);
		$i=$Opp_LimitStart+1;
		while($opp = mysql_fetch_object($result)){
			$html .= '<tr id="tr'.$i.'">
						<td class="a-l"><b>'.$opp->Opp_Name.'</b></td>
						<td class="a-l">'.$opp->Opp_StageName.'</td>
						<td class="a-r">$'.number_format($opp->Opp_Amount).'</td>
						<td class="a-l">'.date('d/m/Y',strtotime($opp->Opp_CloseDate)).'</td>
						<td class="a-r"><a href="index.php?c=company&task=editopp&Company_ID='.$row->Company_ID.'&id='.$opp->Opp_ID.'&redir='.urlencode('index.php?c=company&task=view&id='.$row->Company_ID).'" class="btn">Edit</a></td>
						</tr>';
			$i++;
		}
		//$html .= '<tr><td class="a-l" colspan="5"><b>'.$Opp_LimitStart.'<hr />'.$query.$querywhere.$queryorder.$querylimit.'</b></td></tr>';
		$querytotal = "SELECT COUNT(*) FROM opportunities LEFT JOIN opportunities_stages ON opportunities_stages.Opp_StageID=opportunities.Opp_StageID 
			WHERE Opp_Active!=0 AND Opp_CompanyID='".$Company_ID."'";
		$resulttotal = mysql_query($querytotal);
		$totalrows = mysql_result($resulttotal, 0);
		/*
		if ($totalrows>$Opp_LimitStart+$limit) {
			$html .= '<tfoot>';
			$html .= '<tr><td colspan="5" style="text-align:center;">
							<input type="hidden" id="Company_ID" value="'.$Company_ID.'">
							<input type="hidden" id="Opp_Limit" value="'.$Opp_LimitStart+$limit.'">
							<a href="#" class="btn" id="loadmore">Load More ('.($Opp_LimitStart+$limit).')</a>
						</td></tr>';
			$html .= '</tfoot>';
		}
		*/
		return $html;
	}

}

?>