<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<div id="<?php echo $data['box_id']; ?>" class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo $box_type.' '.$page_title; ?></h2>
				<ul class="nav navbar-right panel_toolbox" <?php echo $btn_add == TRUE && $_SESSION['user']['access']['create']?'':'style="margin-right: -20px;"'; ?>>
					<?php
					if ($btn_hide == TRUE) :
						?>
						<li><a id="<?php echo $data['btn_hide_id']; ?>" class="collapse-link" title="Sembunyikan"><i class="fa fa-chevron-up"></i></a></li>
						<?php
					endif;
					if ($btn_add == TRUE && $_SESSION['user']['access']['create']) :
						?>
						<li><a id="<?php echo $data['btn_add_id']; ?>" class="add-data-link" title="Tambah Data"><i class="fa fa-plus"></i></a></li>
						<?php
					endif;
					if ($btn_close == TRUE) :
						?>
						<li><a id="<?php echo $data['btn_close_id']; ?>" class="close-link" title="Tutup"><i class="fa fa-close"></i></a></li>
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
	<?php $this->load->view('page/'.$data['class_link'].'/'.$js_file, $data); ?>
</div>