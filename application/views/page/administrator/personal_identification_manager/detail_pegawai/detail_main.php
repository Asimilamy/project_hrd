<?php
defined('BASEPATH') or exit('No direct access allowed!');
$default_user_img = $this->m_setting->get_setting('default_user_img');
?>
<!-- START LEFT SIDE -->
<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
	<!-- START USER PROFILE -->
	<div class="panel panel-primary">
		<div class="panel-body">
			<div class="profile_img">
				<div id="crop-avatar">
					<!-- Current avatar -->
					<?php
					if (!empty($karyawan_info->foto_karyawan) && file_exists('assets/admin_assets/images/employees/'.$karyawan_info->foto_karyawan)) :
						?>
						<img class="img-responsive avatar-view" src="<?php echo base_url('assets/admin_assets/images/employees/'.$karyawan_info->foto_karyawan); ?>" alt="<?php echo $karyawan_info->nm_karyawan; ?>" width="195px" height="195px">
						<?php
					else :
						?>
						<img class="img-responsive avatar-view" src="<?php echo base_url('assets/admin_assets/images/settings/'.$default_user_img); ?>" alt="<?php echo $karyawan_info->nm_karyawan; ?>" width="195px" height="195px">
						<?php
					endif;
					?>
				</div>
			</div>
			<h3><?php echo $karyawan_info->nm_karyawan; ?></h3>
			<ul class="list-unstyled user_data">
				<li>
					<i class="fa fa-map-marker user-profile-icon"></i> <?php echo empty_string($karyawan_info->alamat); ?>
				</li>

				<li>
					<i class="fa fa-briefcase user-profile-icon"></i> <?php echo empty_string($karyawan_info->nm_unit).' | '.empty_string($karyawan_info->nm_bagian).' | '.empty_string($karyawan_info->nm_jabatan); ?>
				</li>

				<li class="m-top-xs">
					<i class="fa fa-envelope-o user-profile-icon"></i> <?php echo empty_string($karyawan_info->email_utama); ?>
				</li>
			</ul>
		</div>
	</div>
	<!-- END USER PROFILE -->

	<!-- START DETAIL MENU -->
	<div class="panel panel-primary">
		<div class="panel-heading"><h4 class="panel-title">Menu Pegawai</h4></div>
		<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
				<li role="presentation">
					<a href="javascript:void(0);" data-page-link="data_pribadi">Data Pribadi</a>
				</li>
				<li role="presentation">
					<a href="javascript:void(0);" data-page-link="informasi_kontak">Informasi Kontak</a>
				</li>
				<li role="presentation">
					<a href="javascript:void(0);" data-page-link="data_tanggungan">Tanggungan</a>
				</li>
				<li role="presentation">
					<a href="javascript:void(0);" data-page-link="data_keluarga">Keluarga</a>
				</li>
				<li role="presentation">
					<a href="javascript:void(0);" data-page-link="data_jabatan">Jabatan</a>
				</li>
				<li role="presentation">
					<a href="javascript:void(0);" data-page-link="data_skills">Skills</a>
				</li>
			</ul>
		</div>
	</div>
	<!-- END DETAIL MENU -->
</div>
<!-- END LEFT SIDE -->

<!-- START RIGHT SIDE -->
<div class="col-md-9 col-sm-9 col-xs-12">
	<div class="panel panel-primary">
		<div class="panel-heading"><h4 class="panel-title">Detail Pegawai Title</h4></div>
		<div class="panel-body">
			<div id="idBoxLoaderDetailKaryawan" align="middle">
				<i class="fa fa-spinner fa-pulse fa-2x" style="color:#31708f;"></i>
			</div>
			<div id="idBoxPageDetailKaryawan"></div>
		</div>
	</div>
</div>

<?php $this->load->view('page/'.$class_link.'/exts/ext_detail_js'); ?>
