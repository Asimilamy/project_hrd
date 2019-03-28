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
			array( 'db' => 'a.'.$this->p_key, 'dt' => 1, 'field' => $this->p_key,
				'formatter' => function($d, $row) {
					return $this->tbl_btn($d, $row[3]);
				} ),
			array( 'db' => 'a.'.$this->p_key, 'dt' => 2, 'field' => $this->p_key ),
			array( 'db' => 'a.nik_karyawan', 'dt' => 3, 'field' => 'nik_karyawan' ),
			array( 'db' => 'a.nm_karyawan', 'dt' => 4, 'field' => 'nm_karyawan' ),
			array( 'db' => 'a.alamat', 'dt' => 5, 'field' => 'alamat' ),
			array( 'db' => 'a.tmp_lahir', 'dt' => 6, 'field' => 'tmp_lahir',
				'formatter' => function($d, $row) {
					if (!empty($d)) {
						return $d.', '.format_date($row[6], 'd-m-Y');
					} else {
						return '-';
					}
				} ),
			array( 'db' => 'a.tgl_lahir', 'dt' => 7, 'field' => 'tgl_lahir' ),
			array( 'db' => 'a.tgl_aktif', 'dt' => 8, 'field' => 'tgl_aktif',
				'formatter' => function($d) {
					return format_date($d, 'd-m-Y');
				} ),
		);

		$data['sql_details'] = sql_connect();

		$data['joinQuery'] = 'FROM '.$this->tbl_name.' a LEFT JOIN td_karyawan_kontrak b ON b.karyawan_kd = a.kd_karyawan';

		$filter['status_kerja_kd'] = $this->input->get('selStatusKerja');
		$filter['client_kd'] = $this->input->get('selPerusahaan');
		$filter['unit_kd'] = $this->input->get('selUnit');
		$filter['bagian_kd'] = $this->input->get('selBagian');
		$filter['jabatan_kd'] = $this->input->get('selJabatan');
		foreach ($filter as $key => $value) :
			if (!empty($value)) :
				$param[] = 'b.'.$key.' = \''.$value.'\'';
			endif;
		endforeach;
		if (isset($param)) :
			$param = array_merge($param, ['is_active' => 'b.is_active = \'1\'']);
			$data['where'] = implode(' AND ', $param);
		else :
			$data['where'] = '';
		endif;

		$data['group_by'] = 'a.kd_karyawan';

		return $data;
	}

	private function tbl_btn($id = '', $var = '') {
		$this->load->helper(array('btn_access_helper'));

		$read_access = $_SESSION['user']['access']['read'];
		$update_access = $_SESSION['user']['access']['update'];
		$delete_access = $_SESSION['user']['access']['delete'];

		$btns = array();
		$btns[] = get_btn(array('access' => $read_access, 'title' => 'Detail '.$this->title_name, 'icon' => 'search', 'onclick' => 'view_detail(\''.$id.'\')'));
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
			$data = array('kd_karyawan' => $row->kd_karyawan, 'nik_karyawan' => $row->nik_karyawan, 'nm_karyawan' => $row->nm_karyawan, 'status_kerja_kd' => $row->status_kerja_kd, 'unit_kd' => $row->unit_kd, 'bagian_kd' => $row->bagian_kd, 'jabatan_kd' => $row->jabatan_kd, 'tgl_masuk' => format_date($row->tgl_aktif, 'd-m-Y'));
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