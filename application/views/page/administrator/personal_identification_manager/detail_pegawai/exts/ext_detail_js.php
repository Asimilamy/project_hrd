<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>

<script type="text/javascript">
	var first_page = $('.nav-pills a').parent().first();
	var page_link = $('.nav-pills a').first().data('page-link');
	first_page.addClass('active');
	console.log(page_link);
	get_main_detail(page_link);
	first_load('idBoxLoaderDetailKaryawan', 'idBoxPageDetailKaryawan');

	$(".nav-pills a").on("click", function(){
		$(".nav-pills").find(".active").removeClass("active");
		$(this).parent().addClass("active");

		var page_link = $(this).data('page-link');
		console.log(page_link);
		get_main_detail(page_link);
		first_load('idBoxLoaderDetailKaryawan', 'idBoxPageDetailKaryawan');
	});

	function get_main_detail(page_name) {
		$('#idBoxPageDetailKaryawan').slideUp(function(){
			$.ajax({
				url: '<?php echo base_url($class_link.'/get_main_detail'); ?>',
				type: 'GET',
				data: 'page_name='+page_name,
				success: function(html) {
					$('#idBoxPageDetailKaryawan').html(html);
					moveTo('.main_container');
				}
			});
		});
	}

	function submit_form(form_id) {
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
					}
					if (data.confirm == 'error') {
					}
				}
				$('input[name="<?php echo $this->config->item('csrf_token_name'); ?>"]').val(data.csrf);
			}
		});
	}
</script>
