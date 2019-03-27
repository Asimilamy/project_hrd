<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<script type="text/javascript">
	open_form('<?php echo $id; ?>');
	first_load('<?php echo $box_loader_id; ?>', '<?php echo $box_content_id; ?>');

	$(document).off('click', '#<?php echo $btn_close_id; ?>').on('click', '#<?php echo $btn_close_id; ?>', function() {
		$('#idLoaderBoxTable').show();
		$('#idContentBoxTable').html();
		open_table();
		remove_box('#<?php echo $box_id;?>');
		first_load('idLoaderBoxTable', 'idContentBoxTable');
	});

	$(document).off('submit', '#idFormDataStatusKerja').on('submit', '#idFormDataStatusKerja', function(e) {
		e.preventDefault();
		submit_form(this);
	});

	function open_form(id) {
		$('#<?php echo $box_content_id; ?>').slideUp(function(){
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url($class_link.'/open_form'); ?>',
				data: 'id='+id,
				success: function(html) {
					$('#<?php echo $box_content_id; ?>').html(html);
					$('#<?php echo $box_content_id; ?>').slideDown();
					moveTo('.main_container');
					$('#idTxtNim').focus();
					$('.iCheck').iCheck({
						checkboxClass: 'icheckbox_flat-blue'
					});
				}
			});
		});
	}

	function submit_form(form_id) {
		$('#<?php echo $box_alert_id; ?>').html('');
		<?php
		$no = 0;
		foreach ($form_errs as $form_err) {
			echo $no == 0?"":"\n\t\t";
			echo '$(\'#'.$form_err.'\').slideUp();';
			$no++;
		}
		echo "\n";
		?>
		$.ajax({
			url: "<?php echo base_url($class_link.'/send_data'); ?>",
			type: "POST",
			data:  new FormData(form_id),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				if (data.alert_stat == 'online') {
					if(!alert(data.csrf_alert)){window.location.reload();}
				} else if (data.alert_stat == 'offline') {
					if (data.confirm == 'success') {
						remove_box('#<?php echo $box_id;?>');
						$('#idAlertBoxTable').html(data.alert).fadeIn();
						open_table();
					}
					if (data.confirm == 'error') {
						$('#<?php echo $box_alert_id; ?>').html(data.alert);
						<?php
						$no = 0;
						foreach ($form_errs as $form_err) {
							echo $no == 0?"":"\n\t\t\t\t\t";
							echo 'if (data.'.$form_err.' != \'\') {';
								echo '$(\'#'.$form_err.'\').html(data.'.$form_err.').slideDown();';
							echo '}';
							$no++;
						}
						echo "\n";
						?>
					}
				}
				$('#idTxtNim').focus();
				$('input[name="<?php echo $this->config->item('csrf_token_name'); ?>"]').val(data.csrf);
			}
		});
	}
</script>