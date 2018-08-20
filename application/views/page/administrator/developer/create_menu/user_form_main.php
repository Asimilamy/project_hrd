<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<div class="form-group">
	<label for="idSelMasterType" class="col-sm-2 control-label">Pilih Tipe Admin</label>
	<div class="col-sm-4 col-xs-4">
		<div id="idErrGlobal"></div>
		<?php echo form_dropdown('selMasterType[]', $master_type_opts, '', array('id' => 'idSelMasterType', 'class' => 'form-control')); ?>
	</div>
	<div class="col-sm-1 col-xs-1">
		<?php
		if ($btn_inc < 1) :
			echo form_button(array('type' => 'button', 'id' => 'idBtnAddUser', 'class' => 'btn btn-success btn-add-user', 'title' => 'Tambah User Access', 'content' => '<i class="fa fa-plus"></i>'));
		else :
			echo form_button(array('type' => 'button', 'id' => 'idBtnRemoveUser', 'class' => 'btn btn-danger btn-remove-user', 'title' => 'Hapus User Access', 'content' => '<i class="fa fa-trash"></i>'));
		endif;
		?>
	</div>
</div>