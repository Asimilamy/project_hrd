<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Tm_client extends CI_Model {
	private $tbl_name = 'tm_client';
	private $p_key = 'kd_client';
	private $title_name = 'Data Client';

	public function ssp_table() {
		$this->load->helper('text');
		$data['table'] = $this->tbl_name;

		$data['primaryKey'] = $this->p_key;

		$data['columns'] = array(
			array( 'db' => 'a.'.$this->p_key,
				'dt' => 1, 'field' => $this->p_key,
				'formatter' => function($d, $row){

					return $this->tbl_btn($d, $row[2]);
				} ),
			array( 'db' => 'a.nm_client', 'dt' => 2, 'field' => 'nm_client' ),
			array( 'db' => 'b.nm_client_jenis', 'dt' => 3, 'field' => 'nm_client_jenis' ),
			array( 'db' => 'a.keterangan', 'dt' => 4, 'field' => 'keterangan',
				'formatter' => function($d) {
					return word_limiter($d, '100', '...');
				} ),
		);

		$data['sql_details'] = sql_connect();

		$data['joinQuery'] = 'FROM '.$this->tbl_name.' a LEFT JOIN tm_client_jenis b ON b.kd_client_jenis = a.client_jenis_kd';

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
			$data = array('kd_client' => $row->kd_client, 'client_jenis_kd' => $row->client_jenis_kd, 'nm_client' => $row->nm_client, 'keterangan' => $row->keterangan);
		else :
			$data = array('kd_client' => '', 'client_jenis_kd' => '', 'nm_client' => '', 'keterangan' => '');
		endif;
		return $data;
	}

	public function form_rules() {
		$rules = array(
			array('field' => 'selClientJenis', 'label' => 'Type Client', 'rules' => 'required'),
			array('field' => 'txtNm', 'label' => 'Nama Client', 'rules' => 'required'),
		);
		return $rules;
	}

	public function form_warning($datas = '') {
		$forms = array('selClientJenis', 'txtNm');
		foreach ($datas as $key => $data) :
			$str[$data] = (!empty(form_error($forms[$key])))?build_label('warning', form_error($forms[$key], '"', '"')):'';
		endforeach;
		return $str;
	}
}