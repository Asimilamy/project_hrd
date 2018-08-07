<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->database();
		$this->load->library(array('session'));
		$this->load->helper(array('basic_helper', 'alert_helper', 'key_helper', 'url', 'html'));
	}

	private function check_login() {
		if (!isset($_SESSION['user'])) :
			$this->session->sess_destroy();
			redirect('administrator/auth/login');
		endif;
	}

	public function admin_tpl() {
		if (ENVIRONMENT == 'development') :
			$this->load->model(array('model_tpl/m_menu'));
		endif;
		
		self::check_login();
		$this->output->set_template('admin_tpl/admin_tpl');
		$this->load->helper(array('menu_renderer_helper'));
		
		$data = [];
		$this->load->section('sidebar_menu', 'templates/admin_tpl/sidebar_menu', $data);
		$this->load->section('top_nav', 'templates/admin_tpl/top_nav', $data);
		$this->load->section('footer', 'templates/admin_tpl/footer', $data);

		/*
		** In case we need to add css and js to default template
		** But i prefer to create a function to call the assets instead of put it all in one place
		** To save page load time :)
		$this->load->css('assets/admin_assets/plugins/datatables-1.10.15/extensions/responsive/css/responsive.bootstrap.min.css');
		$this->load->js('assets/admin_assets/plugins/datatables-1.10.15/media/js/jquery.dataTables.min.js');
		*/
	}

	public function admin_login_tpl() {
		if (isset($_SESSION['user'])) :
			redirect('administrator/home');
		else :
			$this->output->set_template('admin_login_tpl/admin_login_tpl');
			$this->load->js('assets/admin_assets/vendors/bootstrap/dist/js/bootstrap.min.js');
		endif;
	}

	public function error_tpl() {
		$this->output->set_template('error_tpl/error_tpl');
	}
}