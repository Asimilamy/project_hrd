<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class M_code_format extends CI_Model {
	public function read_code_format($code_for = '') {
		$this->load->model(['model_basic/base_query']);
		$m_row = $this->base_query->get_row('tm_code_format', ['code_for' => $code_for]);
		if (!empty($m_row)) :
			$data = array('kd_code_format' => $m_row->kd_code_format, 'nm_code_format' => $m_row->nm_code_format, 'code_for' => $m_row->code_for, 'code_format' => $m_row->code_format, 'code_reset' => $m_row->code_reset);
		else :
			$data = array('kd_code_format' => '', 'nm_code_format' => '', 'code_for' => $code_for, 'code_format' => '', 'code_reset' => '', 'contoh_code' => '');
		endif;
		if (!empty($data['kd_code_format'])) :
			$d_result = $this->base_query->get_all('td_code_format_part', ['code_format_kd' => $data['kd_code_format']], ['code_part_order' => 'ASC']);
			$data['code_format'] = '';
			foreach ($d_result as $d_row) :
				$detail[] = (object) ['kd_code_format_part' => $d_row->kd_code_format_part, 'code_format_kd' => $data['kd_code_format'], 'code_part_order' => $d_row->code_part_order, 'code_part' => $d_row->code_part, 'code_separator' => $d_row->code_separator];
				$separator = $d_row->code_separator == 'n'?'':$d_row->code_separator;
				$data['code_format'] = $data['code_format'].$d_row->code_part.$separator;
			endforeach;
			$data['contoh_code'] = $this->generate_code($data['code_format']);
		endif;
		return $data;
	}

	public function code_reset_opts() {
		$opts = [
			0 => (object) ['key' => 'hari', 'value' => 'Hari'],
			1 => (object) ['key' => 'bulan', 'value' => 'Bulan'],
			2 => (object) ['key' => 'tahun', 'value' => 'Tahun'],
			3 => (object) ['key' => 'none', 'value' => 'Tidak Ada'],
		];
		return $opts;
	}

	public function code_part_opts() {
		$opts = [
			0 => (object) ['key' => 'yyyy', 'value' => 'Tahun (yyyy)'],
			1 => (object) ['key' => 'yy', 'value' => 'Tahun (yy)'],
			2 => (object) ['key' => 'mm', 'value' => 'Bulan (mm)'],
			4 => (object) ['key' => 'dd', 'value' => 'Hari (dd)'],
			6 => (object) ['key' => 'yyyy_roman', 'value' => 'Tahun Romawi (yyyy)'],
			7 => (object) ['key' => 'yy_roman', 'value' => 'Tahun Romawi (yy)'],
			8 => (object) ['key' => 'mm_roman', 'value' => 'Bulan Romawi (mm)'],
			10 => (object) ['key' => 'dd_roman', 'value' => 'Hari Romawi (dd)'],
			12 => (object) ['key' => 'urutan_angka', 'value' => 'Urutan Angka'],
			13 => (object) ['key' => 'kode_huruf', 'value' => 'Kode Unik'],
		];
		return $opts;
	}

	public function code_separator_opts() {
		$opts = [
			0 => (object) ['key' => 'n', 'value' => 'Tidak Ada'],
			1 => (object) ['key' => '.', 'value' => 'Titik (.)'],
			2 => (object) ['key' => ',', 'value' => 'Koma (,)'],
			3 => (object) ['key' => '/', 'value' => 'Garis Miring (/)'],
			4 => (object) ['key' => '\\', 'value' => 'Garis Miring (\)'],
			5 => (object) ['key' => '|', 'value' => 'Garis (|)'],
			6 => (object) ['key' => '-', 'value' => 'Strip (-)'],
			7 => (object) ['key' => '_', 'value' => 'Garis Bawah (_)'],
		];
		return $opts;
	}

	public function render_code_format($code_format_kd = '') {
		$this->load->model(['model_basic/base_query']);
		$result = $this->base_query->get_all('td_code_format_part', ['code_format_kd' => $code_format_kd]);
		return $result;
	}

	public function generate_code($code_format = '') {
		return 'ASU';
	}

	public function form_rules() {
		$rules = array(
			array('field' => 'txtNm', 'label' => 'Nama Code Format', 'rules' => 'required'),
			array('field' => 'selReset', 'label' => 'Code Reset', 'rules' => 'required'),
		);
		return $rules;
	}

	public function form_warning($datas = '') {
		$forms = array('txtNm', 'selReset');
		foreach ($datas as $key => $data) :
			$str[$data] = (!empty(form_error($forms[$key])))?build_label('warning', form_error($forms[$key], '"', '"')):'';
		endforeach;
		return $str;
	}

	public function submit_code_part($data = []) {
		if (!empty($data['code_format_kd'])) :
			$code_format = '';
			$jml_part = count($data['code_part']);
			if ($jml_part > 0) :
				$kd_code_format_part = create_pkey('td_code_format_part', 'kd_code_format_part', '', 0);
				$act = $this->base_query->delete_data('td_code_format_part', ['code_format_kd' => $data['code_format_kd'], 'Code Format']);
				if ($act['confirm'] == 'success') :
					for ($i = 0; $i < $jml_part; $i++) :
						if (!empty($data['code_part'][$i])) :
							$separator = $i + 1 == $jml_part?'':'-';
							$code_format .= $data['code_part'][$i].$separator;
							$data_detail[] = ['kd_code_format_part' => $kd_code_format_part, 'code_format_kd' => $data['code_format_kd'], 'code_part_order' => $i, 'code_part' => $data['code_part'][$i], 'code_separator' => $data['code_separator'][$i], 'tgl_input' => date('Y-m-d H:i:s'), 'user_kd' => $_SESSION['user']['kd_user']];
							$kd_code_format_part = create_pkey('td_code_format_part', 'kd_code_format_part', $kd_code_format_part, 1);
						endif;
					endfor;
				endif;
			endif;
			if (isset($data_detail)) :
				$str = $this->base_query->submit_batch('td_code_format_part', 'Code Format', $data_detail);
			endif;
		else :
			$str = get_report(0, 'Mengubah Format Code', $data, $data['code_format_kd']);
		endif;
		$str['code_format'] = $code_format;
		return $str;
	}
}