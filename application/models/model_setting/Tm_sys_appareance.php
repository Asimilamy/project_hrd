<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Tm_sys_appareance extends CI_Model {
	private $tbl_name = 'tm_warehouse';
	private $p_key = 'kd_warehouse';
	private $title_name = 'Data Warehouse';

	public function form_rules() {
		$rules = array(
			array('field' => 'txtNm', 'label' => 'Nama Warehouse', 'rules' => 'required'),
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