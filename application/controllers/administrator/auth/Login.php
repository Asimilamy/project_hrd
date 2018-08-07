<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Login extends MY_Controller {
	private $form_errs = array('idErrUsername', 'idErrPass');
	private $class_link = 'administrator/auth/login';

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		parent::admin_login_tpl();
		$this->login_form();
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

	public function login_form() {
		$this->load->helper(array('form'));
		$data['class_link'] = $this->class_link;
		$data['form_errs'] = $this->form_errs;
		$this->load->view('page/'.$this->class_link.'/login_page', $data);
	}

	public function send_data() {
		$this->load->model(array('model_auth/m_login', 'model_tpl/m_menu'));
		$this->load->library(array('form_validation'));

		if ($this->input->is_ajax_request()) :
			$this->form_validation->set_rules($this->m_login->form_rules());
			if ($this->form_validation->run() == FALSE) :
				$str = $this->m_login->form_warning($this->form_errs);
				$str['confirm'] = 'error';
			else :
				$data['user_id'] = $this->input->post('txtUsername');
				$data['user_pass'] = $this->input->post('txtPassword');
				$str = $this->m_login->verify_login($data);
				if ($str['confirm'] == 'success') :
					$this->m_menu->register_session($_SESSION['user']['master_type_kd']);
				endif;
			endif;
			$str['alert_stat'] = 'offline';
			$str['csrf_alert'] = '';
			$str['csrf'] = $this->security->get_csrf_hash();

			header('Content-Type: application/json');
			echo json_encode($str);
		endif;
	}
}