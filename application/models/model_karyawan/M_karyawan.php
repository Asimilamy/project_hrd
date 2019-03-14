<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class M_karyawan extends CI_Model {
	public function get_data_pribadi($kd_karyawan = '') {
		$this->db->select('a.kd_karyawan, a.nik_karyawan, a.nm_karyawan, a.no_ktp, a.jekel, a.tmp_lahir, a.tgl_lahir, a.alamat, a.tgl_aktif, b.nm_status_kerja, c.nm_unit, d.nm_bagian, e.nm_jabatan, f.no_telp_utama, f.no_telp_lain, f.email_utama, f.email_lain, f.foto_karyawan')
			->from('tm_karyawan a')
			->join('tm_status_kerja b', 'b.kd_status_kerja = a.status_kerja_kd', 'left')
			->join('tm_unit c', 'c.kd_unit = a.unit_kd', 'left')
			->join('tm_bagian d', 'd.kd_bagian = a.bagian_kd', 'left')
			->join('tm_jabatan e', 'e.kd_jabatan = a.jabatan_kd', 'left')
			->join('td_karyawan_info f', 'f.karyawan_kd = a.kd_karyawan', 'left')
			->where(array('a.kd_karyawan' => $kd_karyawan));
		$query = $this->db->get();
		$row = $query->row();
		if (!empty($row)) :
			$data = (object) ['kd_karyawan' => $row->kd_karyawan, 'nik_karyawan' => $row->nik_karyawan, 'nm_karyawan' => $row->nm_karyawan, 'no_ktp' => $row->no_ktp, 'jekel' => $row->jekel, 'tgl_aktif' => $row->tgl_aktif, 'nm_status_kerja' => $row->nm_status_kerja, 'nm_unit' => $row->nm_unit, 'nm_bagian' => $row->nm_bagian, 'nm_jabatan' => $row->nm_jabatan, 'no_telp_utama' => $row->no_telp_utama, 'no_telp_lain' => $row->no_telp_lain, 'email_utama' => $row->email_utama, 'email_lain' => $row->email_lain, 'tmp_lahir' => $row->tmp_lahir, 'tgl_lahir' => $row->tgl_lahir, 'alamat' => $row->alamat, 'foto_karyawan' => $row->foto_karyawan];
		else :
			$data = (object) ['kd_karyawan' => '', 'nik_karyawan' => '', 'nm_karyawan' => '', 'no_ktp' => '', 'jekel' => '', 'tgl_aktif' => '', 'nm_status_kerja' => '', 'nm_unit' => '', 'nm_bagian' => '', 'nm_jabatan' => '', 'no_telp_utama' => '', 'no_telp_lain' => '', 'email_utama' => '', 'email_lain' => '', 'tmp_lahir' => '', 'tgl_lahir' => '', 'alamat' => '', 'foto_karyawan' => ''];
		endif;
		$_SESSION['user']['detail_karyawan']['nik_karyawan'] = $data->nik_karyawan;
		return $data;
	}

	public function define_detail_table($kd_karyawan = '', $page_name = '') {
		$query = [];
		if ($page_name == 'data_pribadi') :
			$query['select'] = 'a.nm_karyawan, a.nik_karyawan, a.no_ktp, a.jekel, a.alamat, a.tmp_lahir, a.tgl_lahir, a.tgl_aktif, b.kd_karyawan_info, b.no_telp_utama, b.no_telp_lain, b.email_utama, b.email_lain, b.foto_karyawan';
			$query['table_a'] = 'tm_karyawan a';
			$query['join'] = ['table_b' => 'td_karyawan_info b', 'cond' => 'b.karyawan_kd = a.kd_karyawan'];
			$query['where'] = ['a.kd_karyawan' => $kd_karyawan];
			$query['get_column'] = (object) ['nm_karyawan', 'nik_karyawan', 'no_ktp', 'jekel', 'tgl_aktif', 'kd_karyawan_info', 'no_telp_utama', 'no_telp_lain', 'no_telp_lain', 'email_utama', 'email_lain', 'alamat', 'tmp_lahir', 'tgl_lahir', 'foto_karyawan'];
		elseif ($page_name == 'data_jabatan') :
			$query['select'] = 'kd_karyawan, unit_kd, bagian_kd, jabatan_kd, status_kerja_kd';
			$query['table_a'] = 'tm_karyawan';
			$query['join'] = [];
			$query['where'] = ['kd_karyawan' => $kd_karyawan];
			$query['get_column'] = (object) ['kd_karyawan', 'unit_kd', 'bagian_kd', 'jabatan_kd', 'status_kerja_kd'];
		endif;
		return $query;
	}

	public function fetch_detail($kd_karyawan = '', $page_name = '') {
		$conds = $this->define_detail_table($kd_karyawan, $page_name);
		if (!empty($conds)) :
			$this->db->select($conds['select'])
				->from($conds['table_a']);
			if (!empty($conds['join'])) :
				$this->db->join($conds['join']['table_b'], $conds['join']['cond'], 'left');
			endif;
			$this->db->where($conds['where']);
			$query = $this->db->get();
			$row = $query->row();
			$data = new stdClass();
			if (!empty($row)) :
				foreach ($conds['get_column'] as $col) :
					$data->{$col} = $row->{$col};
				endforeach;
			else :
				foreach ($conds['get_column'] as $col) :
					$data->{$col} = '';
				endforeach;
			endif;
			return $data;
		endif;
	}

	public function form_detail_errs($form_name = '') {
		$form_errs = [];
		if ($form_name == 'data_pribadi') :
			$form_errs = ['idErrNm', 'idErrTglMasuk', 'idErrFoto', 'idErrNoKtp', 'idErrJekel', 'idErrTmpLahir', 'idErrTglLahir', 'idErrAlamat', 'idErrTelpUtama', 'idErrTelpLain', 'idErrEmailUtama', 'idErrEmailLain'];
		elseif ($form_name == 'data_asuransi') :
			$form_errs = ['idErrAsuransi', 'idErrNoAsuransi', 'idErrTglMasuk', 'idErrStatusAsuransi'];
		elseif ($form_name == 'data_kontak') :
			$form_errs = ['idErrNamaKontak', 'idErrAlamat', 'idErrHubungan', 'idErrTelpUtama', 'idErrEmailUtama'];
		elseif ($form_name == 'data_keluarga') :
			$form_errs = ['idErrNamaKeluarga', 'idErrAlamat', 'idErrHubungan', 'idErrTelpUtama', 'idErrEmailUtama'];
		elseif ($form_name == 'data_jabatan') :
			$form_errs = ['idErrUnit', 'idErrBagian', 'idErrJabatan', 'idErrStatusKerja'];
		elseif ($form_name == 'histori_kontrak') :
			$form_errs = ['idErrClient', 'idErrUnit', 'idErrBagian', 'idErrJabatan', 'idErrTglMulai', 'idErrTglHabis'];
		elseif ($form_name == 'data_skills') :
			$form_errs = ['idErrSkill', 'idErrLevel'];
		endif;
		return $form_errs;
	}

	public function form_detail_rules($form_name = '') {
		if ($form_name == 'data_pribadi') :
			$rules = [
				['field' => 'txtTglMasuk', 'label' => 'Tgl Masuk', 'rules' => 'required'],
				['field' => 'txtNm', 'label' => 'Nama Karyawan', 'rules' => 'required'],
				['field' => 'txtNoKtp', 'label' => 'Nama Karyawan', 'rules' => 'required'],
				['field' => 'selJekel', 'label' => 'Nama Karyawan', 'rules' => 'required'],
				['field' => 'txtTmpLahir', 'label' =>  'Tempat Lahir', 'rules' => 'required'],
				['field' => 'txtTglLahir', 'label' => 'Tanggal Lahir', 'rules' => 'required'],
				['field' => 'txtAlamat', 'label' => 'Alamat Karyawan', 'rules' => 'required'],
				['field' => 'txtTelpUtama', 'label' => 'Telp Utama', 'rules' => 'required'],
				['field' => 'txtEmailUtama', 'label' => 'Email Utama', 'rules' => 'required|valid_email'],
			];
			if (!empty($this->input->post('txtTelpLain'))) :
				$rules = array_merge($rules, [['field' => 'txtTelpLain', 'label' => 'Telp Lain', 'rules' => 'differs[txtTelpUtama]']]);
			endif;
			if (!empty($this->input->post('txtEmailLain'))) :
				$rules = array_merge($rules, [['field' => 'txtEmailLain', 'label' => 'Email Lain', 'rules' => 'required|valid_email|differs[txtEmailUtama]']]);
			endif;
		elseif ($form_name == 'data_asuransi') :
			$rules = [
				['field' => 'selAsuransi', 'label' => 'Nama Asuransi', 'rules' => 'required'],
				['field' => 'txtNoAsuransi', 'label' => 'No Asuransi', 'rules' => 'required'],
				['field' => 'txtTglMasuk', 'label' => 'Tgl Masuk', 'rules' => 'required'],
				['field' => 'selStatusAsuransi', 'label' => 'Status Asuransi', 'rules' => 'required'],
			];
		elseif ($form_name == 'data_kontak') :
			$rules = [
				['field' => 'txtNmKontak', 'label' => 'Nama Kontak', 'rules' => 'required'],
				['field' => 'txtAlamat', 'label' => 'Alamat', 'rules' => 'required'],
				['field' => 'selHubungan', 'label' => 'Hubungan', 'rules' => 'required'],
				['field' => 'txtTelp', 'label' => 'Telp Utama', 'rules' => 'required'],
				['field' => 'txtEmail', 'label' => 'Email Utama', 'rules' => 'required|valid_email'],
			];
		elseif ($form_name == 'data_keluarga') :
			$rules = [
				['field' => 'txtNmKeluarga', 'label' => 'Nama Keluarga', 'rules' => 'required'],
				['field' => 'txtAlamat', 'label' => 'Alamat', 'rules' => 'required'],
				['field' => 'selHubungan', 'label' => 'Hubungan', 'rules' => 'required'],
				['field' => 'txtTelp', 'label' => 'Telp Utama', 'rules' => 'required'],
				['field' => 'txtEmail', 'label' => 'Email Utama', 'rules' => 'required|valid_email'],
			];
		elseif ($form_name == 'data_jabatan') :
			$rules = [
				['field' => 'selUnit', 'label' => 'Unit', 'rules' => 'required'],
				['field' => 'selBagian', 'label' => 'Bagian', 'rules' => 'required'],
				['field' => 'selJabatan', 'label' => 'Jabatan', 'rules' => 'required'],
				['field' => 'selStatusKerja', 'label' => 'Status Kerja', 'rules' => 'required'],
			];
		elseif ($form_name == 'histori_kontrak') :
			$rules = [
				['field' => 'selClient', 'label' => 'Client', 'rules' => 'required'],
				['field' => 'txtUnit', 'label' => 'Unit', 'rules' => 'required'],
				['field' => 'txtBagian', 'label' => 'Bagian', 'rules' => 'required'],
				['field' => 'txtJabatan', 'label' => 'Jabatan', 'rules' => 'required'],
				['field' => 'txtTglMulai', 'label' => 'Tgl Mulai', 'rules' => 'required'],
				['field' => 'txtTglHabis', 'label' => 'Tgl Habis', 'rules' => 'required'],
			];
		elseif ($form_name == 'data_skills') :
			$rules = [
				['field' => 'txtSkill', 'label' => 'Nama Skill', 'rules' => 'required'],
				['field' => 'selLevel', 'label' => 'Level Skill', 'rules' => 'required'],
			];
		endif;
		return $rules;
	}

	public function form_detail_warning($form_name = '', $datas = '') {
		if ($form_name == 'data_pribadi') :
			$forms = array('txtNm', 'txtTglMasuk', 'fileFoto', 'txtNoKtp', 'selJekel', 'txtTmpLahir', 'txtTglLahir', 'txtAlamat', 'txtTelpUtama', 'txtTelpLain', 'txtEmailUtama', 'txtEmailLain');
		elseif ($form_name == 'data_asuransi') :
			$forms = ['selAsuransi', 'txtNoAsuransi', 'txtTglMasuk', 'selStatusAsuransi'];
		elseif ($form_name == 'data_kontak') :
			$forms = ['txtNmKontak', 'txtAlamat', 'selHubungan', 'txtTelp', 'txtEmail'];
		elseif ($form_name == 'data_keluarga') :
			$forms = ['txtNmKeluarga', 'txtAlamat', 'selHubungan', 'txtTelp', 'txtEmail'];
		elseif ($form_name == 'data_jabatan') :
			$forms = ['selUnit', 'selBagian', 'selJabatan', 'selStatusKerja'];
		elseif ($form_name == 'histori_kontrak') :
			$forms = ['selClient', 'txtUnit', 'txtBagian', 'txtJabatan', 'txtTglMulai', 'txtTglHabis'];
		elseif ($form_name == 'data_skills') :
			$forms = ['txtSkill', 'selLevel'];
		endif;
		foreach ($datas as $key => $data) :
			$str[$data] = (!empty(form_error($forms[$key])))?build_label('warning', form_error($forms[$key], '"', '"')):'';
		endforeach;
		return $str;
	}

	public function submit_form_detail($page_name = '') {
		$this->load->model(['model_basic/base_query', 'model_code_format/m_code_format']);
		$this->load->helper('upload_file_helper');
		if ($page_name == 'data_pribadi') :
			$file_img = $_FILES['fileFoto'];
			if (!empty($file_img['name'])) :
				$path = 'assets/admin_assets/images/employees/';
				$upload = upload_file('fileFoto', $path, 'jpg|png|gif', 'idErrFoto');
				if (isset($upload['confirm']) && $upload['confirm'] == 'error') :
					header('Content-Type: application/json');
					echo json_encode($upload);
					exit();
				else :
					$user_img = $upload['upload_data']['file_name'];
					process_image_conf($path.$user_img, '150');
				endif;
			else :
				$user_img = $this->input->post('txtFileFotoLama');
			endif;
			$master['kd_karyawan'] = $this->input->post('txtKd');
			$master['nm_karyawan'] = $this->input->post('txtNm');
			$master['nik_karyawan'] = empty($master['kd_karyawan'])?$this->m_code_format->generate_code('format_nik'):$_SESSION['user']['detail_karyawan']['nik_karyawan'];
			$master['tgl_aktif'] = format_date($this->input->post('txtTglMasuk'), 'Y-m-d');
			$master['no_ktp'] = $this->input->post('txtNoKtp');
			$master['alamat'] = $this->input->post('txtAlamat');
			$master['jekel'] = $this->input->post('selJekel');
			$master['tmp_lahir'] = $this->input->post('txtTmpLahir');
			$master['tgl_lahir'] = format_date($this->input->post('txtTglLahir'), 'Y-m-d');
			$detail['karyawan_kd'] = $master['kd_karyawan'];
			$detail['kd_karyawan_info'] = $this->input->post('txtKdKaryawanInfo');
			$detail['no_telp_utama'] = $this->input->post('txtTelpUtama');
			$detail['no_telp_lain'] = $this->input->post('txtTelpLain');
			$detail['email_utama'] = $this->input->post('txtEmailUtama');
			$detail['email_lain'] = $this->input->post('txtEmailLain');
			$detail['foto_karyawan'] = $user_img;
			$str = $this->base_query->submit_data('tm_karyawan', 'kd_karyawan', 'Data Info Karyawan', $master);
			$master_key = $str['key'];
			if ($str['confirm'] == 'success') :
				$str = [];
				$detail['karyawan_kd'] = empty($detail['kd_karyawan'])?$master_key:$detail['karyawan_kd'];
				$str = $this->base_query->submit_data('td_karyawan_info', 'kd_karyawan_info', 'Data Info Karyawan', $detail);
				$str['key'] = $master_key;
			endif;
		elseif ($page_name == 'data_asuransi') :
			$data['kd_karyawan_asuransi'] = $this->input->post('txtKd');
			$data['asuransi_kd'] = $this->input->post('selAsuransi');
			$data['karyawan_kd'] = $this->input->post('txtKdKaryawan');
			$data['no_asuransi'] = $this->input->post('txtNoAsuransi');
			$data['tgl_masuk'] = format_date($this->input->post('txtTglMasuk'), 'Y-m-d');
			$data['status_asuransi'] = $this->input->post('selStatusAsuransi');
			$str = $this->base_query->submit_data('td_karyawan_asuransi', 'kd_karyawan_asuransi', 'Data Asuransi Karyawan', $data);
		elseif ($page_name == 'data_kontak') :
			$data['kd_karyawan_kontak'] = $this->input->post('txtKd');
			$data['karyawan_kd'] = $this->input->post('txtKdKaryawan');
			$data['nm_kontak'] = $this->input->post('txtNmKontak');
			$data['alamat'] = $this->input->post('txtAlamat');
			$data['hubungan'] = $this->input->post('selHubungan');
			$data['telp_utama'] = $this->input->post('txtTelp');
			$data['email_utama'] = $this->input->post('txtEmail');
			$str = $this->base_query->submit_data('td_karyawan_kontak', 'kd_karyawan_kontak', 'Data Kontak Karyawan', $data);
		elseif ($page_name == 'data_keluarga') :
			$data['kd_karyawan_keluarga'] = $this->input->post('txtKd');
			$data['karyawan_kd'] = $this->input->post('txtKdKaryawan');
			$data['nm_keluarga'] = $this->input->post('txtNmKeluarga');
			$data['alamat'] = $this->input->post('txtAlamat');
			$data['hubungan'] = $this->input->post('selHubungan');
			$data['telp_utama'] = $this->input->post('txtTelp');
			$data['email_utama'] = $this->input->post('txtEmail');
			$str = $this->base_query->submit_data('td_karyawan_keluarga', 'kd_karyawan_keluarga', 'Data Keluarga Karyawan', $data);
		elseif ($page_name == 'data_jabatan') :
			$data['kd_karyawan'] = $_SESSION['user']['detail_karyawan']['kd_karyawan'];
			$data['unit_kd'] = $this->input->post('selUnit');
			$data['bagian_Kd'] = $this->input->post('selBagian');
			$data['jabatan_kd'] = $this->input->post('selJabatan');
			$data['status_kerja_kd'] = $this->input->post('selStatusKerja');
			$str = $this->base_query->submit_data('tm_karyawan', 'kd_karyawan', 'Data Jabatan Karyawan', $data);
		elseif ($page_name == 'histori_kontrak') :
			$data['karyawan_kd'] = $_SESSION['user']['detail_karyawan']['kd_karyawan'];
			$data['kd_karyawan_kontrak'] = $this->input->post('txtKd');
			$data['client_kd'] = $this->input->post('selClient');
			$data['unit_kontrak'] = $this->input->post('txtUnit');
			$data['bagian_kontrak'] = $this->input->post('txtBagian');
			$data['jabatan_kontrak'] = $this->input->post('txtJabatan');
			$data['tgl_mulai'] = format_date($this->input->post('txtTglMulai'), 'Y-m-d');
			$data['tgl_habis'] = format_date($this->input->post('txtTglHabis'), 'Y-m-d');
			$str = $this->base_query->submit_data('td_karyawan_kontrak', 'kd_karyawan_kontrak', 'Data Kontrak Karyawan', $data);
		elseif ($page_name == 'data_skills') :
			$data['karyawan_kd'] = $_SESSION['user']['detail_karyawan']['kd_karyawan'];
			$data['kd_karyawan_skill'] = $this->input->post('txtKd');
			$data['nm_skill'] = $this->input->post('txtSkill');
			$data['lvl_skill'] = $this->input->post('selLevel');
			$str = $this->base_query->submit_data('td_karyawan_skill', 'kd_karyawan_skill', 'Data Skills Karyawan', $data);
		endif;
		return $str;
	}

	public function get_delete_data($page_name = '', $kd_param = '') {
		if ($page_name == 'data_pribadi') :
		elseif ($page_name == 'data_asuransi') :
			$str['tbl_name'] = 'td_karyawan_asuransi';
			$str['params'] = ['kd_karyawan_asuransi' => $kd_param];
			$str['title_name'] = 'Data Karyawan Asuransi';
		elseif ($page_name == 'data_kontak') :
			$str['tbl_name'] = 'td_karyawan_kontak';
			$str['params'] = ['kd_karyawan_kontak' => $kd_param];
			$str['title_name'] = 'Data Kontak Karyawan';
		elseif ($page_name == 'data_keluarga') :
			$str['tbl_name'] = 'td_karyawan_keluarga';
			$str['params'] = ['kd_karyawan_keluarga' => $kd_param];
			$str['title_name'] = 'Data Keluarga Karyawan';
		elseif ($page_name == 'histori_kontrak') :
			$str['tbl_name'] = 'td_karyawan_kontrak';
			$str['params'] = ['kd_karyawan_kontrak' => $kd_param];
			$str['title_name'] = 'Data Kontrak Karyawan';
		elseif ($page_name == 'data_skills') :
			$str['tbl_name'] = 'td_karyawan_skill';
			$str['params'] = ['kd_karyawan_skill' => $kd_param];
			$str['title_name'] = 'Data Skills Karyawan';
		endif;
		return $str;
	}
}