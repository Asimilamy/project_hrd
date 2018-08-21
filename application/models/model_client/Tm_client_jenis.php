<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Tm_client_jenis extends CI_Model {
	private $tbl_name = 'tm_client_jenis';
	private $p_key = 'kd_client_jenis';
	private $title_name = 'Data Type Client';

	public function ssp_table() {
		$this->load->helper('text');
		$data['table'] = $this->tbl_name;

		$data['primaryKey'] = $this->p_key;

		$data['columns'] = array(
			array( 'db' => $this->p_key,
				'dt' => 1, 'field' => $this->p_key,
				'formatter' => function($d, $row){

					return $this->tbl_btn($d, $row[2]);
				} ),
			array( 'db' => 'nm_client_jenis', 'dt' => 2, 'field' => 'nm_client_jenis' ),
			array( 'db' => 'keterangan', 'dt' => 3, 'field' => 'keterangan',
				'formatter' => function($d) {
					return word_limiter($d, '100', '...');
				} ),
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
			$data = array('kd_client_jenis' => $row->kd_client_jenis, 'nm_client_jenis' => $row->nm_client_jenis, 'keterangan' => $row->keterangan);
		else :
			$data = array('kd_client_jenis' => '', 'nm_client_jenis' => '', 'keterangan' => '');
		endif;
		return $data;
	}

	public function form_rules() {
		$rules = array(
			array('field' => 'txtNm', 'label' => 'Nama Type Client', 'rules' => 'required')
		);
		return $rules;
	}

	public function form_warning($datas = '') {
		$forms = array('txtNm');
		foreach ($datas as $key => $data) :
			$str[$data] = (!empty(form_error($forms[$key])))?build_label('warning', form_error($forms[$key], '"', '"')):'';
		endforeach;
		return $str;
	}
}