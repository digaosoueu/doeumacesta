<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funcoes_Model extends CI_Model {
	
	public function InsertNews($itens) {
		$res = $this->db->insert('newslleters', $itens);
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}

        public function getNews($condicao = array()) {

	       $this->db->where($condicao);
		$this->db->from('newslleters');
		return $this->db->count_all_results();
	}
	
}			