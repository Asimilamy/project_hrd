<?php
defined('BASEPATH') or exit('No direct script script access allowed!');

/* --Masukkan setting properti untuk form-- */
$master_var = 'DataStatusKerja';
$form_id = 'idForm'.$master_var;
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
	<label for="idSelHasContract" class="col-sm-2 control-label">Pilihan Kontrak</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrHasContract"></div>
		<?php echo form_dropdown('selHasContract', ['' => '-- Pilihan Kontrak --', '0' => 'Tidak', '1' => 'Ya'], $has_contract, array('id' => 'idSelHasContract', 'class' => 'form-control')); ?>
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