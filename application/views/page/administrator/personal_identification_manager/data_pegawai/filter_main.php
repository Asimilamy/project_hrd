<?php
defined('BASEPATH') or exit('No direct script script access allowed!');

/* --Masukkan setting properti untuk form-- */
$master_var = 'DataMasterType';
$form_id = 'idForm'.$master_var;
echo form_open_multipart('', array('id' => $form_id, 'class' => 'form-horizontal'));
echo form_input(array('type' => 'hidden', 'name' => 'txtKd', 'value' => ''));
?>
<div class="form-group">
	<label for="idTxtNim" class="col-sm-2 control-label">NIK Karyawan</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrNik"></div>
		<?php echo form_input(array('name' => 'txtNik', 'id' => 'idTxtNim', 'class' => 'form-control', 'value' => '', 'placeholder' => 'NIK Karyawan')); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtNm" class="col-sm-2 control-label">Nama Karyawan</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrNm"></div>
		<?php echo form_input(array('name' => 'txtNm', 'id' => 'idTxtNm', 'class' => 'form-control', 'value' => '', 'placeholder' => 'Nama Karyawan')); ?>
	</div>
</div>
<div class="form-group">
	<label for="idSelStatusKerja" class="col-sm-2 control-label">Status Kerja</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrStatusKerja"></div>
		<?php echo form_dropdown('selStatusKerja', ['' => 'Pilih AE'], '', array('id' => 'idSelStatusKerja', 'class' => 'form-control')); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtTglMasuk" class="col-sm-2 control-label">Tanggal Masuk</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrTglMasuk"></div>
		<?php echo form_input(array('name' => 'txtTglMasuk', 'id' => 'idTxtTglMasuk', 'class' => 'form-control datetimepicker', 'value' => '', 'placeholder' => 'Tanggal Masuk')); ?>
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