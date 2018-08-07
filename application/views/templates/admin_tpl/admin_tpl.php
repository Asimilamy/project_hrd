<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="<?php echo base_url().'assets/admin_assets/'; ?>images/favicon.ico" type="image/ico">

		<title>Gentelella Alela! | </title>

		<!-- Bootstrap -->
		<link href="<?php echo base_url().'assets/admin_assets/'; ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="<?php echo base_url().'assets/admin_assets/'; ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<!-- NProgress -->
		<link href="<?php echo base_url().'assets/admin_assets/'; ?>vendors/nprogress/nprogress.css" rel="stylesheet">
		<!-- JQuery Custom Content Scroller -->
		<link href="<?php echo base_url().'assets/admin_assets/'; ?>vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
		<!-- Custom Theme Style -->
		<link href="<?php echo base_url().'assets/admin_assets/'; ?>build/css/custom.min.css" rel="stylesheet">

		<?php
		if(!empty($meta)) {
			foreach($meta as $name=>$content){
				echo "\n\t\t";
				?><meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" /><?php
			}
			echo "\n";
		}
		if(!empty($canonical)) {
			echo "\n\t\t";
			?><link rel="canonical" href="<?php echo $canonical?>" /><?php
		}
		echo "\n\t";

		foreach($css as $file) {
			echo "\n\t\t";
			?><link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" /><?php
		}
		echo "\n\t";
		?>
		
		<!-- jQuery -->
		<script src="<?php echo base_url().'assets/admin_assets/'; ?>vendors/jquery/dist/jquery.min.js"></script>
	</head>
	<body class="nav-md footer_fixed">
		<?php echo $this->load->get_section('sidebar_menu'); ?>

		<?php echo $this->load->get_section('top_nav'); ?>
		
		<!-- page content -->
		<div class="right_col" role="main">
			<?php echo $output; ?>
		</div>
		<!-- /page content -->

		<?php echo $this->load->get_section('footer'); ?>

		<!-- Bootstrap -->
		<script src="<?php echo base_url().'assets/admin_assets/'; ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- NProgress -->
		<script src="<?php echo base_url().'assets/admin_assets/'; ?>vendors/nprogress/nprogress.js"></script>
		<!-- Custom Theme Scripts -->
		<script src="<?php echo base_url().'assets/admin_assets/'; ?>build/js/custom.min.js"></script>
		<?php
		foreach($js as $file) {
			echo "\n\t\t";
			?><script src="<?php echo $file; ?>"></script><?php
		}
		echo "\n\t";
		?>
	</body>
</html>