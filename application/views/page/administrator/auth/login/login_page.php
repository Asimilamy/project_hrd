<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<div class="login_wrapper">
	<div class="animate form login_form">
		<section class="login_content">
			<?php echo form_open_multipart('', array('class' => 'myform', 'id' => 'myform')); ?>
				<h1>Login Form</h1>
				<div>
					<?php echo form_input(array('type' => 'text', 'id' => 'idTxtUsername', 'name' => 'txtUsername', 'class' => 'form-control', 'placeholder' => 'Username')); ?>
				</div>
				<div>
					<?php echo form_input(array('type' => 'password', 'id' => 'idTxtPass', 'name' => 'txtPassword', 'class' => 'form-control', 'placeholder' => 'Password')); ?>
				</div>
				<div>
					<?php echo form_button(array('type' => 'submit', 'id' => 'idBtnSubmit', 'name' => 'btnSubmit', 'class' => 'btn btn-default submit', 'content' => 'Log in')); ?>
				</div>

				<div class="clearfix"></div>

				<div class="separator">
					<div>
						<h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
						<p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
					</div>
				</div>
			<?php echo form_close(); ?>
		</section>
	</div>
</div>