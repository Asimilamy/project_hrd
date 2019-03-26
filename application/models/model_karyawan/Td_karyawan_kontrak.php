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
			array( 'db' => 'a.'.$this->p_key, 'dt' => 1, 'field' => $this->p_key,
				'formatter' => function($d, $row) {
					return $this->tbl_btn($d, $row[2]);
				} ),
			array( 'db' => 'a.'.$this->p_key, 'dt' => 2, 'field' => $this->p_key ),
			array( 'db' => 'b.nm_client', 'dt' => 3, 'field' => 'nm_client' ),
			array( 'db' => 'c.nm_status_kerja', 'dt' => 4, 'field' => 'nm_status_kerja' ),
			array( 'db' => 'd.nm_unit', 'dt' => 5, 'field' => 'nm_unit' ),
			array( 'db' => 'e.nm_bagian', 'dt' => 6, 'field' => 'nm_bagian' ),
			array( 'db' => 'f.nm_jabatan', 'dt' => 7, 'field' => 'nm_jabatan' ),
			array( 'db' => 'a.type_karyawan', 'dt' => 8, 'field' => 'type_karyawan',
				'formatter' => function($d) {
					return ucwords($d);
				} ),
			array( 'db' => 'a.tgl_mulai', 'dt' => 9, 'field' => 'tgl_mulai' ),
			array( 'db' => 'a.tgl_habis', 'dt' => 10, 'field' => 'tgl_habis',
				'formatter' => function($d, $row) {
					if ($row[7] == 'outsourcing') {
						return format_date($d, 'd-m-Y');
					} else {
						return '-';
					}
				} ),
		);

		$data['sql_details'] = sql_connect();

		$data['joinQuery'] = '
			FROM '.$this->tbl_name.' a
			LEFT JOIN tm_client b ON b.kd_client = a.client_kd
			LEFT JOIN tm_status_kerja c ON c.kd_status_kerja = a.status_kerja_kd
			LEFT JOIN tm_unit d ON d.kd_unit = a.unit_kd
			LEFT JOIN tm_bagian e ON e.kd_bagian = a.bagian_kd
			LEFT JOIN tm_jabatan f ON f.kd_jabatan = a.jabatan_kd
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
		$btns[] = get_btn(array('access' => $update_access, 'title' => 'Ubah', 'icon' => 'pencil', 'onclick' => 'open_detail_page({\'file_type\' : \'form\', \''.$this->p_key.'\' : \''.$id.'\'})'));
		$btns[] = get_btn_divider();
		$btns[] = get_btn(array('access' => $delete_access, 'title' => 'Hapus', 'icon' => 'trash',
			'onclick' => 'return confirm(\'Anda akan menghapus '.$this->title_name.' = '.$var.'?\')?hapus_data(\''.$id.'\'):false'));
		$btn_group = group_btns($btns);

		return $btn_group;
	}

	public function get_data($id = '') {
		$this->load->model(array('model_basic/base_query'));
		$this->db->select('a.*, b.has_contract')
			->from($this->tbl_name.' a')
			->join('tm_status_kerja b', 'b.kd_status_kerja = a.status_kerja_kd', 'left')
			->where(['a.'.$this->p_key => $id]);
		$query = $this->db->get();
		$row = $query->row();
		if (!empty($row)) :
			$data = (object) array('kd_karyawan_kontrak' => $row->kd_karyawan_kontrak, 'karyawan_kd' => $row->karyawan_kd, 'client_kd' => $row->client_kd, 'unit_kd' => $row->unit_kd, 'bagian_kd' => $row->bagian_kd, 'jabatan_kd' => $row->jabatan_kd, 'status_kerja_kd' => $row->status_kerja_kd, 'type_karyawan' => $row->type_karyawan, 'tgl_mulai' => format_date($row->tgl_mulai, 'd-m-Y'), 'tgl_habis' => format_date($row->tgl_habis, 'd-m-Y'), 'has_contract' => $row->has_contract);
		else :
			$data = (object) array('kd_karyawan_kontrak' => '', 'karyawan_kd' => '', 'client_kd' => '', 'unit_kd' => '', 'bagian_kd' => '', 'jabatan_kd' => '', 'status_kerja_kd' => '', 'type_karyawan' => '', 'tgl_mulai' => '', 'tgl_habis' => '', 'has_contract' => '0');
		endif;
		return $data;
	}
}
