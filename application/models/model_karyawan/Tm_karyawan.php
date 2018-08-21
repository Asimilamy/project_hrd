<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Tm_karyawan extends CI_Model {
	private $tbl_name = 'tm_karyawan';
	private $p_key = 'kd_karyawan';
	private $title_name = 'Data Pegawai';

	public function ssp_table() {
		$data['table'] = $this->tbl_name;

		$data['primaryKey'] = 'a.'.$this->p_key;

		$data['columns'] = array(
			array( 'db' => $this->p_key,
				'dt' => 1, 'field' => $this->p_key,
				'formatter' => function($d, $row){

					return $this->tbl_btn($d, $row[2]);
				} ),
			array( 'db' => 'a.nik_karyawan', 'dt' => 2, 'field' => 'nik_karyawan' ),
			array( 'db' => 'a.nm_karyawan', 'dt' => 3, 'field' => 'nm_karyawan' ),
			array( 'db' => 'b.nm_unit', 'dt' => 4, 'field' => 'nm_unit' ),
			array( 'db' => 'c.nm_bagian', 'dt' => 5, 'field' => 'nm_bagian' ),
			array( 'db' => 'd.nm_jabatan', 'dt' => 6, 'field' => 'nm_jabatan' ),
			array( 'db' => 'e.nm_status_kerja', 'dt' => 7, 'field' => 'nm_status_kerja' ),
			array( 'db' => 'a.tgl_masuk', 'dt' => 8, 'field' => 'tgl_masuk',
				'formatter' => function($d) {
					return format_date($d, 'd-m-Y');
				} ),
		);

		$data['sql_details'] = sql_connect();

		$data['joinQuery'] = 'FROM '.$this->tbl_name.' a LEFT JOIN tm_unit b ON b.kd_unit = a.unit_kd LEFT JOIN tm_bagian c ON c.kd_bagian = a.bagian_kd LEFT JOIN tm_jabatan d ON d.kd_jabatan = a.jabatan_kd LEFT JOIN tm_status_kerja e ON e.kd_status_kerja = a.status_kerja_kd';

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
			$data = array('kd_karyawan' => $row->kd_karyawan, 'nik_karyawan' => $row->nik_karyawan, 'nm_karyawan' => $row->nm_karyawan, 'status_kerja_kd' => $row->status_kerja_kd, 'unit_kd' => $row->unit_kd, 'bagian_kd' => $row->bagian_kd, 'jabatan_kd' => $row->jabatan_kd, 'tgl_masuk' => $row->tgl_masuk);
		else :
			$data = array('kd_karyawan' => '', 'nik_karyawan' => '', 'nm_karyawan' => '', 'status_kerja_kd' => '', 'unit_kd' => '', 'bagian_kd' => '', 'jabatan_kd' => '', 'tgl_masuk' => '');
		endif;
		return $data;
	}

	public function form_rules() {
		$rules = array(
			array('field' => 'txtNik', 'label' => 'NIK Karyawan', 'rules' => 'required'),
			array('field' => 'txtNm', 'label' => 'Nama Karyawan', 'rules' => 'required'),
			array('field' => 'selStatusKerja', 'label' =>  'Status Kerja', 'rules' => 'required'),
			array('field' => 'selUnit', 'label' => 'Unit', 'rules' => 'required'),
			array('field' => 'selBagian', 'label' => 'Bagian', 'rules' => 'required'),
			array('field' => 'selJabatan', 'label' => 'Jabatan', 'rules' => 'required'),
			array('field' => 'txtTglMasuk', 'label' => 'Tanggal Masuk', 'rules' => 'required'),
		);
		return $rules;
	}

	public function form_warning($datas = '') {
		$forms = array('txtNik', 'txtNm', 'selStatusKerja', 'selUnit', 'selBagian', 'selJabatan', 'txtTglMasuk');
		foreach ($datas as $key => $data) :
			$str[$data] = (!empty(form_error($forms[$key])))?build_label('warning', form_error($forms[$key], '"', '"')):'';
		endforeach;
		return $str;
	}
}