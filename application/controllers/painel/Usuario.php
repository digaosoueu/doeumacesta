<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller{
	
	public function __construct(){
		
		parent::__construct();
		$this->layout = LAYOUT_DASHBOARD;
		$this->load->model('Usuario_model', 'UsuarioM');
	}
	
	public function index(){
		
		$data = array();
		$data['BLC_DADOS'] = array();
		$data['BLC_SEMDADOS'] = array();
		$data['BLC_PAGINAS']	= array();
		
		$pagina = $this->input->get('p');
		if(!$pagina){
			$pagina = 0;
		}else{
			$pagina = ($pagina - 1) * LINHAS_PESQUISA_DASHBOARD;
		}
		
		$res = $this->UsuarioM->get(array(), False, $pagina);
		
		if($res){
			
			foreach($res as $r){
				
				$data['BLC_DADOS'][] = array(

					"NOME" 			=> $r->nomeusuario,
					"URLEDITAR" 	=> site_url('painel/usuario/editar/' . $r->codusuario),
					"URLEXCLUIR" 	=> site_url('painel/usuario/excluir/' . $r->codusuario),
						
				);
				$this->SetUrl($data);
			}
			
		}else{
			$data['BLC_SEMDADOS'][] = array();
			$data['HABANTERIOR']	= 'disabled';
			$data['HABPROX']		= 'disabled';
			$data['URLPROXIMO'] 	= 'disabled';
		}
		
		$totalItens = $this->UsuarioM->getTotal();
		$totalPaginas = ceil($totalItens/LINHAS_PESQUISA_DASHBOARD); 
		$indicePg		= 1;
		$pagina			= $this->input->get('p');
		if (!$pagina) {
		    $pagina = 1;
		}
		$pagina	= ($pagina==0)?1:$pagina;
		
		if ($totalPaginas > $pagina) {
			$data['HABPROX']	= null;
			$data['URLPROXIMO']	= site_url('painel/usuario?p='.($pagina+1));
		} else {
			$data['HABPROX']	= 'disabled';
			$data['URLPROXIMO']	= '#';
		}
		
		if ($pagina <= 1) {
			$data['HABANTERIOR']= 'disabled';
			$data['URLANTERIOR']= '#';
		} else {
			$data['HABANTERIOR']= null;
			$data['URLANTERIOR']= site_url('painel/usuario?p='.$pagina-1);
		}
		
		
		
		while ($indicePg <= $totalPaginas) {
			$data['BLC_PAGINAS'][] = array(
				"LINK"		=> ($indicePg==$pagina)?'active':null,
				"INDICE"	=> $indicePg,
				"URLLINK"	=> site_url('painel/usuario?p='.$indicePg)
			);
			
			$indicePg++;
		}
		$this->parser->parse('painel/Usuario_listar', $data);
	}
	
	public function adicionar(){
		
		$data = array();
		
		$data["ACAO"] 				= "Novo";
		$data["nomeusuario"] 		= "";
		$data["emailusuario"]   	= "";
		$data["codusuario"]     	= "";
		$data["chk_ativousuario"] 	= "";
		$this->SetUrl($data);
		
		$this->parser->parse('painel/Usuario_form', $data);
		
	}
	
	public function excluir($id){
		
		$res = $this->UsuarioM->delete($id);
		
		if($res){
			$this->session->set_flashdata('sucesso', "Usuario removido com sucesso");
			
		}else{
			$this->session->set_flashdata('erro', "Ocorreu um erro ao remover usuario");
		}
		redirect('painel/usuario');
	}
	
	public function editar($id){
		
		$data = array();
		$data['ACAO'] = "Edi&ccedil;&atilde;o";
		$data["chk_ativousuario"] = '';
		
		$res = $this->UsuarioM->get(array("codusuario" => $id), TRUE);
		
		if($res){
			
			foreach ($res as $chave => $valor){
					
				$data[$chave] = $valor;
			}
			$data["chk_ativousuario"] = ($res->ativadousuario=='S')?'checked="checked"':null;
		}else{
			show_error('Não foram encontrados dados', 500, 'Ops, erro encontrado');
		}
		
		
		$this->setUrl($data);
		
		$this->parser->parse('painel/Usuario_form', $data);
	}
	
	private function SetUrl(&$data){
		
		$data["URLLISTAR"]	= site_url("painel/usuario");
		$data["ACAOFORM"]	= site_url("painel/usuario/salvar");
		$data["URLADICIONAR"]	= site_url("painel/usuario/adicionar");
		
	}
	
	public function salvar(){
		
		$codusuario		= $this->input->post("codusuario");
		$nomeusuario	= $this->input->post("nomeusuario");
		$emailusuario	= $this->input->post("emailusuario");
		$senhausuario	= $this->input->post("senhausuario");
		$ativadousuario	= $this->input->post("ativadousuario");
		
		
		$erros = false;
		$mensagem = null;
		
		if(!$nomeusuario){
			
			$erros = true;
			$mensagem .= "Favor preencher o campo Nome\n";
			
		}
		
		if(!$emailusuario){
				
			$erros = true;
			$mensagem .= "Favor preencher o campo Email\n";
				
		}
		
		if(!$senhausuario){
		
			if(!$codusuario){
				
				$erro = true;
				$mensagem .= "Favor preencher o campo Senha\n";
			}			
		
		}
		
		if(!$erros){
			
			$itens = array(		
				"nomeusuario"		=> $nomeusuario,
				"emailusuario"		=> $emailusuario,
				"ativadousuario"	=> ($ativadousuario) ? $ativadousuario:'N'
			);
			
			if($senhausuario){				
				$itens['senhausuario']	= sha1($senhausuario);				
			}
			
			if($codusuario){
				
				$codusuario = $this->UsuarioM->update($itens, $codusuario);
				
			} else {
				
				$codusuario = $this->UsuarioM->post($itens);
			}
			
			if($codusuario){
				$this->session->set_flashdata('sucesso', "Usuario atualizado com sucesso");
				redirect("painel/usuario");
				
			}else{
				$this->session->set_flashdata('erro', "Ocorreu um erro ao inserir usuario");
				
				if($codusuario){
					redirect("painel/usuario/editar" . $codusuario);
				}else{
					redirect("painel/usuario/adicionar");
				}				
				
			}
			
		}else{
			
			$this->session->set_flashdata('erro', n12br($mensagem));
			
			if($codusuario){
				redirect("usuario/editar" . $codusuario);
			}else{
				redirect("usuario/adicionar");
			}
		}
	}
			
	
}