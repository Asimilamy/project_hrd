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
		echo form_input(array('type' => 'hidden', 'name' => 'page_name', 'value' => $page_name));
		echo form_input(array('type' => 'hidden', 'name' => 'txtKd', 'value' => $form_data->kd_karyawan_asuransi_pembayaran));
		echo form_input(array('type' => 'hidden', 'name' => 'txtKdAsuransiKaryawan', 'value' => $form_data->karyawan_asuransi_kd));
		echo form_input(array('type' => 'hidden', 'name' => 'txtKdKaryawan', 'value' => $form_data->karyawan_kd));
		echo form_input(array('type' => 'hidden', 'name' => 'txtKdClient', 'value' => $form_data->client_kd));
		?>
		<div class="form-group">
			<label for="idTxtTglBayar" class="control-label col-md-2 col-sm-12 col-xs-12">Tgl Bayar</label>
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div id="idErrTglBayar"></div>
				<?php echo form_input(array('name' => 'txtTglBayar', 'id' => 'idTxtTglBayar', 'class' => 'form-control datetimepicker', 'value' => $form_data->tgl_bayar, 'placeholder' => 'Tgl Bayar')); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idTxtJmlBayar" class="control-label col-md-2 col-sm-12 col-xs-12">Jml Bayar</label>
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div id="idErrJmlBayar"></div>
				<?php echo form_input(array('name' => 'txtJmlBayar', 'id' => 'idTxtJmlBayar', 'class' => 'form-control', 'value' => $form_data->jml_bayar, 'placeholder' => 'Jml Bayar')); ?>
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
