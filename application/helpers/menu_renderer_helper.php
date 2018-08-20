<?php
defined('BASEPATH') or exit('No direct script access allowed!');

function render_individual_menu($menu_link = '', $menu_title = '', $menu_icon = '', $menu_nm = '') {
	$menu = '<li>';
		$menu .= '<a href="'.base_url($menu_link).'" title="'.$menu_title.'">';
			$menu .= '<i class="'.$menu_icon.'"></i> '.$menu_nm;
		$menu .= '</a>';
	$menu .= '</li>';
	return $menu;
}

function open_parent_menu($menu_title = '', $menu_icon = '', $menu_nm = '', $type = 'parent') {
	if ($type == 'parent') :
		$menu = '<li>';
			$menu .= '<a title="'.$menu_title.'"><i class="fa '.$menu_icon.'"></i> '.$menu_nm.' <span class="fa fa-chevron-down"></span></a>';
			$menu .= '<ul class="nav child_menu">';
	elseif ($type == 'child') :
		$menu = '<li>';
			$menu .= '<a title="'.$menu_title.'">'.$menu_nm.'<span class="fa fa-chevron-down"></span></a>';
			$menu .= '<ul class="nav child_menu">';
	endif;
	return $menu;
}

function close_parent_menu() {
	$menu = '</ul></li>';
	return $menu;
}

function render_child_menu($menu_link = '', $menu_title = '', $menu_nm = '') {
	$menu = '<li><a href="'.base_url($menu_link).'" title="'.$menu_title.'">'.$menu_nm.'</a></li>';
	return $menu;
}