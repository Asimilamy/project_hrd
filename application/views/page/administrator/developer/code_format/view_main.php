<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/* --Masukkan setting properti untuk form-- */
$kata = ucwords(str_replace('_', ' ', $_SESSION['master_type_tipe']));
if ($_SESSION['user']['access']['read']) :
	?>
	<div id="idContainerFormCodeFormat">
		<div class="form-horizontal">
			<div class="form-group">
				<label for="idTxtNm" class="col-sm-2 control-label">Nama Code Format : </label>
				<div class="col-sm-10 col-xs-12">
					<div id="idErrNama"></div>
					<?php echo form_input(array('type' => 'hidden', 'name' => 'txtKd', 'value' => $kd_code_format)); ?>
					<?php echo form_input(['type' => 'hidden', 'name' => 'txtCodeFor', 'value' => $_SESSION['master_type_tipe']]); ?>
					<label id="idTxtNm" class="col-sm-12" style="padding-top: 8px;"><?php echo empty($nm_code_format)?'-':$nm_code_format; ?></label>
				</div>
			</div>
			<div class="form-group">
				<label for="idSelReset" class="col-sm-2 control-label">Code Reset : </label>
				<div class="col-sm-10 col-xs-12">
					<div id="idErrReset"></div>
					<label id="idSelReset" class="col-sm-12" style="padding-top: 8px;"><?php echo empty($code_reset)?'-':$code_reset; ?></label>
				</div>
			</div>
			<div class="form-group">
				<label for="idTxtCodeFormat" class="col-sm-2 control-label">Code Format : </label>
				<div class="col-sm-10 col-xs-12">
					<div id="idErrFormat"></div>
					<label id="idTxtCodeFormat" class="col-sm-12" style="padding-top: 8px;"><?php echo empty($code_format)?'-':$code_format; ?></label>
				</div>
			</div>
			<div class="form-group">
				<label for="idTxtContoh" class="col-sm-2 control-label">Contoh Code : </label>
				<div class="col-sm-10 col-xs-12">
					<div id="idErrContoh"></div>
					<label id="idTxtContoh" class="col-sm-12" style="padding-top: 8px;"><?php echo empty($contoh_code)?'-':$contoh_code; ?></label>
				</div>
			</div>
			<hr>
			<div class="form-group">
				<div class="col-sm-1 col-sm-offset-2 col-xs-12">
					<button type="button" name="btnUbah" id="idBtnUbah" class="btn btn-primary btn-flat" title="Ubah Format - <?php echo $kata; ?>">
						<i class="fa fa-pencil"></i> Ubah Format - <?php echo $kata; ?>
					</button>
				</div>
			</div>
		</div>
	</div>
	<?php
endif;
