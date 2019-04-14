<?php
defined('BASEPATH') or exit('No direct script script access allowed!');
/* --Masukkan setting properti untuk form-- */
$master_var = 'Access';
$form_id = 'idForm'.$master_var;
?>

<div class="row">
	<?php
	echo form_open_multipart('', array('id' => $form_id, 'class' => 'form-horizontal'));
	?>
	<table class="table table-hover table-bordered table-striped">
		<thead>
			<tr>
				<td style="width: 52%;">Nama Menu</td>
				<td class="access-attr" style="width: 12%;">Create Access</td>
				<td class="access-attr" style="width: 12%;">Read Access</td>
				<td class="access-attr" style="width: 12%;">Update Access</td>
				<td class="access-attr" style="width: 12%;">Delete Access</td>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($menu_lvl_ones as $menu_lvl_one) :
				$user_access = isset($user_accesses->{$menu_lvl_one->kd_menu})?$user_accesses->{$menu_lvl_one->kd_menu}:'';
				echo render_menu_table($user_access, $menu_lvl_one);
				foreach ($menu_lvl_twos as $menu_lvl_two) :
					if ($menu_lvl_two->menu_parent == $menu_lvl_one->kd_menu) :
						$user_access = isset($user_accesses->{$menu_lvl_two->kd_menu})?$user_accesses->{$menu_lvl_two->kd_menu}:'';
						echo render_menu_table($user_access, $menu_lvl_two, 'col-sm-10 col-sm-offset-2 col-xs-11 col-xs-offset-1');
						foreach ($menu_lvl_threes as $menu_lvl_three) :
							if ($menu_lvl_three->menu_parent == $menu_lvl_two->kd_menu) :
								$user_access = isset($user_accesses->{$menu_lvl_three->kd_menu})?$user_accesses->{$menu_lvl_three->kd_menu}:'';
								echo render_menu_table($user_access, $menu_lvl_three, 'col-sm-8 col-sm-offset-4 col-xs-10 col-xs-offset-2');
							endif;
						endforeach;
					endif;
				endforeach;
			endforeach;
			?>
		</tbody>
	</table>
	<hr>
	<div class="form-group">
		<div class="col-xs-12 col-sm-4 col-sm-offset-8">
			<button type="submit" name="btnSubmit" class="btn btn-primary btn-flat pull-right">
				<i class="fa fa-save"></i> Submit
			</button>
			<button type="reset" name="btnReset" class="btn btn-default btn-flat pull-right">
				<i class="fa fa-refresh"></i> Reset
			</button>
		</div>
	</div>
	<?php echo form_close(); ?>
</div>

<style type="text/css">
	.access-attr {
		text-align: center;
	}
</style>