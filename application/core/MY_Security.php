<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class MY_Security extends CI_Security {
    public function __construct() {
        parent::__construct();
    }

    public function csrf_error_show() {
        // header('Location: /auth/csrf_redirect'.htmlspecialchars($_SERVER['REQUEST_URI'].'/csrf_redirect'), TRUE, 302);
        header('Location: administrator/auth/login/csrf_redirect', TRUE, 302);
    }
}