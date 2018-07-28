<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<script type="text/javascript">
	$('#<?php echo $field_focus; ?>').focus();
	$(document).off('submit', '#<?php echo $form_id; ?>').on('submit', '#<?php echo $form_id; ?>', function(e) {
		e.preventDefault();
		submit_form(this);
	});

	function submit_form(form_id) {
		$('#idAlert').slideUp();
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
						window.location.replace("<?php echo base_url('administrator/home'); ?>");
					}
					if (data.confirm == 'error') {
						<?php
						$no = 0;
						foreach ($form_errs as $form_err) {
							echo $no == 0?"":"\n\t\t\t\t\t\t";
							echo 'if (data.'.$form_err.' != \'\') {';
								echo '$(\'#'.$form_err.'\').html(data.'.$form_err.').slideDown();';
							echo '}';
							$no++;
						}
						echo "\n";
						?>
					}
				}
				if (data.alert != '') {
					$('#idAlert').html(data.alert).slideDown();
				}
				$('#<?php echo $field_focus; ?>').focus();
				$('input[name="<?php echo $this->config->item('csrf_token_name'); ?>"]').val(data.csrf);
			}
		});
	}
</script>