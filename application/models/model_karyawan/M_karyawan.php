<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class M_karyawan extends CI_Model {
	public function get_data_pribadi($kd_karyawan = '') {
		$this->db->select('a.kd_karyawan, a.nik_karyawan, a.nm_karyawan, a.tgl_aktif, a.flag_status, b.nm_status_kerja, c.nm_unit, d.nm_bagian, e.nm_jabatan, f.no_telp_utama, f.no_telp_lain, f.email_utama, f.email_lain, f.tmp_lahir, f.tgl_lahir, f.alamat, f.foto_karyawan')
			->from('tm_karyawan a')
			->join('tm_status_kerja b', 'b.kd_status_kerja = a.status_kerja_kd', 'left')
			->join('tm_unit c', 'c.kd_unit = a.unit_kd', 'left')
			->join('tm_bagian d', 'd.kd_bagian = a.bagian_kd', 'left')
			->join('tm_jabatan e', 'e.kd_jabatan = a.jabatan_kd', 'left')
			->join('td_karyawan_info f', 'f.karyawan_kd = a.kd_karyawan', 'left')
			->where(array('a.kd_karyawan' => $kd_karyawan));
		$query = $this->db->get();
		$row = $query->row();
		return $row;
	}

	public function define_detail_table($kd_karyawan = '', $page_name = '') {
		$query = [];
		if ($page_name == 'data_pribadi') :
			$query['select'] = 'a.nm_karyawan, b.no_telp_utama, b.no_telp_lain, b.email_utama, b.email_lain, b.alamat, b.tmp_lahir, b.tgl_lahir, b.foto_karyawan';
			$query['table_a'] = 'tm_karyawan a';
			$query['join'] = ['table_b' => 'td_karyawan_info b', 'cond' => 'b.karyawan_kd = a.kd_karyawan'];
			$query['where'] = ['a.kd_karyawan' => $kd_karyawan];
		endif;
		return $query;
	}

	public function fetch_detail($kd_karyawan = '', $page_name = '') {
		$conds = $this->define_detail_table($kd_karyawan, $page_name);
		if (!empty($conds)) :
			$this->db->select($conds['select'])
				->from($conds['table_a'])
				->join($conds['join']['table_b'], $conds['join']['cond'], 'left')
				->where($conds['where']);
			$query = $this->db->get();
			$row = $query->row();
			return $row;
		endif;
	}

	public function form_detail_errs($form_name = '') {
		$form_errs = [];
		if ($form_name == 'data_pribadi') :
			$form_errs = ['idErrNm', 'idErrFoto', 'idErrTmpLahir', 'idErrTglLahir', 'idErrAlamat', 'idErrTelpUtama', 'idErrTelpLain', 'idErrEmailUtama', 'idErrEmailLain'];
		endif;
		return $form_errs;
	}

	public function form_detail_rules($form_name = '') {
		if ($form_name == 'data_pribadi') :
			$rules = array(
				array('field' => 'txtNm', 'label' => 'Nama Karyawan', 'rules' => 'required'),
				array('field' => 'fileFoto', 'label' => 'Foto Karyawan', 'rules' => 'required'),
				array('field' => 'txtTmpLahir', 'label' =>  'Tempat Lahir', 'rules' => 'required'),
				array('field' => 'txtTglLahir', 'label' => 'Tanggal Lahir', 'rules' => 'required'),
				array('field' => 'txtAlamat', 'label' => 'Alamat Karyawan', 'rules' => 'required'),
				array('field' => 'txtTelpUtama', 'label' => 'Telp Utama', 'rules' => 'required'),
				array('field' => 'txtTelpLain', 'label' => 'Telp Lain', 'rules' => 'required'),
				array('field' => 'txtEmailUtama', 'label' => 'Email Utama', 'rules' => 'required'),
				array('field' => 'txtEmailLain', 'label' => 'Email Lain', 'rules' => 'required'),
			);
		endif;
		return $rules;
	}

	public function form_detail_warning($form_name = '', $datas = '') {
		if ($form_name == 'data_pribadi') :
			$forms = array('txtNm', 'fileFoto', 'txtTmpLahir', 'txtTglLahir', 'txtAlamat', 'txtTelpUtama', 'txtTelpLain', 'txtEmailUtama', 'txtEmailLain');
			foreach ($datas as $key => $data) :
				$str[$data] = (!empty(form_error($forms[$key])))?build_label('warning', form_error($forms[$key], '"', '"')):'';
			endforeach;
			return $str;
		endif;
	}
}