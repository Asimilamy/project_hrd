<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<script type="text/javascript">
	open_table();
	first_load('<?php echo $box_loader_id; ?>', '<?php echo $box_content_id; ?>');

	$(document).off('click', '#<?php echo $btn_add_id; ?>').on('click', '#<?php echo $btn_add_id; ?>', function() {
		view_detail('');
	});

	$(document).off('click', '#<?php echo $btn_close_id; ?>').on('click', '#<?php echo $btn_close_id; ?>', function() {
		$.ajax({
			type: 'GET',
			url: '<?php echo base_url('administrator/personal_identification_manager/data_pegawai/get_table'); ?>',
			success: function(data) {
				remove_box('#<?php echo $box_id; ?>');
				$('#idMainContainer').html(data);
			}
		});
	});

	function moveTo(element) {
		$('html, body').animate({ scrollTop: $(element).offset().top - $('header').height() }, 'fast');
	}

	function open_table() {
		$('.panel_toolbox').css({"margin-right" : "0px"});
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

	function remove_box(box_element) {
		$(box_element).slideUp(500, function() {
			$(this).fadeOut(500, function() {
				$(this).remove();
			});
		});
	}

	function hapus_data(id) {
		$('#<?php echo $box_alert_id; ?>').fadeOut();
		remove_box('#idBoxForm');
		$.ajax({
			type: 'GET',
			url: '<?php echo base_url().$class_link.'/delete_data'; ?>',
			data: 'id='+id,
			success: function(data) {
				$('#<?php echo $box_alert_id; ?>').html(data.alert).fadeIn();
				open_table();
			}
		});
	}

	function view_detail(id) {
		$.ajax({
			type: 'GET',
			url: '<?php echo base_url('administrator/personal_identification_manager/detail_pegawai/register_detail'); ?>',
			data: 'id='+id,
			success: function(data) {
				remove_box('#<?php echo $box_id; ?>');
				$('#idMainContainer').html(data);
			}
		});
	}
</script>