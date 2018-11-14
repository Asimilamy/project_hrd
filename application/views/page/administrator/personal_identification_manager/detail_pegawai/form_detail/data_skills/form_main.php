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
		echo form_open_multipart('', array('id' => 'idFormSkill', 'class' => 'form-horizontal form-label-left'));
		echo form_input(array('type' => 'hidden', 'name' => 'txtKd', 'value' => $form_data->kd_karyawan_skill));
		?>
		<div class="form-group">
			<label for="idTxtSkill" class="control-label col-md-2 col-sm-12 col-xs-12">Nama Skill</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div id="idErrSkill"></div>
				<?php echo form_input(['name' => 'txtSkill', 'id' => 'idTxtSkill', 'class' => 'form-control', 'value' => $form_data->nm_skill, 'placeholder' => 'Nama Skill']); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="idSelLvl" class="control-label col-md-2 col-sm-12 col-xs-12">Level Skill</label>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div id="idErrLevel"></div>
				<?php echo form_dropdown('selLevel', ['' => '-- Pilih Level --', 'belajar' => 'Belajar', 'sedang' => 'Sedang', 'mahir' => 'Mahir'], $form_data->lvl_skill, ['id' => 'idSelLvl', 'class' => 'form-control']); ?>
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
		open_detail_page({'file_type' : 'table'});
		$('.form-err-class').slideUp();
	});
	
	$(document).off('submit', '#idFormSkill').on('submit', '#idFormSkill', function(e) {
		e.preventDefault();
		submit_form(this);
	});
</script>
