<?php

class UsersModelUsers extends Component {

	function _loadData($data,$id,$updated=0) {
		$starttime = microtime();
		$query 	= "SELECT * FROM users WHERE Rep_ID='".$id."'";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->numrows = mysql_num_rows($result);
		$db->timetaken = $endtime-$starttime;
		$db->updated = $updated;
		$data->db = $db;
		return $data;
	}
	
	function dologin($data) {
		$starttime = microtime();
		$query 	= "SELECT * FROM users WHERE Rep_Email='".$data->user."@printnational.com.au' AND Rep_Password='".$data->pass."'";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->numrows = mysql_num_rows($result);
		$db->timetaken = $endtime-$starttime;
		$data->db = $db;
		$this->log(NULL,$data->user,NULL,$data,$db);
		return $data;
	}
	
	function updatelastlogin($id) {
		$query = "UPDATE users SET Rep_LastLogin=now(),Rep_LoggedIn=1 WHERE Rep_ID=$id";
		mysql_query($query);
		return;
	}
	
	function doedit($data) {
		$starttime = microtime();
		$query 	= "UPDATE users SET 
			Rep_ContactPhone='".$data->Rep_ContactPhone."' 
			,Rep_ContactMobile='".$data->Rep_ContactMobile."' 
			,Rep_ContactFax='".$data->Rep_ContactFax."' 
			,Rep_CarRegistration='".$data->Rep_CarRegistration."' ";
		if ($data->Rep_Password!='') {
			$query .= ",Rep_Password='".$data->Rep_Password."' ";
		}
		$query .= "WHERE Rep_ID=$data->Rep_ID";
		$result = mysql_query($query);
		$endtime = microtime();
		$db = new stdClass;
		if (mysql_error()) { $db->sql_error = mysql_error(); }
		$db->query = $query;
		$db->result = $result;
		$db->updated = mysql_affected_rows();
		$db->timetaken = $endtime-$starttime;
		$data->db = $db;
		$this->log($_SESSION['pass']['user']->Rep_ID,$_SESSION['pass']['user']->Rep_FirstName.' '.$_SESSION['pass']['user']->Rep_LastName,$data->Rep_ID,$data,$db);
		return $data;
	}

	function gettime(){
		$query = "SELECT now()";
		$result = mysql_query($query);
		$now = mysql_result($result,0);
		return $now;
	}

	function logout($id,$data) {
		$query = "UPDATE users SET Rep_LoggedIn=0 WHERE Rep_ID=$id";
		mysql_query($query);
		$this->log($_SESSION['pass']['user']->Rep_ID,$_SESSION['pass']['user']->Rep_FirstName.' '.$_SESSION['pass']['user']->Rep_LastName,$id,$data,$db);
		return;
	}

}
?>