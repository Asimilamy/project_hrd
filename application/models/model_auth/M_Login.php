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
			$str[$data] = (!empty(form_error($forms[$key])))?build_label('warning', form_error($forms[$key], '"', '"')):'';
		endforeach;
		return $str;
	}

	function chk_user_exist($user_id = '', $user_pass = '') {
		$this->db->select('a.kd_user, a.master_type_kd, a.user_id, a.user_pass')
			->from('tm_user a')
			->where(array('user_id' => $user_id));
		if (!empty($user_pass)) :
			$this->db->where(array('user_pass' => $user_pass));
		endif;
		$query = $this->db->get();
		$num_row = $query->num_rows();
		return $num_row > 0?TRUE:FALSE;
	}

	public function verify_login($datas = '') {
		$chk_userid = $this->chk_user_exist($datas['user_id']);
		if ($chk_userid) :
			$chk_pass = $this->chk_user_exist($user_id, $user_pass);
			if ($chk_pass) :
				// if the datas passed the system then system will register all session according to user
			else :
				$conf = get_report(0, 'Gagal Login Password tidak cocok dengan Username', $datas);
				$conf['idErrUsername'] = '';
				$conf['idErrPass'] = build_label('warning', 'Password tidak cocok dengan Username!');
			endif;
		else :
			$conf = get_report(0, 'Gagal Login Username tidak ada', $datas);
			$conf['idErrUsername'] = build_label('warning', 'Username tidak ada!');
			$conf['idErrPass'] = '';
		endif;
		return $conf;
	}
}