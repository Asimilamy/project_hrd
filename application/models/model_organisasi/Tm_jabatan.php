<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Tm_jabatan extends CI_Model {
	private $tbl_name = 'tm_jabatan';
	private $p_key = 'kd_jabatan';
	private $title_name = 'Data Jabatan';

	public function ssp_table() {
		$data['table'] = $this->tbl_name;

		$data['primaryKey'] = $this->p_key;

		$data['columns'] = array(
			array( 'db' => $this->p_key,
				'dt' => 1, 'field' => $this->p_key,
				'formatter' => function($d, $row){

					return $this->tbl_btn($d, $row[2]);
				} ),
			array( 'db' => 'kd_jabatan', 'dt' => 2, 'field' => 'kd_jabatan' ),
			array( 'db' => 'user_code', 'dt' => 3, 'field' => 'user_code' ),
			array( 'db' => 'nm_jabatan', 'dt' => 4, 'field' => 'nm_jabatan' ),
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
			$data = array('kd_jabatan' => $row->kd_jabatan, 'user_code' => $row->user_code, 'nm_jabatan' => $row->nm_jabatan);
		else :
			$data = array('kd_jabatan' => '', 'user_code' => '', 'nm_jabatan' => '');
		endif;
		return $data;
	}

	public function form_rules() {
		$rules = array(
			array('field' => 'txtCode', 'label' => 'User Code', 'rules' => 'required'),
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