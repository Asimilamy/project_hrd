<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Create_menu extends MY_Controller {
	private $class_link = 'administrator/developer/create_menu';
	private $form_errs = array('idErrNama', 'idErrLink', 'idErrTitle', 'idErrOrder', 'idErrModul', 'idErrGlobal');

	public function __construct() {
		parent::__construct();
		parent::datatables_assets();
		$this->load->model(array('model_auth/m_access', 'model_tpl/tm_menu'));

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
		parent::icheck_assets();
		$this->get_table();
		$_SESSION['master_type_tipe'] = 'administrator';
	}

	public function get_table() {
		$this->load->model(['model_basic/base_query']);
		/* --START OF BOX DEFAULT PROPERTY-- */
		$data['page_title'] = 'Data Menu';
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

		$data = $this->tm_menu->ssp_table();
		echo json_encode(
			Custom_ssp::simple( $_GET, $data['sql_details'], $data['table'], $data['primaryKey'], $data['columns'], $data['joinQuery'], $data['where'] )
		);
	}

	public function get_form() {
		$this->load->model(['model_basic/base_query']);
		/* --START OF BOX DEFAULT PROPERTY-- */
		$data['page_title'] = 'Data Menu';
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
		$this->load->model('model_tpl/m_menu');
		$this->load->helper(array('form'));
		$id = $this->input->get('id');
		$data = $this->tm_menu->get_data($id);
		$data['menu_parent_opts'] = $this->m_menu->menu_parent_opts(array('kd_menu !=' => $id));
		$data['modul_menu_opts'] = $this->m_menu->modul_menu_opts();
		$this->load->view('page/'.$this->class_link.'/form_main', $data);
	}

	public function send_data() {
		$this->load->library('form_validation');
		$this->load->model('model_basic/base_query');
		if ($this->input->is_ajax_request()) :
			$this->form_validation->set_rules($this->tm_menu->form_rules());
			if ($this->form_validation->run() == FALSE) :
				$str = $this->tm_menu->form_warning($this->form_errs);
				$str['confirm'] = 'error';
			else :
				$menu_parent = $this->input->post('selParent');
				$data['kd_menu'] = $this->input->post('txtKd');
				$data['menu_parent'] = empty($menu_parent)?NULL:$menu_parent;
				$data['menu_nm'] = $this->input->post('txtNm');
				$data['menu_link'] = $this->input->post('txtLink');
				$data['menu_title'] = $this->input->post('txtTitle');
				$data['menu_icon'] = $this->input->post('txtIcon');
				$data['menu_order'] = $this->input->post('txtOrder');
				$data['menu_modul'] = $this->input->post('selModul');
				$data['menu_global'] = $this->input->post('selGlobal');
				$str = $this->base_query->submit_data('tm_menu', 'kd_menu', 'Data Menu', $data);
				if ($str['confirm'] == 'success' && $this->input->post('chkAccess') == 'access') :
					$str = $this->process_user_access_batch($str['key']);
				endif;
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
			$str = $this->base_query->delete_data('tm_menu', array('kd_menu' => $id), 'Data Menu');
			if ($str['confirm'] == 'success') :
				$str = $this->delete_user_access($id);
			endif;
			
			header('Content-Type: application/json');
			echo json_encode($str);
		endif;
	}

	public function show_user_type() {
		$this->load->model('model_master_type/m_master_type');
		$this->load->helper('form');
		$data['master_type_opts'] = $this->m_master_type->get_opts(array('type' => $_SESSION['master_type_tipe']));
		$data['btn_inc'] = $this->input->get('btn_inc');
		$this->load->view('page/'.$this->class_link.'/additional_views/user_form_main', $data);
	}

	private function process_user_access_batch($menu_kd = '') {
		$this->load->model('model_basic/base_query');
		$this->db->trans_begin();
		$this->delete_user_access($menu_kd);
		$kd_user_access = create_pkey('td_user_access', 'kd_user_access');
		$master_type_kds = $this->input->post('selMasterType');
		$create_accesss = $this->input->post('chkAccessCreate');
		$read_accesss = $this->input->post('chkAccessRead');
		$update_accesss = $this->input->post('chkAccessUpdate');
		$delete_accesss = $this->input->post('chkAccessDelete');
		for ($i = 0; $i < count($master_type_kds); $i++) :
			$master_type_kd = $master_type_kds[$i];
			$create_access = isset($create_accesss[$i])?$create_accesss[$i]:'0';
			$read_access = isset($read_accesss[$i])?$read_accesss[$i]:'0';
			$update_access = isset($update_accesss[$i])?$update_accesss[$i]:'0';
			$delete_access = isset($delete_accesss[$i])?$delete_accesss[$i]:'0';
			$data_batch[] = array('kd_user_access' => $kd_user_access, 'master_type_kd' => $master_type_kd, 'menu_kd' => $menu_kd, 'create_access' => $create_access, 'read_access' => $read_access, 'update_access' => $update_access, 'delete_access' => $delete_access, 'tgl_input' => date('Y-m-d H:i:s'), 'user_kd' => $_SESSION['user']['kd_user']);
			$kd_user_access = create_pkey('td_user_access', 'kd_user_access', $kd_user_access, 1);
		endfor;
		$str = $this->base_query->submit_batch('td_user_access', 'Data User Access', $data_batch);
		if ($this->db->trans_status() === FALSE) :
			$this->db->trans_rollback();
		else :
			$this->db->trans_commit();
		endif;
		return $str;
	}

	private function delete_user_access($kd_menu = '') {
		$this->load->model('model_basic/base_query');
		$str = $this->base_query->delete_data('td_user_access', array('menu_kd' => $kd_menu), 'Data User Access');
		return $str;
	}
}