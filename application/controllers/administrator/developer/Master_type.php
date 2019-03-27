<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Master_type extends MY_Controller {
	private $class_link = 'administrator/developer/master_type';
	private $form_errs = array('idErrNama');

	public function __construct() {
		parent::__construct();
		parent::datatables_assets();
		$this->load->model(array('model_auth/m_access', 'model_master_type/tm_master_type'));

		$access = $this->m_access->read_user_access('master_type', 'Administrator');
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
		$tot_uri = $this->uri->total_segments();
		$_SESSION['master_type_tipe'] = $this->uri->segment($tot_uri - 1);
		$this->get_table();
	}

	public function get_table() {
		$this->load->model(['model_basic/base_query']);
		/* --START OF BOX DEFAULT PROPERTY-- */
		$data['page_title'] = 'Data Type';
		$data['box_type'] = 'Table';
		$data['page_search'] = FALSE;
		$data['js_file'] = 'table_js';
		/* --END OF BOX DEFAULT PROPERTY-- */

		/* --START OF BOX BUTTON PROPERTY-- */
		$data['btn_add'] = TRUE;
		$data['btn_hide'] = TRUE;
		$data['btn_close'] = FALSE;
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

		$data = $this->tm_master_type->ssp_table($_SESSION['master_type_tipe']);
		echo json_encode(
			Custom_ssp::simple( $_GET, $data['sql_details'], $data['table'], $data['primaryKey'], $data['columns'], $data['joinQuery'], $data['where'] )
		);
	}

	public function get_form() {
		$this->load->model(['model_basic/base_query']);
		/* --START OF BOX DEFAULT PROPERTY-- */
		$data['page_title'] = 'Data Type';
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
		$this->load->model(array('model_master_type/m_master_type'));
		$this->load->helper(array('form'));
		$id = $this->input->get('id');
		$data = $this->tm_master_type->get_data($id);
		$data['master_type_opts'] = $this->m_master_type->get_opts(array('type' => $_SESSION['master_type_tipe'], 'kd_master_type !=' => $id));
		$this->load->view('page/'.$this->class_link.'/form_main', $data);
	}

	public function send_data() {
		$this->load->library('form_validation');
		$this->load->model('model_basic/base_query');
		if ($this->input->is_ajax_request()) :
			$this->form_validation->set_rules($this->tm_master_type->form_rules());
			if ($this->form_validation->run() == FALSE) :
				$str = $this->tm_master_type->form_warning($this->form_errs);
				$str['confirm'] = 'error';
			else :
				$data['kd_master_type'] = $this->input->post('txtKd');
				$data['kd_parent'] = $this->input->post('selParent');
				$data['nm_master_type'] = $this->input->post('txtNm');
				$data['type'] = $_SESSION['master_type_tipe'];
				$str = $this->base_query->submit_data('tm_master_type', 'kd_master_type', 'Data Master Type', $data);
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
			$str = $this->base_query->delete_data('tm_master_type', array('kd_master_type' => $id), 'Data Master Type');
			
			header('Content-Type: application/json');
			echo json_encode($str);
		endif;
	}
}