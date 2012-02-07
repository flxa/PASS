<?php

class ContentModelContent {

	function _loadData() {
		$id = (int) mysql_escape_string($_REQUEST['id']);
		$ref = mysql_escape_string($_REQUEST['ref']);
		$query = "SELECT * FROM articles WHERE article_active=1";
		if ($id!='') { $query .= " AND article_id = $id"; }
		if ($ref!='') { $query .= " AND article_title = $ref"; }
		//$query 	= "SELECT * FROM articles WHERE article_active=1";
		$result = mysql_query($query);
		$row 	= mysql_fetch_object($result);
		return $row;
	}

}
?>