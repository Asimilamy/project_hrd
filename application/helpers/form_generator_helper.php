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