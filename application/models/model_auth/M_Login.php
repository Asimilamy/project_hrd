<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class M_Login extends CI_Model {
	public function form_rules() {
		$rules = array(
			array('field' => 'txtUsername', 'label' => 'Username', 'rules' => 'required'),
			array('field' => 'txtPassword', 'label' => 'Password', 'rules' => 'required'),
		);
		return $rules;
	}

	public function form_warning($datas = '') {
		$forms = array('txtUsername', 'txtPassword');
		foreach ($datas as $key => $data) :
			$str[$data] = (!empty(form_error($forms[$key])))?buildLabel('warning', form_error($forms[$key], '"', '"')):'';
		endforeach;
		return $str;
	}

	public function verify_login($datas = '') {
		return $datas;
	}
}