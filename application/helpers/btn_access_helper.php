<?php
defined('BASEPATH') or exit('No direct script access allowed!');

function get_btn($btn_properties = array()) {
	$btn = '<li><a href=\'javascript:void(0);\'';
	foreach ($btn_properties as $var => $val) :
		if ($var == 'icon') :
			$icon = $val;
			$btn .= '';
		elseif ($var == 'title') :
			$title = $val;
			$btn .= ' '.$var.'="'.$val.'"';
		elseif ($var == 'access') :
			$access = $val;
		else :
			$btn .= ' '.$var.'="'.$val.'"';
		endif;
	endforeach;
	$btn .= '><i class=\'fa fa-'.$icon.'\'></i> '.$title.'</a></li>';

	return $access?$btn:'';
}

function get_btn_divider() {
	return '<li class=\'divider\'></li>';
}

function group_btns($btns) {
	if (!empty($btns)) :
		$btn_group = '<div align=\'center\'>';
		$btn_group .= '<div class=\'btn-group\'>';
		$btn_group .= '<button type=\'button\' class=\'btn btn-info btn-flat dropdown-toggle\' data-toggle=\'dropdown\'>';
		$btn_group .= 'Opsi <span class=\'caret\'></span>';
		$btn_group .= '</button><ul class=\'dropdown-menu\'>';
		foreach($btns as $btn) :
			$btn_group .= $btn;
		endforeach;
		$btn_group .= '</ul></div></div>';
	else :
		$btn_group = '<center>-</center>';
	endif;

	return $btn_group;
}