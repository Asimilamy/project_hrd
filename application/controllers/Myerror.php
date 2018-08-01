<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Myerror extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        parent::error_tpl();
        $this->load->view('errors/html/error_page_404');
    }
}