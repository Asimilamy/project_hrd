<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>

<div class="profile_img">
    <div id="crop-avatar">
        <!-- Current avatar -->
        <?php
        if (!empty($detail_karyawan->foto_karyawan) && file_exists('assets/admin_assets/images/employees/'.$detail_karyawan->foto_karyawan)) :
            ?>
            <img class="img-responsive avatar-view" src="<?php echo base_url('assets/admin_assets/images/employees/'.$detail_karyawan->foto_karyawan); ?>" alt="<?php echo $detail_karyawan->nm_karyawan; ?>" width="253px" height="253px" style="margin-left: auto; margin-right: auto;">
            <?php
        else :
            ?>
            <img class="img-responsive avatar-view" src="<?php echo base_url('assets/admin_assets/images/settings/'.$detail_karyawan->default_user_img); ?>" alt="<?php echo $detail_karyawan->nm_karyawan; ?>" width="253px" height="253px" style="margin-left: auto; margin-right: auto;">
            <?php
        endif;
        ?>
    </div>
</div>
<h3><?php echo $detail_karyawan->nm_karyawan; ?></h3>
<ul class="list-unstyled user_data">
    <li>
        <i class="fa fa-map-marker user-profile-icon"></i> <?php echo empty_string($detail_karyawan->alamat); ?>
    </li>
    <li>
        <i class="fa fa-id-badge user-profile-icon"></i> <?php echo empty_string($detail_karyawan->nm_status_kerja); ?>
    </li>
    <li>
        <i class="fa fa-briefcase user-profile-icon"></i> <?php echo empty_string($detail_karyawan->nm_unit).' <i class="fa fa-chevron-circle-right"></i> '.empty_string($detail_karyawan->nm_bagian).' <i class="fa fa-chevron-circle-right"></i> '.empty_string($detail_karyawan->nm_jabatan); ?>
    </li>
    <li>
        <i class="fa fa-phone user-profile-icon"></i> <?php echo empty_string(format_phone($detail_karyawan->no_telp_utama)); ?>
    </li>
    <li class="m-top-xs">
        <i class="fa fa-envelope-o user-profile-icon"></i> <?php echo empty_string($detail_karyawan->email_utama); ?>
    </li>
</ul>
