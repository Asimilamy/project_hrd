<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$data['class_link'] = $class_link;
$data['form_errs'] = $form_errs;
$data['page_name'] = $page_name;
?>
<button type="button" name="btnAdd" id="idBtnAdd" class="btn btn-warning btn-flat pull-right btn-close-form" title="Tutup Form">
	<i class="fa fa-times"></i> Tutup Form
</button>
<div class="row">
	<div class="col-md-12">
		<?php
		echo form_open_multipart('', array('id' => 'idFormKontrak', 'class' => 'form-horizontal form-label-left'));
		echo form_input(array('type' => 'hidden', 'name' => 'txtKd', 'value' => $form_data->kd_karyawan_kontrak));
		?>
		<div class="form-group">
			<label for="idSelClient" class="control-label col-md-2 col-sm-12 col-xs-12">Nama Client</label>
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div id="idErrClient"></div>
				<?php echo form_dropdown('selClient', $opts_client, $form_data->client_kd, ['id' => 'idSelClient', 'class' => 'form-control']); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idTxtUnit" class="control-label col-md-2 col-sm-12 col-xs-12">Unit Kontrak</label>
			<div class="col-md-4 col-sm-12 col-xs-12">
				<div id="idErrUnit"></div>
				<?php echo form_input(array('name' => 'txtUnit', 'id' => 'idTxtUnit', 'class' => 'form-control', 'value' => $form_data->unit_kontrak, 'placeholder' => 'Unit Kontrak')); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idTxtBagian" class="control-label col-md-2 col-sm-12 col-xs-12">Bagian Kontrak</label>
			<div class="col-md-4 col-sm-12 col-xs-12">
				<div id="idErrBagian"></div>
				<?php echo form_input(array('name' => 'txtBagian', 'id' => 'idTxtBagian', 'class' => 'form-control', 'value' => $form_data->bagian_kontrak, 'placeholder' => 'Bagian Kontrak')); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idTxtJabatan" class="control-label col-md-2 col-sm-12 col-xs-12">Jabatan Kontrak</label>
			<div class="col-md-4 col-sm-12 col-xs-12">
				<div id="idErrJabatan"></div>
				<?php echo form_input(array('name' => 'txtJabatan', 'id' => 'idTxtJabatan', 'class' => 'form-control', 'value' => $form_data->jabatan_kontrak, 'placeholder' => 'Jabatan Kontrak')); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idTxtTglMulai" class="control-label col-md-2 col-sm-12 col-xs-12">Tgl Mulai</label>
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div id="idErrTglMulai"></div>
				<?php echo form_input(array('name' => 'txtTglMulai', 'id' => 'idTxtTglMulai', 'class' => 'form-control datetimepicker', 'value' => $form_data->tgl_mulai, 'placeholder' => 'Tgl Mulai')); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idTxtTglHabis" class="control-label col-md-2 col-sm-12 col-xs-12">Tgl Habis</label>
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div id="idErrTglHabis"></div>
				<?php echo form_input(array('name' => 'txtTglHabis', 'id' => 'idTxtTglHabis', 'class' => 'form-control datetimepicker', 'value' => $form_data->tgl_habis, 'placeholder' => 'Tgl Habis')); ?>
			</div>
		</div>
		<hr>
		<div class="form-group col-sm-offset-6 col-sm-6 col-xs-12">
				<button type="reset" name="btnReset" class="btn btn-default btn-flat">
					<i class="fa fa-refresh"></i> Reset
				</button>
				<button type="submit" name="btnSubmit" class="btn btn-primary btn-flat">
					<i class="fa fa-save"></i> Submit
				</button>
		</div>
	</div>
</div>
<?php
echo form_close();
$this->load->view('page/'.$class_link.'/exts/ext_form_js', $data);
?>

<script type="text/javascript">
	$('.form-err-class').slideUp();
	
	$(document).off('click', '.btn-close-form').on('click', '.btn-close-form', function() {
		open_detail_page({'file_type' : 'table'});
		$('.form-err-class').slideUp();
	});
	
	$(document).off('submit', '#idFormKontrak').on('submit', '#idFormKontrak', function(e) {
		e.preventDefault();
		submit_form(this);
	});
</script>
