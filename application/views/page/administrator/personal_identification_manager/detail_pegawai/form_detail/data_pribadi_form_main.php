<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/* --Masukkan setting properti untuk form-- */
$master_var = 'DataDetailKaryawan';
$form_id = 'idForm'.$master_var;
$data['class_link'] = $class_link;
$data['form_errs'] = $form_errs;
$data['page_name'] = $page_name;
echo form_open_multipart('', array('id' => $form_id, 'style' => 'margin-top: -15px;'));
echo form_input(array('type' => 'hidden', 'name' => 'txtKd', 'value' => $_SESSION['user']['detail_karyawan']['kd_karyawan']));
echo form_input(array('type' => 'hidden', 'name' => 'txtKdKaryawanInfo', 'value' => $detail_row->kd_karyawan_info));
?>
<div class="form-group col-sm-6 col-xs-12">
	<label for="idTxtNm">Nama Karyawan</label>
	<div>
		<div id="idErrNm"></div>
		<?php echo form_input(array('name' => 'txtNm', 'id' => 'idTxtNm', 'class' => 'form-control', 'value' => $detail_row->nm_karyawan, 'placeholder' => 'Nama Karyawan')); ?>
	</div>
</div>
<div class="form-group col-sm-6 col-xs-12">
	<label for="idFileFoto">Foto Karyawan</label>
	<div>
		<div id="idErrFoto"></div>
		<?php echo form_input(array('type' => 'hidden', 'name' => 'txtFileFotoLama', 'value' => $detail_row->foto_karyawan)); ?>
		<?php echo form_upload(array('name' => 'fileFoto', 'id' => 'idFileFoto', 'class' => 'form-control')); ?>
	</div>
</div>
<div class="form-group col-sm-6 col-xs-12">
	<label for="idTxtTmpLahir">Tempat Lahir</label>
	<div>
		<div id="idErrTmpLahir"></div>
		<?php echo form_input(array('name' => 'txtTmpLahir', 'id' => 'idTxtTmpLahir', 'class' => 'form-control', 'value' => $detail_row->tmp_lahir, 'placeholder' => 'Tempat Lahir')); ?>
	</div>
</div>
<div class="form-group col-sm-6 col-xs-12">
	<label for="idTxtTglLahir">Tanggal Lahir</label>
	<div>
		<div id="idErrTglLahir"></div>
		<?php echo form_input(array('name' => 'txtTglLahir', 'id' => 'idTxtTglLahir', 'class' => 'form-control', 'value' => $detail_row->tgl_lahir, 'placeholder' => 'Tanggal Lahir')); ?>
	</div>
</div>
<div class="form-group col-sm-12 col-xs-12">
	<label for="idTxtAlamat">Alamat</label>
	<div>
		<div id="idErrAlamat"></div>
		<?php echo form_textarea(array('name' => 'txtAlamat', 'id' => 'idTxtAlamat', 'class' => 'form-control', 'rows' => '5', 'value' => $detail_row->alamat, 'placeholder' => 'Alamat')); ?>
	</div>
</div>
<div class="form-group col-sm-6 col-xs-12">
	<label for="idTxtTelpUtama">Telp Utama</label>
	<div>
		<div id="idErrTelpUtama"></div>
		<?php echo form_input(array('name' => 'txtTelpUtama', 'id' => 'idTxtTelpUtama', 'class' => 'form-control', 'value' => $detail_row->no_telp_utama, 'placeholder' => 'Telp Utama')); ?>
	</div>
</div>
<div class="form-group col-sm-6 col-xs-12">
	<label for="idTxtTelpLain">Telp Lain</label>
	<div>
		<div id="idErrTelpLain"></div>
		<?php echo form_input(array('name' => 'txtTelpLain', 'id' => 'idTxtTelpLain', 'class' => 'form-control', 'value' => $detail_row->no_telp_lain, 'placeholder' => 'Telp Lain')); ?>
	</div>
</div>
<div class="form-group col-sm-6 col-xs-12">
	<label for="idTxtEmailUtama">Email Utama</label>
	<div>
		<div id="idErrEmailUtama"></div>
		<?php echo form_input(array('name' => 'txtEmailUtama', 'id' => 'idTxtEmailUtama', 'class' => 'form-control', 'value' => $detail_row->email_utama, 'placeholder' => 'Email Utama')); ?>
	</div>
</div>
<div class="form-group col-sm-6 col-xs-12">
	<label for="idTxtEmailLain">Email Lain</label>
	<div>
		<div id="idErrEmailLain"></div>
		<?php echo form_input(array('name' => 'txtEmailLain', 'id' => 'idTxtEmailLain', 'class' => 'form-control', 'value' => $detail_row->email_lain, 'placeholder' => 'Email Lain')); ?>
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
<?php
echo form_close();
$this->load->view('page/'.$class_link.'/exts/ext_form_js', $data);
?>

<script type="text/javascript">
	$(document).off('submit', '#idFormDataDetailKaryawan').on('submit', '#idFormDataDetailKaryawan', function(e) {
		e.preventDefault();
		submit_form(this);
	});
</script>
