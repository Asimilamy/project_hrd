<?php
defined('BASEPATH') or exit('No direct script access allowed!');

function upload_file($file_upload = '', $path = '', $exts = '', $err_id = '') {
	$CI =& get_instance();
	$CI->load->library('upload', do_upload_config($path, $exts));
	if (!$CI->upload->do_upload($file_upload)) :
		$data = array('confirm' => 'error', $err_id => build_label('warning', $CI->upload->display_errors('', '')), 'csrf' => $CI->security->get_csrf_hash(), 'alert_stat' => 'offline', 'csrf_alert' => '');
	else :
		$data = array('upload_data' => $CI->upload->data());
	endif;
	return $data;
}

function do_upload_config($path = '', $exts = '', $max_name = '50') {
	$config['upload_path'] = $path;
	$config['allowed_types'] = $exts;
	$config['encrypt_name'] = TRUE;
	$config['max_filename'] = $max_name;
	$config['detect_mime'] = TRUE;
	return $config;
}

function process_image_conf($path = '', $width = '') {
	$CI =& get_instance();
	$config['image_library'] = 'gd2';
	$config['source_image'] = $path;
	$config['maintain_ratio'] = TRUE;
	$config['width'] = $width;
	$CI->load->library('image_lib', $config);

	$CI->image_lib->resize();
}