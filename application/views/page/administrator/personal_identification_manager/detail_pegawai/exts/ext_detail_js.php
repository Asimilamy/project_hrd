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
</script>
