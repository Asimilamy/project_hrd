<?php
defined('BASEPATH') or exit('No direct script script access allowed!');

/* --Masukkan setting properti untuk form-- */
$master_var = 'FilterKaryawan';
$form_id = 'idForm'.$master_var;
echo form_open_multipart('', array('id' => $form_id, 'style' => 'margin-top: -15px;'));
?>
<div class="row" style="margin-top: 15px;">
	<div class="form-group col-sm-3 col-xs-12">
		<label for="idSelStatusKerja">Status Kerja</label>
		<div>
			<?php echo form_dropdown('selStatusKerja', $opts_status_kerja, '', ['id' => 'idSelStatusKerja', 'class' => 'form-control']); ?>
		</div>
	</div>
	<div class="form-group col-sm-3 col-xs-12">
		<label for="idSelPerusahaan">Nama Perusahaan</label>
		<div>
			<?php echo form_dropdown('selPerusahaan', $opts_client, '', ['id' => 'idSelPerusahaan', 'class' => 'form-control']); ?>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group col-sm-3 col-xs-12">
		<label for="idSelUnit">Nama Unit</label>
		<div>
			<?php echo form_dropdown('selUnit', $opts_unit, '', ['id' => 'idSelUnit', 'class' => 'form-control']); ?>
		</div>
	</div>
	<div class="form-group col-sm-3 col-xs-12">
		<label for="idSelBagian">Nama Bagian</label>
		<div>
			<?php echo form_dropdown('selBagian', $opts_bagian, '', ['id' => 'idSelBagian', 'class' => 'form-control']); ?>
		</div>
	</div>
	<div class="form-group col-sm-3 col-xs-12">
		<label for="idSelJabatan">Nama Jabatan</label>
		<div>
			<?php echo form_dropdown('selJabatan', $opts_jabatan, '', ['id' => 'idSelJabatan', 'class' => 'form-control']); ?>
		</div>
	</div>
</div>
<hr>
<div class="form-group col-sm-3 col-xs-12">
	<button type="reset" name="btnReset" class="btn btn-default btn-sm btn-flat">
		<i class="fa fa-refresh"></i> Reset
	</button>
	<button type="submit" name="btnSubmit" class="btn btn-warning btn-sm btn-flat">
		<i class="fa fa-search"></i> Filter Data
	</button>
</div>
<?php echo form_close(); ?>