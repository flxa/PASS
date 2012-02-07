<?php

class ClientModelClient extends Component{

	function generate_query($data){
		$query 	= "SELECT clients.*, company.Company_Name,client_roles.Client_RoleName FROM clients ";
		$query .= "LEFT JOIN company ON Company_ID=Client_Company_ID ";
		$query .= "LEFT JOIN client_roles ON client_roles.Client_RoleID=clients.Client_RoleID ";
		if ($_SESSION['pass']['user']->Rep_GroupID!=2) {
			$query .= "LEFT JOIN client_XREF ON client_XREF.Client_XREF_ClientID=clients.Client_ID ";
		}
		$query .= "WHERE Client_Active!=0";
		if ($_SESSION['pass']['user']->Rep_GroupID!=2) {
			$query .= " AND client_XREF.Client_XREF_Active!=0";
			$query .= " AND client_XREF_UserID='".$_SESSION['pass']['user']->Rep_ID."'";
		}
		if ($data->Client_ID!='') {
			$query .= " AND Client_ID='".$data->Client_ID."'";
		}
		if ($data->Client_ID=='' && $_REQUEST['id']!='') {
			$id = mysql_real_escape_string($_REQUEST['id']);
			$query .= " AND Client_ID='".$id."'";
		}
		$query .= " ORDER BY Client_Surname ";
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
		$pagination->setLink("index.php?c=client&page=%s");
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
		$query 	= "INSERT INTO clients (Client_ID,Client_Company_ID,Client_FirstName,Client_Surname,Client_ContactPhone,Client_ContactFax,Client_ContactMobile,Client_Email
		,Client_RoleID,Client_Extra1,Client_Extra2,Client_Extra3,Client_Extra4,Client_Extra5,Client_Extra6,Client_Extra7,Client_Extra8
		,Client_Extra9,Client_Extra10,Client_Active) 
		VALUES 
		(NULL,'$data->Client_Company_ID','$data->Client_FirstName','$data->Client_Surname','$data->Client_ContactPhone','$data->Client_ContactFax','$data->Client_ContactMobile','$data->Client_Email','$Client_RoleID'
		,'$data->Client_Extra1','$data->Client_Extra2','$data->Client_Extra3','$data->Client_Extra4','$data->Client_Extra5','$data->Client_Extra6','$data->Client_Extra7'
		,'$data->Client_Extra8','$data->Client_Extra9','$data->Client_Extra10',$data->Client_Active)";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->updated = mysql_affected_rows();
		$db->timetaken = $endtime-$starttime;
		$data->Client_ID = mysql_insert_id();
		$db->result = $this->_loadData($data);
		$data->db = $db;
		$this->log($_SESSION['pass']['user']->Rep_ID,$data->Client_FirstName.' '.$data->Client_Surname,$data->Client_ID,$data,$db);
		return $data;
	}
	
	function doedit($data) {
		$starttime = microtime();
		$query 	= "UPDATE clients SET 
			Client_Company_ID='".$data->Client_Company_ID."'
			,Client_FirstName='".$data->Client_FirstName."'
			,Client_Surname='".$data->Client_Surname."'
			,Client_ContactPhone='".$data->Client_ContactPhone."'
			,Client_ContactFax='".$data->Client_ContactFax."'
			,Client_ContactMobile='".$data->Client_ContactMobile."'
			,Client_Email='".$data->Client_Email."'
			,Client_RoleID='".$data->Client_RoleID."'
			,Client_Extra1='".$data->Client_Extra1."'
			,Client_Extra2='".$data->Client_Extra2."'
			,Client_Extra3='".$data->Client_Extra3."'
			,Client_Extra4='".$data->Client_Extra4."'
			,Client_Extra5='".$data->Client_Extra5."'
			,Client_Extra6='".$data->Client_Extra6."'
			,Client_Extra7='".$data->Client_Extra7."'
			,Client_Extra8='".$data->Client_Extra8."'
			,Client_Extra9='".$data->Client_Extra9."'
			,Client_Extra10='".$data->Client_Extra10."'
			,Client_Active='".$data->Client_Active."' ";
		$query .= "WHERE Client_ID=$data->Client_ID";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->updated = mysql_affected_rows();
		$db->timetaken = $endtime-$starttime;
		$data->db = $db;
		$this->log($_SESSION['pass']['user']->Rep_ID,$data->Client_FirstName.' '.$data->Client_Surname,$data->Client_ID,$data,$db);
		return $data;
	}
	
	function delete($data,$aid) {
		$starttime = microtime();
		$query 	= "UPDATE clients SET 
			Client_Active=0 ";
		$query .= "WHERE Client_ID IN ( ";
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

	function get_companies() {
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

	function client_list($Company_ID) {
		$starttime = microtime();
		$query 	= "SELECT * FROM clients WHERE Client_Active!=0 AND Client_Company_ID='$Company_ID'";
		$query .= " ORDER BY Client_Surname";
		$result = mysql_query($query);
		$endtime = microtime();
		return $result;
	}

	function get_roles() {
		$starttime = microtime();
		$query 	= "SELECT * FROM client_roles WHERE Client_RoleActive!=0 ";
		$query .= " ORDER BY Client_RoleName";
		$result = mysql_query($query);
		$endtime = microtime();
		return $result;
	}

}
?>