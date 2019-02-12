<?php
defined('BASEPATH') or exit('No direct script access allowed!');

function render_form($label = '', $input_name = '', $type = '', $value = '') {
	$CI =& get_instance();
	$CI->load->helper('form');
	$type = $type == 'media'?'file':$type;
	$form = '<div class="form-group">';
		$form .= '<label class="col-sm-2 control-label">'.$label.'</label>';
		if ($type != 'text_area') :
			$form .= '<div class="col-sm-4 col-xs-10">';
				$form .= form_input(array('type' => $type, 'name' => $input_name, 'class' => 'form-control', 'value' => $value, 'placeholder' => $label));
			$form .= '</div>';
		else :
			$form .= '<div class="col-sm-6 col-xs-10">';
				$form .= form_textarea(array('name' => $input_name, 'class' => 'form-control', 'rows' => 5, 'value' => $value, 'placeholder' => $label));
			$form .= '</div>';
		endif;
	$form .= '</div>';
	return $form;
}

function render_form_dropdown($label = '', $dropdown_name = '', $options = [], $value = '') {
	$CI =& get_instance();
	$CI->load->helper('form');
	foreach ($options as $keys => $vals) :
		foreach ($vals as $key => $val) :
			$option[$key] = $val;
		endforeach;
	endforeach;
	$form = '<div class="form-group">';
		$form .= '<label class="col-sm-2 control-label">'.$label.'</label>';
		$form .= '<div class="col-sm-4 col-xs-10">';
			$form .= form_dropdown($dropdown_name, $option, $value, array('class' => 'form-control'));
		$form .= '</div>';
	$form .= '</div>';
	return $form;
}

function render_form_codeformat($code_part_val = '', $code_unique_val = '', $code_separator_val = '', $btn = 'plus') {
	$CI =& get_instance();
	$CI->load->model(['model_code_format/m_code_format']);
	$CI->load->helper(['form']);
	$code_part_opts = render_dropdown('Code Part', $CI->m_code_format->code_part_opts(), 'key', 'value');
	$code_separator_opts = render_dropdown('Code Separator', $CI->m_code_format->code_separator_opts(), 'key', 'value');
	$is_hidden = $btn == 'minus'?'style=\'display: none;\'':'';
	$is_unique_hidden = $code_part_val == 'urutan_angka' || $code_part_val == 'kode_huruf'?'':'style=\'display: none;\'';

	$form = '<div class="form-group" '.$is_hidden.'>';
		$form .= '<label class="col-sm-2 col-xs-1 control-label"></label>';
		$form .= '<div class="col-sm-2 col-xs-4">';
			$form .= form_dropdown('selCodePart[]', $code_part_opts, $code_part_val, array('class' => 'form-control'));
		$form .= '</div>';
		$form .= '<div class="cl-form-unique" '.$is_unique_hidden.'>';
			$form .= '<div class = "col-sm-2 col-xs-4">';
				$form .= form_input(['name' => 'txtCodeUnique[]', 'class' => 'form-control', 'value' => $code_unique_val]);
			$form .= '</div>';
		$form .= '</div>';
		$form .= '<div class="col-sm-2 col-xs-4">';
			$form .= form_dropdown('selSeparator[]', $code_separator_opts, $code_separator_val, array('class' => 'form-control'));
		$form .= '</div>';
		$form .= '<div class="col-sm-1 col-xs-1">';
			if ($btn == 'plus') :
				$form .= '<button type="button" name="btnTambah" class="btn btn-success btn-flat btn-tambah-format" title="Tambah Format">';
					$form .= '<i class="fa fa-plus"></i>';
				$form .= '</button>';
			elseif ($btn == 'minus') :
				$form .= '<button type="button" name="btnHapus" class="btn btn-danger btn-flat btn-hapus-format" title="Hapus Format">';
					$form .= '<i class="fa fa-minus"></i>';
				$form .= '</button>';
			endif;
		$form .= '</div>';
	$form .= '</div>';
	return $form;
}