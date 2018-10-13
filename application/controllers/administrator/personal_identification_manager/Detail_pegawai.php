<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Detail_pegawai extends MY_Controller {
	private $class_link = 'administrator/personal_identification_manager/detail_pegawai';
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
			redirect($class_link, 'location');
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
		parent::chart_assets();
		parent::daterangepicker_assets();
		$this->get_detail();
	}

	public function get_detail() {
		/* --START OF BOX DEFAULT PROPERTY-- */
		$data['page_title'] = 'Data Pegawai';
		$data['box_type'] = 'Detail';
		$data['page_search'] = FALSE;
		$data['js_file'] = 'detail_js';
		/* --END OF BOX DEFAULT PROPERTY-- */

		/* --START OF BOX BUTTON PROPERTY-- */
		$data['btn_add'] = FALSE;
		$data['btn_hide'] = TRUE;
		$data['btn_close'] = TRUE;
		/* --END OF BOX BUTTON PROPERTY-- */

		/* --START OF BOX DATA PROPERTY-- */
		$data['data']['class_link'] = $this->class_link;
		$data['data']['box_id'] = 'idBox'.$data['box_type'];
		$data['data']['box_alert_id'] = 'idAlertBox'.$data['box_type'];
		$data['data']['box_loader_id'] = 'idLoaderBox'.$data['box_type'];
		$data['data']['box_content_id'] = 'idContentBox'.$data['box_type'];
		$data['data']['btn_hide_id'] = 'idBtnHide'.$data['box_type'];
		$data['data']['btn_add_id'] = 'idBtnAdd'.$data['box_type'];
		$data['data']['btn_close_id'] = 'idBtnClose'.$data['box_type'];
		/* --END OF BOX DATA PROPERTY-- */
		$this->load->view('containers/view_box', $data);
	}

	public function open_detail() {
		$this->load->model(array('model_karyawan/m_karyawan', 'model_setting/m_setting'));
		$kd_karyawan = $this->input->get('kd_karyawan');
		$data['class_link'] = $this->class_link;
		$data['karyawan_info'] = $this->m_karyawan->get_data_pribadi($kd_karyawan);
		$this->load->view('page/'.$this->class_link.'/detail_main', $data);
	}

	public function get_main_detail() {
		$this->load->model(array('model_karyawan/m_karyawan'));
		$this->load->helper(array('form'));

		$page_name = $this->input->get('page_name');
		$data['page_name'] = $page_name;
		$data = $this->m_karyawan->fetch_detail($_SESSION['user']['kd_karyawan'], $page_name);
		$page_url = 'page/'.$this->class_link.'/form_detail/'.$page_name.'_form_main';
		if (file_exists(FCPATH.'application/views/'.$page_url.'.php')) :
			$this->load->view($page_url, $data);
		else :
			echo $page_name.' - File Not Exist!';
		endif;
	}

	public function send_data_detail() {
		$this->load->library('form_validation');
		$this->load->model('model_basic/base_query');
		$this->load->helper('date');
		if ($this->input->is_ajax_request()) :
			$str['form_data'] = $this->input->post();
			$str['alert_stat'] = 'offline';
			$str['csrf_alert'] = '';
			$str['csrf'] = $this->security->get_csrf_hash();

			header('Content-Type: application/json');
			echo json_encode($str);
		endif;
	}

	public function get_table() {
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
		$data['data']['class_link'] = $this->class_link;
		$data['data']['box_id'] = 'idBox'.$data['box_type'];
		$data['data']['box_alert_id'] = 'idAlertBox'.$data['box_type'];
		$data['data']['box_loader_id'] = 'idLoaderBox'.$data['box_type'];
		$data['data']['box_content_id'] = 'idContentBox'.$data['box_type'];
		$data['data']['btn_hide_id'] = 'idBtnHide'.$data['box_type'];
		$data['data']['btn_add_id'] = 'idBtnAdd'.$data['box_type'];
		$data['data']['btn_close_id'] = 'idBtnClose'.$data['box_type'];
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

	public function get_form() {
		$data['data']['id'] = $this->input->get('id');

		/* --START OF BOX DEFAULT PROPERTY-- */
		$data['page_title'] = 'Data Karyawan';
		$data['box_type'] = 'Form';
		$data['page_search'] = FALSE;
		$data['js_file'] = 'form_js';
		/* --END OF BOX DEFAULT PROPERTY-- */

		/* --START OF BOX BUTTON PROPERTY-- */
		$data['btn_add'] = FALSE;
		$data['btn_hide'] = TRUE;
		$data['btn_close'] = TRUE;
		/* --END OF BOX BUTTON PROPERTY-- */

		/* --START OF BOX DATA PROPERTY-- */
		$data['data']['class_link'] = $this->class_link;
		$data['data']['box_id'] = 'idBox'.$data['box_type'];
		$data['data']['box_alert_id'] = 'idAlertBox'.$data['box_type'];
		$data['data']['box_loader_id'] = 'idLoaderBox'.$data['box_type'];
		$data['data']['box_content_id'] = 'idContentBox'.$data['box_type'];
		$data['data']['btn_hide_id'] = 'idBtnHide'.$data['box_type'];
		$data['data']['btn_add_id'] = 'idBtnAdd'.$data['box_type'];
		$data['data']['btn_close_id'] = 'idBtnClose'.$data['box_type'];
		$data['data']['form_errs'] = $this->form_errs;
		/* --END OF BOX DATA PROPERTY-- */
		$this->load->view('containers/view_box', $data);
	}

	public function open_form() {
		$this->load->model('model_organisasi/model_organisasi');
		$this->load->helper(array('form'));
		$id = $this->input->get('id');
		$data = $this->tm_karyawan->get_data($id);
		$data['opts_unit'] = render_dropdown('Unit', $this->model_organisasi->get_organisasi('tm_unit', [], []), 'kd_unit', 'nm_unit');
		$data['opts_bagian'] = render_dropdown('Bagian', $this->model_organisasi->get_organisasi('tm_bagian', [], []), 'kd_bagian', 'nm_bagian');
		$data['opts_jabatan'] = render_dropdown('Bagian', $this->model_organisasi->get_organisasi('tm_jabatan', [], []), 'kd_jabatan', 'nm_jabatan');
		$data['opts_status_kerja'] = render_dropdown('Bagian', $this->model_organisasi->get_organisasi('tm_status_kerja', [], []), 'kd_status_kerja', 'nm_status_kerja');
		$this->load->view('page/'.$this->class_link.'/form_main', $data);
	}

	public function send_data() {
		$this->load->library('form_validation');
		$this->load->model('model_basic/base_query');
		$this->load->helper('date');
		if ($this->input->is_ajax_request()) :
			$this->form_validation->set_rules($this->tm_karyawan->form_rules());
			if ($this->form_validation->run() == FALSE) :
				$str = $this->tm_karyawan->form_warning($this->form_errs);
				$str['confirm'] = 'error';
			else :
				$data['kd_karyawan'] = $this->input->post('txtKd');
				$data['nik_karyawan'] = $this->input->post('txtNik');
				$data['nm_karyawan'] = $this->input->post('txtNm');
				$data['status_kerja_kd'] = $this->input->post('selStatusKerja');
				$data['unit_kd'] = $this->input->post('selUnit');
				$data['bagian_kd'] = $this->input->post('selBagian');
				$data['jabatan_kd'] = $this->input->post('selJabatan');
				$data['tgl_masuk'] = format_date($this->input->post('txtTglMasuk'), 'Y-m-d');
				$str = $this->base_query->submit_data('tm_karyawan', 'kd_karyawan', 'Data Karyawan', $data);
			endif;
			$str['alert_stat'] = 'offline';
			$str['csrf_alert'] = '';
			$str['csrf'] = $this->security->get_csrf_hash();

			header('Content-Type: application/json');
			echo json_encode($str);
		endif;
	}

	public function delete_data() {
		$this->load->model('model_basic/base_query');
		if ($this->input->is_ajax_request()) :
			$id = $this->input->get('id');
			$str = $this->base_query->delete_data('tm_karyawan', array('kd_karyawan' => $id), 'Data Karyawan');
			
			header('Content-Type: application/json');
			echo json_encode($str);
		endif;
	}
}