<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<script type="text/javascript">
	open_detail();
	first_load('#<?php echo $box_loader_id; ?>', '#<?php echo $box_content_id; ?>');

	function moveTo(element) {
		$('html, body').animate({ scrollTop: $(element).offset().top - $('header').height() }, 'fast');
	}

	function open_detail() {
		$('#<?php echo $btn_add_id; ?>').slideDown();
		$('#<?php echo $box_content_id; ?>').slideUp(function(){
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url($class_link.'/open_detail'); ?>',
				success: function(html) {
					$('#<?php echo $box_content_id; ?>').html(html);
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

	function remove_box(box_element) {
		$(box_element).slideUp(500, function() {
			$(this).fadeOut(500, function() {
				$(this).remove();
			});
		});
	}

	function get_form(id) {
		$('#<?php echo $box_alert_id; ?>').fadeOut();
		remove_box('#idBoxForm');
		$.ajax({
			type: 'GET',
			url: '<?php echo base_url($class_link.'/get_form'); ?>',
			data: 'id='+id,
			success: function(html) {
				$('#idMainContainer').prepend(html);
			}
		});
	}

	$(document).off('click', '#idBtnCloseDetail').on('click', '#idBtnCloseDetail', function() {
		$.ajax({
			type: 'GET',
			url: '<?php echo base_url('administrator/personal_identification_manager/data_pegawai/first_load'); ?>',
			success: function(data) {
				remove_box('#<?php echo $box_id; ?>');
				$('#idMainContainer').html(data);
			}
		});
	});
</script>