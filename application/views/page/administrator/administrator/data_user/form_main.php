<?php
defined('BASEPATH') or exit('No direct script script access allowed!');

/* --Masukkan setting properti untuk form-- */
$master_var = 'DataUser';
$form_id = 'idForm'.$master_var;
echo form_open_multipart('', array('id' => $form_id, 'class' => 'form-horizontal'));
echo form_input(array('type' => 'hidden', 'name' => 'txtKd', 'value' => $kd_user));
?>
<div class="form-group">
	<label for="idSelType" class="col-sm-2 control-label">Master Type</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrType"></div>
		<?php echo form_dropdown('selType', $master_type_opts, $master_type_kd, array('id' => 'idSelType', 'class' => 'form-control')); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtId" class="col-sm-2 control-label">User ID</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrId"></div>
		<?php echo form_input(array('name' => 'txtId', 'id' => 'idTxtId', 'class' => 'form-control', 'placeholder' => 'User ID', 'value' => $user_id)); ?>
	</div>
</div>
<?php
if (!empty($kd_user)) :
	?>
	<div class="form-group">
		<label class="col-xs-10 col-xs-offset-2">
			<?php echo build_label('info', 'Jika Password tidak diubah, kosongkan field ini!'); ?>
		</label>
	</div>
	<?php
endif;
?>
<div class="form-group">
	<label for="idTxtPass" class="col-sm-2 control-label">Password</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrPass"></div>
		<?php echo form_input(array('type' => 'password', 'name' => 'txtPass', 'id' => 'idTxtPass', 'class' => 'form-control', 'placeholder' => 'Password')); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtPassConf" class="col-sm-2 control-label">Confirm Password</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrPassConf"></div>
		<?php echo form_input(array('type' => 'password', 'name' => 'txtPassConf', 'id' => 'idTxtPassConf', 'class' => 'form-control', 'placeholder' => 'Confirm Password')); ?>
	</div>
</div>
<div class="box_form_properties"></div>
<hr>
<div class="form-group">
	<div class="col-sm-1 col-sm-offset-2 col-xs-12">
		<button type="reset" name="btnReset" class="btn btn-default btn-flat">
			<i class="fa fa-refresh"></i> Reset
		</button>
	</div>
	<div class="col-sm-1 col-xs-12">
		<button type="submit" name="btnSubmit" class="btn btn-primary btn-flat">
			<i class="fa fa-save"></i> Submit
		</button>
	</div>
</div>
<?php echo form_close(); ?>