<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<script type="text/javascript">
	open_table();
	first_load('<?php echo $box_loader_id; ?>', '<?php echo $box_content_id; ?>');

	function moveTo(element) {
		$('html, body').animate({ scrollTop: $(element).offset().top - $('header').height() }, 1000);
	}

	function open_table() {
		$('#<?php echo $btn_add_id; ?>').slideDown();
		$('#<?php echo $box_content_id; ?>').slideUp(function(){
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url().$class_link.'/open_table'; ?>',
				success: function(html) {
					$('#<?php echo $box_content_id; ?>').html(html);
					$('#<?php echo $box_content_id; ?>').slideDown();
					moveTo('.main_container');
				}
			});
		});
	}

	function first_load(loader, content) {
		$('#'+loader).fadeOut(500, function(e){
			$('#'+content).slideDown();
		});
	}
</script>