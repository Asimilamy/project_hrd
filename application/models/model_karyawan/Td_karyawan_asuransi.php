<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Td_karyawan_asuransi extends CI_Model {
	private $tbl_name = 'td_karyawan_asuransi';
	private $p_key = 'kd_karyawan_asuransi';
	private $title_name = 'Data Asuransi Pegawai';

	public function ssp_table() {
		$data['table'] = $this->tbl_name;

		$data['primaryKey'] = 'a.'.$this->p_key;

		$data['columns'] = array(
			array( 'db' => 'a.'.$this->p_key,
				'dt' => 1, 'field' => $this->p_key,
				'formatter' => function($d, $row){

					return $this->tbl_btn($d, $row[2]);
				} ),
			array( 'db' => 'a.'.$this->p_key, 'dt' => 2, 'field' => $this->p_key ),
			array( 'db' => 'b.nm_asuransi', 'dt' => 3, 'field' => 'nm_asuransi' ),
			array( 'db' => 'a.no_asuransi', 'dt' => 4, 'field' => 'no_asuransi' ),
			array( 'db' => 'a.tgl_masuk', 'dt' => 5, 'field' => 'tgl_masuk',
			'formatter' => function($d) {
				return format_date($d, 'd-m-Y');
			} ),
			array( 'db' => 'c.nm_client', 'dt' => 6, 'field' => 'nm_client',
				'formatter' => function($d) {
					return empty_string($d, '-');
				} ),
			array( 'db' => 'a.status_asuransi', 'dt' => 7, 'field' => 'status_asuransi',
				'formatter' => function($d) {
					return ucwords($d);
				} ),
		);

		$data['sql_details'] = sql_connect();

		$data['joinQuery'] = '
			FROM '.$this->tbl_name.' a
			LEFT JOIN tm_asuransi b ON b.kd_asuransi = a.asuransi_kd
			LEFT JOIN tm_client c ON c.kd_client = a.client_kd
		';

		$data['where'] = 'a.karyawan_kd = \''.$_SESSION['user']['detail_karyawan']['kd_karyawan'].'\'';

		return $data;
	}

	private function tbl_btn($id = '', $var = '') {
		$this->load->helper(array('btn_access_helper'));

		$read_access = $_SESSION['user']['access']['read'];
		$update_access = $_SESSION['user']['access']['update'];
		$delete_access = $_SESSION['user']['access']['delete'];

		$btns = array();
		// $btns[] = get_btn(array('access' => $read_access, 'title' => 'Detail '.$this->title_name, 'icon' => 'search', 'onclick' => 'view_detail(\''.$id.'\')'));
		$btns[] = get_btn(array('access' => $update_access, 'title' => 'Ubah', 'icon' => 'pencil', 'onclick' => 'open_detail_page({\'file_type\' : \'form\', \'page_name\' : \'data_asuransi\', \'kd_karyawan_asuransi\' : \''.$id.'\'})'));
		$btns[] = get_btn_divider();
		$btns[] = get_btn(array('access' => $delete_access, 'title' => 'Hapus', 'icon' => 'trash',
			'onclick' => 'return confirm(\'Anda akan menghapus '.$this->title_name.' = '.$var.'?\')?hapus_data(\''.$id.'\', \'data_asuransi\'):false'));
		$btn_group = group_btns($btns);

		return $btn_group;
	}

	public function get_data($id = '') {
		$this->load->model(array('model_basic/base_query'));
		$row = $this->base_query->get_row($this->tbl_name, array($this->p_key => $id));
		if (!empty($row)) :
			$data = (object) array('kd_karyawan_asuransi' => $row->kd_karyawan_asuransi, 'asuransi_kd' => $row->asuransi_kd, 'karyawan_kd' => $row->karyawan_kd, 'client_kd' => $row->client_kd, 'no_asuransi' => $row->no_asuransi, 'tgl_masuk' => format_date($row->tgl_masuk, 'd-m-Y'), 'status_asuransi' => $row->status_asuransi);
		else :
			$data = (object) array('kd_karyawan_asuransi' => '', 'asuransi_kd' => '', 'karyawan_kd' => '', 'client_kd' => '', 'no_asuransi' => '', 'tgl_masuk' => '', 'status_asuransi' => '');
		endif;
		return $data;
	}
}
