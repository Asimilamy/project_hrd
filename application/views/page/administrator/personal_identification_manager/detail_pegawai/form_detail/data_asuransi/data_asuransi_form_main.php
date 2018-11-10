<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/* --Masukkan setting properti untuk form-- */
$master_var = 'DataDetailKaryawan';
$form_id = 'idForm'.$master_var;
$data['class_link'] = $class_link;
$data['form_errs'] = $form_errs;
$data['page_name'] = $page_name;
$this->load->model(array('model_karyawan/m_karyawan'));
$detail_row = $this->m_karyawan->fetch_detail($_SESSION['user']['detail_karyawan']['kd_karyawan'], 'data_pribadi');
?>
<div class="form_detail_main"></div>
<?php
$this->load->view('page/'.$class_link.'/exts/ext_form_js', $data);
?>

<script type="text/javascript">
	open_detail_page({'file_type' : 'table'});

	$(document).off('submit', '#idFormDataDetailKaryawan').on('submit', '#idFormDataDetailKaryawan', function(e) {
		e.preventDefault();
		submit_form(this);
	});

	$(document).off('click', '.btn-add-asuransi').on('click', '.btn-add-asuransi', function() {
		open_detail_page({'file_type' : 'form', 'kd_karyawan_asuransi' : ''});
		first_load('.box-loader-detail-karyawan', '.form_detail_main');
		$('.form-err-class').slideUp();
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
