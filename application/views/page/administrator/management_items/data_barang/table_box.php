<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/* --START OF BOX DEFAULT PROPERTY-- */
$page_title = 'Data Barang';
$page_search = FALSE;
$box_title = 'Tabel Data Barang';
$box_type = 'Table';
$js_file = 'table_js';
/* --END OF BOX DEFAULT PROPERTY-- */

/* --START OF BOX BUTTON PROPERTY-- */
$btn_add = TRUE;
$btn_hide = TRUE;
$btn_close = TRUE;
/* --END OF BOX BUTTON PROPERTY-- */

/* --START OF BOX DATA PROPERTY-- */
$data['class_link'] = $class_link;
$data['box_alert_id'] = 'idAlertBox'.$box_type;
$data['box_loader_id'] = 'idLoaderBox'.$box_type;
$data['box_content_id'] = 'idContentBox'.$box_type;
$data['btn_add_id'] = 'idBtnAdd'.$box_type;
/* --END OF BOX DATA PROPERTY-- */
?>

<div class="page-title">
	<div class="title_left">
		<h3><?php echo $page_title; ?></h3>
	</div>
	<?php
	if ($page_search == TRUE) :
		?>
		<div class="title_right">
			<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search for...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Go!</button>
					</span>
				</div>
			</div>
		</div>
		<?php
	endif;
	?>
</div>

<div class="clearfix"></div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo $box_title; ?></h2>
				<ul class="nav navbar-right panel_toolbox">
					<?php
					if ($btn_hide == TRUE) :
						?>
						<li><a class="collapse-link" title="Sembunyikan"><i class="fa fa-chevron-up"></i></a></li>
						<?php
					endif;
					if ($btn_add == TRUE) :
						?>
						<li><a id="<?php echo $data['btn_add_id']; ?>" class="add-data-link" title="Tambah Data"><i class="fa fa-plus"></i></a></li>
						<?php
					endif;
					if ($btn_close == TRUE) :
						?>
						<li><a class="close-link" title="Tutup"><i class="fa fa-close"></i></a></li>
						<?php
					endif;
					?>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div id="<?php echo $data['box_alert_id']; ?>"></div>
				<div id="<?php echo $data['box_loader_id']; ?>" align="middle">
					<i class="fa fa-spinner fa-pulse fa-2x" style="color:#31708f;"></i>
				</div>
				<div id="<?php echo $data['box_content_id']; ?>"></div>
			</div>
		</div>
	</div>
	<?php $this->load->view('page/'.$class_link.'/'.$js_file, $data); ?>
</div>