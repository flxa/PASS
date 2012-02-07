<?php
	$component = 'company';
	$html .= '<div class="toolbar">';
	$html .= '<a href="index.php?c='.$component.'" class="btn primary icon"><img src="img/template/icons/small/list.png"> <span>List</span></a>';
	$html .= '<a href="index.php?c='.$component.'&task=add" class="btn success icon"><img src="img/template/icons/small/add.png"> <span>New</span></a>';
	if ($data->task!='view' && $data->task!='edit' && $data->task!='add') {
		$html .= '<a href="#" id="delete-item" class="btn danger icon"><img src="img/template/icons/small/del.png"> <span>Delete</span></a>';
	}	
	$html .= '<br><br>';
	$html .= '</div>';
?>