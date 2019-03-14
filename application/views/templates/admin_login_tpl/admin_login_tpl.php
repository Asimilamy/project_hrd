<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$last_uri = $this->uri->segment_array();
$last_uri = ucwords(str_replace('_', ' ', end($last_uri)));
$favicon = $this->m_setting->get_setting('favicon');
$app_title = $this->m_setting->get_setting('app_title');
$app_logo = $this->m_setting->get_setting('app_logo');
?>
<!DOCTYPE html>
<html lang="en">
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

		<title><?php echo $app_title; ?> | Login</title>

		<!-- Bootstrap -->
		<link href="<?php echo base_url().'assets/admin_assets/'; ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="<?php echo base_url().'assets/admin_assets/'; ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<!-- NProgress -->
		<link href="<?php echo base_url().'assets/admin_assets/'; ?>vendors/nprogress/nprogress.css" rel="stylesheet">
		<!-- Animate.css -->
		<link href="<?php echo base_url().'assets/admin_assets/'; ?>vendors/animate.css/animate.min.css" rel="stylesheet">
		<!-- Custom Theme Style -->
		<link href="<?php echo base_url().'assets/admin_assets/'; ?>build/css/my_custom.min.css" rel="stylesheet">

		<!-- jQuery -->
		<script src="<?php echo base_url().'assets/admin_assets/'; ?>vendors/jquery/dist/jquery.min.js"></script>
	</head>
	<body class="login" style="background: #ffffff; color: #000000; height: 0%;">
		<div class="login_wrapper">
			<div class="animate form login_form">
				<?php echo $output; ?>

				<section style="text-align: center; font-size: 13px; font-weight: 400;">
					<div class="separator">
						<div>
							<h3><i class="fa <?php echo $app_logo; ?>"></i> <?php echo $app_title; ?></h3>
							<p>©2019 All Rights Reserved CV. Ali Insan Jaya.</p>
							<p>Privacy and Terms</p>
							<p>V <?php echo $_SERVER['APP_VERSION']; ?></p>
						</div>
					</div>
				</section>
			</div>
		</div>

		<?php
		foreach($js as $file) {
			echo "\n\t\t";
			?><script src="<?php echo $file; ?>"></script><?php
		}
		echo "\n\t";
		?>
	</body>
</html>