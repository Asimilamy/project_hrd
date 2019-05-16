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
		echo form_input(array('type' => 'hidden', 'name' => 'txtKd', 'value' => $form_data->kd_karyawan_keluarga));
		echo form_input(array('type' => 'hidden', 'name' => 'txtKdKaryawan', 'value' => $_SESSION['user']['detail_karyawan']['kd_karyawan']));
		?>
		<div class="form-group">
			<label for="idTxtNmKeluarga" class="control-label col-md-2 col-sm-12 col-xs-12">Nama Keluarga</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div id="idErrNamaKeluarga"></div>
				<?php echo form_input(['name' => 'txtNmKeluarga', 'id' => 'idTxtNmKeluarga', 'class' => 'form-control', 'value' => $form_data->nm_keluarga, 'placeholder' => 'Nama Keluarga']); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idTxtAlamat" class="control-label col-md-2 col-sm-12 col-xs-12">Alamat</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div id="idErrAlamat"></div>
				<?php echo form_textarea(array('name' => 'txtAlamat', 'id' => 'idTxtAlamat', 'class' => 'form-control', 'value' => $form_data->alamat, 'placeholder' => 'Alamat', 'rows' => '5')); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idSelHubungan" class="control-label col-md-2 col-sm-12 col-xs-12">Hubungan</label>
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div id="idErrHubungan"></div>
				<?php echo form_dropdown('selHubungan', ['' => '-- Pilih Hubungan --', 'orangtua' => 'Orangtua', 'pasangan' => 'Pasangan', 'anak' => 'Anak', 'saudara kandung' => 'Saudara Kandung'], $form_data->hubungan, ['id' => 'idSelHubungan', 'class' => 'form-control']); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idTxtTelp" class="control-label col-md-2 col-sm-12 col-xs-12">Telp Utama</label>
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div id="idErrTelpUtama"></div>
				<?php echo form_input(['name' => 'txtTelp', 'id' => 'idTxtTelp', 'class' => 'form-control', 'value' => $form_data->telp_utama, 'placeholder' => 'Telp Utama']); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idTxtEmail" class="control-label col-md-2 col-sm-12 col-xs-12">Email Utama</label>
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div id="idErrEmailUtama"></div>
				<?php echo form_input(['name' => 'txtEmail', 'id' => 'idTxtEmail', 'class' => 'form-control', 'value' => $form_data->email_utama, 'placeholder' => 'Email Utama']); ?>
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
