<?php

class Component {

	function log($uid,$name,$id,$data,$db) {
		if ($data->task=='delete') { $suffix = 'd'; } elseif ($data->task=='dologin' || $data->task=='logout') { $suffix = ''; } else { $suffix = 'ed'; }
		$logaction = str_replace('/','',(ucwords(str_replace('do', '', $data->task.$suffix).' '.str_replace('components/', '', $data->path))));
		$logdetail = $_SESSION['pass']['user']->Rep_FirstName.' '.$_SESSION['pass']['user']->Rep_LastName;
		$logdetail .= ' '.$logaction.' '.$name;
		
		//echo '<pre>'; echo print_r($data); echo '<hr />'; echo print_r($db); echo '</pre>';

		$transactioninfo = "DATA:\n";
		if ($data) {
			foreach($data as $key=>$val) {
				if (!is_object($val)) {
					$transactioninfo .= $key.' = '.$val."\n";
				}
			}
		}
		$transactioninfo .= "\n\nDB:\n";
		$transactioninfo .= "Query: ".$db->query."\n";
		$transactioninfo .= "Updated: ".$db->updated."\n";
		$transactioninfo .= "Timetaken: ".$db->timetaken." seconds";

		//echo nl2br($transactioninfo); exit;
		
		$query = "INSERT INTO log (Log_ID,Log_Date,Log_UserID,Log_Action,Log_TableID,Log_Detail,Log_TransactionInfo,Log_Active) 
			VALUES (NULL,now(),'$uid','$logaction','$id','".trim($logdetail)."','".mysql_real_escape_string($transactioninfo)."',1)";
		mysql_query($query);
		if (mysql_error()) { echo mysql_error(); exit; }
		return;
	}	

}

?>