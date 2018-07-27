<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Gentelella Alela! | </title>

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
	<body class="login">
		<?php echo $output; ?>

		<?php
		foreach($js as $file) {
			echo "\n\t\t";
			?><script src="<?php echo $file; ?>"></script><?php
		}
		echo "\n\t";
		?>
	</body>
</html>