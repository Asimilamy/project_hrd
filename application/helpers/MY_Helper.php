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

function get_client_ip() {
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP')) :
		$ipaddress = getenv('HTTP_CLIENT_IP');
	elseif(getenv('HTTP_X_FORWARDED_FOR')) :
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	elseif(getenv('HTTP_X_FORWARDED')) :
		$ipaddress = getenv('HTTP_X_FORWARDED');
	elseif(getenv('HTTP_FORWARDED_FOR')) :
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	elseif(getenv('HTTP_FORWARDED')) :
		$ipaddress = getenv('HTTP_FORWARDED');
	elseif(getenv('REMOTE_ADDR')) :
		$ipaddress = getenv('REMOTE_ADDR');
	else :
		$ipaddress = 'UNKNOWN';
	endif;

	return $ipaddress;
}

function hash_text($text) {
	$options = [
		'cost' => 12,
	];
	$result = password_hash($text, PASSWORD_BCRYPT, $options);

	return $result;
}

function verify_hash($text, $hash) {
	$decrypt = password_verify($text, $hash);

	return $decrypt;
}