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

function ya_tidak($var = '') {
	$text = 'Tidak';
	if ($var == '0') :
		$text = 'Tidak';
	elseif ($var == '1') :
		$text = 'Ya';
	endif;
	return $text;
}

function render_dropdown($title = '', $opts = [], $val = '', $var = '') {
	$option[''] = '-- Pilih '.$title.' --';
	foreach ($opts as $opt) :
		if (is_object($opt)) :
			$option[$opt->{$val}] = $opt->{$var}; 
		else :
			$option[$opt[$val]] = $opt[$var];
		endif;
	endforeach;
	return $option;
}

function format_date($date, $format){
	$tgl = new DateTime($date);
	$tgl_formatted = $tgl->format($format);

	return $tgl_formatted;
}

function empty_string($str = '', $replacement = '-') {
	if (empty($str)) :
		$string = $replacement;
	else :
		$string = $str;
	endif;
	return $string;
}