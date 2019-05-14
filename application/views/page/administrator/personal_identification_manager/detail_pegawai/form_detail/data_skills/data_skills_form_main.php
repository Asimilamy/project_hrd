<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/* --Masukkan setting properti untuk form-- */
$master_var = 'DataDetailKaryawan';
$form_id = 'idForm'.$master_var;
$data['class_link'] = $class_link;
$data['form_errs'] = $form_errs;
$data['page_name'] = $page_name;
?>
<div class="form_detail_main"></div>
<?php
$this->load->view('page/'.$class_link.'/exts/ext_form_js', $data);
?>

<script type="text/javascript">
	open_detail_page({'file_type' : 'table', 'page_name': '<?php echo $page_name; ?>'});

	$(document).off('click', '.btn-add-asuransi').on('click', '.btn-add-asuransi', function() {
		open_detail_page({'file_type' : 'form', 'page_name': '<?php echo $page_name; ?>', 'kd_karyawan_skill': ''});
	});

	function open_detail_page(params) {
		$.ajax({
			type: 'GET',
			url: '<?php echo base_url($class_link.'/get_complete_detail'); ?>',
			data: params,
			success: function(html) {
				$('.form_detail_main').html(html);
				moveTo('.main_container');
				$('.datetimepicker').datetimepicker({
					format: 'DD-MM-YYYY',
				});
				first_load('.box-loader-detail-karyawan', '.box-page-detail-karyawan');
			}
		});
	}
</script>
