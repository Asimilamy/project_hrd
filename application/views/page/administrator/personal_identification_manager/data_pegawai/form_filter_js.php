<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<script type="text/javascript">
	open_filter();
	first_load('#<?php echo $box_loader_id; ?>', '#<?php echo $box_content_id; ?>');

	$(document).off('submit', '#idFormDataMasterType').on('submit', '#idFormDataMasterType', function(e) {
		e.preventDefault();
		submit_form(this);
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
</script>