<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$last_uri = $this->uri->segment_array();
$last_uri = ucwords(str_replace('_', ' ', end($last_uri)));
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="<?php echo base_url().'assets/admin_assets/'; ?>images/favicon.ico" type="image/ico">

        <title>Project HRD | ERROR | <?php echo $last_uri; ?></title>

        <!-- Bootstrap -->
        <link href="<?php echo base_url('assets/admin_assets/vendors/bootstrap/dist/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?php echo base_url('assets/admin_assets/vendors/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?php echo base_url('assets/admin_assets/vendors/nprogress/nprogress.css'); ?>" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="<?php echo base_url('assets/admin_assets/build/css/custom.min.css'); ?>" rel="stylesheet">
    </head>
    <body class="nav-md">
        <div class="container body">
            <?php echo $output; ?>
        </div>
        

        <!-- jQuery -->
        <script src="<?php echo base_url('assets/admin_assets/vendors/jquery/dist/jquery.min.js'); ?>"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url('assets/admin_assets/vendors/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url('assets/admin_assets/vendors/fastclick/lib/fastclick.js'); ?>"></script>
        <!-- NProgress -->
        <script src="<?php echo base_url('assets/admin_assets/vendors/nprogress/nprogress.js'); ?>"></script>

        <!-- Custom Theme Scripts -->
        <script src="<?php echo base_url('assets/admin_assets/build/js/custom.min.js'); ?>"></script>
    </body>
</html>