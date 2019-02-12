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
				$detail[] = (object) ['kd_code_format_part' => $d_row->kd_code_format_part, 'code_format_kd' => $data['kd_code_format'], 'code_part_order' => $d_row->code_part_order, 'code_part' => $d_row->code_part, 'code_unique' => $d_row->code_unique, 'code_separator' => $d_row->code_separator];
				$separator = $d_row->code_separator == 'n'?'':$d_row->code_separator;
				$data['code_format'] = empty($d_row->code_unique)?$data['code_format'].$d_row->code_part.$separator:$data['code_format'].$d_row->code_part.'['.$d_row->code_unique.']'.$separator;
			endforeach;
			$data['contoh_code'] = $this->generate_code($code_for);
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
			7 => (object) ['key' => '&nbsp;', 'value' => 'Spasi ( )'],
		];
		return $opts;
	}

	private function render_code_part($code_part = '', $code_unique = '') {
		$this->load->helper(['number']);

		if ($code_part == 'yyyy') :
			$code = date('Y');
		elseif ($code_part == 'yy') :
			$code = date('y');
		elseif ($code_part == 'mm') :
			$code = date('m');
		elseif ($code_part == 'dd') :
			$code = date('d');
		elseif ($code_part == 'yyyy_roman') :
			$code = number_to_roman(date('Y'));
		elseif ($code_part == 'yy_roman') :
			$code = number_to_roman(date('y'));
		elseif ($code_part == 'mm_roman') :
			$code = number_to_roman(date('m'));
		elseif ($code_part == 'dd_roman') :
			$code = number_to_roman(date('d'));
		elseif ($code_part == 'urutan_angka') :
			$code = $code_unique;
		elseif ($code_part == 'kode_huruf') :
			$code = $code_unique;
		endif;
		return $code;
	}

	public function render_code_format($code_format_kd = '') {
		$this->load->model(['model_basic/base_query']);
		$result = $this->base_query->get_all('td_code_format_part', ['code_format_kd' => $code_format_kd]);
		return $result;
	}

	public function generate_code($code_for = '') {
		$this->load->model(['model_basic/base_query']);
		$src = $this->get_code_source($code_for);
		$code_row = $this->base_query->get_row('tm_code_format', ['code_for' => $code_for]);
		if (!empty($code_row)) :
			$code_last_date = !empty($code_row->tgl_edit)?$code_row->tgl_edit:$code_row->tgl_input;
			$code_result = $this->base_query->get_all('td_code_format_part', ['code_format_kd' => $code_row->kd_code_format], ['code_part_order' => 'ASC']);
		endif;
		if ($code_row->code_reset == 'hari') :
			$params = ['DATE(tgl_input)' => date('Y-m-d')];
		elseif ($code_row->code_reset == 'bulan') :
			$params = ['MONTH(tgl_input)' => date('m'), 'YEAR(tgl_input)' => date('Y')];
		elseif ($code_row->code_reset == 'tahun') :
			$params = ['YEAR(tgl_input)' => date('Y')];
		elseif ($code_row->code_reset == 'none') :
			$params = [];
		endif;
		$orders = ['tgl_input' => 'DESC'];
		if (!empty($src['p_key'])) :
			$orders = array_merge($orders, [$src['p_key'] => 'DESC']);
		endif;
		$data_row = $this->base_query->get_row($src['tbl_name'], $params, $orders);
		if (!empty($data_row)) :
			$data_last_date = !empty($data_row->tgl_input)?$data_row->tgl_input:$code_last_date;
			$last_data_code = $data_row->{$src['col_name']};
		else :
			$data_last_date = $code_last_date;
		endif;
		$code_format = '';
		if (strtotime($data_last_date) <= strtotime($code_last_date)) :
			$str = 'Code Format berubah!';
			foreach ($code_result as $row) :
				$code_format = $code_format.$this->render_code_part($row->code_part, $row->code_unique).$row->code_separator;
			endforeach;
		else :
			$str = 'Code Format tidak dirubah!';
			$urutan_angka = $this->base_query->get_row('td_code_format_part', ['code_format_kd' => $code_row->kd_code_format, 'code_part' => 'urutan_angka']);
			if (!empty($urutan_angka)) :
				$urutan_order = $urutan_angka->code_part_order;
			endif;
			$this->db->select('DISTINCT(code_separator)')
				->from('td_code_format_part')
				->where(['code_format_kd' => $code_row->kd_code_format]);
			$query = $this->db->get();
			$result = $query->result();
			foreach ($result as $row) :
				$glue_code = str_replace($row->code_separator, '-', $last_data_code);
				$last_data_code = $glue_code;
			endforeach;
			$explode_glues = explode('-', $last_data_code);
			if (!empty($urutan_order)) :
				$jml_inc = strlen($explode_glues[$urutan_order]);
				$angka = $explode_glues[$urutan_order] + 1;
    			$urutan = str_pad($angka, $jml_inc, '000', STR_PAD_LEFT);
				$explode_glues[$urutan_order] = $urutan;
			endif;
			$no = 0;
			foreach ($code_result as $row) :
				$code_unique = $urutan_order == $no && $row->code_part == 'urutan_angka'?$explode_glues[$urutan_order]:$row->code_unique;
				$code_format = $code_format.$this->render_code_part($row->code_part, $code_unique).$row->code_separator;
				$no++;
			endforeach;
		endif;
		return $code_format;
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
					$has_urutan_angka = 0;
					for ($i = 0; $i < $jml_part; $i++) :
						if (!empty($data['code_part'][$i])) :
							$separator = $i + 1 == $jml_part?'':'-';
							$code_format .= $data['code_part'][$i].$separator;
							$code_unique = $data['code_part'][$i] == 'urutan_angka' || $data['code_part'][$i] == 'kode_huruf'?$data['code_unique'][$i]:NULL;
							if ($data['code_part'][$i] != 'urutan_angka' || ($data['code_part'][$i] == 'urutan_angka' && !$has_urutan_angka)) :
								$data_detail[] = ['kd_code_format_part' => $kd_code_format_part, 'code_format_kd' => $data['code_format_kd'], 'code_part_order' => $i, 'code_part' => $data['code_part'][$i], 'code_unique' => $code_unique, 'code_separator' => $data['code_separator'][$i], 'tgl_input' => date('Y-m-d H:i:s'), 'user_kd' => $_SESSION['user']['kd_user']];
								$kd_code_format_part = create_pkey('td_code_format_part', 'kd_code_format_part', $kd_code_format_part, 1);
								if ($data['code_part'][$i] == 'urutan_angka') :
									$has_urutan_angka = 1;
								endif;
							endif;
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

	private function get_code_source($code_for) {
		if ($code_for == 'format_nik') :
			$src['tbl_name'] = 'tm_karyawan';
			$src['col_name'] = 'nik_karyawan';
			$src['p_key'] = 'kd_karyawan';
		endif;
		return $src;
	}
}