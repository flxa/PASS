<?php

class ClientViewClient {

	function display($data,$model) {
		switch($data->task) {
			default:
				$html = $this->_list($data,$model,'default');
				break;
			case 'view':
				$html = $this->view($data,$model,'view');
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
		include($data->path.'views/client/tmpl/toolbar.php');
		include($data->path.'views/client/tmpl/'.$tpl.'.php');
		return $html;
	}

	function view($data,$model,$tpl) {
		$data = $model->_loadData($data);
		include('components/address/models/address.php');
		$addr = new AddressModelAddress;
		include($data->path.'views/client/tmpl/toolbar.php');
		include($data->path.'views/client/tmpl/'.$tpl.'.php');
		return $html;
	}
	
	function edit($data,$model,$tpl) {
		if ($data->task!='add' || ($data->task=='add' && $data->error)) {
			$data = $model->_loadData($data);
		}
		include($data->path.'views/client/tmpl/toolbar.php');
		include($data->path.'views/client/tmpl/'.$tpl.'.php');
		return $html;
	}

	function company_select_list($model,$id=NULL){
		$datalist = $model->get_companies($id);
		$html = '<select name="Client_Company_ID" id="CCI">';
		while($row = mysql_fetch_object($datalist->result)) {
			$html .= '<option value="'.$row->Company_ID.'"'; if ($row->Company_ID==$id) { $html .= ' selected'; } $html .= '>'.$row->Company_Name.'</option>';
		}
		$html .= '</select>';
		return $html;
	}

	function get_roles_list($model,$id=NULL){
		$result = $model->get_roles();
		$html = '<select name="Client_RoleID" id="CRI">';
		while($row = mysql_fetch_object($result)) {
			$html .= '<option value="'.$row->Client_RoleID.'"'; if ($row->Client_RoleID==$id) { $html .= ' selected'; } $html .= '>'.$row->Client_RoleName.'</option>';
		}
		$html .= '</select>';
		return $html;
	}
	
}

?>