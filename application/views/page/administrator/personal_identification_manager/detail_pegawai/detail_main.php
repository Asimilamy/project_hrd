<?php
defined('BASEPATH') or exit('No direct access allowed!');
?>
<!-- START LEFT SIDE -->
<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
	<!-- START USER PROFILE -->
	<div class="panel panel-primary">
		<div class="panel-body cl-panel-profile-badge"></div>
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
				<?php
				if (!empty($detail_karyawan->kd_karyawan)) :
					?>
					<li role="presentation">
						<a href="javascript:void(0);" data-page-link="histori_kontrak">Histori Kontrak</a>
					</li>
					<li role="presentation">
						<a href="javascript:void(0);" data-page-link="data_skills">Skills</a>
					</li>
					<li role="presentation">
						<a href="javascript:void(0);" data-page-link="data_asuransi">Asuransi</a>
					</li>
					<li role="presentation">
						<a href="javascript:void(0);" data-page-link="data_keluarga">Keluarga</a>
					</li>
					<li role="presentation">
						<a href="javascript:void(0);" data-page-link="data_kontak">Kontak Lain</a>
					</li>
					<?php
				endif;
				?>
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
			<div class="box-loader-detail-karyawan" align="middle">
				<i class="fa fa-spinner fa-pulse fa-2x" style="color:#31708f;"></i>
			</div>
			<div class="form-err-class"></div>
			<div class="box-page-detail-karyawan"></div>
		</div>
	</div>
</div>

<?php $this->load->view('page/'.$class_link.'/exts/ext_detail_js'); ?>
