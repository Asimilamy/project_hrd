<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<script type="text/javascript">
	open_filter();
	first_load('#<?php echo $box_loader_id; ?>', '#<?php echo $box_content_id; ?>');

	$(document).off('submit', '#idFormFilterKaryawan').on('submit', '#idFormFilterKaryawan', function(e) {
		e.preventDefault();
		submit_form_filter(this);
	});

	function open_filter() {
		$('#<?php echo $box_content_id; ?>').slideUp(function(){
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url($class_link.'/open_filter'); ?>',
				success: function(html) {
					$('#<?php echo $box_content_id; ?>').html(html);
					$('#<?php echo $box_content_id; ?>').slideDown();
					moveTo('.main_container');
					$('#idTxtNim').focus();
					$('.datetimepicker').datetimepicker({
						format: 'DD-MM-YYYY',
					});
				}
			});
		});
	}

	function first_load(loader, content) {
		$(content).hide();
		$(loader).fadeIn('fast', function(e) {
			$(loader).fadeOut('slow', function(e){
				$(content).slideDown();
			});
		});
	}
	
	function submit_form_filter(form_id) {
		$.ajax({
			url: "<?php echo base_url($class_link.'/submit_form_filter'); ?>",
			type: "POST",
			data:  new FormData(form_id),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				if (data.alert_stat == 'online') {
					if(!alert(data.csrf_alert)){window.location.reload();}
				} else if (data.alert_stat == 'offline') {
					open_table(data.form_data);
				}
				$('input[name="<?php echo $this->config->item('csrf_token_name'); ?>"]').val(data.csrf);
			}
		});
	}
</script>