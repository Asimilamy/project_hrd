<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class M_setting extends CI_Model {
	public function get_setting($nm_setting = '') {
		$this->load->model(array('model_basic/base_query'));
		$query = $this->base_query->get_row('tm_sys_appareance', ['nm_sys_appareance' => $nm_setting]);
		$row = $query->val_sys_appareance;
		return $row;
	}
}