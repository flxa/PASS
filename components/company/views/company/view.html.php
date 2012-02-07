<?php

class CompanyViewCompany {

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
			case 'addopp':
			case 'doaddopp':
				$html = $this->opp($data,$model,'opp');
				break;
			case 'editopp':
			case 'doeditopp':
				$html = $this->opp($data,$model,'opp');
				break;
		}
		return $html;
	}
	
	function _list($data,$model,$tpl) {
		$data = $model->_loadData($data,$pagination);
		include($data->path.'views/company/tmpl/toolbar.php');
		include($data->path.'views/company/tmpl/'.$tpl.'.php');
		return $html;
	}
	
	function edit($data,$model,$tpl) {
		//if ($data->task!='addopp' || ($data->task=='addopp' && $data->error)) { $data = $model->_loadData($data); }
		//include($data->path.'views/company/tmpl/toolbar.php');
		include($data->path.'views/company/tmpl/'.$tpl.'.php');
		return $html;
	}

	function view($data,$model,$tpl) {
		$data = $model->_loadData($data);
		include('components/client/models/client.php');
		$client = new ClientModelClient;
		include('components/address/models/address.php');
		$addr = new AddressModelAddress;
		include($data->path.'views/company/tmpl/toolbar.php');
		include($data->path.'views/company/tmpl/'.$tpl.'.php');
		return $html;
	}

	function opp($data,$model,$tpl) {
		//include($data->path.'views/company/tmpl/toolbar.php');
		include($data->path.'views/company/tmpl/'.$tpl.'.php');
		return $html;
	}

	function company_type_list($model,$id=NULL){
		$datalist = $model->get_company_types($id);
		$html = '<select name="Company_TypeID" id="CTL">';
		while($row = mysql_fetch_object($datalist->result)) {
			$html .= '<option value="'.$row->Company_TypeID.'"'; if ($row->Company_TypeID==$id) { $html .= ' selected'; } $html .= '>'.$row->Company_TypeName.'</option>';
		}
		$html .= '</select>';
		return $html;
	}

	function rep_list($model,$id=NULL){
		$datalist = $model->get_reps();
		$html = '<select name="Company_AssignedRep" id="CAR">';
		while($row = mysql_fetch_object($datalist->result)) {
			$html .= '<option value="'.$row->Rep_ID.'"'; if ($row->Rep_ID==$id) { $html .= ' selected'; } $html .= '>'.$row->Rep_FirstName.' '.$row->Rep_LastName.'</option>';
		}
		$html .= '</select>';
		return $html;
	}

	function parent_acc_list($model,$id=NULL){
		$datalist = $model->get_accounts();
		$html = '<select name="Company_ParentAccount" id="CPA">';
		$html .= '<option value="NULL"'; if (!isset($id) || $id==NULL) { $html .= ' selected'; } $html .= '>N/A or Select</option>';
		while($row = mysql_fetch_object($datalist->result)) {
			$html .= '<option value="'.$row->Company_ID.'"'; if ($row->Company_ID==$id) { $html .= ' selected'; } $html .= '>'.$row->Company_Name.'</option>';
		}
		$html .= '</select>';
		return $html;
	}

	function region_list($model,$id=NULL){
		$datalist = $model->get_regions();
		$html = '<select name="Company_SalesRegion" id="CSR">';
		$html .= '<option value="NULL"'; if (!isset($id) || $id==NULL) { $html .= ' selected'; } $html .= '>Select</option>';
		while($row = mysql_fetch_object($datalist->result)) {
			$html .= '<option value="'.$row->Company_RegionID.'"'; if ($row->Company_RegionID==$id) { $html .= ' selected'; } $html .= '>'.$row->Company_RegionName.'</option>';
		}
		$html .= '</select>';
		return $html;
	}

	function segment_list($model,$id=NULL){
		$datalist = $model->get_market_segments();
		$html = '<select name="Company_MarketSegment" id="CMS">';
		$html .= '<option value="NULL"'; if (!isset($id) || $id==NULL) { $html .= ' selected'; } $html .= '>Select</option>';
		while($row = mysql_fetch_object($datalist->result)) {
			$html .= '<option value="'.$row->Company_MarketSegmentID.'"'; if ($row->Company_MarketSegmentID==$id) { $html .= ' selected'; } $html .= '>'.$row->Company_MarketSegmentName.'</option>';
		}
		$html .= '</select>';
		return $html;
	}

	function status_list($model,$id=NULL){
		$datalist = $model->get_status_list();
		$html = '<select name="Company_StatusID" id="ST">';
		$html .= '<option value="NULL"'; if (!isset($id) || $id==NULL) { $html .= ' selected'; } $html .= '>Select</option>';
		while($row = mysql_fetch_object($datalist->result)) {
			$html .= '<option value="'.$row->Company_StatusID.'"'; if ($row->Company_StatusID==$id) { $html .= ' selected'; } $html .= '>'.$row->Company_StatusName.'</option>';
		}
		$html .= '</select>';
		return $html;
	}

	function opp_stage_list($model,$id){
		$datalist = $model->get_stage_list();
		$html = '<select name="Opp_StageID" id="OS">';
		$html .= '<option value="NULL"'; if (!isset($id) || $id==NULL) { $html .= ' selected'; } $html .= '>Select</option>';
		while($row = mysql_fetch_object($datalist->result)) {
			$html .= '<option value="'.$row->Opp_StageID.'"'; 
			if ($_REQUEST['task']=='addopp') {
				if ($row->Opp_StageID==1) { $html .= ' selected'; }
			} else {
				if ($row->Opp_StageID==$id) { $html .= ' selected'; }
			} 
			$html .= '>'.$row->Opp_StageName.'</option>';
		}
		$html .= '</select>';
		return $html;
	}
	
}

?>