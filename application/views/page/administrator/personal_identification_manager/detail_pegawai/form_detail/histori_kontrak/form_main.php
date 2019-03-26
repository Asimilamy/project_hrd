<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$data['class_link'] = $class_link;
$data['form_errs'] = $form_errs;
$data['page_name'] = $page_name;
$is_show_client = $form_data->type_karyawan == 'outsourcing'?'':'style="display: none;"';
$is_show_contract = $form_data->has_contract == '0'?'style="display: none;"':'';
$_SESSION['user']['detail_karyawan']['has_contract'] = $form_data->has_contract;
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
			<label for="idSelTypeKaryawan" class="control-label col-md-2 col-sm-12 col-xs-12">Type Karyawan</label>
			<div class="col-md-4 col-sm-12 col-xs-12">
				<div id="idErrTypeKaryawan"></div>
				<?php echo form_dropdown('selTypeKaryawan', $opts_type_karyawan, $form_data->type_karyawan, ['id' => 'idSelTypeKaryawan', 'class' => 'form-control']); ?>
			</div>
		</div>
		<div id="idFormClient" class="form-group" <?php echo $is_show_client; ?>>
			<label for="idSelClient" class="control-label col-md-2 col-sm-12 col-xs-12">Nama Client</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div id="idErrClient"></div>
				<?php echo form_dropdown('selClient', $opts_client, $form_data->client_kd, ['id' => 'idSelClient', 'class' => 'form-control']); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idSelUnit" class="control-label col-md-2 col-sm-12 col-xs-12">Unit</label>
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div id="idErrUnit"></div>
				<?php echo form_dropdown('selUnit', $opts_unit, $form_data->unit_kd, ['id' => 'idSelUnit', 'class' => 'form-control']); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idSelBagian" class="control-label col-md-2 col-sm-12 col-xs-12">Bagian</label>
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div id="idErrBagian"></div>
				<?php echo form_dropdown('selBagian', $opts_bagian, $form_data->bagian_kd, ['id' => 'idSelBagian', 'class' => 'form-control']); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idSelJabatan" class="control-label col-md-2 col-sm-12 col-xs-12">Jabatan</label>
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div id="idErrJabatan"></div>
				<?php echo form_dropdown('selJabatan', $opts_jabatan, $form_data->jabatan_kd, ['id' => 'idSelJabatan', 'class' => 'form-control']); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idSelStatusKerja" class="control-label col-md-2 col-sm-12 col-xs-12">Status Kerja</label>
			<div class="col-md-4 col-sm-12 col-xs-12">
				<div id="idErrStatusKerja"></div>
				<?php echo form_dropdown('selStatusKerja', $opts_status_kerja, $form_data->status_kerja_kd, ['id' => 'idSelStatusKerja', 'class' => 'form-control']); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idTxtTglMulai" class="control-label col-md-2 col-sm-12 col-xs-12">Tgl Mulai</label>
			<div class="col-md-5 col-sm-12 col-xs-12">
				<div id="idErrTglMulai"></div>
				<?php echo form_input(array('name' => 'txtTglMulai', 'id' => 'idTxtTglMulai', 'class' => 'form-control datetimepicker', 'value' => $form_data->tgl_mulai, 'placeholder' => 'Tgl Mulai')); ?>
			</div>
		</div>
		<div id="idFormTglHabis" class="form-group" <?php echo $is_show_contract; ?>>
			<label for="idTxtTglHabis" class="control-label col-md-2 col-sm-12 col-xs-12">Tgl Habis</label>
			<div class="col-md-5 col-sm-12 col-xs-12">
				<div id="idErrTglHabis"></div>
				<?php echo form_input(array('name' => 'txtTglHabis', 'id' => 'idTxtTglHabis', 'class' => 'form-control datetimepicker', 'value' => $form_data->tgl_habis, 'placeholder' => 'Tgl Habis')); ?>
			</div>
		</div>
		<hr>
		<div class="form-group col-sm-offset-6 col-sm-6 col-xs-12">
				<button type="button" name="btnReset" class="btn btn-default btn-flat">
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

	$(document).off('change', '#idSelTypeKaryawan').on('change', '#idSelTypeKaryawan', function() {
		var type_karyawan = $(this).val();
		type_karyawan_change(type_karyawan);
	});

	$(document).off('change', '#idSelStatusKerja').on('change', '#idSelStatusKerja', function() {
		var kd_status_kerja = $(this).val();
		status_kerja_change(kd_status_kerja);
	});

	$(document).off('click', 'button[name="btnReset"]').on('click', 'button[name="btnReset"]', function() {
		type_karyawan_change('');
		status_kerja_change('<?php echo $form_data->has_contract; ?>');
		$('#idFormKontrak').trigger('reset');
	});

	function type_karyawan_change(type_karyawan) {
		if (type_karyawan == 'internal') {
			$('#idFormClient').slideUp();
		} else if (type_karyawan == 'outsourcing') {
			$('#idFormClient').slideDown();
		} else {
			$('#idFormClient').slideUp();
		}
	}

	function status_kerja_change(kd_status_kerja) {
		$.ajax({
			url: "<?php echo base_url($class_link.'/define_status_kerja'); ?>",
			type: "GET",
			data:  {'kd_status_kerja': kd_status_kerja},
			success: function(data){
				show_tgl_habis(data.has_contract);
			}
		});
	}

	function show_tgl_habis(has_contract) {
		if (has_contract == '0') {
			$('#idFormTglHabis').slideUp();
		} else if (has_contract == '1') {
			$('#idFormTglHabis').slideDown();
		}
	}
</script>
