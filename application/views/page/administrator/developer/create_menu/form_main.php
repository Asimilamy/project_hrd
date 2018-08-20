<?php
defined('BASEPATH') or exit('No direct script script access allowed!');

/* --Masukkan setting properti untuk form-- */
$master_var = 'DataMasterType';
$form_id = 'idForm'.$master_var;
echo form_open_multipart('', array('id' => $form_id, 'class' => 'form-horizontal'));
echo form_input(array('type' => 'hidden', 'name' => 'txtKd', 'value' => $kd_menu));
?>
<div class="form-group">
	<label for="idSelParent" class="col-sm-2 control-label">Menu Parent</label>
	<div class="col-sm-4 col-xs-4">
		<?php echo form_dropdown('selParent', $menu_parent_opts, $menu_parent, array('id' => 'idSelParent', 'class' => 'form-control')); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtNm" class="col-sm-2 control-label">Nama Menu</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrNama"></div>
		<?php echo form_input(array('name' => 'txtNm', 'id' => 'idTxtNm', 'class' => 'form-control', 'placeholder' => 'Nama Menu', 'value' => $menu_nm)); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtLink" class="col-sm-2 control-label">Link Menu</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrLink"></div>
		<?php echo form_input(array('name' => 'txtLink', 'id' => 'idTxtLink', 'class' => 'form-control', 'placeholder' => 'Link Menu', 'value' => $menu_link)); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtTitle" class="col-sm-2 control-label">Judul Menu</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrTitle"></div>
		<?php echo form_input(array('name' => 'txtTitle', 'id' => 'idTxtTitle', 'class' => 'form-control', 'placeholder' => 'Judul Menu', 'value' => $menu_title)); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtIcon" class="col-sm-2 control-label">Icon Menu</label>
	<div class="col-sm-4 col-xs-4">
		<?php echo form_input(array('name' => 'txtIcon', 'id' => 'idTxtIcon', 'class' => 'form-control', 'placeholder' => 'Icon Menu', 'value' => $menu_icon)); ?>
	</div>
</div>
<div class="form-group">
	<label for="idTxtOrder" class="col-sm-2 control-label">Urutan Menu</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrOrder"></div>
		<?php echo form_input(array('name' => 'txtOrder', 'id' => 'idTxtOrder', 'class' => 'form-control', 'placeholder' => 'Urutan Menu', 'value' => $menu_order)); ?>
	</div>
</div>
<div class="form-group">
	<label for="idSelModul" class="col-sm-2 control-label">Modul Menu</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrModul"></div>
		<?php echo form_dropdown('selModul', $modul_menu_opts, $menu_modul, array('id' => 'idSelModul', 'class' => 'form-control')); ?>
	</div>
</div>
<div class="form-group">
	<label for="idSelGlobal" class="col-sm-2 control-label">Menu Global</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrGlobal"></div>
		<?php echo form_dropdown('selGlobal', array('' => '--Setting Menu Global--', '0' => 'Tidak', '1' => 'Ya'), $menu_global, array('id' => 'idSelGlobal', 'class' => 'form-control')); ?>
	</div>
</div>
<hr>
<div class="form-group">
	<div class="checkbox">
		<label for="idChkAccess">
			<?php echo form_checkbox('chkAccess', 'access', FALSE, array('id' => 'idChkAccess', 'class' => 'flat')); ?>
			Buat Hak Akses
		</label>
	</div>
</div>
<div class="form_user_access"></div>
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