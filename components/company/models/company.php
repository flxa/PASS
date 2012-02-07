<?php

class CompanyModelCompany extends Component {

	function generate_query($data){
		$query 	= "SELECT company.Company_ID 
			, company.Company_Name 
			, company.Company_AssignedRep 
			, assignedRep.Rep_FirstName 
			, assignedRep.Rep_LastName 
			, company.Company_ParentAccount 
			, company.Company_ABN 
			, company.Company_Phone 
			, company.Company_Fax 
			, company.Company_Website 
			, company.Company_MarketSegment 
			, company_market_segments.Company_MarketSegmentName 
			, company.Company_EstRevenue 
			, company.Company_SalesRegion 
			, company_regions.Company_RegionName 
			, company.Company_TypeID 
			, company_types.Company_TypeName 
			, company.Company_StatusID 
			, company_status.Company_StatusName 
			, company.Company_Active 
			FROM company ";
		$query .= "LEFT JOIN company_types ON company_types.Company_TypeID=company.Company_TypeID ";
		$query .= "LEFT JOIN company_status ON company_status.Company_StatusID=company.Company_StatusID ";
		$query .= "LEFT JOIN company_regions ON company_regions.Company_RegionID=company.Company_SalesRegion ";
		$query .= "LEFT JOIN company_market_segments ON company_market_segments.Company_MarketSegmentID=company.Company_MarketSegment ";
		//if ($_SESSION['pass']['user']->Rep_GroupID!=2) {
			$query .= "LEFT JOIN company_XREF ON company_XREF.Company_XREF_CompanyID=company.Company_ID ";
		//}
		$query .= "LEFT JOIN users ON users.Rep_ID=company_XREF.company_XREF_UserID ";
		$query .= "LEFT JOIN users as assignedRep ON assignedRep.Rep_ID=company.Company_AssignedRep ";
		$query .= "WHERE Company_Active!=0";
		if ($_SESSION['pass']['user']->Rep_GroupID!=2) {
			$query .= " AND company_XREF.Company_XREF_Active!=0";
			$query .= " AND company_XREF_UserID='".$_SESSION['pass']['user']->Rep_ID."'";
		}
		if ($data->Company_ID!='') {
			$id = $data->Company_ID;
			$query .= " AND Company_ID='".$id."'";
		}
		if ($data->Company_ID=='' && $_REQUEST['id']!='') {
			$id = mysql_real_escape_string($_REQUEST['id']);
			$query .= " AND Company_ID='".$id."'";
		}
		$query .= " ORDER BY Company_ID ";
		return $query;
	}

	function gettotal($query) {
		$query 	= "SELECT count(*) FROM ($query) as counttable";
		$result = mysql_query($query);
		$total = mysql_result($result, 0);
		return $total;
	}

	function _loadData($data,$pagination=NULL) {
		$starttime = microtime();
		$query = $this->generate_query($data);
		require_once('include/pagination.php');
		$page = 1;
		$size = 10;
		if (isset($_GET['page'])){ $page = (int) $_GET['page']; }
		$pagination = new Pagination();
		$pagination->setLink("index.php?c=company&page=%s");
		$pagination->setPage($page);
		$pagination->setSize($size);
		$pagination->setTotalRecords($this->gettotal($query));
		if ($pagination!=NULL) {
			$p_query .= $pagination->getLimitSql();
		}
		$result = mysql_query($query.$p_query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->numrows = mysql_num_rows($result);
		$db->timetaken = $endtime-$starttime;
		$db->updated = $data->db->updated;
		if ($pagination!=NULL) {
			$totalrows = $this->gettotal($query);
		} else {
			$totalrows = 1;
		}
		$db->totalrows = $totalrows;
		$db->pagination = $pagination->create_links();
		$data->db = $db;
		return $data;
	}
	
	function doadd($data) {
		$starttime = microtime();
		$query 	= "INSERT INTO company (
				Company_ID
				,Company_Name
				,Company_AssignedRep
				,Company_ParentAccount
				,Company_ABN
				,Company_Phone
				,Company_Fax
				,Company_Website
				,Company_MarketSegment
				,Company_EstRevenue
				,Company_SalesRegion
				,Company_TypeID
				,Company_StatusID
				,Company_Active
			) VALUES (
				NULL
				,'$data->Company_Name'
				,'$data->Company_AssignedRep'
				,'$data->Company_ParentAccount'
				,'$data->Company_ABN'
				,'$data->Company_Phone'
				,'$data->Company_Fax'
				,'$data->Company_Website'
				,'$data->Company_MarketSegment'
				,'$data->Company_EstRevenue'
				,'$data->Company_SalesRegion'
				,'$data->Company_TypeID'
				,'$data->Company_StatusID'
				,'$data->Company_Active' 
			)";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); echo $db->sql_error.'<hr />'.$query; exit; }
		$db->query = $query;
		$db->result = $result;
		$db->updated = mysql_affected_rows();
		$db->timetaken = $endtime-$starttime;
		$data->Address_ID = mysql_insert_id();
		$db->result = $this->_loadData($data);
		$data->db = $db;
		$this->log($_SESSION['pass']['user']->Rep_ID,$data->Company_Name,$data->Company_ID,$data,$db);
		return $data;
	}
	
	function doedit($data) {
		$starttime = microtime();
		$query 	= "UPDATE company SET 
			Company_Name='".$data->Company_Name."' 
			,Company_AssignedRep='".$data->Company_AssignedRep."' 
			,Company_ParentAccount='".$data->Company_ParentAccount."'
			,Company_ABN='".$data->Company_ABN."'
			,Company_Phone='".$data->Company_Phone."' 
			,Company_Fax='".$data->Company_Fax."' 
			,Company_Website='".$data->Company_Website."' 
			,Company_MarketSegment='".$data->Company_MarketSegment."' 
			,Company_EstRevenue='".$data->Company_EstRevenue."' 
			,Company_SalesRegion='".$data->Company_SalesRegion."'   
			,Company_TypeID='".$data->Company_TypeID."' 
			,Company_StatusID='".$data->Company_StatusID."' 
			,Company_Active='".$data->Company_Active."' ";
		$query .= "WHERE Company_ID=$data->Company_ID";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->updated = mysql_affected_rows();
		$db->timetaken = $endtime-$starttime;
		$data->db = $db;
		$this->log($_SESSION['pass']['user']->Rep_ID,$data->Company_Name,$data->Company_ID,$data,$db);
		return $data;
	}
	
	function delete($data,$aid) {
		$starttime = microtime();
		$query 	= "UPDATE company SET 
			Company_Active=0 ";
		$query .= "WHERE Company_ID IN ( ";
		$i=0;
		foreach($aid as $index => $id) {
			if ($i>0) { $query.= ","; }
			$query .= (int) $id;
			$logid .= $id.',';
			$i++;
		}
		$query .= " )";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->updated = mysql_affected_rows();
		$db->timetaken = $endtime-$starttime;
		$data->db = $db;
		$this->log($_SESSION['pass']['user']->Rep_ID,NULL,$logid,$data,$db);
		return $data;
	}

	function get_company_types() {
		$starttime = microtime();
		$query 	= "SELECT Company_TypeID,Company_TypeName FROM company_types WHERE Company_TypeActive!=0 ";
		$query .= "ORDER BY Company_TypeName";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->numrows = mysql_num_rows($result);
		$db->timetaken = $endtime-$starttime;
		$db->updated = 0;
		$datalist = $db;
		return $datalist;
	}

	function get_reps() {
		$starttime = microtime();
		$query 	= "SELECT Rep_ID,Rep_FirstName,Rep_LastName FROM users WHERE Rep_Active!=0 ";
		$query .= "ORDER BY Rep_LastName";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->numrows = mysql_num_rows($result);
		$db->timetaken = $endtime-$starttime;
		$db->updated = 0;
		$datalist = $db;
		return $datalist;
	}

	function get_accounts() {
		$starttime = microtime();
		$query 	= "SELECT Company_ID,Company_Name FROM company WHERE Company_Active!=0 ";
		$query .= "ORDER BY Company_Name";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->numrows = mysql_num_rows($result);
		$db->timetaken = $endtime-$starttime;
		$db->updated = 0;
		$datalist = $db;
		return $datalist;
	}

	function get_regions() {
		$starttime = microtime();
		$query 	= "SELECT Company_RegionID,Company_RegionName FROM company_regions WHERE Company_RegionActive!=0 ";
		$query .= "ORDER BY Company_RegionID";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->numrows = mysql_num_rows($result);
		$db->timetaken = $endtime-$starttime;
		$db->updated = 0;
		$datalist = $db;
		return $datalist;
	}

	function get_market_segments() {
		$starttime = microtime();
		$query 	= "SELECT Company_MarketSegmentID,Company_MarketSegmentName FROM company_market_segments WHERE Company_MarketSegmentActive!=0 ";
		$query .= "ORDER BY Company_MarketSegmentName";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->numrows = mysql_num_rows($result);
		$db->timetaken = $endtime-$starttime;
		$db->updated = 0;
		$datalist = $db;
		return $datalist;
	}

	function get_status_list() {
		$starttime = microtime();
		$query 	= "SELECT Company_StatusID,Company_StatusName FROM company_status WHERE Company_StatusActive!=0 ";
		$query .= "ORDER BY Company_StatusName";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->numrows = mysql_num_rows($result);
		$db->timetaken = $endtime-$starttime;
		$db->updated = 0;
		$datalist = $db;
		return $datalist;
	}

	function get_company_name($id) {
		$starttime = microtime();
		$query 	= "SELECT Company_Name FROM company WHERE Company_ID=".$id;
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->numrows = mysql_num_rows($result);
		$db->timetaken = $endtime-$starttime;
		$db->updated = 0;
		$datalist = $db;
		$companyname = mysql_result($result,0,"Company_Name");
		return $companyname;
	}

	function get_notes($id=NULL,$NoteID=NULL,$limit=NULL) {
		$starttime = microtime();
		$query 	= "SELECT Opp_ID,Opp_Name,opportunities.Opp_StageID,opportunities_stages.Opp_StageName,Opp_Amount,Opp_StartDate,Opp_CloseDate,Opp_Active
			,Opp_CompanyID 
			FROM opportunities ";
		$querywhere .= "LEFT JOIN opportunities_stages ON opportunities_stages.Opp_StageID=opportunities.Opp_StageID 
			WHERE Opp_Active!=0 ";
		if ($id!='') {
			$querywhere .= " AND Opp_CompanyID='".$id."'";
		}
		if ($OppID!=NULL) {
			$querywhere .= " AND Opp_ID='".$OppID."'";
		}
		//$queryorder .= " ORDER BY Opp_CloseDate ASC";
		if ($limit!=NULL) {
			$querylimit .= " LIMIT $limit";
		} else {
			$querylimit .= " LIMIT 0,5";
		}
		$result = mysql_query($query.$querywhere.$queryorder.$querylimit);
		//echo $query.$querywhere.$queryorder.$querylimit; exit;
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); echo mysql_error(); exit; }
		$db->query = $query;
		$db->result = $result;
		$db->numrows = mysql_num_rows($result);
		$query = "SELECT COUNT(*) FROM opportunities ".$querywhere;
		$resulttotal = mysql_query($query);
		$db->totalrows = mysql_result($resulttotal,0);
		$db->Opp_LimitStart = "5";
		$db->timetaken = $endtime-$starttime;
		$db->updated = 0;
		$datalist = $db;
		return $datalist;
	}

	function get_opportunities($id=NULL,$OppID=NULL,$limit=NULL) {
		$starttime = microtime();
		$query 	= "SELECT Opp_ID,Opp_Name,opportunities.Opp_StageID,opportunities_stages.Opp_StageName,Opp_Amount,Opp_StartDate,Opp_CloseDate,Opp_Active
			,Opp_CompanyID 
			FROM opportunities ";
		$querywhere .= "LEFT JOIN opportunities_stages ON opportunities_stages.Opp_StageID=opportunities.Opp_StageID 
			WHERE Opp_Active!=0 ";
		if ($id!='') {
			$querywhere .= " AND Opp_CompanyID='".$id."'";
		}
		if ($OppID!=NULL) {
			$querywhere .= " AND Opp_ID='".$OppID."'";
		}
		//$queryorder .= " ORDER BY Opp_CloseDate ASC";
		if ($limit!=NULL) {
			$querylimit .= " LIMIT $limit";
		} else {
			$querylimit .= " LIMIT 0,5";
		}
		$result = mysql_query($query.$querywhere.$queryorder.$querylimit);
		//echo $query.$querywhere.$queryorder.$querylimit; exit;
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); echo mysql_error(); exit; }
		$db->query = $query;
		$db->result = $result;
		$db->numrows = mysql_num_rows($result);
		$query = "SELECT COUNT(*) FROM opportunities ".$querywhere;
		$resulttotal = mysql_query($query);
		$db->totalrows = mysql_result($resulttotal,0);
		$db->Opp_LimitStart = "5";
		$db->timetaken = $endtime-$starttime;
		$db->updated = 0;
		$datalist = $db;
		return $datalist;
	}

	function save_opp($data) {
		$starttime = microtime();
		$query 	= "INSERT INTO opportunities (
				Opp_ID
				,Opp_Name
				,Opp_StageID
				,Opp_Amount
				,Opp_StartDate
				,Opp_CloseDate
				,Opp_Active
				,Opp_CompanyID
			) VALUES (
				NULL
				,'$data->Opp_Name'
				,'$data->Opp_StageID'
				,'$data->Opp_Amount'
				,'$data->Opp_StartDate'
				,'$data->Opp_CloseDate'
				,'$data->Opp_Active'
				,'$data->Opp_CompanyID'
			)";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); echo $db->sql_error.'<hr />'.$query; exit; }
		$db->query = $query;
		$db->result = $result;
		$db->updated = mysql_affected_rows();
		$db->timetaken = $endtime-$starttime;
		$data->Opp_ID = mysql_insert_id();
		$db->result = $this->_loadData($data);
		$data->db = $db;
		//echo '<pre>'; echo print_r($data); exit;
		//$this->log($_SESSION['pass']['user']->Rep_ID,$data->Company_Name,$data->Company_ID,$data,$db);
		return $data;
	}
	
	function edit_opp($data) {
		$starttime = microtime();
		$query 	= "UPDATE opportunities SET 
			Opp_Name='".$data->Opp_Name."'
			,Opp_StageID='".$data->Opp_StageID."'
			,Opp_Amount='".$data->Opp_Amount."'
			,Opp_StartDate='".$data->Opp_StartDate."'
			,Opp_CloseDate='".$data->Opp_CloseDate."'
			,Opp_Active='".$data->Opp_Active."'
			,Opp_CompanyID='".$data->Opp_CompanyID."'"; 
		$query .= "WHERE Opp_ID=$data->Opp_ID";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->updated = mysql_affected_rows();
		$db->timetaken = $endtime-$starttime;
		$data->db = $db;
		//$this->log($_SESSION['pass']['user']->Rep_ID,$data->Company_Name,$data->Company_ID,$data,$db);
		return $data;
	}

	function get_stage_list() {
		$starttime = microtime();
		$query 	= "SELECT Opp_StageID,Opp_StageName FROM opportunities_stages WHERE Opp_StageActive!=0 ";
		$query .= "ORDER BY Opp_StageName";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->numrows = mysql_num_rows($result);
		$db->timetaken = $endtime-$starttime;
		$db->updated = 0;
		$datalist = $db;
		return $datalist;
	}

}
?>