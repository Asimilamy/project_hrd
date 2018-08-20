<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class M_master_type extends CI_Model {
	public function get_opts($params = []) {
		$this->db->select('kd_master_type, nm_master_type')
			->from('tm_master_type');
		if (!empty($params)) :
			$this->db->where($params);
		endif;
		$query = $this->db->get();
		$return = $query->result();
		return $this->render_opts($return);
	}

	public function render_opts($opts) {
		$option[''] = '--Pilih Master Type--';
		foreach ($opts as $opt) :
			$option[$opt->kd_master_type] = $opt->nm_master_type;
		endforeach;
		return $option;
	}
}