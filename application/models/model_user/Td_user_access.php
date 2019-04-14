<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Td_user_access extends CI_Model {
	private $tbl_name = 'td_user_access';
	private $p_key = 'kd_user_access';
	private $title_name = 'Data User Access';

	public function get_access_data($user_type_kd = '') {
		$this->load->model(array('model_basic/base_query'));
		$access_datas = new StdClass;
		$result = $this->base_query->get_all($this->tbl_name, ['user_type_kd' => $user_type_kd]);
		foreach ($result as $row) {
			$access_datas->{$row->menu_kd} = (object) [
				'create_access' => $row->create_access,
				'read_access' => $row->read_access,
				'update_access' => $row->update_access,
				'delete_access' => $row->delete_access,
			];
		}
		return !empty($result)?$access_datas:NULL;
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
