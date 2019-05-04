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

function render_menu_table($accesses = [], $menu = [], $attr = 'col-xs-12') {
	$CI =& get_instance();
	$CI->load->helper(['form']);
	$menu_table = '';
	$obj_accesses = is_array($accesses)?(object) $accesses:$accesses;
	$create_access = !empty($obj_accesses->create_access)?TRUE:FALSE;
	$read_access = !empty($obj_accesses->read_access)?TRUE:FALSE;
	$update_access = !empty($obj_accesses->update_access)?TRUE:FALSE;
	$delete_access = !empty($obj_accesses->delete_access)?TRUE:FALSE;
	$obj_menu = is_array($menu)?(object) $menu:$menu;
	$is_colspan = $obj_menu->menu_link == '#' || $obj_menu->menu_global?'colspan="4"':'';
	$menu_table .= '<tr>';
		$menu_table .= '<td><div class="'.$attr.'">';
			$menu_table .= '<label style="cursor: pointer;">'.$obj_menu->menu_nm.'</label>';
			$menu_table .= form_input(['type' => 'hidden', 'name' => 'txtKdMenu[]', 'value' => $obj_menu->kd_menu]);
		$menu_table .= '</div></td>';
		if (empty($is_colspan)) :
			$menu_table .= '<td class=\'access-attr\'>';
				$menu_table .= form_checkbox(['name' => 'chkCreate['.$obj_menu->kd_menu.']', 'class' => 'flat icheckbox_flat-blue', 'value' => '1', 'checked' => $create_access]);
			$menu_table .= '</td>';
			$menu_table .= '<td class=\'access-attr\'>';
				$menu_table .= form_checkbox(['name' => 'chkRead['.$obj_menu->kd_menu.']', 'class' => 'flat icheckbox_flat-blue', 'value' => '1', 'checked' => $read_access]);
			$menu_table .= '</td>';
			$menu_table .= '<td class=\'access-attr\'>';
				$menu_table .= form_checkbox(['name' => 'chkUpdate['.$obj_menu->kd_menu.']', 'class' => 'flat icheckbox_flat-blue', 'value' => '1', 'checked' => $update_access]);
			$menu_table .= '</td>';
			$menu_table .= '<td class=\'access-attr\'>';
				$menu_table .= form_checkbox(['name' => 'chkDelete['.$obj_menu->kd_menu.']', 'class' => 'flat icheckbox_flat-blue', 'value' => '1', 'checked' => $delete_access]);
			$menu_table .= '</td>';
		else :
			$menu_table .= '<td '.$is_colspan.'>';
				$menu_table .= form_input(['type' => 'hidden', 'name' => 'chkCreate['.$obj_menu->kd_menu.']', 'value' => '1']);
				$menu_table .= form_input(['type' => 'hidden', 'name' => 'chkRead['.$obj_menu->kd_menu.']', 'value' => '1']);
				$menu_table .= form_input(['type' => 'hidden', 'name' => 'chkUpdate['.$obj_menu->kd_menu.']', 'value' => '1']);
				$menu_table .= form_input(['type' => 'hidden', 'name' => 'chkDelete['.$obj_menu->kd_menu.']', 'value' => '1']);
			$menu_table .= '</td>';
		endif;
	$menu_table .= '</tr>';

	return $menu_table;
}