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
		echo form_open_multipart('', array('id' => 'idFormAsuransi', 'class' => 'form-horizontal form-label-left'));
		echo form_input(array('type' => 'hidden', 'name' => 'txtKd', 'value' => $form_data->kd_karyawan_asuransi));
		echo form_input(array('type' => 'hidden', 'name' => 'txtKdKaryawan', 'value' => $_SESSION['user']['detail_karyawan']['kd_karyawan']));
		?>
		<div class="form-group">
			<label for="idSelAsuransi" class="control-label col-md-2 col-sm-12 col-xs-12">Nama Asuransi</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div id="idErrAsuransi"></div>
				<?php echo form_dropdown('selAsuransi', $opts_asuransi, $form_data->asuransi_kd, array('id' => 'idSelAsuransi', 'class' => 'form-control',)); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idTxtNoAsuransi" class="control-label col-md-2 col-sm-12 col-xs-12">No Asuransi</label>
			<div class="col-md-4 col-sm-12 col-xs-12">
				<div id="idErrNoAsuransi"></div>
				<?php echo form_input(array('name' => 'txtNoAsuransi', 'id' => 'idTxtNoAsuransi', 'class' => 'form-control', 'value' => $form_data->no_asuransi, 'placeholder' => 'No Asuransi')); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idTxtTglMasuk" class="control-label col-md-2 col-sm-12 col-xs-12">Tgl Masuk</label>
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div id="idErrTglMasuk"></div>
				<?php echo form_input(array('name' => 'txtTglMasuk', 'id' => 'idTxtTglMasuk', 'class' => 'form-control datetimepicker', 'value' => $form_data->tgl_masuk, 'placeholder' => 'Tgl Masuk')); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idSelStatusAsuransi" class="control-label col-md-2 col-sm-12 col-xs-12">Status Asuransi</label>
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div id="idErrStatusAsuransi"></div>
				<?php echo form_dropdown('selStatusAsuransi', ['' => '-- Pilih Status Asuransi --', 'aktif' => 'Aktif', 'tidak aktif' => 'Tidak Aktif'], $form_data->status_asuransi, array('id' => 'idSelStatusAsuransi', 'class' => 'form-control',)); ?>
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
		open_detail_page({'file_type' : 'table', 'page_name': '<?php echo $page_name; ?>'});
		$('.form-err-class').slideUp();
	});
	
	$(document).off('submit', '#idFormAsuransi').on('submit', '#idFormAsuransi', function(e) {
		e.preventDefault();
		submit_form(this);
	});
</script>
