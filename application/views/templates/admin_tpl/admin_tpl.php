<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$last_uri = $this->uri->segment_array();
$last_uri = ucwords(str_replace('_', ' ', end($last_uri)));
$favicon = $this->m_setting->get_setting('favicon');
$app_title = $this->m_setting->get_setting('app_title');
$app_logo = $this->m_setting->get_setting('app_logo');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php
		if (!empty($favicon)) :
			?>
			<link rel="icon" href="<?php echo base_url('assets/admin_assets/images/settings/'.$favicon); ?>" type="image/ico">
			<?php
		endif;
		?>

		<title><?php echo $app_title; ?> | <?php echo $last_uri; ?></title>

		<!-- Bootstrap -->
		<link href="<?php echo base_url().'assets/admin_assets/'; ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="<?php echo base_url().'assets/admin_assets/'; ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<!-- NProgress -->
		<link href="<?php echo base_url().'assets/admin_assets/'; ?>vendors/nprogress/nprogress.css" rel="stylesheet">
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
	<body class="nav-md">
		<?php echo $this->load->get_section('sidebar_menu'); ?>

		<?php echo $this->load->get_section('top_nav'); ?>
		
		<!-- page content -->
		<div class="right_col" role="main">
			<?php
			$uri_segments = $this->uri->segment_array();
			$page_title = ucwords(str_replace('_', ' ', end($uri_segments)));
			?>
			<div class="page-title">
				<div class="title_left">
					<h3><?php echo $page_title; ?></h3>
				</div>
				<?php
				$page_search = FALSE;
				if ($page_search == TRUE) :
					?>
					<div class="title_right">
						<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Search for...">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button">Go!</button>
								</span>
							</div>
						</div>
					</div>
					<?php
				endif;
				?>
			</div>
			
			<div class="clearfix"></div>

			<div id="idMainContainer">
				<?php echo $output; ?>
			</div>
		</div>
		<!-- /page content -->

		<?php echo $this->load->get_section('footer'); ?>

		<!-- Bootstrap -->
		<script src="<?php echo base_url().'assets/admin_assets/'; ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- NProgress -->
		<script src="<?php echo base_url().'assets/admin_assets/'; ?>vendors/nprogress/nprogress.js"></script>
		<?php
		foreach($js as $file) {
			echo "\n\t\t";
			?><script src="<?php echo $file; ?>"></script><?php
		}
		echo "\n\t";
		?>
		<!-- Custom Theme Scripts -->
		<script src="<?php echo base_url().'assets/admin_assets/'; ?>build/js/my_custom.min.js"></script>
	</body>
</html>