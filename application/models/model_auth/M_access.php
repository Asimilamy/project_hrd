<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class M_access extends CI_Model {
	public function read_user_access($menu_link = '', $menu_parent = '') {
		$this->db->select('b.create_access AS create, b.read_access AS read, b.update_access AS update, b.delete_access AS delete')
			->from('tm_menu a')
			->join('td_user_access b', 'a.kd_menu = b.menu_kd', 'left')
			->join('tm_menu c', 'a.menu_parent = c.kd_menu', 'left')
			->like(array('a.menu_link' => $menu_link));
		if (!empty($menu_parent)) :
			$this->db->where(array('c.menu_nm' => $menu_parent));
		endif;
		$query = $this->db->get();
		$row = $query->row();
		if (!empty($row)) :
			$data = (object) ['create' => $row->create, 'read' => $row->read, 'update' => $row->update, 'delete' => $row->delete];
		else :
			$data = (object) ['create' => '0', 'read' => '0', 'update' => '0', 'delete' => '0'];
		endif;
		return $data;
	}
}