<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class System_appareance extends MY_Controller {
	private $class_link = 'administrator/setting/personal_setting/system_appareance';
	private $form_errs = array('idErrNm');

	public function __construct() {
		parent::__construct();
		parent::datatables_assets();
		$this->load->model(array('model_auth/m_access', 'model_setting/tm_sys_appareance'));

		$access = $this->m_access->read_user_access('system_appareance', 'Personal Setting');
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
		$this->get_form();
	}

	public function get_form() {
		$this->load->model(array('model_basic/base_query'));
		
		/* --START OF BOX DEFAULT PROPERTY-- */
		$data['page_title'] = 'System Appareance';
		$data['box_type'] = 'Form';
		$data['page_search'] = FALSE;
		$data['js_file'] = 'form_js';
		/* --END OF BOX DEFAULT PROPERTY-- */
		
		/* --START OF BOX BUTTON PROPERTY-- */
		$data['btn_add'] = FALSE;
		$data['btn_hide'] = TRUE;
		$data['btn_close'] = FALSE;
		/* --END OF BOX BUTTON PROPERTY-- */
		
		/* --START OF BOX DATA PROPERTY-- */
		$data['data'] = $this->base_query->define_container($this->class_link, $data['box_type']);
		/* --END OF BOX DATA PROPERTY-- */
		$data['data']['id'] = $this->input->get('id');
		$data['data']['form_errs'] = $this->base_query->form_errs('tm_sys_appareance', 'kd_sys_appareance');
		$this->load->view('containers/view_box', $data);
	}

	public function open_form() {
		$this->load->model(array('model_basic/base_query'));
		$this->load->helper(array('form'));
		$id = $this->input->get('id');
		$data['form_sys'] = $this->base_query->get_all('tm_sys_appareance');
		$this->load->view('page/'.$this->class_link.'/form_main', $data);
	}

	public function send_data() {
		$this->load->library('form_validation');
		$this->load->model('model_basic/base_query');
		$this->load->helper('upload_file_helper');
		if ($this->input->is_ajax_request()) :
			$kd_sys_appareances = $this->input->post('txtKd');
			$val_sys_appareances = $this->input->post('txtValSys');
			$type_sys_appareances = $this->input->post('txtType');

			for ($i = 0; $i < count($kd_sys_appareances); $i++) :
				$kd_sys_appareance = $kd_sys_appareances[$i];
				$type_sys_appareance = $type_sys_appareances[$kd_sys_appareance];
				if ($type_sys_appareance == 'img') :
					$nm_file = 'fileValSys'.$kd_sys_appareance;
					$file_sys_appareance = $_FILES[$nm_file];
					if (!empty($file_sys_appareance['name'])) :
						$upload = upload_file($nm_file, 'assets/admin_assets/images/settings/', 'jpg|ico|png|gif', 'idErr'.$kd_sys_appareance);
						if (isset($upload['confirm']) && $upload['confirm'] == 'error') :
							header('Content-Type: application/json');
							echo json_encode($upload);
							exit();
						else :
							$file_sys_appareance = $upload['upload_data']['file_name'];
						endif;
						$data[] = ['kd_sys_appareance' => $kd_sys_appareance, 'val_sys_appareance' => $file_sys_appareance, 'tgl_edit' => date('Y-m-d H:i:s'), 'user_kd' => $_SESSION['user']['kd_user']];
					endif;
				else :
					$val_sys_appareance = $val_sys_appareances[$kd_sys_appareance];
					$data[] = ['kd_sys_appareance' => $kd_sys_appareance, 'val_sys_appareance' => $val_sys_appareance, 'tgl_edit' => date('Y-m-d H:i:s'), 'user_kd' => $_SESSION['user']['kd_user']];
				endif;
			endfor;
			if (isset($data)) :
				$str = $this->base_query->edit_batch('tm_sys_appareance', 'System Appareance', $data, 'kd_sys_appareance');
			else :
				$str = get_report(0, 'Mengubah System Appareance', $data);
			endif;
			$str['alert_stat'] = 'offline';
			$str['csrf_alert'] = '';
			$str['csrf'] = $this->security->get_csrf_hash();

			header('Content-Type: application/json');
			echo json_encode($str);
		endif;
	}
}