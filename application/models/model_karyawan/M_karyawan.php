<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class M_karyawan extends CI_Model {
	public function get_data_pribadi() {
		$this->load->model(['model_setting/m_setting']);
		$kd_karyawan = $_SESSION['user']['detail_karyawan']['kd_karyawan'];
		$this->db->select('a.kd_karyawan, a.nik_karyawan, a.nm_karyawan, a.no_ktp, a.jekel, a.tmp_lahir, a.tgl_lahir, a.alamat, a.tgl_aktif, b.kd_karyawan_info, b.no_telp_utama, b.no_telp_lain, b.email_utama, b.email_lain, b.foto_karyawan')
			->from('tm_karyawan a')
			->join('td_karyawan_info b', 'b.karyawan_kd = a.kd_karyawan', 'left')
			->where(['a.kd_karyawan' => $kd_karyawan]);
		$query = $this->db->get();
		$row = $query->row();
		$this->db->select('b.nm_client, c.nm_status_kerja, d.nm_unit, e.nm_bagian, f.nm_jabatan')
			->from('td_karyawan_kontrak a')
			->join('tm_client b', 'b.kd_client = a.client_kd', 'left')
			->join('tm_status_kerja c', 'c.kd_status_kerja = a.status_kerja_kd', 'left')
			->join('tm_unit d', 'd.kd_unit = a.unit_kd', 'left')
			->join('tm_bagian e', 'e.kd_bagian = a.bagian_kd', 'left')
			->join('tm_jabatan f', 'f.kd_jabatan = a.jabatan_kd', 'left')
			->where(['a.karyawan_kd' => $kd_karyawan, 'a.is_active' => '1']);
		$query = $this->db->get();
		$r_kontrak = $query->row();
		$default_user_img = $this->m_setting->get_setting('default_user_img');
		if (!empty($row)) :
			$data = (object) ['kd_karyawan' => $row->kd_karyawan, 'nik_karyawan' => $row->nik_karyawan, 'nm_karyawan' => $row->nm_karyawan, 'no_ktp' => $row->no_ktp, 'jekel' => $row->jekel, 'tmp_lahir' => $row->tmp_lahir, 'tgl_lahir' => $row->tgl_lahir, 'alamat' => $row->alamat, 'tgl_aktif' => $row->tgl_aktif, 'kd_karyawan_info' => $row->kd_karyawan_info, 'no_telp_utama' => $row->no_telp_utama, 'no_telp_lain' => $row->no_telp_lain, 'email_utama' => $row->email_utama, 'email_lain' => $row->email_lain, 'foto_karyawan' => $row->foto_karyawan, 'default_user_img' => $default_user_img];
			$data->nm_client = !empty($r_kontrak)?$r_kontrak->nm_client:'';
			$data->nm_status_kerja = !empty($r_kontrak)?$r_kontrak->nm_status_kerja:'';
			$data->nm_unit = !empty($r_kontrak)?$r_kontrak->nm_unit:'';
			$data->nm_bagian = !empty($r_kontrak)?$r_kontrak->nm_bagian:'';
			$data->nm_jabatan = !empty($r_kontrak)?$r_kontrak->nm_jabatan:'';
		else :
			$data = (object) ['kd_karyawan' => '', 'nik_karyawan' => '', 'nm_karyawan' => '', 'no_ktp' => '', 'jekel' => '', 'tmp_lahir' => '', 'tgl_lahir' => '', 'alamat' => '', 'tgl_aktif' => '', 'kd_karyawan_info' => '', 'no_telp_utama' => '', 'no_telp_lain' => '', 'email_utama' => '', 'email_lain' => '', 'foto_karyawan' => '', 'nm_client' => '', 'nm_status_kerja' => '', 'nm_unit' => '', 'nm_bagian' => '', 'nm_jabatan' => '', 'default_user_img' => $default_user_img];
		endif;
		$_SESSION['user']['detail_karyawan']['nik_karyawan'] = $data->nik_karyawan;
		return $data;
	}

	public function get_complete_detail($page_name = '') {
		if ($page_name == 'histori_kontrak') :
			$this->load->model(array('model_karyawan/td_karyawan_kontrak'));
			$table = 'td_karyawan_kontrak';
			$p_key = $this->input->get('kd_karyawan_kontrak');
			$data['opts_type_karyawan'] = render_dropdown('Type Karyawan', (object) ['0' => (object) ['key' => 'internal', 'value' => 'Internal'], '1' => (object) ['key' => 'outsourcing', 'value' => 'Outsourcing']], 'key', 'value');
			$data['opts_client'] = render_dropdown('Client', $this->base_query->get_all('tm_client'), 'kd_client', 'nm_client');
			$data['opts_unit'] = render_dropdown('Unit', $this->base_query->get_all('tm_unit'), 'kd_unit', 'nm_unit');
			$data['opts_bagian'] = render_dropdown('Bagian', $this->base_query->get_all('tm_bagian'), 'kd_bagian', 'nm_bagian');
			$data['opts_jabatan'] = render_dropdown('Jabatan', $this->base_query->get_all('tm_jabatan'), 'kd_jabatan', 'nm_jabatan');
			$data['opts_status_kerja'] = render_dropdown('Status Kerja', $this->base_query->get_all('tm_status_kerja'), 'kd_status_kerja', 'nm_status_kerja');
		elseif ($page_name == 'data_skills') :
			$this->load->model(array('model_karyawan/td_karyawan_skill'));
			$table = 'td_karyawan_skill';
			$p_key = $this->input->get('kd_karyawan_skill');
		elseif ($page_name == 'data_asuransi') :
			$this->load->model(array('model_karyawan/td_karyawan_asuransi'));
			$data['opts_asuransi'] = render_dropdown('Asuransi', $this->base_query->get_all('tm_asuransi'), 'kd_asuransi', 'nm_asuransi');
			$table = 'td_karyawan_asuransi';
			$p_key = $this->input->get('kd_karyawan_asuransi');
		elseif ($page_name == 'data_keluarga') :
			$this->load->model(array('model_karyawan/td_karyawan_keluarga'));
			$table = 'td_karyawan_keluarga';
			$p_key = $this->input->get('kd_karyawan_keluarga');
		elseif ($page_name == 'data_kontak') :
			$this->load->model(array('model_karyawan/td_karyawan_kontak'));
			$table = 'td_karyawan_kontak';
			$p_key = $this->input->get('kd_karyawan_kontak');
		endif;
		$data['form_data'] = $this->{$table}->get_data($p_key);
		return $data;
	}

	public function get_ssp($page_name = '') {
		if ($page_name == 'histori_kontrak') :
			$this->load->model(array('model_karyawan/td_karyawan_kontrak'));
			$data = $this->td_karyawan_kontrak->ssp_table();
		elseif ($page_name == 'data_skills') :
			$this->load->model(array('model_karyawan/td_karyawan_skill'));
			$data = $this->td_karyawan_skill->ssp_table();
		elseif ($page_name == 'data_asuransi') :
			$this->load->model(array('model_karyawan/td_karyawan_asuransi'));
			$data = $this->td_karyawan_asuransi->ssp_table();
		elseif ($page_name == 'data_keluarga') :
			$this->load->model(array('model_karyawan/td_karyawan_keluarga'));
			$data = $this->td_karyawan_keluarga->ssp_table();
		elseif ($page_name == 'data_kontak') :
			$this->load->model(array('model_karyawan/td_karyawan_kontak'));
			$data = $this->td_karyawan_kontak->ssp_table();
		endif;
		return $data;
	}

	public function form_detail_errs($form_name = '') {
		$form_errs = [];
		if ($form_name == 'data_pribadi') :
			$form_errs = ['idErrNm', 'idErrTglMasuk', 'idErrFoto', 'idErrNoKtp', 'idErrJekel', 'idErrTmpLahir', 'idErrTglLahir', 'idErrAlamat', 'idErrTelpUtama', 'idErrTelpLain', 'idErrEmailUtama', 'idErrEmailLain'];
		elseif ($form_name == 'histori_kontrak') :
			$form_errs = ['idErrTypeKaryawan', 'idErrClient', 'idErrUnit', 'idErrBagian', 'idErrJabatan', 'idErrStatusKerja', 'idErrTglMulai', 'idErrTglHabis'];
		elseif ($form_name == 'data_skills') :
			$form_errs = ['idErrSkill', 'idErrLevel'];
		elseif ($form_name == 'data_asuransi') :
			$form_errs = ['idErrAsuransi', 'idErrNoAsuransi', 'idErrTglMasuk', 'idErrStatusAsuransi'];
		elseif ($form_name == 'data_keluarga') :
			$form_errs = ['idErrNamaKeluarga', 'idErrAlamat', 'idErrHubungan', 'idErrTelpUtama', 'idErrEmailUtama'];
		elseif ($form_name == 'data_kontak') :
			$form_errs = ['idErrNamaKontak', 'idErrAlamat', 'idErrHubungan', 'idErrTelpUtama', 'idErrEmailUtama'];
		endif;
		return $form_errs;
	}

	public function form_detail_rules($form_name = '') {
		if ($form_name == 'data_pribadi') :
			$rules = [
				['field' => 'txtTglMasuk', 'label' => 'Tgl Masuk', 'rules' => 'required'],
				['field' => 'txtNm', 'label' => 'Nama Karyawan', 'rules' => 'required'],
				['field' => 'txtNoKtp', 'label' => 'No KTP', 'rules' => 'required'],
				['field' => 'selJekel', 'label' => 'Jenis Kelamin', 'rules' => 'required'],
				['field' => 'txtTmpLahir', 'label' =>  'Tempat Lahir', 'rules' => 'required'],
				['field' => 'txtTglLahir', 'label' => 'Tanggal Lahir', 'rules' => 'required'],
				['field' => 'txtAlamat', 'label' => 'Alamat Karyawan', 'rules' => 'required'],
				['field' => 'txtTelpUtama', 'label' => 'Telp Utama', 'rules' => 'required|numeric|min_length[8]'],
				['field' => 'txtEmailUtama', 'label' => 'Email Utama', 'rules' => 'required|valid_email'],
			];
			if (!empty($this->input->post('txtTelpLain'))) :
				$rules = array_merge($rules, [['field' => 'txtTelpLain', 'label' => 'Telp Lain', 'rules' => 'differs[txtTelpUtama]numeric||min_length[8]']]);
			endif;
			if (!empty($this->input->post('txtEmailLain'))) :
				$rules = array_merge($rules, [['field' => 'txtEmailLain', 'label' => 'Email Lain', 'rules' => 'valid_email|differs[txtEmailUtama]']]);
			endif;
		elseif ($form_name == 'histori_kontrak') :
			$rules = [
				['field' => 'selTypeKaryawan', 'label' => 'Type Karyawan', 'rules' => 'required'],
				['field' => 'selUnit', 'label' => 'Unit', 'rules' => 'required'],
				['field' => 'selBagian', 'label' => 'Bagian', 'rules' => 'required'],
				['field' => 'selJabatan', 'label' => 'Jabatan', 'rules' => 'required'],
				['field' => 'selStatusKerja', 'label' => 'Status Kerja', 'rules' => 'required'],
			];
			if ($this->input->post('selTypeKaryawan') == 'outsourcing') :
				$rules = array_merge($rules, [
					['field' => 'selClient', 'label' => 'Client', 'rules' => 'required']
				]);
			endif;
			if ($_SESSION['user']['detail_karyawan']['has_contract'] == '1') :
				$rules = array_merge($rules, [
					['field' => 'txtTglMulai', 'label' => 'Tgl Mulai', 'rules' => 'required|callback_compare_date'],
					['field' => 'txtTglHabis', 'label' => 'Tgl Habis', 'rules' => 'required|callback_compare_date']
				]);
			else :
				$rules = array_merge($rules, [
					['field' => 'txtTglMulai', 'label' => 'Tgl Mulai', 'rules' => 'required']
				]);
			endif;
		elseif ($form_name == 'data_skills') :
			$rules = [
				['field' => 'txtSkill', 'label' => 'Nama Skill', 'rules' => 'required'],
				['field' => 'selLevel', 'label' => 'Level Skill', 'rules' => 'required'],
			];
		elseif ($form_name == 'data_asuransi') :
			$rules = [
				['field' => 'selAsuransi', 'label' => 'Nama Asuransi', 'rules' => 'required'],
				['field' => 'txtNoAsuransi', 'label' => 'No Asuransi', 'rules' => 'required'],
				['field' => 'txtTglMasuk', 'label' => 'Tgl Masuk', 'rules' => 'required'],
				['field' => 'selStatusAsuransi', 'label' => 'Status Asuransi', 'rules' => 'required'],
			];
		elseif ($form_name == 'data_keluarga') :
			$rules = [
				['field' => 'txtNmKeluarga', 'label' => 'Nama Keluarga', 'rules' => 'required'],
				['field' => 'txtAlamat', 'label' => 'Alamat', 'rules' => 'required'],
				['field' => 'selHubungan', 'label' => 'Hubungan', 'rules' => 'required'],
				['field' => 'txtTelp', 'label' => 'Telp Utama', 'rules' => 'required'],
				['field' => 'txtEmail', 'label' => 'Email Utama', 'rules' => 'required|valid_email'],
			];
		elseif ($form_name == 'data_kontak') :
			$rules = [
				['field' => 'txtNmKontak', 'label' => 'Nama Kontak', 'rules' => 'required'],
				['field' => 'txtAlamat', 'label' => 'Alamat', 'rules' => 'required'],
				['field' => 'selHubungan', 'label' => 'Hubungan', 'rules' => 'required'],
				['field' => 'txtTelp', 'label' => 'Telp Utama', 'rules' => 'required'],
				['field' => 'txtEmail', 'label' => 'Email Utama', 'rules' => 'required|valid_email'],
			];
		endif;
		return $rules;
	}

	public function form_detail_warning($form_name = '', $datas = '') {
		if ($form_name == 'data_pribadi') :
			$forms = array('txtNm', 'txtTglMasuk', 'fileFoto', 'txtNoKtp', 'selJekel', 'txtTmpLahir', 'txtTglLahir', 'txtAlamat', 'txtTelpUtama', 'txtTelpLain', 'txtEmailUtama', 'txtEmailLain');
		elseif ($form_name == 'histori_kontrak') :
			$forms = ['selTypeKaryawan', 'selClient', 'selUnit', 'selBagian', 'selJabatan', 'selStatusKerja', 'txtTglMulai', 'txtTglHabis'];
		elseif ($form_name == 'data_skills') :
			$forms = ['txtSkill', 'selLevel'];
		elseif ($form_name == 'data_asuransi') :
			$forms = ['selAsuransi', 'txtNoAsuransi', 'txtTglMasuk', 'selStatusAsuransi'];
		elseif ($form_name == 'data_keluarga') :
			$forms = ['txtNmKeluarga', 'txtAlamat', 'selHubungan', 'txtTelp', 'txtEmail'];
		elseif ($form_name == 'data_kontak') :
			$forms = ['txtNmKontak', 'txtAlamat', 'selHubungan', 'txtTelp', 'txtEmail'];
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
			$master['no_ktp'] = $this->input->post('txtNoKtp');
			$master['jekel'] = $this->input->post('selJekel');
			$master['tmp_lahir'] = $this->input->post('txtTmpLahir');
			$master['tgl_lahir'] = format_date($this->input->post('txtTglLahir'), 'Y-m-d');
			$master['alamat'] = $this->input->post('txtAlamat');
			$master['tgl_aktif'] = format_date($this->input->post('txtTglMasuk'), 'Y-m-d');
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
				$str['load_profile_badge'] = 'yes';
			endif;
		elseif ($page_name == 'histori_kontrak') :
			$data['karyawan_kd'] = $_SESSION['user']['detail_karyawan']['kd_karyawan'];
			$data['kd_karyawan_kontrak'] = $this->input->post('txtKd');
			$data['type_karyawan'] = $this->input->post('selTypeKaryawan');
			$data['client_kd'] = empty($this->input->post('selClient'))?NULL:$this->input->post('selClient');
			$data['unit_kd'] = $this->input->post('selUnit');
			$data['bagian_kd'] = $this->input->post('selBagian');
			$data['jabatan_kd'] = $this->input->post('selJabatan');
			$data['status_kerja_kd'] = $this->input->post('selStatusKerja');
			$data['tgl_mulai'] = format_date($this->input->post('txtTglMulai'), 'Y-m-d');
			$data['tgl_habis'] = format_date($this->input->post('txtTglHabis'), 'Y-m-d');
			$data['is_active'] = '1';
			/**
			 * Check apakah tgl mulai sebelum tgl habis kontrak lama
			*/
			$this->db->select('kd_karyawan_kontrak')
				->from('td_karyawan_kontrak')
				->where(['tgl_habis >=' => $data['tgl_mulai'], 'karyawan_kd' => $data['karyawan_kd']])
				->order_by('tgl_habis', 'DESC');
			$query = $this->db->get();
			$row = $query->row();
			if (!empty($row)) :
				$update['kd_karyawan_kontrak'] = $row->kd_karyawan_kontrak;
				$update['tgl_habis'] = $data['tgl_mulai'];
				$this->base_query->edit_batch('td_karyawan_kontrak', 'Data Kontrak Karyawan', [['karyawan_kd' => $data['karyawan_kd'], 'is_active' => '0', 'tgl_edit' => date('Y-m-d H:i:s')]], 'karyawan_kd');
				$this->base_query->submit_data('td_karyawan_kontrak', 'kd_karyawan_kontrak', 'Data Kontrak Karyawan', $update);
			endif;
			$str = $this->base_query->submit_data('td_karyawan_kontrak', 'kd_karyawan_kontrak', 'Data Kontrak Karyawan', $data);
			if ($str['confirm'] == 'success') :
				$str['load_profile_badge'] = 'yes';
			endif;
		elseif ($page_name == 'data_skills') :
			$data['karyawan_kd'] = $_SESSION['user']['detail_karyawan']['kd_karyawan'];
			$data['kd_karyawan_skill'] = $this->input->post('txtKd');
			$data['nm_skill'] = $this->input->post('txtSkill');
			$data['lvl_skill'] = $this->input->post('selLevel');
			$str = $this->base_query->submit_data('td_karyawan_skill', 'kd_karyawan_skill', 'Data Skills Karyawan', $data);
		elseif ($page_name == 'data_asuransi') :
			$data['kd_karyawan_asuransi'] = $this->input->post('txtKd');
			$data['asuransi_kd'] = $this->input->post('selAsuransi');
			$data['karyawan_kd'] = $this->input->post('txtKdKaryawan');
			$data['no_asuransi'] = $this->input->post('txtNoAsuransi');
			$data['tgl_masuk'] = format_date($this->input->post('txtTglMasuk'), 'Y-m-d');
			$data['status_asuransi'] = $this->input->post('selStatusAsuransi');
			$str = $this->base_query->submit_data('td_karyawan_asuransi', 'kd_karyawan_asuransi', 'Data Asuransi Karyawan', $data);
		elseif ($page_name == 'data_keluarga') :
			$data['kd_karyawan_keluarga'] = $this->input->post('txtKd');
			$data['karyawan_kd'] = $this->input->post('txtKdKaryawan');
			$data['nm_keluarga'] = $this->input->post('txtNmKeluarga');
			$data['alamat'] = $this->input->post('txtAlamat');
			$data['hubungan'] = $this->input->post('selHubungan');
			$data['telp_utama'] = $this->input->post('txtTelp');
			$data['email_utama'] = $this->input->post('txtEmail');
			$str = $this->base_query->submit_data('td_karyawan_keluarga', 'kd_karyawan_keluarga', 'Data Keluarga Karyawan', $data);
		elseif ($page_name == 'data_kontak') :
			$data['kd_karyawan_kontak'] = $this->input->post('txtKd');
			$data['karyawan_kd'] = $this->input->post('txtKdKaryawan');
			$data['nm_kontak'] = $this->input->post('txtNmKontak');
			$data['alamat'] = $this->input->post('txtAlamat');
			$data['hubungan'] = $this->input->post('selHubungan');
			$data['telp_utama'] = $this->input->post('txtTelp');
			$data['email_utama'] = $this->input->post('txtEmail');
			$str = $this->base_query->submit_data('td_karyawan_kontak', 'kd_karyawan_kontak', 'Data Kontak Karyawan', $data);
		endif;
		return $str;
	}

	public function get_delete_data($page_name = '', $kd_param = '') {
		if ($page_name == 'data_pribadi') :
		elseif ($page_name == 'histori_kontrak') :
			$str['tbl_name'] = 'td_karyawan_kontrak';
			$str['params'] = ['kd_karyawan_kontrak' => $kd_param];
			$str['title_name'] = 'Data Kontrak Karyawan';
		elseif ($page_name == 'data_skills') :
			$str['tbl_name'] = 'td_karyawan_skill';
			$str['params'] = ['kd_karyawan_skill' => $kd_param];
			$str['title_name'] = 'Data Skills Karyawan';
		elseif ($page_name == 'data_asuransi') :
			$str['tbl_name'] = 'td_karyawan_asuransi';
			$str['params'] = ['kd_karyawan_asuransi' => $kd_param];
			$str['title_name'] = 'Data Karyawan Asuransi';
		elseif ($page_name == 'data_keluarga') :
			$str['tbl_name'] = 'td_karyawan_keluarga';
			$str['params'] = ['kd_karyawan_keluarga' => $kd_param];
			$str['title_name'] = 'Data Keluarga Karyawan';
		elseif ($page_name == 'data_kontak') :
			$str['tbl_name'] = 'td_karyawan_kontak';
			$str['params'] = ['kd_karyawan_kontak' => $kd_param];
			$str['title_name'] = 'Data Kontak Karyawan';
		endif;
		return $str;
	}
}