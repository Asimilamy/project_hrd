<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Model_organisasi extends CI_Model {
	public function get_organisasi($tbl_name = '', $tbl_joins = [], $where_params = []) {
		$this->db->from($tbl_name);
		foreach ($tbl_joins as $tbl => $params) :
			if (is_array($params)) :
				foreach ($params as $param => $join_type) :
					$this->db->join($tbl, $param, $join_type);
				endforeach;
			else :
				$this->db->join($tbl, $params);
			endif;
		endforeach;
		$this->db->where($where_params);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
}