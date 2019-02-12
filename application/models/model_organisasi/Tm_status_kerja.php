<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Tm_status_kerja extends CI_Model {
	private $tbl_name = 'tm_status_kerja';
	private $p_key = 'kd_status_kerja';
	private $title_name = 'Data Status Kerja';

	public function ssp_table() {
		$data['table'] = $this->tbl_name;

		$data['primaryKey'] = $this->p_key;

		$data['columns'] = array(
			array( 'db' => $this->p_key,
				'dt' => 1, 'field' => $this->p_key,
				'formatter' => function($d, $row){

					return $this->tbl_btn($d, $row[2]);
				} ),
			array( 'db' => 'kd_status_kerja', 'dt' => 2, 'field' => 'kd_status_kerja' ),
			array( 'db' => 'user_code', 'dt' => 3, 'field' => 'user_code' ),
			array( 'db' => 'nm_status_kerja', 'dt' => 4, 'field' => 'nm_status_kerja' ),
		);

		$data['sql_details'] = sql_connect();

		$data['joinQuery'] = '';

		$data['where'] = '';

		return $data;
	}

	private function tbl_btn($id = '', $var = '') {
		$this->load->helper(array('btn_access_helper'));

		$read_access = $_SESSION['user']['access']['read'];
		$update_access = $_SESSION['user']['access']['update'];
		$delete_access = $_SESSION['user']['access']['delete'];

		$btns = array();
		$btns[] = get_btn(array('access' => $read_access, 'title' => 'Detail '.$this->title_name, 'icon' => 'search', 'onclick' => 'view_detail(\''.$id.'\')'));
		$btns[] = get_btn(array('access' => $update_access, 'title' => 'Ubah', 'icon' => 'pencil', 'onclick' => 'get_form(\''.$id.'\')'));
		$btns[] = get_btn_divider();
		$btns[] = get_btn(array('access' => $delete_access, 'title' => 'Hapus', 'icon' => 'trash',
			'onclick' => 'return confirm(\'Anda akan menghapus '.$this->title_name.' = '.$var.'?\')?hapus_data(\''.$id.'\'):false'));
		$btn_group = group_btns($btns);

		return $btn_group;
	}

	public function get_data($id = '') {
		$this->load->model(array('model_basic/base_query'));
		$row = $this->base_query->get_row($this->tbl_name, array($this->p_key => $id));
		if (!empty($row)) :
			$data = array('kd_status_kerja' => $row->kd_status_kerja, 'user_code' => $row->user_code, 'nm_status_kerja' => $row->nm_status_kerja);
		else :
			$data = array('kd_status_kerja' => '', 'user_code' => '', 'nm_status_kerja' => '');
		endif;
		return $data;
	}

	public function form_rules() {
		$rules = array(
			array('field' => 'txtCode', 'label' => 'User Code', 'rules' => 'required|callback_code_check'),
			array('field' => 'txtNm', 'label' => 'Nama Unit', 'rules' => 'required')
		);
		return $rules;
	}

	public function form_warning($datas = '') {
		$forms = array('txtCode', 'txtNm');
		foreach ($datas as $key => $data) :
			$str[$data] = (!empty(form_error($forms[$key])))?build_label('warning', form_error($forms[$key], '"', '"')):'';
		endforeach;
		return $str;
	}
}