<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class M_Menu extends CI_Model {
	public function get_user_menu($master_type_kd = '') {
		$this->db->select('a.kd_menu, a.menu_parent, a.menu_nm, a.menu_link,  a.menu_title, a.menu_icon, a.menu_order, a.menu_modul, a.menu_global')
			->from('tm_menu a')
			->join('td_user_access b', 'b.menu_kd = a.kd_menu', 'left')
			->where(array('b.master_type_kd' => $master_type_kd))
			->or_where(array('a.menu_global' => '1'))
			->order_by('a.menu_parent, a.kd_menu, a.menu_order');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
}