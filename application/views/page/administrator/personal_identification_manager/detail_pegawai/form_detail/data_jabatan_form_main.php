<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/* --Masukkan setting properti untuk form-- */
$master_var = 'DataJabatanKaryawan';
$form_id = 'idForm'.$master_var;
$data['class_link'] = $class_link;
$data['form_errs'] = $form_errs;
$data['page_name'] = $page_name;
$kd_karyawan_jabatan = !empty($detail_row->kd_karyawan_jabatan)?$detail_row->kd_karyawan_jabatan:'';
$unit_kd = !empty($detail_row->unit_kd)?$detail_row->unit_kd:'';
$bagian_kd = !empty($detail_row->bagian_kd)?$detail_row->bagian_kd:'';
$jabatan_kd = !empty($detail_row->jabatan_kd)?$detail_row->jabatan_kd:'';
$status_kerja_kd = !empty($detail_row->status_kerja_kd)?$detail_row->status_kerja_kd:'';
echo form_open_multipart('', array('id' => $form_id, 'style' => 'margin-top: -15px;'));
echo form_input(array('type' => 'hidden', 'name' => 'txtKd', 'value' => $kd_karyawan_jabatan));
?>
<div class="form-group col-sm-6 col-xs-12">
	<label for="idSelUnit">Nama Unit</label>
	<div>
		<div id="idErrUnit"></div>
		<?php echo form_dropdown('selUnit', $opts_unit, $unit_kd, ['id' => 'idSelUnit', 'class' => 'form-control']); ?>
	</div>
</div>
<div class="form-group col-sm-6 col-xs-12">
	<label for="idSelBagian">Nama Bagian</label>
	<div>
		<div id="idErrBagian"></div>
		<?php echo form_dropdown('selBagian', $opts_bagian, $bagian_kd, ['id' => 'idSelBagian', 'class' => 'form-control']); ?>
	</div>
</div>
<div class="form-group col-sm-6 col-xs-12">
	<label for="idSelJabatan">Nama Jabatan</label>
	<div>
		<div id="idErrJabatan"></div>
		<?php echo form_dropdown('selJabatan', $opts_jabatan, $jabatan_kd, ['id' => 'idSelJabatan', 'class' => 'form-control']); ?>
	</div>
</div>
<div class="form-group col-sm-6 col-xs-12">
	<label for="idSelStatusKerja">Status Kerja</label>
	<div>
		<div id="idErrStatusKerja"></div>
		<?php echo form_dropdown('selStatusKerja', $opts_status_kerja, $status_kerja_kd, ['id' => 'idSelStatusKerja', 'class' => 'form-control']); ?>
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
	$(document).off('submit', '#idFormDataJabatanKaryawan').on('submit', '#idFormDataJabatanKaryawan', function(e) {
		e.preventDefault();
		submit_form(this);
	});
</script>
