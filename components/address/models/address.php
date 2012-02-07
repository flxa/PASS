<?php

class AddressModelAddress extends Component{

	function generate_query($data){
		//echo '<pre>'; echo print_r($data); exit;
		$query 	= "SELECT * FROM address WHERE Address_Active!=0";
		if ($data->Address_ID!='') {
			$query .= " AND Address_ID='".$data->Address_ID."'";
		}
		if ($data->Address_ID=='' && $_REQUEST['id']!='') {
			$id = mysql_real_escape_string($_REQUEST['id']);
			$query .= " AND Address_ID='".$id."'";
		}
		if ($id==NULL) {
			$query .= " AND Address_Type=1 ";
			$query .= " AND Address_RepID='".$_SESSION['pass']['user']->Rep_ID."' ";
		}
		$query .= " ORDER BY Address_DescriptionLabel ";
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
		$pagination->setLink("index.php?c=address&page=%s");
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
		$query 	= "INSERT INTO address (Address_ID,Address_RepID,Address_CompanyID,Address_Type,Address_DescriptionLabel,Address_Line1,Address_Line2,Address_Locality,Address_State,Address_Postcode
			,Address_IsPrimary,Address_IsPostal,Address_Active) VALUES 
			(NULL,'$data->Address_RepID','$data->Address_CompanyID','$data->Address_Type','$data->Address_DescriptionLabel','$data->Address_Line1','$data->Address_Line2','$data->Address_Locality','$data->Address_State','$data->Address_Postcode'
			,'$data->Address_IsPrimary','$data->Address_IsPostal',$data->Address_Active)";
		$result = mysql_query($query);
		//echo $query; exit;
		//if (mysql_error()) { echo mysql_error(); exit; }
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->updated = mysql_affected_rows();
		$db->timetaken = $endtime-$starttime;
		$data->Address_ID = mysql_insert_id();
		$db->result = $this->_loadData($data);
		$data->db = $db;
		$this->log($_SESSION['pass']['user']->Rep_ID,$data->Address_DescriptionLabel,$data->Address_ID,$data,$db);
		return $data;
	}
	
	function doedit($data) {
		$starttime = microtime();
		$query 	= "UPDATE address SET 
			Address_RepID='".$data->Address_RepID."'
			,Address_CompanyID='".$data->Address_CompanyID."'
			,Address_Type='".$data->Address_Type."' 
			,Address_DescriptionLabel='".$data->Address_DescriptionLabel."' 
			,Address_Line1='".$data->Address_Line1."' 
			,Address_Line2='".$data->Address_Line2."' 
			,Address_Locality='".$data->Address_Locality."' 
			,Address_State='".$data->Address_State."' 
			,Address_Postcode='".$data->Address_Postcode."' 
			,Address_IsPrimary='".$data->Address_IsPrimary."' 
			,Address_IsPostal='".$data->Address_IsPostal."' 
			,Address_Active='".$data->Address_Active."' ";
		$query .= "WHERE Address_ID=$data->Address_ID";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->updated = mysql_affected_rows();
		$db->timetaken = $endtime-$starttime;
		$data->db = $db;
		$this->log($_SESSION['pass']['user']->Rep_ID,$data->Address_DescriptionLabel,$data->Address_ID,$data,$db);
		return $data;
	}
	
	function delete($data,$aid) {
		$starttime = microtime();
		$query 	= "UPDATE address SET 
			Address_Active=0 ";
		$query .= "WHERE Address_ID IN ( ";
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

	function address_list($id,$type){
		$query = "SELECT * FROM address 
		LEFT JOIN address_types ON address_types.Address_Type_ID=address.Address_Type 
		WHERE Address_Active!=0 AND Address_Type='$type'";
		if ($id!='') {
			$query .= " AND Address_CompanyID=$id";
		}
		//echo $query; exit;
		$result = mysql_query($query);
		//$row = mysql_fetch_object($result);
		return $result;
	}

}
?>