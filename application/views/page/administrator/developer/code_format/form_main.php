<?php
defined('BASEPATH') or exit('No direct script access allowed!');

$kata = ucwords(str_replace('_', ' ', $_SESSION['master_type_tipe']));
$master_var = 'CodeFormat';
$form_id = 'idForm'.$master_var;
if ($_SESSION['user']['access']['read']) :
	echo form_open_multipart('', array('id' => $form_id, 'class' => 'form-horizontal'));
	echo form_input(array('type' => 'hidden', 'name' => 'txtKd', 'value' => $kd_code_format));
	?>
	<div class="form-group">
		<label for="idTxtNm" class="col-sm-2 control-label">Nama Code Format : </label>
		<div class="col-sm-4 col-xs-10">
			<div id="idErrNama"></div>
			<?php echo form_input(['type' => 'hidden', 'name' => 'txtCodeFor', 'value' => $_SESSION['master_type_tipe']]); ?>
			<?php echo form_input(array('name' => 'txtNm', 'id' => 'idTxtNm', 'class' => 'form-control', 'placeholder' => 'Nama Code Format', 'value' => $nm_code_format)); ?>
		</div>
	</div>
	<div class="form-group">
		<label for="idSelReset" class="col-sm-2 control-label">Code Reset : </label>
		<div class="col-sm-2 col-xs-10">
			<div id="idErrReset"></div>
			<?php echo form_dropdown('selReset', $reset_opts, $code_reset, array('id' => 'idSelReset', 'class' => 'form-control')); ?>
		</div>
	</div>
	<div class="cl-group-code-format"></div>
	<hr>
	<div class="form-group">
		<div class="col-sm-6 col-sm-offset-6 col-xs-12">
			<button type="button" name="btnKembali" id="idBtnKembali" class="btn btn-warning btn-flat" title="Kembali">
				<i class="fa fa-arrow-left"></i> Kembali
			</button>
			<button type="reset" name="btnReset" class="btn btn-default btn-flat">
				<i class="fa fa-refresh"></i> Reset
			</button>
			<button type="submit" name="btnSubmit" class="btn btn-primary btn-flat">
				<i class="fa fa-save"></i> Submit
			</button>
		</div>
	</div>
	<?php
	echo form_close();
endif;
