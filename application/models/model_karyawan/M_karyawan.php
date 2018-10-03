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
}