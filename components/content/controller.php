<?php

class ContentController {
		
	function display() {
		require_once('components/content/models/content.php');
		$model = new ContentModelContent;
		$row = $model->_loadData();
		$html .= $row->article_content;
		return $html;
	}
}
?>