<?php
defined('BASEPATH') or exit('No direct script access allowed!');

function number_to_roman($number = 1) {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $ret_val = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $ret_val .= $roman;
                break;
            }
        }
    }
    return $ret_val;
}
