<?php
defined('BASEPATH') or exit('No direct script script access allowed!');

/* --Masukkan setting properti untuk form-- */
$master_var = 'DataStatusKerja';
$form_id = 'idForm'.$master_var;
$is_status_visible = $has_contract?'':'style="display: none;"';
echo form_open_multipart('', array('id' => $form_id, 'class' => 'form-horizontal'));
echo form_input(array('type' => 'hidden', 'name' => 'txtKd', 'value' => $kd_status_kerja));
?>
<div class="form-group">
	<label for="idTxtCode" class="col-sm-2 control-label">User Code</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrCode"></div>
		<?php echo form_input(array('name' => 'txtCode', 'id' => 'idTxtCode', 'class' => 'form-control', 'value' => $user_code, 'placeholder' => 'User Code')); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtNm" class="col-sm-2 control-label">Nama Status Kerja</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrNm"></div>
		<?php echo form_input(array('name' => 'txtNm', 'id' => 'idTxtNm', 'class' => 'form-control', 'value' => $nm_status_kerja, 'placeholder' => 'Nama Status Kerja')); ?>
	</div>
</div>
<div class="form-group">
	<label for="idChkHasContract" class="col-sm-2 control-label" style="padding: 1px 5px 5px;">Pilihan Kontrak</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrHasContract"></div>
		<?php echo form_checkbox(['name' => 'chkHasContract', 'id' => 'idChkHasContract', 'class' => 'iCheck', 'value' => '1', 'checked' => $has_contract?TRUE:FALSE]); ?>
	</div>
</div>
<div id="idFormStatus" class="form-group" <?php echo $is_status_visible; ?>>
	<label for="idSelKdStatus" class="col-sm-2 control-label">Status Habis</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrKdStatus"></div>
		<?php echo form_dropdown('selKdStatus', $opts_status, $kd_status_habis, ['id' => 'idSelKdStatus', 'class' => 'form-control']); ?>
	</div>
</div>
<div class="form-group">
	<label for="idChkIsVisible" class="col-sm-2 control-label" style="padding: 1px 5px 5px;">Data Ditampilkan</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrIsVisible"></div>
		<?php echo form_checkbox(['name' => 'chkIsVisible', 'id' => 'idChkIsVisible', 'class' => 'iCheck', 'value' => '1', 'checked' => $is_visible?TRUE:FALSE]); ?>
	</div>
</div>
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