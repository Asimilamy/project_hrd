<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Tm_user_type extends CI_Model {
	private $tbl_name = 'tm_user_type';
	private $p_key = 'kd_user_type';
	private $title_name = 'Data Tipe User';

	public function ssp_table() {
        $this->load->helper(['basic_helper']);
		$data['table'] = $this->tbl_name;

		$data['primaryKey'] = 'a.'.$this->p_key;

		$data['columns'] = array(
			array( 'db' => 'a.'.$this->p_key, 'dt' => 1, 'field' => $this->p_key,
            'formatter' => function($d, $row){
                return $this->tbl_btn($d, $row[2]);
            } ),
			array( 'db' => 'a.'.$this->p_key, 'dt' => 2, 'field' => $this->p_key ),
            array( 'db' => 'b.nm_user_type AS nm_parent', 'dt' => 3, 'field' => 'nm_parent',
            'formatter' => function($d) {
                return empty_string($d);
            } ),
			array( 'db' => 'a.nm_user_type', 'dt' => 4, 'field' => 'nm_user_type' ),
		);

		$data['sql_details'] = sql_connect();

		$data['joinQuery'] = 'FROM '.$this->tbl_name.' a LEFT JOIN '.$this->tbl_name.' b ON b.'.$this->p_key.' = a.kd_parent';

		$data['where'] = '';

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
			$data = ['kd_user_type' => $row->kd_user_type, 'kd_parent' => $row->kd_parent, 'nm_user_type' => $row->nm_user_type];
		else :
			$data = ['kd_user_type' => '', 'kd_parent' => '', 'nm_user_type' => ''];
		endif;
		return $data;
	}

	public function form_rules() {
		$rules = [
			['field' => 'txtNm', 'label' => 'Nama User Type', 'rules' => 'required'],
        ];
		return $rules;
	}

	public function form_warning($datas = '') {
		$forms = ['txtNm'];
		foreach ($datas as $key => $data) :
			$str[$data] = (!empty(form_error($forms[$key])))?build_label('warning', form_error($forms[$key], '"', '"')):'';
		endforeach;
		return $str;
	}
}
