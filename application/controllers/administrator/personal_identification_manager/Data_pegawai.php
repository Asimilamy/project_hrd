<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Data_pegawai extends MY_Controller {
	private $class_link = 'administrator/personal_identification_manager/data_pegawai';
	private $form_errs = array('idErrNik', 'idErrNm', 'idErrStatusKerja', 'idErrUnit', 'idErrBagian', 'idErrJabatan', 'idErrTglMasuk');

	public function __construct() {
		parent::__construct();
		parent::datatables_assets();
		$this->load->model(array('model_auth/m_access', 'model_karyawan/tm_karyawan'));

		$access = $this->m_access->read_user_access('data_pegawai', 'PIM');
		$_SESSION['user']['access'] = array('create' => $access->create, 'read' => $access->read, 'update' => $access->update, 'delete' => $access->delete);
	}

	/*
	** I still wondering about this function
	** is it still necessary to put it in every controller :\
	*/
	function csrf_redirect() {
		if ($this->input->is_ajax_request()) :
			$str['alert_stat'] = 'online';
			$str['csrf_alert'] = 'Halaman anda direset dikarenakan sesi browser anda telah habis.'."\n".'Silahkan coba lagi.';

			header('Content-Type: application/json');
			echo json_encode($str);
		else :
			$flash = 'Halaman anda direset dikarenakan sesi browser anda telah habis.&nbsp; Silahkan coba lagi.';
			$this->session->set_flashdata('message', $flash);
			redirect($this->class_link, 'location');
		endif;
	}

	/*
	** Load your assets in index
	** this will preserve the page load
	** because we will only use the needed assets in the page
	** ps : build your assets function in 'core/my_controller.php'
	*/
	public function index() {
		parent::admin_tpl();
		parent::datetimepicker_assets();
		$this->first_load();
	}

	public function first_load() {
		$this->get_filter();
		$this->get_table();
	}

	public function get_table() {
		$this->load->model(['model_basic/base_query']);
		/* --START OF BOX DEFAULT PROPERTY-- */
		$data['page_title'] = 'Data Karyawan';
		$data['box_type'] = 'Table';
		$data['page_search'] = FALSE;
		$data['js_file'] = 'table_js';
		/* --END OF BOX DEFAULT PROPERTY-- */

		/* --START OF BOX BUTTON PROPERTY-- */
		$data['btn_add'] = TRUE;
		$data['btn_hide'] = TRUE;
		$data['btn_close'] = TRUE;
		/* --END OF BOX BUTTON PROPERTY-- */

		/* --START OF BOX DATA PROPERTY-- */
		$data['data'] = $this->base_query->define_container($this->class_link, $data['box_type']);
		/* --END OF BOX DATA PROPERTY-- */
		$this->load->view('containers/view_box', $data);
	}

	public function open_table() {
		$data['class_link'] = $this->class_link;
		$this->load->view('page/'.$this->class_link.'/table_main', $data);
	}

	public function table_data() {
		$this->load->library(array('custom_ssp'));

		$data = $this->tm_karyawan->ssp_table();
		echo json_encode(
			Custom_SSP::simple( $_GET, $data['sql_details'], $data['table'], $data['primaryKey'], $data['columns'], $data['joinQuery'], $data['where'] )
		);
	}

	public function get_filter() {
		$this->load->model(['model_basic/base_query']);
		/* --START OF BOX DEFAULT PROPERTY-- */
		$data['page_title'] = 'Filter Karyawan';
		$data['box_type'] = 'Form';
		$data['page_search'] = FALSE;
		$data['js_file'] = 'form_filter_js';
		/* --END OF BOX DEFAULT PROPERTY-- */

		/* --START OF BOX BUTTON PROPERTY-- */
		$data['btn_add'] = FALSE;
		$data['btn_hide'] = TRUE;
		$data['btn_close'] = TRUE;
		/* --END OF BOX BUTTON PROPERTY-- */

		/* --START OF BOX DATA PROPERTY-- */
		$data['data'] = $this->base_query->define_container($this->class_link, $data['box_type']);
		/* --END OF BOX DATA PROPERTY-- */
		$this->load->view('containers/view_box', $data);
	}

	public function open_filter() {
		$this->load->helper(['form']);
		$data['class_link'] = $this->class_link;
		$this->load->view('page/'.$this->class_link.'/filter_main', $data);
	}

	public function delete_data() {
		$this->load->model('model_basic/base_query');
		if ($this->input->is_ajax_request()) :
			$id = $this->input->get('id');
			$str = $this->base_query->delete_data('td_karyawan_asuransi', array('karyawan_kd' => $id), 'Data Karyawan');
			$str = $this->base_query->delete_data('td_karyawan_info', array('karyawan_kd' => $id), 'Data Karyawan');
			$str = $this->base_query->delete_data('td_karyawan_jabatan', array('karyawan_kd' => $id), 'Data Karyawan');
			$str = $this->base_query->delete_data('td_karyawan_keluarga', array('karyawan_kd' => $id), 'Data Karyawan');
			$str = $this->base_query->delete_data('td_karyawan_kontak', array('karyawan_kd' => $id), 'Data Karyawan');
			$str = $this->base_query->delete_data('td_karyawan_kontrak', array('karyawan_kd' => $id), 'Data Karyawan');
			$str = $this->base_query->delete_data('td_karyawan_skill', array('karyawan_kd' => $id), 'Data Karyawan');
			$str = $this->base_query->delete_data('tm_karyawan', array('kd_karyawan' => $id), 'Data Karyawan');
			
			header('Content-Type: application/json');
			echo json_encode($str);
		endif;
	}
}