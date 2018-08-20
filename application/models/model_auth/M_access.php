<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class M_access extends CI_Model {
	public function read_user_access($menu_link = '', $menu_parent = '') {
		$this->db->select('b.create_access AS create, b.read_access AS read, b.update_access AS update, b.delete_access AS delete')
			->from('tm_menu a')
			->join('td_user_access b', 'a.kd_menu = b.menu_kd', 'left')
			->join('tm_menu c', 'a.menu_parent = c.kd_menu', 'left')
			->where(array('a.menu_link' => $menu_link));
		if (!empty($menu_parent)) :
			$this->db->where(array('c.menu_nm' => $menu_parent));
		endif;
		$query = $this->db->get();
		$row = $query->row();
		return $row;
	}
}