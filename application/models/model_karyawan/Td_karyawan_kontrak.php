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
					if ($row[11] == '0') :
						return '-';
					elseif ($row[11] == '1') :
						return $this->tbl_btn($d, $row[2]);
					endif;
				} ),
			array( 'db' => 'a.'.$this->p_key, 'dt' => 2, 'field' => $this->p_key ),
			array( 'db' => 'a.type_karyawan', 'dt' => 3, 'field' => 'type_karyawan',
				'formatter' => function($d) {
					return ucwords($d);
				} ),
			array( 'db' => 'b.nm_client', 'dt' => 4, 'field' => 'nm_client',
				'formatter' => function($d, $row) {
					if ($row[2] == 'outsourcing') {
						return $d;
					} else {
						return '-';
					}
				} ),
			array( 'db' => 'd.nm_unit', 'dt' => 5, 'field' => 'nm_unit' ),
			array( 'db' => 'e.nm_bagian', 'dt' => 6, 'field' => 'nm_bagian' ),
			array( 'db' => 'f.nm_jabatan', 'dt' => 7, 'field' => 'nm_jabatan' ),
			array( 'db' => 'c.nm_status_kerja', 'dt' => 8, 'field' => 'nm_status_kerja' ),
			array( 'db' => 'a.tgl_mulai', 'dt' => 9, 'field' => 'tgl_mulai',
				'formatter' => function($d, $row) {
					return format_date($d, 'd-m-Y');
				} ),
			array( 'db' => 'a.tgl_habis', 'dt' => 10, 'field' => 'tgl_habis',
				'formatter' => function($d, $row) {
					if ($row[10] == '1') {
						return format_date($d, 'd-m-Y');
					} else {
						return '-';
					}
				} ),
			array( 'db' => 'c.has_contract', 'dt' => 11, 'field' => 'has_contract' ),
			array( 'db' => 'a.is_active', 'dt' => 12, 'field' => 'is_active' ),
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
		$min_date = '1';
		$this->load->model(array('model_basic/base_query'));
		$this->db->select('a.*, b.has_contract')
			->from($this->tbl_name.' a')
			->join('tm_status_kerja b', 'b.kd_status_kerja = a.status_kerja_kd', 'left')
			->where(['a.'.$this->p_key => $id]);
		$query = $this->db->get();
		$row = $query->row();
		if (!empty($row)) :
			$this->db->from($this->tbl_name)
				->where(['karyawan_kd' => $_SESSION['user']['detail_karyawan']['kd_karyawan'], 'tgl_mulai <' => $row->tgl_mulai])
				->order_by('tgl_mulai', 'DESC');
			$query = $this->db->get();
			$r_sblm = $query->row();
			if (!empty($r_sblm)) :
				$tgl_mulai = new DateTime($r_sblm->tgl_mulai);
				$tgl_mulai->add(new DateInterval('P'.$min_date.'D'));
				$tgl_mulai_sblm = $tgl_mulai->format('m/d/Y');
			endif;
			$tgl_mulai_sblm = !empty($tgl_mulai_sblm)?$tgl_mulai_sblm:'';
			$data = (object) array('kd_karyawan_kontrak' => $row->kd_karyawan_kontrak, 'karyawan_kd' => $row->karyawan_kd, 'client_kd' => $row->client_kd, 'unit_kd' => $row->unit_kd, 'bagian_kd' => $row->bagian_kd, 'jabatan_kd' => $row->jabatan_kd, 'status_kerja_kd' => $row->status_kerja_kd, 'type_karyawan' => $row->type_karyawan, 'tgl_mulai' => format_date($row->tgl_mulai, 'd-m-Y'), 'tgl_habis' => format_date($row->tgl_habis, 'd-m-Y'), 'tgl_mulai_sblm' => $tgl_mulai_sblm, 'has_contract' => $row->has_contract);
		else :
			$this->db->select('a.*, b.has_contract')
				->from($this->tbl_name.' a')
				->join('tm_status_kerja b', 'b.kd_status_kerja = a.status_kerja_kd', 'left')
				->where(['karyawan_kd' => $_SESSION['user']['detail_karyawan']['kd_karyawan'], 'is_active' => '1']);
			$query = $this->db->get();
			$row = $query->row();
			if (!empty($row)) :
				$tgl_mulai = new DateTime($row->tgl_mulai);
				$tgl_mulai->add(new DateInterval('P'.$min_date.'D'));
				$tgl_mulai_sblm = $tgl_mulai->format('m/d/Y');

				$client_kd = !empty($row->client_kd)?$row->client_kd:'';
				$unit_kd = !empty($row->unit_kd)?$row->unit_kd:'';
				$bagian_kd = !empty($row->bagian_kd)?$row->bagian_kd:'';
				$jabatan_kd = !empty($row->jabatan_kd)?$row->jabatan_kd:'';
				$status_kerja_kd = !empty($row->status_kerja_kd)?$row->status_kerja_kd:'';
				$type_karyawan = !empty($row->type_karyawan)?$row->type_karyawan:'';
				$has_contract = !empty($row->has_contract)?$row->has_contract:'0';
			endif;
			$tgl_mulai_sblm = !empty($tgl_mulai_sblm)?$tgl_mulai_sblm:'';
			$data = (object) array('kd_karyawan_kontrak' => '', 'karyawan_kd' => '', 'client_kd' => $client_kd, 'unit_kd' => $unit_kd, 'bagian_kd' => $bagian_kd, 'jabatan_kd' => $jabatan_kd, 'status_kerja_kd' => $status_kerja_kd, 'type_karyawan' => $type_karyawan, 'tgl_mulai' => '', 'tgl_habis' => '', 'tgl_mulai_sblm' => $tgl_mulai_sblm, 'has_contract' => $has_contract);
		endif;
		return $data;
	}

	public function set_expired_contract() {
		$this->load->model(['model_basic/base_query']);
		$this->load->helper(['key_helper']);
		$this->db->select('a.*, b.kd_status_habis')
			->from($this->tbl_name.' a')
			->join('tm_status_kerja b', 'b.kd_status_kerja = a.status_kerja_kd', 'left')
			->where(['a.tgl_habis <=' => date('Y-m-d'), 'a.is_active' => '1']);
		$query = $this->db->get();
		$result = $query->result();
		$p_key = create_pkey($this->tbl_name, $this->p_key, '', 0);
		if (!empty($result)) :
			foreach ($result as $row) :
				if (!empty($row->kd_status_habis)) :
					$update_datas[] = [$this->p_key => $row->{$this->p_key}, 'is_active' => '0'];
					$new_contracts[] = [$this->p_key => $p_key, 'karyawan_kd' => $row->karyawan_kd, 'client_kd' => empty($row->client_kd)?NULL:$row->client_kd, 'unit_kd' => $row->unit_kd, 'bagian_kd' => $row->bagian_kd, 'jabatan_kd' => $row->jabatan_kd, 'status_kerja_kd' => $row->kd_status_habis, 'type_karyawan' => $row->type_karyawan, 'tgl_mulai' => $row->tgl_habis, 'is_active' => '1', 'tgl_input' => date('Y-m-d H:i:s'), 'user_kd' => 'SYSTEM'];
					$p_key = create_pkey($this->tbl_name, $this->p_key, $p_key, 1);
				endif;
			endforeach;
			if (isset($update_datas) && isset($new_contracts)) :
				$this->base_query->edit_batch('td_karyawan_kontrak', 'Data Kontrak Karyawan', $update_datas, $this->p_key);
				$this->base_query->submit_batch('td_karyawan_kontrak', 'Data Kontrak Karyawan', $new_contracts);
			endif;
		endif;
	}
}
