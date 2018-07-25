<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Login extends MY_Controller {
	private $class_link = 'administrator/auth/login';

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		parent::admin_login_tpl();

		$this->load->helper(array('form'));
		$data['class_link'] = $this->class_link;
		$data['form_errs'] = array('idErrUsername', 'idErrPass');
		$this->load->view('page/'.$this->class_link.'/login_page', $data);
	}

	function csrf_redirect() {
		if ($this->input->is_ajax_request()) :
			$str['alert_stat'] = 'online';
			$str['csrf_alert'] = 'Halaman anda direset dikarenakan sesi browser anda telah habis.'."\n".'Silahkan coba lagi.';

			header('Content-Type: application/json');
			echo json_encode($str);
		else :
			$flash = 'Halaman anda direset dikarenakan sesi browser anda telah habis.&nbsp; Silahkan coba lagi.';
			$this->session->set_flashdata('message', $flash);
			redirect($class_link, 'location');
		endif;
	}

	public function send_data() {
		if ($this->input->is_ajax_request()) :
			$str['alert_stat'] = 'offline';
			$str['csrf_alert'] = '';
			/*$this->form_validation->set_rules($this->tm_rak->form_rules());
			if ($this->form_validation->run() == FALSE) :
				$str = $this->tm_rak->form_warning($this->form_errs);
				$str['confirm'] = 'error';
			else :
				$data['kd_rak'] = $this->input->post('txtKd');
				$data['gudang_kd'] = $this->input->post('txtKdGudang');
				$data['nm_rak'] = $this->input->post('txtNmRak');
				$str = $this->tm_rak->submit_data($data);
			endif;*/
			$str['csrf'] = $this->security->get_csrf_hash();

			header('Content-Type: application/json');
			echo json_encode($str);
		endif;
	}
}