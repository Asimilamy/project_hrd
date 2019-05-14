<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Base_query extends CI_Model {
	public function get_all($tbl = '', $params = [], $orders = []) {
		$this->db->from($tbl);
		if (count($params) > 0) :
			$this->db->where($params);
		endif;
		if (count($orders) > 0) :
			foreach ($orders as $col => $ordering) :
				$this->db->order_by($col, $ordering);
			endforeach;
		endif;
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	public function get_row($tbl = '', $params = [], $orders = []) {
		$this->db->from($tbl)
			->where($params);
		if (count($orders) > 0) :
			foreach ($orders as $col => $ordering) :
				$this->db->order_by($col, $ordering);
			endforeach;
		endif;
		$query = $this->db->get();
		$row = $query->row();
		return $row;
	}

	public function count_data($tbl = '', $params = []) {
		$this->db->from($tbl)
			->where($params);
		$query = $this->db->get();
		$num = $query->num_rows();
		return $num;
	}

	public function submit_data($tbl_name = '', $p_key = '', $title_name = '', $data = []) {
		if (!empty($data[$p_key])) :
			$label = 'Mengubah '.$title_name;
			$submit = array_merge($data, array('user_kd' => $_SESSION['user']['kd_user'], 'tgl_edit' => date('Y-m-d H:i:s')));
			$where = array($p_key => $data[$p_key]);
			$act = $this->db->update($tbl_name, $submit, $where);
		else :
			$label = 'Menambahkan '.$title_name;
			$data[$p_key] = create_pkey($tbl_name, $p_key);
			$submit = array_merge($data, array('user_kd' => $_SESSION['user']['kd_user'], 'tgl_input' => date('Y-m-d H:i:s')));
			$act = $this->db->insert($tbl_name, $submit);
		endif;
		$str = get_report($act, $label, $submit, $data[$p_key]);
		return $str;
	}

	public function delete_data($tbl_name = '', $data = [], $title_name = '') {
		$act = $this->db->delete($tbl_name, $data);
		$str = get_report($act, 'Menghapus '.$title_name, $data);
		return $str;
	}

	public function soft_delete($tbl_name = '', $data = [], $title_name = '') {
		$act = $this->db->update($tbl_name, ['is_deleted' => 1], $data);
		$str = get_report($act, 'Menghapus '.$title_name, $data);
		return $str;
	}

	public function submit_batch($tbl_name = '', $title_name = '', $data = []) {
		$act = $this->db->insert_batch($tbl_name, $data);
		$str = get_report($act, 'Menambahkan '.$title_name, $data);
		return $str;
	}

	public function edit_batch($tbl_name = '', $title_name = '', $data = [], $key_row = '') {
		$N_row = $this->db->update_batch($tbl_name, $data, $key_row);
		$act = $N_row > 0?TRUE:FALSE;
		$str = get_report($act, 'Mengubah '.$title_name, $data);
		return $str;
	}

	public function form_errs($tbl_name = '', $column = '') {
		$form_errs = [];
		$this->db->select($column)
			->from($tbl_name);
		$query = $this->db->get();
		$result = $query->result();
		foreach ($result as $row) :
			$form_errs[] = 'idErr'.$row->{$column};
		endforeach;
		return $form_errs;
	}

	public function del_unused_img($path_to_img = '', $img_tbl = '', $img_col = '', $ex_params = []) {
		$img_on_dir = glob(FCPATH . $path_to_img . '*.*');
		$path = strlen(FCPATH . $path_to_img);

		$this->db->trans_start();
		foreach ($img_on_dir as $img) :
			$fotos[] = substr($img, $path);
		endforeach;

		$this->db->select($img_col)
			->from($img_tbl);
		if (isset($fotos)) :
			$this->db->where_in($img_col, $fotos);
		endif;
		if (!empty($ex_params)) :
			$this->db->where($ex_params);
		endif;
		$query = $this->db->get();
		$result = $query->result();
		foreach ($result as $row) :
			$imgs[] = $row->{$img_col};
		endforeach;

		if (isset($fotos)) :
			foreach ($fotos as $foto) :
				if (isset($imgs)) :
					if (!in_array($foto, $imgs)) :
						unlink($path_to_img.$foto);
					endif;
				else :
					unlink($path_to_img.$foto);
				endif;
			endforeach;
		endif;
		$this->db->trans_complete();
	}

	public function define_container($class_link = '', $box_type = '') {
		$data['class_link'] = $class_link;
		$data['box_id'] = 'idBox'.$box_type;
		$data['box_alert_id'] = 'idAlertBox'.$box_type;
		$data['box_loader_id'] = 'idLoaderBox'.$box_type;
		$data['box_content_id'] = 'idContentBox'.$box_type;
		$data['btn_hide_id'] = 'idBtnHide'.$box_type;
		$data['btn_add_id'] = 'idBtnAdd'.$box_type;
		$data['btn_close_id'] = 'idBtnClose'.$box_type;
		return $data;
	}
}