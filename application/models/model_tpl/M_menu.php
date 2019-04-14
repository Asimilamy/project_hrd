<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class M_menu extends CI_Model {
	public function register_session($user_type_kd = '') {
		$_SESSION['user']['menus']['one'] = $this->m_menu->get_menu_level($user_type_kd, 'one');
		$_SESSION['user']['menus']['two'] = $this->m_menu->get_menu_level($user_type_kd, 'two');
		$_SESSION['user']['menus']['three'] = $this->m_menu->get_menu_level($user_type_kd, 'three');
	}

	public function get_menu_level($user_type_kd = '', $level = 'one') {
		if ($level != 'one') :
			if ($level == 'two') :
				$menus = $this->get_menu_level($user_type_kd, 'one');
			elseif ($level == 'three') :
				$menus = $this->get_menu_level($user_type_kd, 'two');
			endif;
			foreach ($menus as $menu) :
				$kd_menus[] = $menu->kd_menu;
			endforeach;
			$this->db->where_in('a.menu_parent', $kd_menus);
		endif;
		$this->db->select('a.kd_menu, a.menu_parent, a.menu_nm, a.menu_link,  a.menu_title, a.menu_icon, a.menu_order, a.menu_modul, a.menu_global')
			->from('tm_menu a')
			->join('td_user_access b', 'b.menu_kd = a.kd_menu', 'left')
			->where(array('b.user_type_kd' => $user_type_kd));
		if ($level == 'one') :
			$this->db->where('a.menu_parent IS NULL', NULL, FALSE)
				->or_where(array('a.menu_global' => '1'));
		endif;
		$this->db->order_by('a.menu_parent, a.menu_order, a.kd_menu');

		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	public function menu_parent_opts($params = []) {
		$this->db->select('kd_menu, menu_nm')
			->from('tm_menu');
		if (!empty($params)) :
			$this->db->where($params);
		endif;
		$query = $this->db->get();
		$return = $query->result();
		return $this->render_opts($return);
	}

	public function render_opts($opts) {
		$option[''] = '--Pilih Parent Menu--';
		foreach ($opts as $opt) :
			$option[$opt->kd_menu] = $opt->menu_nm;
		endforeach;
		return $option;
	}

	public function modul_menu_opts() {
		$option[''] = '--Pilih Modul Menu--';
		$option['administrator'] = 'Modul Administrator';
		return $option;
	}
}