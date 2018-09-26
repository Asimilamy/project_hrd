<?php
defined('BASEPATH') or exit('No direct access allowed!');
?>
<!-- START LEFT SIDE -->
<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
	<!-- START USER PROFILE -->
	<div class="panel panel-primary">
		<div class="panel-body">
			<div class="profile_img">
				<div id="crop-avatar">
					<!-- Current avatar -->
					<img class="img-responsive avatar-view" src="<?php echo base_url('assets/admin_assets/images/picture.jpg'); ?>" alt="Avatar" title="Change the avatar">
				</div>
			</div>
			<h3>Samuel Doe</h3>
			<ul class="list-unstyled user_data">
				<li>
					<i class="fa fa-map-marker user-profile-icon"></i> San Francisco, California, USA
				</li>

				<li>
					<i class="fa fa-briefcase user-profile-icon"></i> Software Engineer
				</li>

				<li class="m-top-xs">
					<i class="fa fa-external-link user-profile-icon"></i>
					<a href="http://www.kimlabs.com/profile/" target="_blank">www.kimlabs.com</a>
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
		<div class="panel-body"></div>
	</div>
</div>

<script type="text/javascript">
	var first_page = $('.nav-pills a').parent().first();
	var page_link = $('.nav-pills a').first().data('page-link');
	first_page.addClass('active');
	console.log(page_link);

	$(".nav-pills a").on("click", function(){
		$(".nav-pills").find(".active").removeClass("active");
		$(this).parent().addClass("active");

		var page_link = $(this).data('page-link');
		console.log(page_link);
	});
</script>