<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>

<script type="text/javascript">
	$(document).off('click', 'button[name="btnReset"]').on('click', 'button[name="btnReset"]', function() {
		<?php
		$no = 0;
		foreach ($form_errs as $form_err) {
			echo $no == 0?"":"\n\t\t";
			echo '$(\'#'.$form_err.'\').slideUp();';
			$no++;
		}
		echo "\n";
		?>
	});
	
	function submit_form(form_id) {
		$(form_id).parents('.box-page-detail-karyawan').prev('.form-err-class').slideUp();
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
			url: "<?php echo base_url($class_link.'/send_data_detail'); ?>",
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
						$(form_id).parents('.box-page-detail-karyawan').prev('.form-err-class').html(data.alert).slideDown();
						get_main_detail('<?php echo $page_name; ?>');
						first_load('.box-loader-detail-karyawan', '.box-page-detail-karyawan');
						if (data.reload == 'yes') {
							location.reload();
						}
						if (data.load_profile_badge == 'yes') {
							get_profile_badge();
						}
					}
					if (data.confirm == 'error') {
						<?php
						$no = 0;
						foreach ($form_errs as $form_err) {
							echo $no == 0?"":"\n\t\t\t\t\t\t";
							echo '$(\'#'.$form_err.'\').html(data.'.$form_err.').slideDown();';
							$no++;
						}
						echo "\n";
						?>
					}
				}
				$('input[name="<?php echo $this->config->item('csrf_token_name'); ?>"]').val(data.csrf);
			}
		});
	}
</script>