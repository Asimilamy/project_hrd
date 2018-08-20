<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Tm_menu extends CI_Model {
	private $tbl_name = 'tm_menu';
	private $p_key = 'kd_menu';
	private $title_name = 'Data Menu';

	public function ssp_table() {
		$data['table'] = $this->tbl_name;

		$data['primaryKey'] = 'a.'.$this->p_key;

		$data['columns'] = array(
			array( 'db' => 'a.'.$this->p_key.' AS kd_master',
				'dt' => 1, 'field' => 'kd_master',
				'formatter' => function($d, $row){

					return $this->tbl_btn($d, $row[2]);
				} ),
			array( 'db' => 'b.menu_nm AS menu_parent', 'dt' => 2, 'field' => 'menu_parent',
				'formatter' => function($d) {
					$d = empty($d)?'-':$d;
					return $d;
				} ),
			array( 'db' => 'a.menu_nm', 'dt' => 3, 'field' => 'menu_nm' ),
			array( 'db' => 'a.menu_link', 'dt' => 4, 'field' => 'menu_link' ),
			array( 'db' => 'a.menu_title', 'dt' => 5, 'field' => 'menu_title' ),
			array( 'db' => 'a.menu_icon', 'dt' => 6, 'field' => 'menu_icon',
				'formatter' => function($d) {
					$d = empty($d)?'-':$d;
					return $d;
				} ),
			array( 'db' => 'a.menu_order', 'dt' => 7, 'field' => 'menu_order' ),
			array( 'db' => 'a.menu_modul', 'dt' => 8, 'field' => 'menu_modul' ),
			array( 'db' => 'a.menu_global', 'dt' => 9, 'field' => 'menu_global',
				'formatter' => function($d) {
					$d = ya_tidak($d);
					return $d;
				} ),
		);

		$data['sql_details'] = sql_connect();

		$data['joinQuery'] = 'FROM '.$this->tbl_name.' a LEFT JOIN tm_menu b ON b.kd_menu = a.menu_parent';

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
			$data = array('kd_menu' => $row->kd_menu, 'menu_parent' => $row->menu_parent, 'menu_nm' => $row->menu_nm, 'menu_link' => $row->menu_link, 'menu_title' => $row->menu_title, 'menu_icon' => $row->menu_icon, 'menu_order' => $row->menu_order, 'menu_modul' => $row->menu_modul, 'menu_global' => $row->menu_global);
		else :
			$data = array('kd_menu' => '', 'menu_parent' => '', 'menu_nm' => '', 'menu_link' => '', 'menu_title' => '', 'menu_icon' => '', 'menu_order' => '', 'menu_modul' => '', 'menu_global' => '');
		endif;
		return $data;
	}

	public function form_rules() {
		$rules = array(
			array('field' => 'txtNm', 'label' => 'Nama Menu', 'rules' => 'required'),
			array('field' => 'txtLink', 'label' => 'Link Menu', 'rules' => 'required'),
			array('field' => 'txtTitle', 'label' => 'Judul Menu', 'rules' => 'required'),
			array('field' => 'txtOrder', 'label' => 'Urutan Menu', 'rules' => 'required'),
			array('field' => 'selModul', 'label' => 'Modul Menu', 'rules' => 'required'),
			array('field' => 'selGlobal', 'label' => 'Menu Global', 'rules' => 'required'),
		);
		return $rules;
	}

	public function form_warning($datas = '') {
		$forms = array('txtNm', 'txtLink', 'txtTitle', 'txtOrder', 'selModul', 'selGlobal');
		foreach ($datas as $key => $data) :
			$str[$data] = (!empty(form_error($forms[$key])))?build_label('warning', form_error($forms[$key], '"', '"')):'';
		endforeach;
		return $str;
	}
}