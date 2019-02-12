<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<script type="text/javascript">
	open_view();
	first_load('<?php echo $box_loader_id; ?>', '<?php echo $box_content_id; ?>');

	$(document).off('click', '#idBtnUbah').on('click', '#idBtnUbah', function() {
		open_form($('input[name="txtKd"]').val(), $('input[name="txtCodeFor"]').val());
	});

	$(document).off('click', '#idBtnKembali').on('click', '#idBtnKembali', function() {
		open_view();
	});

	$(document).off('click', '.btn-tambah-format').on('click', '.btn-tambah-format', function() {
		$.ajax({
			type: 'GET',
			url: '<?php echo base_url().$class_link.'/add_code_format'; ?>',
			success: function(html) {
				$('.cl-group-code-format').append(html);
				$('.form-group').slideDown();
			}
		});
	});

	$(document).off('click', '.btn-hapus-format').on('click', '.btn-hapus-format', function() {
		$(this).parents('.form-group').slideUp(function() {
			$(this).remove();
		});
	});

	$(document).off('submit', '#idFormCodeFormat').on('submit', '#idFormCodeFormat', function(e) {
		e.preventDefault();
		submit_form(this);
	});

	$(document).off('change', 'select[name="selCodePart[]"]').on('change', 'select[name="selCodePart[]"]', function() {
		var sel_value = $(this).val();
		if (sel_value == 'urutan_angka' || sel_value == 'kode_huruf') {
			$(this).parents('.form-group').find('.cl-form-unique').fadeIn();
		} else {
			$(this).parents('.form-group').find('.cl-form-unique').fadeOut();
		}
	});

	function moveTo(element) {
		$('html, body').animate({ scrollTop: $(element).offset().top - $('header').height() }, 'fast');
	}

	function open_view() {
		$('#<?php echo $box_content_id; ?>').slideUp(function(){
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url().$class_link.'/open_view'; ?>',
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

	function open_form(id, code_for) {
		$('#idAlertBoxView').slideUp(function() {
			$(this).html('');
		});
		$('#idContainerFormCodeFormat').slideUp(function() {
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url().$class_link.'/open_form'; ?>',
				data: 'id='+id+'&code_for='+code_for,
				success: function(html) {
					$('#idContainerFormCodeFormat').html(html);
					$('#idContainerFormCodeFormat').slideDown();
					$('#idTxtNm').focus();
					code_format_form(id, code_for);
				}
			});
		});
	}

	function code_format_form(id, code_for) {
		$('.cl-group-code-format').slideUp(function() {
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url().$class_link.'/code_format_form'; ?>',
				data: 'id='+id+'&code_for='+code_for,
				success: function(html) {
					$('.cl-group-code-format').html(html);
					$('.cl-group-code-format').slideDown();
					$('.form-group').slideDown();
				}
			});
		});
	}

	function submit_form(form_id) {
		$('#idAlertBoxView').slideUp(function() {
			$(this).html('');
		});
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
						$('#idAlertBoxView').html(data.alert).slideDown();
						open_view();
					}
					if (data.confirm == 'error') {
						$('#idAlertBoxView').html(data.alert).slideDown();
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
				$('#idTxtNm').focus();
				$('input[name="<?php echo $this->config->item('csrf_token_name'); ?>"]').val(data.csrf);
			}
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
</script>