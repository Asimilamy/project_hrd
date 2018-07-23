<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Login extends MY_Controller {
	private $class_uri = 'administrator/auth/login';

	public function __construct() {
		parent::__construct();
		parent::admin_login_tpl();
	}

	public function index() {
		$data = [];
		$this->load->view('page/'.$this->class_uri.'/login_page', $data);
	}
}