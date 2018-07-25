<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function sql_connect() {
	$CI =& get_instance();
	$connection = array(
		'user' => $CI->db->username,
		'pass' => $CI->db->password,
		'db'   => $CI->db->database,
		'host' => $CI->db->hostname
	);
	return $connection;
}

function hashText($text) {
	$options = [
		'cost' => 12,
	];
	$result = password_hash($text, PASSWORD_BCRYPT, $options);

	return $result;
}

function getHash($text, $hash) {
	$decrypt = password_verify($text, $hash);

	return $decrypt;
}

function buildLabel($type = 'success', $msg = '') {
	$icon = build_icon($type);

	$label = '<span class="label label-'.$type.'">
		<i class="ace-icon fa fa-'.$icon.'"></i> 
		'.$msg.'
	</span>';

	return $label;
}

function build_icon($text = 'danger') {
	if ($text == 'danger') :
		$icon = 'ban';
	elseif ($text == 'warning') :
		$icon = 'exclamation-triangle';
	elseif ($text == 'success') :
		$icon = 'check';
	else :
		$icon = build_icon();
	endif;
	return $icon;
}