<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Td_karyawan_kontrak extends CI_Model {
	private $tbl_name = 'td_karyawan_kontrak';
	private $p_key = 'kd_karyawan_kontrak';
	private $title_name = 'Data Kontrak Pegawai';

	public function ssp_table() {
		$data['table'] = $this->tbl_name;

		$data['primaryKey'] = $this->p_key;

		$data['columns'] = array(
			array( 'db' => 'a.'.$this->p_key,
				'dt' => 1, 'field' => $this->p_key,
				'formatter' => function($d, $row){

					return $this->tbl_btn($d, $row[2]);
				} ),
			array( 'db' => 'a.'.$this->p_key, 'dt' => 2, 'field' => $this->p_key ),
			array( 'db' => 'b.nm_client', 'dt' => 3, 'field' => 'nm_client' ),
			array( 'db' => 'a.unit_kontrak', 'dt' => 4, 'field' => 'unit_kontrak' ),
			array( 'db' => 'a.bagian_kontrak', 'dt' => 5, 'field' => 'bagian_kontrak' ),
			array( 'db' => 'a.jabatan_kontrak', 'dt' => 6, 'field' => 'jabatan_kontrak' ),
			array( 'db' => 'a.tgl_mulai', 'dt' => 7, 'field' => 'tgl_mulai',
				'formatter' => function($d) {
					return format_date($d, 'd-m-Y');
				} ),
			array( 'db' => 'a.tgl_habis', 'dt' => 8, 'field' => 'tgl_habis',
				'formatter' => function($d) {
					return format_date($d, 'd-m-Y');
				} ),
		);

		$data['sql_details'] = sql_connect();

		$data['joinQuery'] = 'FROM '.$this->tbl_name.' a LEFT JOIN tm_client b ON b.kd_client = a.client_kd';

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
		$btns[] = get_btn(array('access' => $update_access, 'title' => 'Ubah', 'icon' => 'pencil', 'onclick' => 'open_detail_page({\'file_type\' : \'form\', \''.$this->p_key.'\' : \''.$id.'\'})'));
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
			$data = (object) array('kd_karyawan_kontrak' => $row->kd_karyawan_kontrak, 'karyawan_kd' => $row->karyawan_kd, 'client_kd' => $row->client_kd, 'unit_kontrak' => $row->unit_kontrak, 'bagian_kontrak' => $row->bagian_kontrak, 'jabatan_kontrak' => $row->jabatan_kontrak, 'tgl_mulai' => format_date($row->tgl_mulai, 'd-m-Y'), 'tgl_habis' => format_date($row->tgl_habis, 'd-m-Y'));
		else :
			$data = (object) array('kd_karyawan_kontrak' => '', 'karyawan_kd' => '', 'client_kd' => '', 'unit_kontrak' => '', 'bagian_kontrak' => '', 'jabatan_kontrak' => '', 'tgl_mulai' => '', 'tgl_habis' => '');
		endif;
		return $data;
	}
}
