<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Tm_user extends CI_Model {
	private $tbl_name = 'tm_user';
	private $p_key = 'kd_user';
	private $title_name = 'Data User';

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
			array( 'db' => 'b.nm_master_type', 'dt' => 3, 'field' => 'nm_master_type' ),
			array( 'db' => 'a.user_id', 'dt' => 4, 'field' => 'user_id' ),
			array( 'db' => 'a.user_name', 'dt' => 5, 'field' => 'user_name' ),
		);

		$data['sql_details'] = sql_connect();

		$data['joinQuery'] = 'FROM '.$this->tbl_name.' a LEFT JOIN tm_master_type b ON b.kd_master_type = a.master_type_kd';

		$data['where'] = 'a.kd_user != '.$_SESSION['user']['kd_user'];

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
			$data = array('kd_user' => $row->kd_user, 'master_type_kd' => $row->master_type_kd, 'user_id' => $row->user_id, 'user_pass' => $row->user_pass, 'user_name' => $row->user_name, 'user_img' => $row->user_img);
		else :
			$data = array('kd_user' => '', 'master_type_kd' => '', 'user_id' => '', 'user_pass' => '', 'user_name' => '', 'user_img' => '');
		endif;
		return $data;
	}

	public function form_rules() {
		$rules = array(
			array('field' => 'selType', 'label' => 'Master Type', 'rules' => 'required'),
			array('field' => 'txtId', 'label' => 'User ID', 'rules' => 'required|callback_username_check'),
			array('field' => 'txtUsername', 'label' => 'User Name', 'rules' => 'required|callback_username_check'),
		);
		if (empty($this->input->post('txtKd')) || !empty($this->input->post('txtPass'))) :
			$rules_pass = array(
				array('field' => 'txtPass', 'label' => 'Password', 'rules' => 'required'),
				array('field' => 'txtPassConf', 'label' => 'Confirm Password', 'rules' => 'required|matches[txtPass]'),
			);
			$rules = array_merge($rules, $rules_pass);
		endif;
		return $rules;
	}

	public function form_warning($datas = '') {
		$forms = array('selType', 'txtId', 'txtPass', 'txtPassConf');
		foreach ($datas as $key => $data) :
			$str[$data] = (!empty(form_error($forms[$key])))?build_label('warning', form_error($forms[$key], '"', '"')):'';
		endforeach;
		return $str;
	}
}