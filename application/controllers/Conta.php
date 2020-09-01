<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conta extends CI_Controller {
	
	public function __construct() {
		parent::__construct ();
		$this->layout = LAYOUT_LOJA;
		$this->load->model ( 'Comprador_model', 'CompradorM' );	
		$this->load->model ( "Carrinho_model", "CarrinhoM" );
		$this->load->helper('cookie');
	}
	
	public function minhasdoacoes(){
		
		clienteLogado ( true );
		
		$comprador = $this->session->userdata ( 'UserDoeUmaCesta' );
		
		$pg = $this->input->get( "pg" );
		
		if (!$pg) {
			$pg = 0;
		} else {
			$pg --;
		}
		
		//$this->load->model ( "Carrinho_model", "CarrinhoM" );
		
		$totalItens = $this->CarrinhoM->getTotal ( array (
				"codcomprador" => $comprador ["codcomprador"]
		) );
		
		$totalPaginas = ceil( $totalItens / LINHAS_PESQUISA_DASHBOARD );
		
		$data = array ();
		$data ["BLC_DADOS"] = array ();
		$data ["BLC_PAGINACAO"] = array ();
		
		
		
		$paginas = array ();
		
		for($i = 1; $i <= $totalPaginas; $i ++) {
			$paginas [] = array (
					"URLPAGINA" => current_url () . "?&pg={$i}",
					"INDICE" => $i
			);
		}
		
		$data ["BLC_PAGINACAO"] [] = array (
				"BLC_PAGINA" => $paginas
		);
		
		$carrinho = $this->CarrinhoM->get ( array (
				"c.codcomprador" => $comprador ["codcomprador"]
		), FALSE, $pg );
		
		if ($carrinho) {
			foreach ( $carrinho as $car ) {
				
				$situacao = "<td class='status warning'><span>Processando</span></td>";
				if($car->situacao == "P"){
					$situacao = "<td class='status primary'><span>Pago</span></td>";
				}
				
				if($car->situacao == "C"){
					$situacao = "<td class='status danger'><span>Cancelado</span></td>";
				}
				
				$data ["BLC_DADOS"] [] = array (
						"URLRESUMO" => site_url ( 'conta/resumo/' . $car->codcarrinho ),
						"CODPEDIDO" => $car->codcarrinho,
						"DATA" => $car->data,
						"STATUS" => $situacao,
						"VALOR" => number_format ( $car->valorcompra, 2, ",", "." )
				);
			}
		}
		
		$this->parser->parse ( "Lista_doacoes", $data );
	}
	
	public function editarconta() {
		
		clienteLogado ( true );
		
		$this->title = "Editar Dados";
		$this->descricao = "Editar Dados";
		$this->keyw = "dados, cesta basica";
		$redirect = $this->input->get( 're' );
		$disabled = "disabled='disabled'";
		$data = array ();
		$data ['ACAOFORM'] = site_url( 'conta/salvar' );		
			
		$data['REDIRECT'] 		= $redirect;
		if ($redirect == ""){
			$data ['REDIRECT'] = $this->session->flashdata('REDIRECT');
		}
				
		$conta = $this->session->userdata( "UserDoeUmaCesta" );
		
		if ($conta) {
						
			$infoSKU = $this->CompradorM->get(array("codcomprador" => $conta["codcomprador"]), TRUE);
			
			//$data ["BLC_COMPRADOR"] [] = array (
			$nome 			= $infoSKU->nomecomprador;
			$email 			= $infoSKU->emailcomprador;
			$cpf 			= $infoSKU->cpfcomprador;
			$telefone 		= $infoSKU->telefonecomprador;
			$cod 			= $infoSKU->codcomprador;
			$sobrenome 		= $infoSKU->sobrenomecomprador;
			$uf 			= $infoSKU->ufcomprador;
			$cidade 		= $infoSKU->cidadecomprador;
			$celular 		= $infoSKU->celularcomprador;
			$datanascimento = $infoSKU->datanascimentocomprador;
			$newsletter 	= ($infoSKU->newslettercomprador == "1") ? "checked" : null;
			if($cpf == ""){$disabled = "";}
			//);
		}
		//debug($this->session->flashdata('DATANASCIMENTO'),true);
		$data['NOME'] 			= ($nome == "") ? $this->session->flashdata('NOME') : $nome;
		$data['EMAIL'] 			= $email ;
		$data['SOBRENOME'] 		= ($sobrenome == "") ? $this->session->flashdata('SOBRENOME') : $sobrenome;
		$data['CPF'] 			= $cpf;
		$data['DATANASCIMENTO'] = ($datanascimento == "") ? $this->session->flashdata('DATANASCIMENTO') : dateMySQL2BR($datanascimento);
		$data['TELEFONE'] 		= ($telefone == "") ? $this->session->flashdata('TELEFONE') : $telefone;
		$data['CELULAR'] 		= ($celular == "") ? $this->session->flashdata('CELULAR') : $celular;
		$data['LISTAUF'] 		= listaEstado($uf);
		$data['CIDADE'] 		= ($cidade == "") ? $this->session->flashdata('CIDADE') : $cidade;
		$data['SENHA'] 			= "";
		$data['CODCOMPRADOR'] 	= $cod;
		$data['NEWSLETTER'] 	= $newsletter;
		$data['DISABLED'] 		= $disabled;
		
		$this->parser->parse('EditarConta_form', $data);
		
	}
	
	
	
	public function novaconta() {
		
		if (clienteLogado()) {
			redirect ( 'conta/editarconta' );
		}

		$this->title = "Login/ registrar";
		$this->descricao = "Login/ registrar";
		$this->keyw = "Login, registrar";
		
		//$redirect = str_replace(site_url(), "", current_url());	
		
		$redirect = $this->input->get( 're' );
		if ($redirect == ""){
			$redirect = $this->session->flashdata('REDIRECT');
		}
		
		$data = array ();		

		$data['FORMVALIDAR'][] = array(
				
			"EMAIL2" => $this->session->flashdata('EMAIL2'),
			"SENHA2" => $this->session->flashdata('SENHA2'),
			"REDIRECT" => $redirect
				
		);
		$data['NOVASENHA'] = array();
		
		//$data ['ACAOFORM'] = site_url ( 'conta/salvar');
		$data ['ACAOFORMLOGIN'] = site_url ( 'conta/valida');
		
		$data['REGISTRO'][] = array(
			
			"CPF" => "545",
			"EMAIL" => $this->session->flashdata('EMAIL'),
			"SENHA" => $this->session->flashdata('SENHA'),
			"ACAOFORM" => site_url( 'conta/salvar'),
			"REDIRECT" => $redirect
		);
		
//print_r( $data);
//echo $_SESSION['EMAIL'];
		//$data ['EMAIL2'] 	= $this->session->flashdata('EMAIL2');
		$data ['CPF'] 		= "dsad";
		//$data ['SENHA2'] 	= $this->session->flashdata('SENHA2');
		//$data ['EMAIL'] 	= $this->session->flashdata('EMAIL');
		//$data ['SENHA'] 	= $this->session->flashdata('SENHA');
		//$data ['REDIRECT']	= $redirect;
		
		$this->parser->parse('Conta_form', $data);
	}
	public function salvar() {

		$codcomprador = $this->input->post( 'codcomprador' );
		$emailcomprador = $this->input->post( 'emailcomprador' );
		$senhacomprador = $this->input->post( 'senhacomprador' );
		$cpfcomprador = $this->input->post( 'cpfcomprador' );
		$cpfcomprador = str_replace ( ".", null, $cpfcomprador );
		$cpfcomprador = str_replace ( "-", null, $cpfcomprador );
		$cpfcomprador = str_replace ( " ", null, $cpfcomprador );
		$redirect = $this->input->post ( 'redirect' );
		$checked = "0";
		$nomecomprador = "-";
		
		
		$valid = $this->input->post( 'VALID' );
		
		if($valid){
			
			$info = $this->CompradorM->get(array("senhacomprador" => $valid, "codcomprador" => $codcomprador), TRUE);
			if($info){
				
				$novasenha = $this->input->post( 'novasenhacomprador' );
				$codnovasenha = $info->codcomprador;
				$itens = array (
						"senhacomprador" => md5( $novasenha )
				);
				$this->CompradorM->update( $itens, $codnovasenha );
				
				$sessaoLoja = array (
						'nomecomprador' => $info->nomecomprador,
						'emailcomprador' => $info->emailcomprador,
						'codcomprador' => $info->codcomprador
				);
				
				$this->session->set_userdata( 'UserDoeUmaCesta', $sessaoLoja );	
				//set_cookie("carrinhoDoeumaCesta", 'UserDoeUmaCesta', 86400*12);			
				$this->session->set_flashdata ( 'sucesso', 'Senha atualizada com sucesso.' );
				if(!$redirect){$redirect = site_url("conta/editarconta");}
				redirect($redirect);
				
			}
		}
		
		$this->load->library( 'Form_validation' );
		$this->form_validation->set_rules( 'emailcomprador', 'Email', 'required|valid_email' );
		$editar = false;
		
		if($codcomprador){
			
			$nomecomprador 			 = $this->input->post( 'nomecomprador' );
			$sobrenomecomprador 	 = $this->input->post( 'sobrenomecomprador' );
			$datanascimentocomprador = $this->input->post( 'datanascimentocomprador' );
			$telefonecomprador 		 = $this->input->post( 'telefonecomprador' );
			$celularcomprador 		 = $this->input->post( 'celularcomprador' );
			$ufcomprador 		 	 = $this->input->post( 'ufcomprador' );
			$cidadecomprador 		 = $this->input->post( 'cidadecomprador' );
			$newslettercomprador 	 = $this->input->post( 'newslettercomprador' );
			$editar = true;
			if($redirect == ""){$redirect = "conta/editarconta";}
			
		}else{		
			
			$this->form_validation->set_rules ( 'senhacomprador', 'Password', 'required' );
			$this->form_validation->set_rules ( 'cpfcomprador', 'CPF', 'required' );
			
		}
		

		$Erro = false;
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata( 'erro', 'Informe os campos corretamente.' . validation_errors() );
			//redirect ( 'conta/novaconta' );
			$Erro = true;
		}


		if (!validaCPF($cpfcomprador) && $editar == false) {
			$erros = TRUE;
			$this->session->set_flashdata ( 'erro', 'Informe um CPF correto.' );
			$Erro = true;
			//redirect ( 'conta/novaconta' );
		} else {
			//debug($cpfcomprador,true);
			$cpfUsado = $this->CompradorM->validaCPFDuplicado( $codcomprador, $cpfcomprador );
			if ($cpfUsado > 0) {
				$this->session->set_flashdata( 'erro', 'Ja existe um cliente utilizando este CPF.' );
				//redirect ( 'conta/novaconta' );
				$Erro = true;
			}
		}
		
		$emailUsado = $this->CompradorM->validaEmailDuplicado( $codcomprador, $emailcomprador );
		if ($emailUsado > 0) {
			$this->session->set_flashdata ( 'erro', 'Ja existe um cliente utilizando este email.' );
			//redirect ( 'conta/novaconta' );
			$Erro = true;
		}
		//debug($codcomprador,true);
		if($Erro == false){	
			
			if($editar == false){
				
				$itens = array (
						"emailcomprador" => $emailcomprador,
						"cpfcomprador" => $cpfcomprador,
				);
				
				if ($senhacomprador) {
					$itens['senhacomprador'] = md5( $senhacomprador );
				}
				
				$codcomprador = $this->CompradorM->post( $itens );
				
				$sessaoLoja = array (
						'emailcomprador' => $emailcomprador,
						'codcomprador' 	 => $codcomprador
				);
				//if (!$nomecomprador) {
					//$nomecomprador = "-";
				//}
				$sessaoLoja['nomecomprador'] = $nomecomprador;
				
				$this->session->set_userdata('UserDoeUmaCesta', $sessaoLoja);
				$this->session->set_flashdata ( 'sucesso', 'Conta criada com sucesso.' );
				
			}else{
				
				if($newslettercomprador == "1"){
					$checked = "1";
				}
				
				$itens = array (
						
						"nomecomprador" => $nomecomprador,
						"sobrenomecomprador" => $sobrenomecomprador,												
						"emailcomprador" => $emailcomprador,
						"datanascimentocomprador" => dateBR2MySQL($datanascimentocomprador),
						"telefonecomprador" => $telefonecomprador,
						"celularcomprador" => $celularcomprador,
						"ufcomprador" => $ufcomprador,
						"cidadecomprador" => $cidadecomprador,
						"newslettercomprador" => $checked,
				);
				
				if ($senhacomprador) {
					$itens['senhacomprador'] = md5( $senhacomprador );
				}
				if($cpfcomprador){
					$itens['cpfcomprador'] = $cpfcomprador;
				}
				//debug($newslettercomprador, true);
				
				
				$this->CompradorM->update( $itens, $codcomprador );
				$this->session->set_flashdata ( 'sucesso', 'Conta atualizada com sucesso.' );
				
			}
			
	
			
			redirect ($redirect);
		
		}else{
			
			//debug($redirect, true);
			//$this->parser->parse ( 'Conta_form', $data );
			
			$this->session->set_flashdata('CPF', $cpfcomprador);
			$this->session->set_flashdata('EMAIL', $emailcomprador);
			$this->session->set_flashdata('SENHA', $senhacomprador);
			$_SESSION['EMAIL'] = $emailcomprador;
			
			if($editar == true){
				
				$this->session->set_flashdata('NOME', $nomecomprador);
				$this->session->set_flashdata('SOBRENOME', $sobrenomecomprador);
				$this->session->set_flashdata('CELULAR', $celularcomprador);
				$this->session->set_flashdata('TELEFONE', $telefonecomprador);
				$this->session->set_flashdata('CIDADE', $cidadecomprador);
				$this->session->set_flashdata('DATANASCIMENTO', $datanascimentocomprador);
				
			}			
			
			$this->session->set_flashdata('REDIRECT', $redirect);
			
			if (clienteLogado()) {
				redirect ( 'conta/editarconta' );
			}else{
				redirect ( 'conta/novaconta' );
			}
			
			//echo $this->session->flashdata('EMAIL') . "xhcvjxv";
		}
	}
	
	
	public function valida() {
		
		$emailEsqueci = $this->input->post( "CPFesquecicomprador" );
		$email = $this->input->post( "email2comprador" );
		$senha = $this->input->post( "password2comprador" );
		$redirect = $this->input->post( "redirect" );
		//debug($emailEsqueci, true);
		if($emailEsqueci){
			
			$infoComprador = $this->CompradorM->getSenha("(emailcomprador='" . $emailEsqueci . "' or cpfcomprador='" . $emailEsqueci . "')");
			
			if ($infoComprador) {
				
				$dados = array();
				$Link = site_url("conta/novasenha?re=" . $redirect . "&c=" . $infoComprador->senhacomprador . "&cd=" . $infoComprador->codcomprador);
				$dados["LINK"] = $Link;
				$dados["NOMECLIENTE"] = $infoComprador->nomecomprador;
				//debug($infoComprador->senhacomprador, true);
				$retorno = enviarEmail("noreply@doeumacesta.com.br", "noreply", $infoComprador->emailcomprador, "Resetar senha - doeumacesta.com.br", "Esqueci_senha", $dados);
				if($retorno == ""){					
					$this->session->set_flashdata ( 'sucesso', 'Instruções enviadas para o seu email.');
					
				}else{
					$this->session->set_flashdata ( 'erro', $retorno);
					
				}
				
			}else{
				$this->session->set_flashdata ( 'erro', 'Dados incorretos.');				
			}
			redirect( 'conta/novaconta?re=' .$redirect );
			//redirect( $Link );
				
		}
		
		

		$this->load->library( 'Form_validation' );

		$this->form_validation->set_rules( 'email2comprador', 'Email', 'required|valid_email' );
		$this->form_validation->set_rules( 'password2comprador', 'Senha', 'required' );

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata ( 'erro', 'Informe os campos corretamente.' . validation_errors () );
			redirect( 'conta/novaconta?re=' .$redirect );
		}
		
		
		//debug($emailEsqueci,true);
		$infoComprador = $this->CompradorM->get( array (
				"emailcomprador" => $email,
				"senhacomprador" => md5( $senha )
		), TRUE );

		if (!$infoComprador) {
			
			$this->session->set_flashdata( 'erro', 'Email ou senha inválidos.' );
			redirect( 'conta/novaconta?re=' .$redirect );
			
		} else {
			
			$sessaoLoja = array (
					'nomecomprador' => $infoComprador->nomecomprador,
					'emailcomprador' => $infoComprador->emailcomprador,
					'codcomprador' => $infoComprador->codcomprador
			);
			//$ExpireCookie = "201600";
			
			//$codcomprador = $infoComprador->codcomprador;
			//$emailcomprador = $infoComprador->emailcomprador;
			//$nomecomprador = $infoComprador->nomecomprador;
			$this->session->set_userdata( 'UserDoeUmaCesta', $sessaoLoja );	
					
			//$this->input->set_cookie('CodDoeUmaCesta',$codcomprador, $ExpireCookie, FALSE);			
				
			//$this->input->set_cookie('EmailDoeUmaCesta', $emailcomprador, $ExpireCookie, FALSE);
							
			//$this->input->set_cookie('NomeDoeUmaCesta', $nomecomprador, $ExpireCookie, FALSE);
			
			redirect($redirect);
		}
	}
	
	public function novasenha(){
		
		$redirect = $this->input->get( "re" );
		$codi = $this->input->get( "c" );
		$id = $this->input->get( "cd" );
		
		if($codi){
				
			$infoComprador = $this->CompradorM->getSenha("senhacomprador='" . $codi . "' and codcomprador=" . $id);
				
			if ($infoComprador) {
				
				$data = array();
				$data['REGISTRO'] = array();
				$data['FORMVALIDAR'] = array();
				$data['ACAOFORMLOGIN'] = site_url ( "conta/salvar" );
				
				$data['NOVASENHA'][] = array(
				
						"URLVOLTA" => site_url("conta/novaconta?re=" . $redirect),
						"VALID" => $codi,
						"CD" => $id,
						"REDIRECT" => $redirect
				);
						
			}else{
				$this->session->set_flashdata ( 'erro', 'Código incorreto.');
				redirect( 'conta/novaconta?re=' .$redirect );
			}
					
		}else{
				$this->session->set_flashdata ( 'erro', 'Código incorreto.');
				redirect( 'conta/novaconta?re=' .$redirect );
			}
		
		$this->parser->parse('Conta_form', $data);
		
	}
	public function sair() {
		$this->session->unset_userdata( 'UserDoeUmaCesta' );
		redirect ();
	}
	
	public function resumo($codcarrinho) {
		
		//redirect("checkout/resumo/" . $codcarrinho);
		
		clienteLogado( true );

		$comprador = $this->session->userdata ( 'UserDoeUmaCesta' );

		//$this->load->model( "Carrinho_Model", "CarrinhoM" );
		$this->load->model( "ItemCarrinho_model", "ItemCarrinhoM" );

		$carrinho = $this->CarrinhoM->get ( array (
				"c.codcarrinho" => $codcarrinho,
				"c.codcomprador" => $comprador["codcomprador"]
		), TRUE );

		if (!$carrinho) {
			$this->session->set_flashdata( 'erro', 'Carrinho não existente.' );
			redirect ( 'conta/novaconta' );
		}

		$data = array();

		$data["CODCARRINHO"] = $codcarrinho;
		$data["PAGSEGURO"] = array();
		$data["DEPOSITOTRANS"] = array();

		$data["FINALIZADO"] = array();
		
		$data["DATA"] = $carrinho->data;
		$data["NOMEFORMAPAGAMENTO"] = $carrinho->nomeformapagamento;
		$data["NOMEFORMAENTREGA"] = $carrinho->nomeformaentrega;
		$data["VALORFINALCOMPRA"] = number_format ( $carrinho->valorfinalcompra, 2, ",", "." );
		
		$codformapagamento = $carrinho->codformapagamento;
		$this->load->model( 'Formapagamento_model', 'FormapagamentoM' );
		$descricaofor = $this->FormapagamentoM->get ( array (
				"codformapagamento" => $codformapagamento
		), TRUE );
		$situacao = $carrinho->situacao;
		
		if($situacao == "A"){
			
			if($codformapagamento == "1"){
				
					$data ["DEPOSITOTRANS"][] = array(
					"DADOS" => $descricaofor->descricao
				);
			}
			
			if($codformapagamento == "2"){				
		
				$data ["PAGSEGURO"][] = array(
						"SCRIPT" => "",
						"COD" => $carrinho->codpagseguro,
	    				"TIPO" => "NaoVerificar"
				);
					
			}
			
		}
		
		$data ["DETALHESPAGAMENTO"] = array();

		$itens = $this->ItemCarrinhoM->get ( array (
				"ic.codcarrinho" => $codcarrinho
		) );

		$data ["BLC_DADOS"] = array ();

		if ($itens) {
			foreach ( $itens as $i ) {
				$data ["BLC_DADOS"] [] = array (
						"NOMEPRODUTO" => $i->nomeproduto,
						"QTD" => $i->quantidadeitem,
						"VLRUN" => number_format ( $i->valoritem, 2, ",", "." ),
						"VLRTOTAL" => number_format ( $i->valorfinal, 2, ",", "." )
				);
			}
		}
		

		$this->parser->parse( "resumo", $data );
	}
	public function boleto($codcarrinho, $tipo) {
		clienteLogado ( true );

		$comprador = $this->session->userdata ( 'loja' );

	//	$this->load->model ( "Carrinho_Model", "CarrinhoM" );

		$carrinho = $this->CarrinhoM->get ( array (
				"c.codcarrinho" => $codcarrinho,
				"c.codcomprador" => $comprador ["codcomprador"]
		), TRUE );

		if (! $carrinho) {
			$this->session->set_flashdata ( 'erro', 'Carrinho não existente.' );
			redirect ( 'conta' );
		}

		$this->layout = '';

		switch ($tipo) {
			case "bb" :
				$arquivoBoleto = "boleto_bb";
				break;
		}

		$boleto = new stdClass ();
		$boleto->codcarrinho = $carrinho->codcarrinho;
		$boleto->valor = $carrinho->valorfinalcompra;
		$boleto->nomecomprador = $carrinho->nomecomprador;
		$boleto->endereco = $carrinho->enderecocomprador;
		$boleto->endereco2 = $carrinho->cidadecomprador . "/" . $carrinho->ufcomprador . " - " . $carrinho->cepcomprador;

		require_once FCPATH . "/application/libraries/boleto/" . $arquivoBoleto . ".php";
	}
}