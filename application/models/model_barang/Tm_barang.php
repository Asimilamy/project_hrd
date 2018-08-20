<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Tm_barang extends CI_Model {
	private $tbl_name = 'tm_barang';
	private $p_key = 'kd_mbarang';
	private $title_name = 'Data Master Barang';

	public function ssp_table() {
		$data['table'] = $this->tbl_name;

		$data['primaryKey'] = $this->p_key;

		$data['columns'] = array(
			array( 'db' => $this->p_key,
				'dt' => 1, 'field' => $this->p_key,
				'formatter' => function($d, $row){

					return $this->tbl_btn($d, $row[2]);
				} ),
			array( 'db' => 'barcode', 'dt' => 2, 'field' => 'barcode' ),
			array( 'db' => 'nm_barang', 'dt' => 3, 'field' => 'nm_barang' ),
			array( 'db' => 'deskripsi', 'dt' => 4, 'field' => 'deskripsi' ),
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
			$data = array('kd_mbarang' => $row->kd_mbarang, 'master_type_kd' => $row->master_type_kd, 'barcode' => $row->barcode, 'nm_barang' => $row->nm_barang, 'deskripsi' => $row->deskripsi);
		else :
			$data = array('kd_mbarang' => '', 'master_type_kd' => '', 'barcode' => '', 'nm_barang' => '', 'deskripsi' => '');
		endif;
		return $data;
	}

	public function form_rules() {
		$rules = array(
			// array('field' => 'selType', 'label' => 'Master Type', 'rules' => 'required'),
			array('field' => 'txtBarcode', 'label' => 'Barcode', 'rules' => 'required'),
			array('field' => 'txtNmBarang', 'label' => 'Nama Barang', 'rules' => 'required'),
			array('field' => 'txtDeskripsi', 'label' => 'Deskripsi', 'rules' => 'required'),
		);
		return $rules;
	}

	public function form_warning($datas = '') {
		$forms = array('selType', 'txtBarcode', 'txtNmBarang', 'txtDeskripsi');
		foreach ($datas as $key => $data) :
			$str[$data] = (!empty(form_error($forms[$key])))?build_label('warning', form_error($forms[$key], '"', '"')):'';
		endforeach;
		return $str;
	}
}