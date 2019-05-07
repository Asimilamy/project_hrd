<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Data_user extends MY_Controller {
	private $class_link = 'administrator/administrator/data_user';
	private $form_errs = array('idErrType', 'idErrId', 'idErrPass', 'idErrPassConf', 'idErrUsername');

	public function __construct() {
		parent::__construct();
		parent::datatables_assets();
		$this->load->model(array('model_auth/m_access', 'model_user/tm_user'));
		
		$access = $this->m_access->read_user_access('data_user', 'Administrator');
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
		$this->get_table();
	}

	public function get_table() {
		$this->load->model(['model_basic/base_query']);
		/* --START OF BOX DEFAULT PROPERTY-- */
		$data['page_title'] = 'Data User';
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

		$data = $this->tm_user->ssp_table();
		echo json_encode(
			Custom_ssp::simple( $_GET, $data['sql_details'], $data['table'], $data['primaryKey'], $data['columns'], $data['joinQuery'], $data['where'] )
		);
	}

	public function get_form() {
		$this->load->model(['model_basic/base_query']);
		$id = $this->input->get('id');

		/* --START OF BOX DEFAULT PROPERTY-- */
		$data['page_title'] = 'Data User';
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
		$data['data']['id'] = $id;
		$data['data']['form_errs'] = $this->form_errs;
		$this->load->view('containers/view_box', $data);
	}

	public function open_form() {
		$this->load->helper(array('form'));
		$id = $this->input->get('id');
		$data = $this->tm_user->get_data($id);
		$data['user_type_opts'] = render_dropdown('User Type', $this->base_query->get_all('tm_user_type'), 'kd_user_type', 'nm_user_type');
		$this->load->view('page/'.$this->class_link.'/form_main', $data);
	}

	public function send_data() {
		$this->load->library('form_validation');
		$this->load->model('model_basic/base_query');
		$this->load->helper('upload_file_helper');
		if ($this->input->is_ajax_request()) :
			$this->form_validation->set_rules($this->tm_user->form_rules());
			if ($this->form_validation->run() == FALSE) :
				$str = $this->tm_user->form_warning($this->form_errs);
				$str['confirm'] = 'error';
			else :
				$file_img = $_FILES['fileImage'];
				if (!empty($file_img['name'])) :
					$path = 'assets/admin_assets/images/users/';
					$upload = upload_file('fileImage', $path, 'jpg|png|gif', 'idErrFileImage');
					if (isset($upload['confirm']) && $upload['confirm'] == 'error') :
						header('Content-Type: application/json');
						echo json_encode($upload);
						exit();
					else :
						$user_img = $upload['upload_data']['file_name'];
						process_image_conf($path.$user_img, '150');
					endif;
				else :
					$user_img = $this->input->post('txtFileLama');
				endif;
				$data['kd_user'] = $this->input->post('txtKd');
				$data['user_type_kd'] = $this->input->post('selType');
				$data['user_id'] = $this->input->post('txtId');
				$data['user_name'] = $this->input->post('txtUsername');
				$data['user_img'] = $user_img;
				if (!empty($this->input->post('txtPass'))) :
					$data['user_pass'] = hash_text($this->input->post('txtPass'));
				endif;
				$str = $this->base_query->submit_data('tm_user', 'kd_user', 'Data User', $data);
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
			$str = $this->base_query->delete_data('tm_user', array('kd_user' => $id), 'Data User');
			
			header('Content-Type: application/json');
			echo json_encode($str);
		endif;
	}

	public function username_check($str) {
		if ($str == 'test') :
			$this->form_validation->set_message('username_check', '{field} tidak boleh menggunakan kata "test"');
			return FALSE;
		else :
			$this->db->from('tm_user')
				->where(array('user_id' => $str, 'kd_user !=' => $this->input->post('txtKd')));
			$query = $this->db->get();
			$return = $query->num_rows();
			if ($return > 0) :
				$this->form_validation->set_message('username_check', '{field} sudah digunakan, gunakan {field} lain!');
				return FALSE;
			else :
				return TRUE;
			endif;
		endif;
	}
}