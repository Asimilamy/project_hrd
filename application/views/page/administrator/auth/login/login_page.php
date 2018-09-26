<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/* --START OF BOX DEFAULT PROPERTY-- */
$js_file = 'login_page_js';
$box_title = 'Login Form';
$data['class_link'] = $class_link;
$data['form_id'] = 'myform';
$data['form_errs'] = $form_errs;
$data['field_focus'] = 'idTxtUsername';
/* --END OF BOX DEFAULT PROPERTY-- */
?>
<section class="login_content">
	<?php echo form_open_multipart('', array('class' => 'myform form-label-left', 'id' => $data['form_id'])); ?>
		<h1><?php echo $box_title; ?></h1>
		<div id="idAlert" style="display: none;"></div>
		<div class="form-group">
			<span id="idErrUsername" class="label label-warning pull-left" style="font-size: 100%;display: none;">
				<i class="ace-icon fa fa-ban"></i> 
				Username anda sudah digunakan!
			</span>
			<?php echo form_input(array('type' => 'text', 'id' => $data['field_focus'], 'name' => 'txtUsername', 'class' => 'form-control', 'placeholder' => 'Username')); ?>
		</div>
		<div>
			<span id="idErrPass" class="label label-warning pull-left" style="font-size: 100%;display: none;">
				<i class="ace-icon fa fa-ban"></i> 
				Password tidak cocok!
			</span>
			<?php echo form_input(array('type' => 'password', 'id' => 'idTxtPass', 'name' => 'txtPassword', 'class' => 'form-control', 'placeholder' => 'Password')); ?>
		</div>
		<div>
			<?php echo form_button(array('type' => 'submit', 'id' => 'idBtnSubmit', 'name' => 'btnSubmit', 'class' => 'btn btn-default submit', 'content' => 'Log in')); ?>
		</div>

		<div class="clearfix"></div>
	<?php echo form_close(); ?>
</section>
<?php $this->load->view('page/'.$class_link.'/'.$js_file, $data); ?>