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

	public function submit_data($datas = []) {
		$this->load->model(['model_basic/base_query']);

		$act = $this->base_query->delete_data($this->tbl_name, ['user_type_kd' => $datas['user_type_kd']], $this->title_name);
		if ($act) {
			$datas[$this->p_key] = create_pkey($this->tbl_name, $this->p_key, '', '');
			for ($i = 0; $i < count($datas['menu_kd']); $i++) {
				$menu_kd = $datas['menu_kd'][$i];
				$create_access = isset($datas['create_access'][$menu_kd])?'1':'0';
				$read_access = isset($datas['read_access'][$menu_kd])?'1':'0';
				$update_access = isset($datas['update_access'][$menu_kd])?'1':'0';
				$delete_access = isset($datas['delete_access'][$menu_kd])?'1':'0';

				if ($create_access || $read_access || $update_access || $delete_access) {
					$data_submit[] = ['kd_user_access' => $datas[$this->p_key], 'user_type_kd' => $datas['user_type_kd'], 'menu_kd' => $menu_kd, 'create_access' => $create_access, 'read_access' => $read_access, 'update_access' => $update_access, 'delete_access' => $delete_access, 'tgl_input' => date('Y-m-d H:i:s'), 'user_kd' => $_SESSION['user']['kd_user']];
					$datas[$this->p_key] = create_pkey($this->tbl_name, $this->p_key, $datas[$this->p_key], 1);
				}
			}
			$act = $this->base_query->submit_batch($this->tbl_name, $this->title_name, $data_submit);
		}

		return $act;
	}
}
