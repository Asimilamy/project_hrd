<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Master_type extends MY_Controller {
	private $class_link = 'administratro/ajax_call/master_type';

	public function __construct() {
		parent::__construct();
	}

	/*
	** I still wondering about this function
	** is it still necessary to put it in every controller :\
	*/
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

	public function get_prop_form() {
		$this->load->model(array('model_master_properties/m_master_prop'));
		$kd_user = $this->input->get('kd_user');
		$kd_type = $this->input->get('kd_type');
		$content_type = $this->input->get('content_type');
		$str['form'] = $this->m_master_prop->render_prop_form($kd_user, $kd_type, $content_type);

		header('Content-Type: application/json');
		echo json_encode($str);
	}
}