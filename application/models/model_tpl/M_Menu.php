<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class M_Menu extends CI_Model {
	public function get_menu_level($master_type_kd = '', $level = 'one') {
		if ($level == 'one') :
			$this->db->where('a.menu_parent IS NULL', NULL, FALSE)
				->or_where(array('a.menu_global' => '1'));
		else :
			if ($level == 'two') :
				$menus = $this->get_menu_level($master_type_kd, 'one');
			elseif ($level == 'three') :
				$menus = $this->get_menu_level($master_type_kd, 'two');
			endif;
			foreach ($menus as $menu) :
				$kd_menus[] = $menu->kd_menu;
			endforeach;
			$this->db->where_in('a.menu_parent', $kd_menus);
		endif;
		$this->db->select('a.kd_menu, a.menu_parent, a.menu_nm, a.menu_link,  a.menu_title, a.menu_icon, a.menu_order, a.menu_modul, a.menu_global')
			->from('tm_menu a')
			->join('td_user_access b', 'b.menu_kd = a.kd_menu', 'left')
			->where(array('b.master_type_kd' => $master_type_kd))
			->order_by('a.menu_parent, a.kd_menu, a.menu_order');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
}