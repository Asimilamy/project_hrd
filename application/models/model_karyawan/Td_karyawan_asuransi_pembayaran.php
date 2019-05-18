<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Td_karyawan_asuransi_pembayaran extends CI_Model {
	private $tbl_name = 'td_karyawan_asuransi_pembayaran';
	private $p_key = 'kd_karyawan_asuransi_pembayaran';
	private $title_name = 'Data Pembayaran Asuransi Pegawai';

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
			array( 'db' => 'c.nm_client', 'dt' => 4, 'field' => 'nm_client' ),
			array( 'db' => 'd.no_asuransi', 'dt' => 5, 'field' => 'no_asuransi' ),
			array( 'db' => 'a.tgl_bayar', 'dt' => 6, 'field' => 'tgl_bayar',
			'formatter' => function($d) {
				return format_date($d, 'd-m-Y');
			} ),
			array( 'db' => 'a.jml_bayar', 'dt' => 7, 'field' => 'jml_bayar',
				'formatter' => function($d) {
					return number_format($d, 2, ',', '.');
				} ),
		);

		$data['sql_details'] = sql_connect();

		$data['joinQuery'] = '
			FROM '.$this->tbl_name.' a
			LEFT JOIN tm_asuransi b ON b.kd_asuransi = a.asuransi_kd
			LEFT JOIN tm_client c ON c.kd_client = a.client_kd
			LEFT JOIN td_karyawan_asuransi d ON d.kd_karyawan_asuransi = a.karyawan_asuransi_kd
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
		$btns[] = get_btn(array('access' => $update_access, 'title' => 'Ubah', 'icon' => 'pencil', 'onclick' => 'open_detail_page({\'file_type\' : \'form\', \'page_name\' : \'data_pembayaran_asuransi\', \'kd_karyawan_asuransi_pembayaran\' : \''.$id.'\'})'));
		$btns[] = get_btn_divider();
		$btns[] = get_btn(array('access' => $delete_access, 'title' => 'Hapus', 'icon' => 'trash',
			'onclick' => 'return confirm(\'Anda akan menghapus '.$this->title_name.' = '.$var.'?\')?hapus_data(\''.$id.'\', \'data_pembayaran_asuransi\'):false'));
		$btn_group = group_btns($btns);

		return $btn_group;
	}

	public function get_data($id = '') {
		$this->load->model(array('model_basic/base_query'));
		$row = $this->base_query->get_row($this->tbl_name, array($this->p_key => $id));
		if (!empty($row)) :
			$data = (object) array('kd_karyawan_asuransi_pembayaran' => $row->kd_karyawan_asuransi_pembayaran, 'karyawan_asuransi_kd' => $row->karyawan_asuransi_kd, 'karyawan_kd' => $row->karyawan_kd, 'asuransi_kd' => $row->asuransi_kd, 'client_kd' => $row->client_kd, 'tgl_bayar' => format_date($row->tgl_bayar, 'd-m-Y'), 'jml_bayar' => $row->jml_bayar);
		else :
			$data = (object) array('kd_karyawan_asuransi_pembayaran' => '', 'karyawan_asuransi_kd' => '', 'karyawan_kd' => '', 'asuransi_kd' => '', 'client_kd' => '', 'tgl_bayar' => '', 'jml_bayar' => '');
		endif;
		return $data;
	}
}
