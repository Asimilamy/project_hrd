<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<script type="text/javascript">
	open_form('<?php echo $id; ?>');
	first_load('<?php echo $box_loader_id; ?>', '<?php echo $box_content_id; ?>');

	$(document).off('submit', '#idFormDataSysAppareance').on('submit', '#idFormDataSysAppareance', function(e) {
		e.preventDefault();
		submit_form(this);
	});

	function moveTo(element) {
		$('html, body').animate({ scrollTop: $(element).offset().top - $('header').height() }, 'fast');
	}

	function first_load(loader, content) {
		$('#'+loader).fadeOut(500, function(e){
			$('#'+content).slideDown();
		});
	}

	function open_form(id) {
		$('#<?php echo $box_content_id; ?>').slideUp(function(){
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url().$class_link.'/open_form'; ?>',
				data: 'id='+id,
				success: function(html) {
					$('#<?php echo $box_content_id; ?>').html(html);
					$('#<?php echo $box_content_id; ?>').slideDown();
					moveTo('.main_container');
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
			url: "<?php echo base_url().$class_link.'/send_data'; ?>",
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
						$('#<?php echo $box_alert_id; ?>').html(data.alert);
					}
					if (data.confirm == 'error') {
						$('#<?php echo $box_alert_id; ?>').html(data.alert);
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
				moveTo('.main_container');
				$('input[name="<?php echo $this->config->item('csrf_token_name'); ?>"]').val(data.csrf);
				$('input[type="file"]').val('');
			}
		});
	}
</script>