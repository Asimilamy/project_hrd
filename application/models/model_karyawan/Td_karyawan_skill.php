<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Td_karyawan_skill extends CI_Model {
	private $tbl_name = 'td_karyawan_skill';
	private $p_key = 'kd_karyawan_skill';
	private $title_name = 'Data Skills Pegawai';

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
			array( 'db' => 'nm_skill', 'dt' => 3, 'field' => 'nm_skill' ),
			array( 'db' => 'lvl_skill', 'dt' => 4, 'field' => 'lvl_skill',
				'formatter' => function($d){
					return ucwords($d);
				} ),
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
			$data = (object) array('kd_karyawan_skill' => $row->kd_karyawan_skill, 'karyawan_kd' => $row->karyawan_kd, 'nm_skill' => $row->nm_skill, 'lvl_skill' => $row->lvl_skill);
		else :
			$data = (object) array('kd_karyawan_skill' => '', 'karyawan_kd' => '', 'nm_skill' => '', 'lvl_skill' => '');
		endif;
		return $data;
	}
}
