<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Detail_pegawai extends MY_Controller {
	private $class_link = 'administrator/personal_identification_manager/detail_pegawai';

	public function __construct() {
		parent::__construct();
		parent::datatables_assets();
		$this->load->model(array('model_auth/m_access', 'model_karyawan/tm_karyawan'));
		// $this->output->enable_profiler(TRUE);

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
		redirect('myerror');
	}

	public function register_detail() {
		$id = $this->input->get('id');
		$_SESSION['user']['detail_karyawan']['kd_karyawan'] = $id;
		$this->get_detail();
	}

	public function get_detail() {
		$this->load->model(['model_basic/base_query']);
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
		$data['data'] = $this->base_query->define_container($this->class_link, $data['box_type']);
		/* --END OF BOX DATA PROPERTY-- */
		$this->load->view('containers/view_box', $data);
	}

	public function open_detail() {
		$this->load->model(['model_karyawan/m_karyawan']);
		$data['class_link'] = $this->class_link;
		$data['detail_karyawan'] = $this->m_karyawan->get_data_pribadi();
		$this->load->view('page/'.$this->class_link.'/detail_main', $data);
	}

	public function get_profile_badge() {
		$this->load->model(['model_karyawan/m_karyawan']);
		$data['detail_karyawan'] = $this->m_karyawan->get_data_pribadi();
		$this->load->view('page/'.$this->class_link.'/profile_badge', $data);
	}

	public function get_main_detail() {
		$this->load->model(array('model_karyawan/m_karyawan'));
		$this->load->helper(array('form'));

		$_SESSION['user']['detail_karyawan']['page_name'] = $this->input->get('page_name');
		$page_name = $_SESSION['user']['detail_karyawan']['page_name'];
		$data['page_name'] = $page_name;
		$data['class_link'] = $this->class_link;
		$data['form_errs'] = $this->m_karyawan->form_detail_errs($page_name);
		$data['detail_karyawan'] = $this->m_karyawan->get_data_pribadi();
		$page_url = 'page/'.$this->class_link.'/form_detail/'.$page_name.'_form_main';
		if (file_exists(FCPATH.'application/views/'.$page_url.'.php')) :
			$this->load->view($page_url, $data);
		else :
			$page_url = 'page/'.$this->class_link.'/form_detail/'.$page_name.'/'.$page_name.'_form_main';
			if (file_exists(FCPATH.'application/views/'.$page_url.'.php')) :
				$this->load->view($page_url, $data);
			else :
				echo $page_name.' - File Not Exist!';
			endif;
		endif;
	}

	public function get_complete_detail() {
		$this->load->model(array('model_basic/base_query', 'model_karyawan/m_karyawan'));
		$this->load->helper(array('form'));
		
		$file_type = $this->input->get('file_type');
		$page_name = $_SESSION['user']['detail_karyawan']['page_name'];
		if ($file_type == 'form') :
			$data = $this->m_karyawan->get_complete_detail($page_name);
		endif;
		$data['page_name'] = $page_name;
		$data['class_link'] = $this->class_link;
		$data['form_errs'] = $this->m_karyawan->form_detail_errs($page_name);
		$page_url = 'page/'.$this->class_link.'/form_detail/'.$page_name.'/'.$file_type.'_main';
		if (file_exists(FCPATH.'application/views/'.$page_url.'.php')) :
			$this->load->view($page_url, $data);
		else :
			echo $page_name.' - File Not Exist!';
		endif;
	}

	public function define_status_kerja() {
		$this->load->model(['model_basic/base_query']);
		$kd_status_kerja = $this->input->get('kd_status_kerja');
		$row = $this->base_query->get_row('tm_status_kerja', ['kd_status_kerja' => $kd_status_kerja]);
		$str['has_contract'] = !empty($row)?$row->has_contract:'0';
		$_SESSION['user']['detail_karyawan']['has_contract'] = $str['has_contract'];
		header('Content-Type: application/json');
		echo json_encode($str);
	}

	public function send_data_detail() {
		$this->load->library('form_validation');
		$this->load->model(array('model_basic/base_query', 'model_karyawan/m_karyawan'));
		$this->load->helper('date');
		if ($this->input->is_ajax_request()) :
			$page_name = $_SESSION['user']['detail_karyawan']['page_name'];
			$this->form_validation->set_rules($this->m_karyawan->form_detail_rules($page_name));
			if ($this->form_validation->run() == FALSE) :
				$str = $this->m_karyawan->form_detail_warning($page_name, $this->m_karyawan->form_detail_errs($page_name));
				$str['confirm'] = 'error';
			else :
				$str = $this->m_karyawan->submit_form_detail($page_name);
			endif;
			if (empty($_SESSION['user']['detail_karyawan']['kd_karyawan']) && $str['confirm'] == 'success') :
				$_SESSION['user']['detail_karyawan']['kd_karyawan'] = $str['key'];
				$str['reload'] = 'yes';
			endif;
			$str['form_data'] = $this->input->post();
			$str['alert_stat'] = 'offline';
			$str['csrf_alert'] = '';
			$str['csrf'] = $this->security->get_csrf_hash();

			header('Content-Type: application/json');
			echo json_encode($str);
		endif;
	}

	public function compare_date() {
		$tgl_mulai = strtotime($this->input->post('txtTglMulai'));
		$tgl_habis = strtotime($this->input->post('txtTglHabis'));
	  
		if ($tgl_habis >= $tgl_mulai)
			return TRUE;
		else {
			$this->form_validation->set_message('compare_date', 'Tanggal Habis tidak boleh kurang dari Tanggal Mulai');
			return FALSE;
		}
	}

	public function table_detail_data() {
		$this->load->library(array('custom_ssp'));
		$this->load->model(array('model_karyawan/m_karyawan'));

		$data = $this->m_karyawan->get_ssp($_SESSION['user']['detail_karyawan']['page_name']);
		echo json_encode(
			Custom_SSP::simple( $_GET, $data['sql_details'], $data['table'], $data['primaryKey'], $data['columns'], $data['joinQuery'], $data['where'] )
		);
	}

	public function delete_data_detail() {
		$this->load->model('model_karyawan/m_karyawan');
		$this->load->model('model_basic/base_query');
		if ($this->input->is_ajax_request()) :
			$id = $this->input->get('id');
			$page_name = $_SESSION['user']['detail_karyawan']['page_name'];
			$data = $this->m_karyawan->get_delete_data($page_name, $id);
			$str = $this->base_query->delete_data($data['tbl_name'], $data['params'], $data['title_name']);
			if ($str['confirm'] == 'success' && $page_name == 'histori_kontrak') :
				$this->db->from('td_karyawan_kontrak')
					->order_by('tgl_mulai', 'DESC')
					->limit(1);
				$query = $this->db->get();
				$row = $query->row();
				if (!empty($row)) :
					$this->base_query->edit_batch('td_karyawan_kontrak', 'Data Kontrak Karyawan', [['is_active' => '1', 'kd_karyawan_kontrak' => $row->kd_karyawan_kontrak]], 'kd_karyawan_kontrak');
				endif;
				$this->m_karyawan->get_data_pribadi();
				$str['load_profile_badge'] = 'yes';
			endif;
			
			header('Content-Type: application/json');
			echo json_encode($str);
		endif;
	}
}