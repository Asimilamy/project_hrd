<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class MY_Security extends CI_Security {
    public function __construct() {
        parent::__construct();
    }

    public function csrf_show_error() {
        $uri_string = '';
        $uris = explode('/', htmlspecialchars($_SERVER['REQUEST_URI']));
        for ($i = 0; $i < count($uris); $i++) :
            if (!empty($uri) || $uris[$i] != $uris[count($uris) - 1]) :
                $uri_string .= $uris[$i].'/';
            endif;
        endfor;
        header('Location: '.$uri_string.'/csrf_redirect');
    }
}