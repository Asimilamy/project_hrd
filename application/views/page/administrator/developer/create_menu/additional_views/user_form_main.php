<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<div class="form_group_user_access">
	<div class="form-group">
		<label for="idSelMasterType<?php echo $btn_inc; ?>" class="col-sm-2 control-label">Pilih Tipe Admin</label>
		<div class="col-sm-4 col-xs-4">
			<?php echo form_dropdown('selMasterType['.$btn_inc.']', $master_type_opts, '', array('id' => 'idSelMasterType'.$btn_inc, 'class' => 'form-control')); ?>
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
	<div class="form-group">
		<label class="col-sm-2 control-label"></label>
		<div class="col-sm-2 col-xs-2">
			<div class="checkbox">
				<label for="idChkAccessCreate<?php echo $btn_inc; ?>">
					<?php echo form_checkbox('chkAccessCreate['.$btn_inc.']', '1', FALSE, array('id' => 'idChkAccessCreate'.$btn_inc,'class' => 'flat')); ?>
					Create Access
				</label>
			</div>
		</div>
		<div class="col-sm-2 col-xs-2">
			<div class="checkbox">
				<label for="idChkAccessRead<?php echo $btn_inc; ?>">
					<?php echo form_checkbox('chkAccessRead['.$btn_inc.']', '1', FALSE, array('id' => 'idChkAccessRead'.$btn_inc,'class' => 'flat')); ?>
					Read Access
				</label>
			</div>
		</div>
		<div class="col-sm-2 col-xs-2">
			<div class="checkbox">
				<label for="idChkAccessUpdate<?php echo $btn_inc; ?>">
					<?php echo form_checkbox('chkAccessUpdate['.$btn_inc.']', '1', FALSE, array('id' => 'idChkAccessUpdate'.$btn_inc,'class' => 'flat')); ?>
					Update Access
				</label>
			</div>
		</div>
		<div class="col-sm-2 col-xs-2">
			<div class="checkbox">
				<label for="idChkAccessDelete<?php echo $btn_inc; ?>">
					<?php echo form_checkbox('chkAccessDelete['.$btn_inc.']', '1', FALSE, array('id' => 'idChkAccessDelete'.$btn_inc,'class' => 'flat')); ?>
					Delete Access
				</label>
			</div>
		</div>
	</div>
</div>
