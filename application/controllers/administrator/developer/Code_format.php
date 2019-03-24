<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Code_format extends MY_Controller {
	private $class_link = 'administrator/developer/code_format';
	private $form_errs = array('idErrNama', 'idErrReset');

	public function __construct() {
		parent::__construct();
		parent::datatables_assets();
		$this->load->model(array('model_auth/m_access', 'model_master_type/tm_master_type'));

		$master_type_tipe = isset($_SESSION['master_type_tipe'])?$_SESSION['master_type_tipe'].'/':'';
		$access = $this->m_access->read_user_access($master_type_tipe.'code_format', '');
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
		$this->get_view();
	}

	public function get_view() {
		/* --START OF BOX DEFAULT PROPERTY-- */
		$data['page_title'] = 'Format Kode - '.ucwords(str_replace('_', ' ', $_SESSION['master_type_tipe']));
		$data['box_type'] = 'View';
		$data['page_search'] = FALSE;
		$data['js_file'] = 'view_js';
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

	public function open_view() {
		$this->load->model(['model_code_format/m_code_format', 'model_basic/base_query']);
		$this->load->helper(['form']);
		$data = $this->m_code_format->read_code_format($_SESSION['master_type_tipe']);
		$data['reset_opts'] = render_dropdown('Tipe Reset', $this->m_code_format->code_reset_opts(), 'key', 'value');
		$this->load->view('page/'.$this->class_link.'/view_main', $data);
	}

	public function get_table() {
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

		$data = $this->tm_master_type->ssp_table($_SESSION['master_type_tipe']);
		echo json_encode(
			Custom_ssp::simple( $_GET, $data['sql_details'], $data['table'], $data['primaryKey'], $data['columns'], $data['joinQuery'], $data['where'] )
		);
	}

	public function get_form() {
		$data['data']['id'] = $this->input->get('id');

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
		$this->load->model(['model_code_format/m_code_format', 'model_basic/base_query']);
		$this->load->helper(array('form'));
		$id = $this->input->get('id');
		$data = $this->m_code_format->read_code_format($_SESSION['master_type_tipe']);
		$data['reset_opts'] = render_dropdown('Tipe Reset', $this->m_code_format->code_reset_opts(), 'key', 'value');
		$this->load->view('page/'.$this->class_link.'/form_main', $data);
	}

	public function code_format_form() {
		$this->load->model(['model_code_format/m_code_format', 'model_basic/base_query']);
		$this->load->helper(array('form', 'form_generator_helper'));
		$id = $this->input->get('id');
		$data['code_format_parts'] = $this->m_code_format->render_code_format($id);
		echo $this->load->view('page/'.$this->class_link.'/code_format_form_main', $data, TRUE);
	}

	public function add_code_format() {
		$this->load->helper(array('form_generator_helper'));
		echo render_form_codeformat('', '', '', 'minus');
	}

	public function send_data() {
		$this->load->library('form_validation');
		$this->load->model(['model_basic/base_query', 'model_code_format/m_code_format']);
		if ($this->input->is_ajax_request()) :
			$this->form_validation->set_rules($this->m_code_format->form_rules());
			if ($this->form_validation->run() == FALSE) :
				$str = $this->m_code_format->form_warning($this->form_errs);
				$str['confirm'] = 'error';
			else :
				$this->db->trans_begin();
				$data['kd_code_format'] = $this->input->post('txtKd');
				$data['nm_code_format'] = $this->input->post('txtNm');
				$data['code_for'] = $this->input->post('txtCodeFor');
				$data['code_reset'] = $this->input->post('selReset');
				$str = $this->base_query->submit_data('tm_code_format', 'kd_code_format', 'Code Format', $data);
				$m_alert = $str['alert'];
				if ($str['confirm'] == 'success') :
					$kd_code_format = $str['key'];
					$data_detail['code_format_kd'] = $str['key'];
					$data_detail['code_part'] = $this->input->post('selCodePart');
					$data_detail['code_unique'] = $this->input->post('txtCodeUnique');
					$data_detail['code_separator'] = $this->input->post('selSeparator');
					$str = [];
					$str = $this->m_code_format->submit_code_part($data_detail);
					if ($str['confirm'] == 'success') :
						$data['code_format'] = $str['code_format'];
						$act = $this->db->update('tm_code_format', ['code_format' => $data['code_format']], ['kd_code_format' => $kd_code_format]);
						$str['alert'] = $m_alert;
					endif;
				endif;
				if ($this->db->trans_status() === FALSE) :
					$this->db->trans_rollback();
				else :
			        $this->db->trans_commit();
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
			$str = $this->base_query->delete_data('tm_master_type', array('kd_master_type' => $id), 'Data Master Type');
			
			header('Content-Type: application/json');
			echo json_encode($str);
		endif;
	}
}