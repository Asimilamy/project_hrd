<?php
defined('BASEPATH') or exit('No direct script access allowed!');

function create_pkey($tbl_name = '', $key_column = '', $key_before = '', $inc = 0) {
    $CI =& get_instance();
    $jml_inc = 4;
    $urutan = 0;
    if ($inc < 1) :
        $CI->db->select('tgl_input, '.$key_column)
            ->from($tbl_name)
            ->order_by($key_column.' DESC, tgl_input DESC');
        $query = $CI->db->get();
        $num_row = $query->num_rows();
        if ($num_row > 0) :
            $row = $query->row();
            if (isset($row)) :
                $code = $row->{$key_column};
                $urutan = substr($code, 6);
            endif;
        endif;
    else :
        $urutan = substr($key_before, 6);
    endif;
    $angka = $urutan + 1;
    $pkey = date('ymd').str_pad($angka, $jml_inc, '000', STR_PAD_LEFT);
    return $pkey;
}