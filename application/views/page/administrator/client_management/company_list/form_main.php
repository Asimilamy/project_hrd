<?php
defined('BASEPATH') or exit('No direct script script access allowed!');

/* --Masukkan setting properti untuk form-- */
$master_var = 'DataClient';
$form_id = 'idForm'.$master_var;
echo form_open_multipart('', array('id' => $form_id, 'class' => 'form-horizontal'));
echo form_input(array('type' => 'hidden', 'name' => 'txtKd', 'value' => $kd_client));
?>
<div class="form-group">
	<label for="idSelClientJenis" class="col-sm-2 control-label">Nama Type Client</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrClientJenis"></div>
		<?php echo form_dropdown('selClientJenis', $client_jenis_opts, $client_jenis_kd, array('id' => 'idSelClientJenis', 'class' => 'form-control')); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtNm" class="col-sm-2 control-label">Nama Client</label>
	<div class="col-sm-6 col-xs-6">
		<div id="idErrNm"></div>
		<?php echo form_input(array('name' => 'txtNm', 'id' => 'idTxtNm', 'class' => 'form-control', 'value' => $nm_client, 'placeholder' => 'Nama Client')); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtAlamat" class="col-sm-2 control-label">Alamat</label>
	<div class="col-sm-6 col-xs-6">
		<div id="idErrAlamat"></div>
		<?php echo form_textarea(array('name' => 'txtAlamat', 'id' => 'idTxtAlamat', 'class' => 'form-control', 'value' => $alamat, 'rows' => '5', 'placeholder' => 'Alamat')); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtBidangKerja" class="col-sm-2 control-label">Bidang Pekerjaan</label>
	<div class="col-sm-6 col-xs-6">
		<div id="idErrBidangKerja"></div>
		<?php echo form_input(array('name' => 'txtBidangKerja', 'id' => 'idTxtBidangKerja', 'class' => 'form-control', 'value' => $bidang_pekerjaan, 'placeholder' => 'Bidang Pekerjaan')); ?>
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