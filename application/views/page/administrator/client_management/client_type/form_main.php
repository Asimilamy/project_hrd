<?php
defined('BASEPATH') or exit('No direct script script access allowed!');

/* --Masukkan setting properti untuk form-- */
$master_var = 'DataClientJenis';
$form_id = 'idForm'.$master_var;
echo form_open_multipart('', array('id' => $form_id, 'class' => 'form-horizontal'));
echo form_input(array('type' => 'hidden', 'name' => 'txtKd', 'value' => $kd_client_jenis));
?>
<div class="form-group">
	<label for="idTxtNm" class="col-sm-2 control-label">Nama Type Client</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrNm"></div>
		<?php echo form_input(array('name' => 'txtNm', 'id' => 'idTxtNm', 'class' => 'form-control', 'value' => $nm_client_jenis, 'placeholder' => 'Nama Type Client')); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtKeterangan" class="col-sm-2 control-label">Keterangan</label>
	<div class="col-sm-6 col-xs-6">
		<?php echo form_textarea(array('name' => 'txtKeterangan', 'id' => 'idTxtKeterangan', 'class' => 'form-control', 'value' => $keterangan, 'rows' => '5', 'placeholder' => 'Keterangan')); ?>
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