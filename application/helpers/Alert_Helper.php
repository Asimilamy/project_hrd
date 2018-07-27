<?php
defined('BASEPATH') or exit('No direct script access allowed!');

function build_label($label_type = 'success', $label_msg = '') {
	$icon = build_icon($label_type);

	$label = '<span class="label label-'.$label_type.'">
		<i class="ace-icon fa fa-'.$icon.'"></i> 
		'.$label_msg.'
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

function build_alert($alert_type = '', $alert_title = '', $alert_msg = '') {
    $icon = build_icon($alert_type);
    $alert = '<div class="alert alert-'.$alert_type.' alert-dismissible fade in" role="alert">';
        $alert .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            $alert .= '<span aria-hidden="true">×</span>';
        $alert .= '</button>';
        $alert .= '<strong><i class="ace-icon fa fa-'.$icon.'"></i> '.$alert_title.'</strong>';
        $alert .= '<br>'.$alert_msg;
    $alert .= '</div>';

    return $alert;
}

function get_report($act = '', $label = '', $data = '') {
    if ($act) :
        $str = render_report('Berhasil', 'success', build_alert('success', 'Berhasil!', $label.'!'));
    else :
        $str = render_report('Gagal', 'error', build_alert('danger', 'Gagal!', $label.'!'));
    endif;
    write_log($str['stat'], $label, $data);
    return $str;
}

function render_report($stat = '', $confirm = '', $alert = '') {
    $report['stat'] = $stat;
    $report['confirm'] = $confirm;
    $report['alert'] = $alert;
    return $report;
}

function write_log($stat, $var, $data = array()){
    $user_kd = isset($_SESSION['user_kd'])?$_SESSION['user_kd']:get_client_ip();
    $user_id = isset($_SESSION['user_id'])?$_SESSION['user_id']:'IP Address';
    $nm_kolom = '';
    $no = 0;
    $jml = count($data);
    foreach ($data as $key => $val) :
        $no++;
        $koma = $no == $jml?'':',';
        $nm_kolom .= ' '.$key.' = '.$val.$koma;
    endforeach;
    insert_log(array('user_kd' => $user_kd, 'user_id' => $user_id, 'stat' => $stat, 'keterangan' => $var.' dengan'.$nm_kolom));
}

function insert_log($datas = '') {
    $CI =& get_instance();
    $kd_log = create_pkey('tb_log', 'kd_log', '', 0);

    $d_log = array_merge(array('kd_log' => $kd_log, 'tgl_input' => date('Y-m-d H:i:s')), $datas);
    $input_log = $CI->db->insert('tb_log', $d_log);

    return $input_log?TRUE:FALSE;
}