<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Data_status_kerja extends MY_Controller {
	private $class_link = 'administrator/struktur_organisasi/data_status_kerja';
	private $form_errs = array('idErrCode', 'idErrNm', 'idErrHasContract', 'idErrIsVisible');

	public function __construct() {
		parent::__construct();
		$this->load->model(array('model_auth/m_access', 'model_organisasi/tm_status_kerja'));

		$access = $this->m_access->read_user_access('data_status_kerja', 'Struktur Organisasi');
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
		parent::datatables_assets();
		parent::icheck_assets();
		$this->get_table();
	}

	public function get_table() {
		$this->load->model(['model_basic/base_query']);
		/* --START OF BOX DEFAULT PROPERTY-- */
		$data['page_title'] = 'Data Status Kerja';
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

		$data = $this->tm_status_kerja->ssp_table();
		echo json_encode(
			Custom_ssp::simple( $_GET, $data['sql_details'], $data['table'], $data['primaryKey'], $data['columns'], $data['joinQuery'], $data['where'] )
		);
	}

	public function get_form() {
		$this->load->model(['model_basic/base_query']);
		/* --START OF BOX DEFAULT PROPERTY-- */
		$data['page_title'] = 'Data Status Kerja';
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
		$data['data'] = $this->base_query->define_container($this->class_link, $data['box_type']);
		/* --END OF BOX DATA PROPERTY-- */
		$data['data']['id'] = $this->input->get('id');
		$data['data']['form_errs'] = $this->form_errs;
		$this->load->view('containers/view_box', $data);
	}

	public function open_form() {
		$this->load->model(['model_organisasi/tm_status_kerja']);
		$this->load->helper(array('form'));
		$id = $this->input->get('id');
		$data = $this->tm_status_kerja->get_data($id);
		$data['opts_status'] = render_dropdown('Status Habis', $this->tm_status_kerja->get_notme($id), 'kd_status_kerja', 'nm_status_kerja');
		$this->load->view('page/'.$this->class_link.'/form_main', $data);
	}

	public function send_data() {
		$this->load->library('form_validation');
		$this->load->model('model_basic/base_query');
		if ($this->input->is_ajax_request()) :
			$this->form_validation->set_rules($this->tm_status_kerja->form_rules());
			if ($this->form_validation->run() == FALSE) :
				$str = $this->tm_status_kerja->form_warning($this->form_errs);
				$str['confirm'] = 'error';
			else :
				$data['kd_status_kerja'] = $this->input->post('txtKd');
				$data['user_code'] = $this->input->post('txtCode');
				$data['nm_status_kerja'] = $this->input->post('txtNm');
				$data['has_contract'] = empty($this->input->post('chkHasContract'))?'0':'1';
				$data['is_visible'] = empty($this->input->post('chkIsVisible'))?'0':'1';
				$data['kd_status_habis'] = empty($this->input->post('selKdStatus'))?NULL:$this->input->post('selKdStatus');
				$str = $this->base_query->submit_data('tm_status_kerja', 'kd_status_kerja', 'Data Status Kerja', $data);
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
			$str = $this->base_query->soft_delete('tm_status_kerja', array('kd_status_kerja' => $id), 'Data Status Kerja');
			
			header('Content-Type: application/json');
			echo json_encode($str);
		endif;
	}

    public function code_check($str) {
		if ($str == 'test' || $str == 'TEST') :
			$this->form_validation->set_message('code_check', '{field} tidak boleh menggunakan kata "'.$str.'"');
			return FALSE;
		else :
			$this->db->from('tm_status_kerja')
				->where(array('user_code' => $str, 'kd_status_kerja !=' => $this->input->post('txtKd')));
			$query = $this->db->get();
			$return = $query->num_rows();
			if ($return > 0) :
				$this->form_validation->set_message('code_check', '{field} sudah digunakan, gunakan {field} lain!');
				return FALSE;
			else :
				return TRUE;
			endif;
		endif;
    }
}