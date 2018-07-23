<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Home extends MY_Controller {
	private $class_url = 'administrator/home';

	public function __construct() {
		parent::__construct();
		parent::admin_tpl();
	}

	public function index() {
		$this->load->view('page/'.$this->class_url.'/home');
	}
}