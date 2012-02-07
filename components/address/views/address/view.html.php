<?php

class AddressViewAddress {

	function display($data,$model) {
		switch($data->task) {
			default:
				$html = $this->_list($data,$model,'default');
				break;
			case 'add':
			case 'doadd':
				$html = $this->edit($data,$model,'form');
				break;
			case 'edit':
			case 'doedit':
				$html = $this->edit($data,$model,'edit');
				break;
		}
		return $html;
	}
	
	function _list($data,$model,$tpl) {
		$data = $model->_loadData($data,$pagination);
		include($data->path.'views/address/tmpl/toolbar.php');
		include($data->path.'views/address/tmpl/'.$tpl.'.php');
		return $html;
	}
	
	function edit($data,$model,$tpl) {
		if ($data->task!='add' || ($data->task=='add' && $data->error)) {
			$data = $model->_loadData($data);
		}
		include($data->path.'views/address/tmpl/toolbar.php');
		include($data->path.'views/address/tmpl/'.$tpl.'.php');
		return $html;
	}
	
}

?>