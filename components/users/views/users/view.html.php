<?php

class UsersViewUsers {

	function display($data,$model) {
		switch($data->task) {
			case 'dologin':
				$html = $this->_dologin($data,$model,'default');
				break;
			case 'edit':
				$html = $this->edit($data,$model,'edit');
				break;
			case 'doedit':
				$html = $this->doedit($data,$model,'edit');
				break;
			case '_displayForm':
			default:
				if ($_SESSION['pass']['user']->Rep_ID>0) {
					$html = $this->dashboard($data,$model,'default');
				} else {
					$html = $this->_displayForm($data,$model,'form');
				}
				break;
		}
		return $html;
	}

	function dashboard($data,$model,$tpl) {
		//$row = $model->_loadData();
		include($data->path.'views/users/tmpl/'.$tpl.'.php');
		return $html;
	}

	function _displayForm($data,$model,$tpl) {
		//$row = $model->_loadData();
		include($data->path.'views/users/tmpl/'.$tpl.'.php');
		return $html;
	}
	
	function _dologin($data,$model,$tpl) {
		//$row = $model->_loadData();
		include($data->path.'views/users/tmpl/'.$tpl.'.php');
		return $html;
	}
	
	function edit($data,$model,$tpl) {
		$data = $model->_loadData($data,$_SESSION['pass']['user']->Rep_ID);
		include($data->path.'views/users/tmpl/'.$tpl.'.php');
		return $html;
	}
	
	function doedit($data,$model,$tpl) {
		$data = $model->_loadData($data,$_SESSION['pass']['user']->Rep_ID,$data->db->updated);
		include($data->path.'views/users/tmpl/'.$tpl.'.php');
		return $html;
	}
}

?>