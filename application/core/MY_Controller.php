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
		if (!isset($_SESSION['user']['kd_user'])) :
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
		$this->load->model(array('model_basic/base_query', 'model_setting/m_setting'));

		$this->db->trans_start();
		$this->base_query->del_unused_img('assets/admin_assets/images/settings/', 'tm_sys_appareance', 'val_sys_appareance', ['type_sys_appareance' => 'img']);
		$this->base_query->del_unused_img('assets/admin_assets/images/users/', 'tm_user', 'user_img');
		$this->db->trans_complete();
		
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
		$this->load->model(array('model_setting/m_setting'));
		if (isset($_SESSION['user']['kd_user'])) :
			redirect('administrator/home');
		else :
			$this->output->set_template('admin_login_tpl/admin_login_tpl');
			$this->load->js('assets/admin_assets/vendors/bootstrap/dist/js/bootstrap.min.js');
		endif;
	}

	public function error_tpl() {
		$this->output->set_template('error_tpl/error_tpl');
	}

	public function datatables_assets() {
		$this->load->css('assets/admin_assets/vendors/datatables-1.10.15/media/css/dataTables.bootstrap.min.css');
		$this->load->js('assets/admin_assets/vendors/datatables-1.10.15/media/js/jquery.dataTables.min.js');
		$this->load->js('assets/admin_assets/vendors/datatables-1.10.15/media/js/dataTables.bootstrap.min.js');
	}

	public function tableresponsive_assets() {
		$this->load->css('assets/admin_assets/vendors/datatables-1.10.15/extensions/responsive/css/responsive.bootstrap.min.css');
		$this->load->js('assets/admin_assets/vendors/datatables-1.10.15/extensions/responsive/js/dataTables.responsive.min.js');
		$this->load->js('assets/admin_assets/vendors/datatables-1.10.15/extensions/responsive/js/responsive.bootstrap.min.js');
	}

	public function tablefixed_assets() {
		$this->load->css('assets/admin_assets/vendors/datatables-1.10.15/extensions/fixedcolumns/css/fixedcolumns.bootstrap.min.css');
		$this->load->js('assets/admin_assets/vendors/datatables-1.10.15/extensions/fixedcolumns/js/datatables.fixedcolumns.min.js');
	}

	public function icheck_assets() {
		$this->load->css('assets/admin_assets/vendors/iCheck/skins/flat/blue.css');
		$this->load->js('assets/admin_assets/vendors/iCheck/icheck.min.js');
	}

	public function datetimepicker_assets() {
		$this->load->css('assets/admin_assets/vendors/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css');
		$this->load->js('assets/admin_assets/js/moment/moment.min.js');
		$this->load->js('assets/admin_assets/vendors/bootstrap-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js');
	}
}