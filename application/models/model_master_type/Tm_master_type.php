<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Tm_master_type extends CI_Model {
	private $tbl_name = 'tm_master_type';
	private $p_key = 'kd_master_type';
	private $title_name = 'Data Master Type';

	public function ssp_table($var = '') {
		$data['table'] = $this->tbl_name;

		$data['primaryKey'] = 'a.'.$this->p_key;

		$data['columns'] = array(
			array( 'db' => 'a.'.$this->p_key.' AS kd_master',
				'dt' => 1, 'field' => 'kd_master',
				'formatter' => function($d, $row){

					return $this->tbl_btn($d, $row[2]);
				} ),
			array( 'db' => 'b.nm_master_type AS nm_parent', 'dt' => 2, 'field' => 'nm_parent' ),
			array( 'db' => 'a.nm_master_type', 'dt' => 3, 'field' => 'nm_master_type' ),
		);

		$data['sql_details'] = sql_connect();

		$data['joinQuery'] = 'FROM '.$this->tbl_name.' a LEFT JOIN '.$this->tbl_name.' b ON b.kd_master_type = a.kd_parent';

		$data['where'] = 'a.type = \''.$var.'\'';

		return $data;
	}

	private function tbl_btn($id = '', $var = '') {
		$this->load->helper(array('btn_access_helper'));

		$read_access = $_SESSION['user']['access']['read'];
		$update_access = $_SESSION['user']['access']['update'];
		$delete_access = $_SESSION['user']['access']['delete'];

		$btns = array();
		$btns[] = get_btn(array('access' => $read_access, 'title' => 'Detail '.$this->title_name, 'icon' => 'search', 'onclick' => 'view_detail(\''.$id.'\')'));
		$btns[] = get_btn(array('access' => $update_access, 'title' => 'Ubah', 'icon' => 'pencil', 'onclick' => 'get_form(\''.$id.'\')'));
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
			$data = array('kd_master_type' => $row->kd_master_type, 'kd_parent' => $row->kd_parent, 'nm_master_type' => $row->nm_master_type, 'type' => $row->type);
		else :
			$data = array('kd_master_type' => '', 'kd_parent' => '', 'nm_master_type' => '', 'type' => $_SESSION['master_type_tipe']);
		endif;
		return $data;
	}

	public function form_rules() {
		$rules = array(
			array('field' => 'txtNm', 'label' => 'Master Type', 'rules' => 'required'),
		);
		return $rules;
	}

	public function form_warning($datas = '') {
		$forms = array('txtNm');
		foreach ($datas as $key => $data) :
			$str[$data] = (!empty(form_error($forms[$key])))?build_label('warning', form_error($forms[$key], '"', '"')):'';
		endforeach;
		return $str;
	}
}