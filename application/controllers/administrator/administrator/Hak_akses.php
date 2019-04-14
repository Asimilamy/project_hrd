<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Hak_akses extends MY_Controller {
	private $class_link = 'administrator/administrator/hak_akses';
	private $form_errs = [];

	public function __construct() {
		parent::__construct();
		parent::datatables_assets();
		$this->load->model(array('model_auth/m_access', 'model_user/td_user_access'));

		$access = $this->m_access->read_user_access('hak_akses', 'Administrator');
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
		parent::icheck_assets();
		$this->get_table();
	}

	public function get_table() {
		$this->load->model(['model_basic/base_query']);
		/* --START OF BOX DEFAULT PROPERTY-- */
		$data['page_title'] = 'Data Tipe User';
		$data['box_type'] = 'Table';
		$data['page_search'] = FALSE;
		$data['js_file'] = 'table_js';
		/* --END OF BOX DEFAULT PROPERTY-- */

		/* --START OF BOX BUTTON PROPERTY-- */
		$data['btn_add'] = FALSE;
		$data['btn_hide'] = TRUE;
		$data['btn_close'] = TRUE;
		/* --END OF BOX BUTTON PROPERTY-- */

		/* --START OF BOX DATA PROPERTY-- */
		$data['data'] = $this->base_query->define_container('administrator/administrator/tipe_user', $data['box_type']);
		/* --END OF BOX DATA PROPERTY-- */
		$this->load->view('containers/view_box', $data);
	}

	public function get_form() {
		$this->load->model(['model_basic/base_query']);
		/* --START OF BOX DEFAULT PROPERTY-- */
		$data['page_title'] = 'User Access';
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
		$this->load->model(['model_tpl/m_menu']);
		$this->load->helper(['form', 'menu_renderer_helper']);
		$id = $this->input->get('id');
		$_SESSION['user']['hak_akses']['kd_user_type'] = $id;
		$data['user_accesses'] = $this->td_user_access->get_access_data($id);
		$data['menu_lvl_ones'] = $this->m_menu->get_menu_level($id, 'one');
		$data['menu_lvl_twos'] = $this->m_menu->get_menu_level($id, 'two');
		$data['menu_lvl_threes'] = $this->m_menu->get_menu_level($id, 'three');
		$this->load->view('page/'.$this->class_link.'/form_main', $data);
	}

	public function send_data() {
		$this->load->library('form_validation');
		if ($this->input->is_ajax_request()) :
			/*$this->form_validation->set_rules($this->tm_barang->form_rules());
			if ($this->form_validation->run() == FALSE) :
				$str = $this->tm_barang->form_warning($this->form_errs);
				$str['confirm'] = 'error';
			else :
				$data['kd_mbarang'] = $this->input->post('txtKd');
				$data['master_type_kd'] = $this->input->post('selType');
				$data['barcode'] = $this->input->post('txtBarcode');
				$data['nm_barang'] = $this->input->post('txtNmBarang');
				$data['deskripsi'] = $this->input->post('txtDeskripsi');
				$str = $this->tm_barang->submit_data($data);
			endif;*/
			$str['form-data'] = $this->input->post();
			$str['csrf'] = $this->security->get_csrf_hash();

			header('Content-Type: application/json');
			echo json_encode($str);
		endif;
	}

	public function delete_data() {
		if ($this->input->is_ajax_request()) :
			$id = $this->input->get('id');
			$str = $this->tm_barang->delete_data($id);
			
			header('Content-Type: application/json');
			echo json_encode($str);
		endif;
	}
}