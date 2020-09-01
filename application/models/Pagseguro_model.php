<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagseguro_Model extends CI_Model {
	
		
	public function getRetorno($condicao = array(), $primeiraLinha = FALSE, $pagina = 0) {
		$this->db->select('codcarrinho, codtransacao, status, tipopagamento, urlboleto');
		$this->db->where($condicao);
		$this->db->from('retornopagseguro');		
		
		if ($primeiraLinha) {
			$this->db->order_by('datacadastro', 'desc');
			return $this->db->get()->first_row();
		} else {
			$this->db->limit(LINHAS_PESQUISA_DASHBOARD, $pagina);
			$this->db->order_by('codpagseguro', 'desc');
			return $this->db->get()->result();
		}
	}
	
	public function post($itens) {
		$res = $this->db->insert('pagseguro', $itens);
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	public function postRetorno($itens) {
		$res = $this->db->insert('retornopagseguro', $itens);
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	public function updateRetorno($itens, $codpagseguro) {
		$this->db->where('codpagseguro', $codpagseguro, FALSE);
		$res = $this->db->update('retornopagseguro', $itens);
		if ($res) {
			return $codpagseguro;
		} else {
			return FALSE;
		}
	}
	
	public function delete($ID_PagSeguro) {
		$this->db->where('codpagSeguro', $ID_PagSeguro, FALSE);
		return $this->db->delete('retornopagseguro');
	}
}