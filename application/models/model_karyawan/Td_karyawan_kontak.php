<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Td_karyawan_kontak extends CI_Model {
	private $tbl_name = 'td_karyawan_kontak';
	private $p_key = 'kd_karyawan_kontak';
	private $title_name = 'Data Kontak Lain Pegawai';

	public function ssp_table() {
		$data['table'] = $this->tbl_name;

		$data['primaryKey'] = $this->p_key;

		$data['columns'] = array(
			array( 'db' => $this->p_key,
				'dt' => 1, 'field' => $this->p_key,
				'formatter' => function($d, $row){

					return $this->tbl_btn($d, $row[2]);
				} ),
			array( 'db' => $this->p_key, 'dt' => 2, 'field' => $this->p_key ),
			array( 'db' => 'nm_kontak', 'dt' => 3, 'field' => 'nm_kontak' ),
			array( 'db' => 'alamat', 'dt' => 4, 'field' => 'alamat' ),
			array( 'db' => 'hubungan', 'dt' => 5, 'field' => 'hubungan' ),
			array( 'db' => 'telp_utama', 'dt' => 6, 'field' => 'telp_utama' ),
			array( 'db' => 'email_utama', 'dt' => 7, 'field' => 'email_utama' ),
		);

		$data['sql_details'] = sql_connect();

		$data['joinQuery'] = '';

		$data['where'] = 'karyawan_kd = \''.$_SESSION['user']['detail_karyawan']['kd_karyawan'].'\'';

		return $data;
	}

	private function tbl_btn($id = '', $var = '') {
		$this->load->helper(array('btn_access_helper'));

		$read_access = $_SESSION['user']['access']['read'];
		$update_access = $_SESSION['user']['access']['update'];
		$delete_access = $_SESSION['user']['access']['delete'];

		$btns = array();
		// $btns[] = get_btn(array('access' => $read_access, 'title' => 'Detail '.$this->title_name, 'icon' => 'search', 'onclick' => 'view_detail(\''.$id.'\')'));
		$btns[] = get_btn(array('access' => $update_access, 'title' => 'Ubah', 'icon' => 'pencil', 'onclick' => 'open_detail_page({\'file_type\' : \'form\', \'page_name\' : \'data_kontak\', \''.$this->p_key.'\' : \''.$id.'\'})'));
		$btns[] = get_btn_divider();
		$btns[] = get_btn(array('access' => $delete_access, 'title' => 'Hapus', 'icon' => 'trash',
			'onclick' => 'return confirm(\'Anda akan menghapus '.$this->title_name.' = '.$var.'?\')?hapus_data(\''.$id.'\', \'data_kontak\'):false'));
		$btn_group = group_btns($btns);

		return $btn_group;
	}

	public function get_data($id = '') {
		$this->load->model(array('model_basic/base_query'));
		$row = $this->base_query->get_row($this->tbl_name, array($this->p_key => $id));
		if (!empty($row)) :
			$data = (object) array('kd_karyawan_kontak' => $row->kd_karyawan_kontak, 'karyawan_kd' => $row->karyawan_kd, 'nm_kontak' => $row->nm_kontak, 'alamat' => $row->alamat, 'hubungan' => $row->hubungan, 'telp_utama' => $row->telp_utama, 'email_utama' => $row->email_utama);
		else :
			$data = (object) array('kd_karyawan_kontak' => '', 'karyawan_kd' => '', 'nm_kontak' => '', 'alamat' => '', 'hubungan' => '', 'telp_utama' => '', 'email_utama' => '');
		endif;
		return $data;
	}
}
