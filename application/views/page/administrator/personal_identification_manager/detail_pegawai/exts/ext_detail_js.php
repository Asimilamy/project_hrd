<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>

<script type="text/javascript">
	var first_page = $('.nav-pills a').parent().first();
	var page_link = $('.nav-pills a').first().data('page-link');
	first_page.addClass('active');
	get_main_detail(page_link);
	first_load('.box-loader-detail-karyawan', '.box-page-detail-karyawan');

	$(".nav-pills a").on("click", function(){
		$('.form-err-class').slideUp();
		$(".nav-pills").find(".active").removeClass("active");
		$(this).parent().addClass("active");

		var page_link = $(this).data('page-link');
		console.log(page_link);
		get_main_detail(page_link);
		first_load('.box-loader-detail-karyawan', '.box-page-detail-karyawan');
	});

	function get_main_detail(page_name) {
		$('.box-page-detail-karyawan').slideUp(function(){
			$.ajax({
				url: '<?php echo base_url($class_link.'/get_main_detail'); ?>',
				type: 'GET',
				data: 'page_name='+page_name,
				success: function(html) {
					$('.box-page-detail-karyawan').html(html);
					moveTo('.main_container');
				}
			});
		});
	}

	function hapus_data(id) {
		$('.form-err-class').slideUp();
		remove_box('#idBoxForm');
		$.ajax({
			type: 'GET',
			url: '<?php echo base_url().$class_link.'/delete_data_detail'; ?>',
			data: 'id='+id,
			success: function(data) {
				$('.form-err-class').html(data.alert).fadeIn();
				open_detail_page({'file_type' : 'table'});
			}
		});
	}
</script>
