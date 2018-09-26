<?php
defined('BASEPATH') or exit('No direct script script access allowed!');

/* --Masukkan setting properti untuk form-- */
$master_var = 'DataSysAppareance';
$form_id = 'idForm'.$master_var;
echo form_open_multipart('', array('id' => $form_id, 'class' => 'form-horizontal'));

foreach ($form_sys as $sys_app) :
	?>
	<div class="form-group">
		<label for="id<?php echo $sys_app->kd_sys_appareance; ?>" class="col-sm-2 control-label"><?php echo ucwords(str_replace('_', ' ', $sys_app->nm_sys_appareance)); ?></label>
		<div class="col-sm-6 col-xs-6">
			<div id="idErr<?php echo $sys_app->kd_sys_appareance; ?>"></div>
			<?php
			echo form_input(array('type' => 'hidden', 'name' => 'txtKd[]', 'value' => $sys_app->kd_sys_appareance));
			echo form_input(array('type' => 'hidden', 'name' => 'txtType['.$sys_app->kd_sys_appareance.']', 'value' => $sys_app->type_sys_appareance));
			if ($sys_app->type_sys_appareance == 'img') :
				if (!empty($sys_app->val_sys_appareance) && file_exists('assets/admin_assets/images/settings/'.$sys_app->val_sys_appareance)) :
					echo img('assets/admin_assets/images/settings/'.$sys_app->val_sys_appareance, FALSE, array('width' => '100', 'height' => '100', 'title' => $sys_app->nm_sys_appareance, 'style' => 'margin-bottom: 5px;'));
				endif;
				echo form_upload(array('id' => 'id'.$sys_app->kd_sys_appareance, 'name' => 'fileValSys'.$sys_app->kd_sys_appareance, 'class' => 'form-control'));
			else :
				echo form_input(array('id' => 'id'.$sys_app->kd_sys_appareance, 'name' => 'txtValSys['.$sys_app->kd_sys_appareance.']', 'class' => 'form-control', 'value' => $sys_app->val_sys_appareance, 'placeholder' => ucwords(str_replace('_', ' ', $sys_app->nm_sys_appareance))));
			endif;
			?>
		</div>
	</div>
	<?php
endforeach;
?>
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