<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class M_master_prop extends CI_Model {
	public function get_opts($params = []) {
		$this->db->select('c.kd_master_prop, c.nm_master_prop')
			->from('tm_master_type a')
			->join('tm_type_prop b', 'b.master_type_kd = a.kd_master_type', 'left')
			->join('tm_master_prop c', 'b.master_prop_kd = c.kd_master_prop', 'left');
		if (!empty($params)) :
			$this->db->where($params);
		endif;
		$query = $this->db->get();
		$return = $query->result();
		return $this->render_opts($return);
	}

	public function render_opts($opts) {
		$option[''] = '--Pilih Type Properties--';
		foreach ($opts as $opt) :
			$option[$opt->kd_master_prop] = $opt->nm_master_prop;
		endforeach;
		return $option;
	}

	public function render_prop_form($kd_user = '', $kd_master_type = '', $content_type = '') {
		$this->load->helper('form_generator');
		$form = '<div class="form_prop_content">';
		$result = $this->prop_data($kd_master_type, $kd_user, $content_type);
		foreach ($result as $row) :
			$row['value'] = isset($row['value'])?$row['value']:'';
			if (isset($prop_group_sblm)) :
				if ($prop_group_sblm != $row['nm_master_prop']) :
					$form .= '<hr><h2 class="title">'.$row['nm_master_prop'].'</h2>';
				endif;
			else :
				$form .= '<hr><h2 class="title">'.$row['nm_master_prop'].'</h2>';
			endif;

			if ($row['type_prop'] == 'option') :
				if (!isset($opt_group_sblm)) :
					$opts[$row['kd_prop']][] = array('' => '--Pilih '.$row['nm_prop'].'--');
					$opts[$row['kd_prop']][] = array($row['kd_prop_opt'] => $row['nm_opt']);
					$opt_group_sblm = $row['kd_prop'];
					$nm_prop_sblm = $row['nm_prop'];
				else :
					$opts[$row['kd_prop']][] = array($row['kd_prop_opt'] => $row['nm_opt']);
					$opt_group_sblm = $row['kd_prop'];
					$nm_prop_sblm = $row['nm_prop'];
				endif;
				if (isset($opt_group_sblm)) :
					next($result);
					$row_next = next($result);
					if ($row['kd_prop'] != $row_next['kd_prop']) :
						$form .= render_form_dropdown($nm_prop_sblm, 'fieldProp[]', $opts[$opt_group_sblm], $row['value']);
					endif;
				endif;
			else :
				$form .= render_form($row['nm_prop'], 'fieldProp[]', $row['type_prop'], $row['value']);
			endif;
			$prop_group_sblm = $row['nm_master_prop'];
		endforeach;
		$form .= '</div>';
		return $form;
	}

	public function prop_data($kd_master_type = '', $kd_relation = '', $content_type = '') {
		$add_query = '';
		if (!empty($kd_relation) && !empty($content_type)) :
			$add_query = $this->relation_query($kd_relation, $content_type);
		endif;
		$this->db->select('a.master_type_kd, b.nm_master_type, c.kd_master_prop, c.nm_master_prop, d.kd_prop, d.nm_prop, d.type_prop, e.kd_prop_opt, e.nm_opt'.$add_query)
			->from('tm_type_prop a')
			->join('tm_master_type b', 'b.kd_master_type = a.master_type_kd', 'left')
			->join('tm_master_prop c', 'c.kd_master_prop = a.master_prop_kd', 'left')
			->join('tm_prop d', 'd.master_prop_kd = c.kd_master_prop', 'left')
			->join('td_prop_opt e', 'e.prop_kd = d.kd_prop', 'left')
			->where(array('a.master_type_kd' => $kd_master_type))
			->order_by('c.kd_master_prop, d.kd_prop');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	private function relation_query($kd_relation = '', $content_type = '') {
		$param_relation = !empty($kd_relation)?' AND f.kd_relation = \''.$kd_relation.'\'':'';
		$param_type = !empty($content_type)?' AND f.content_type = \''.$content_type.'\'':'';
		$query = ', (SELECT f.value FROM td_prop_content f WHERE f.master_type_kd = a.master_type_kd AND f.master_prop_kd = a.master_prop_kd AND f.prop_kd = d.kd_prop'.$param_relation.$param_type.') AS value';
		return $query;
	}
}