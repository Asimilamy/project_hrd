<?php
defined('BASEPATH') or exit('No direct script script access allowed!');

/* --Masukkan setting properti untuk form-- */
$master_var = 'DataBarang';
$form_id = 'idForm'.$master_var;
echo form_open_multipart('', array('id' => $form_id, 'class' => 'form-horizontal'));
echo form_input(array('type' => 'hidden', 'name' => 'txtKd', 'value' => $kd_mbarang));
?>
<div class="form-group">
	<label for="idSelType" class="col-sm-2 control-label">Master Type</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrType"></div>
		<?php echo form_dropdown('selType', array('' => '--Pilih Type--'), $master_type_kd, array('id' => 'idSelType', 'class' => 'form-control')); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtBarcode" class="col-sm-2 control-label">Barcode</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrBarcode"></div>
		<?php echo form_input(array('name' => 'txtBarcode', 'id' => 'idTxtBarcode', 'class' => 'form-control', 'placeholder' => 'Barcode', 'value' => $barcode)); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtNmBarang" class="col-sm-2 control-label">Nama Barang</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrNmBarang"></div>
		<?php echo form_input(array('name' => 'txtNmBarang', 'id' => 'idTxtNmBarang', 'class' => 'form-control', 'placeholder' => 'Nama Barang', 'value' => $nm_barang)); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtDeskripsi" class="col-sm-2 control-label">Deskripsi</label>
	<div class="col-sm-6 col-xs-6">
		<div id="idErrDeskripsi"></div>
		<?php echo form_textarea(array('name' => 'txtDeskripsi', 'id' => 'idTxtDeskripsi', 'class' => 'form-control', 'placeholder' => 'Deskripsi'), $deskripsi); ?>
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