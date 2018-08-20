<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Base_query extends CI_Model {
	public function get_row($tbl = '', $params = []) {
		$this->db->from($tbl)
			->where($params);
		$query = $this->db->get();
		$row = $query->row();
		return $row;
	}

	public function submit_data($tbl_name = '', $p_key = '', $title_name = '', $data = []) {
		if (!empty($data[$p_key])) :
			$label = 'Mengubah '.$title_name;
			$submit = array_merge($data, array('user_kd' => $_SESSION['user']['kd_user'], 'tgl_edit' => date('Y-m-d H:i:s')));
			$where = array($p_key => $data[$p_key]);
			$act = $this->db->update($tbl_name, $submit, $where);
		else :
			$label = 'Menambahkan '.$title_name;
			$data[$p_key] = create_pkey($tbl_name, $p_key);
			$submit = array_merge($data, array('user_kd' => $_SESSION['user']['kd_user'], 'tgl_input' => date('Y-m-d H:i:s')));
			$act = $this->db->insert($tbl_name, $submit);
		endif;
		$str = get_report($act, $label, $submit, $data[$p_key]);
		return $str;
	}

	public function delete_data($tbl_name = '', $data = [], $title_name = '') {
		$act = $this->db->delete($tbl_name, $data);
		$str = get_report($act, 'Menghapus '.$title_name, $data);
		return $str;
	}

	public function submit_batch() {
		
	}
}