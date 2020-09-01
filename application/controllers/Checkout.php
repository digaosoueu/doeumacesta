<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {
    public function __construct() {
        parent::__construct ();
        $this->layout = LAYOUT_LOJA;
        $this->load->model( "Sku_model", "SkuM" );
        $this->load->model( 'Comprador_model', 'CompradorM' );
        $this->load->model( "FormaPagamento_Model", "FormaPagamentoM" );
        $this->load->helper('cookie');
    }
       
    public function resumoEmail(){
    	
    	$data = array ();
    	$data ["NOMECLIENTE"] = "Rodrigo";
    	$data ["TOTAL"] = "R$ " . number_format( $this->getPrecoCarrinho(FALSE), 2, ",", "." );
    	$carrinho = $this->session->userdata ( "carrinhoDoeumaCesta" );
    	
    	if (!$carrinho) {
    		$carrinho = array();
    	} else {
    		$carrinho = unserialize( $carrinho );
    	}
    	
    	$data ["BLC_PRODUTOS"] = array ();
    	
    	if (sizeof( $carrinho ) === 0) {
    		//$data ["BLC_SEMPRODUTOS"] [] = array ();
    	} else {
    		foreach ( $carrinho as $codsku => $quantidade ) {
    			$infoSKU = $this->SkuM->getPorSKU ( $codsku );
    	
    			if (($infoSKU->valorpromocional > 0) && ($infoSKU->valorproduto > $infoSKU->valorpromocional)) {
    				$valorFinal = $infoSKU->valorpromocional;
    			} else {
    				$valorFinal = $infoSKU->valorproduto;
    			}
    			$valorTotal = $valorFinal * $quantidade;    	
    			    	
    			$data ["BLC_PRODUTOS"] [] = array (
    					"NOMEPRODUTO" => $infoSKU->nomeproduto,
    					"QUANTIDADE" => $quantidade,
    					"VALOR" => number_format( $valorFinal, 2, ",", "." ),
    					"VALORTOTAL" => number_format ( $valorTotal, 2, ",", "." )
    			);
    		}
    	}
    	
    	$this->parser->parse( "email/resumo", $data );
    
    }
    
    private function getPesoCarrinho() {
        $carrinho = get_cookie( "carrinhoDoeumaCesta" );//$this->session->userdata( "carrinhoDoeumaCesta" );
        
        $peso = 0;
        
        if ($carrinho) {
            $carrinho = unserialize ( $carrinho );
            
            if (sizeof( $carrinho ) > 0) {
                foreach ( $carrinho as $codprodutosku => $quantidade ) {
                    $infoSKU = $this->SkuM->getPorSKU ( $codprodutosku );
                    
                    if ($quantidade <= 0) {
                        continue;
                    }
                    
                    if ($quantidade > $infoSKU->quantidade) {
                        continue;
                    }
                    
                    $pesoCubico = ($infoSKU->altura * $infoSKU->largura * $infoSKU->comprimento) / 6000;
                    
                    if ($pesoCubico > $infoSKU->peso) {
                        $peso += $pesoCubico;
                    } else {
                        $peso += $infoSKU->peso;
                    }
                }
            }
        }
        
        return $peso;
    }
    
    public function index() {
        $carrinho = get_cookie( "carrinhoDoeumaCesta" );//$this->session->userdata ( "carrinhoDoeumaCesta" );
        
        if (!$carrinho) {
            $carrinho = array();
        } else {
            $carrinho = unserialize( $carrinho );
        }
        
        $data = array ();
        $data ["BLC_PRODUTOS"] = array ();
        $data ["BLC_FINALIZAR"] = array ();
        $data ["BLC_SEMPRODUTOS"] = array ();
        
        if (sizeof( $carrinho ) === 0) {
            $data ["BLC_SEMPRODUTOS"] [] = array ();
        } else {
            foreach ( $carrinho as $codsku => $quantidade ) {
                $infoSKU = $this->SkuM->getPorSKU( $codsku );
                
                if (($infoSKU->valorpromocional > 0) && ($infoSKU->valorproduto > $infoSKU->valorpromocional)) {
                    $valorFinal = $infoSKU->valorpromocional;
                } else {
                    $valorFinal = $infoSKU->valorproduto;
                }
                $valorTotal = $valorFinal * $quantidade;
                
                $referencia = "";
                
                if (! empty ( $infoSKU->referencia )) {
                    $referencia = " - " . $infoSKU->referencia;
                }
                
                
                $urlFoto = base_url ( "assets/img/produto/80x80/" . $infoSKU->produtofoto);
                
                if (! empty ( $infoSKU->codprodutofotosku )) {
                    //$urlFoto = base_url ( "assets/img/produto/80x80/" . $infoSKU->codprodutofotosku . "." . $infoSKU->produtofotoextensaosku );
                } else {
                    //$urlFoto = base_url ( "assets/img/produto/80x80/" . $infoSKU->codprodutofoto . "." . $infoSKU->produtofotoextensao );
                }
                
                $data ["BLC_PRODUTOS"] [] = array (
                        "URLFOTO" => $urlFoto,
                        "NOMEPRODUTO" => $infoSKU->nomeproduto . $referencia,
                        "QUANTIDADE" => $quantidade,
                        "VALOR" => number_format( $valorFinal, 2, ",", "." ),
                        "VALORTOTAL" => number_format ( $valorTotal, 2, ",", "." ),
                		"CODSKU" => $infoSKU->codsku,
                        "URLAUMENTAQTD" => site_url ( "checkout/aumenta/" . $infoSKU->codsku ),
                        "URLDIMINUIQTD" => site_url ( "checkout/diminui/" . $infoSKU->codsku ),
                        "URLREMOVEQTD" => site_url ( "checkout/remove/" . $infoSKU->codsku ) 
                );
            }
            
            $data ["BLC_FINALIZAR"] [] = array (
                    "URLFINALIZAR" => site_url ( 'checkout/formaentrega' ) 
            );
        }
        
        $valorTotalCarrinho = $this->getPrecoCarrinho(FALSE);
        $data ["BCL_TOTALCARRINHO"] [] = array (
        		"SUBTOTALCARRINHO" => number_format( $valorTotalCarrinho, 2, ",", "." ),
        		"TOTALCARRINHO" => number_format( $valorTotalCarrinho, 2, ",", "." )
        );
        
        $this->parser->parse( "carrinho", $data );
    }
    
    public function formaentrega() {
        clienteLogado( true );
        
        $carrinho = $this->session->userdata ( "carrinhoDoeumaCesta" );
        $enderecoentrega = $this->session->userdata ( "enderecoentrega" );
        $comprador = $this->session->userdata ( 'UserDoeUmaCesta' );
        
        if (!$carrinho) {
            $carrinho = array ();
        } else {
            $carrinho = unserialize ( $carrinho );
        }
        
        if (sizeof ( $carrinho ) === 0) {
            redirect ();
        }
        
        if ($enderecoentrega) {
            $enderecoentrega = unserialize ( $enderecoentrega );
        }
        
        if ((! $enderecoentrega) || (sizeof ( $enderecoentrega ) === 0)) {
            
            
            $infoComprador = $this->CompradorM->get ( array (
                    "codcomprador" => $comprador ["codcomprador"] 
            ), TRUE );
            
            $infoEntrega = array ();
            $infoEntrega ['enderecocomprador'] = $infoComprador->enderecocomprador;
            $infoEntrega ['cidadecomprador'] = $infoComprador->cidadecomprador;
            $infoEntrega ['ufcomprador'] = $infoComprador->ufcomprador;
            $infoEntrega ['cepcomprador'] = $infoComprador->cepcomprador;
            
            $infoEntregaSessao = serialize ( $infoEntrega );
            
            $this->session->set_userdata ( 'enderecoentrega', $infoEntregaSessao );
        } else {
            $infoEntrega = $enderecoentrega;
        }
        
        $data = array ();
        
        $data ["ENDERECO"] = $infoEntrega ['enderecocomprador'];
        $data ["CIDADE"] = $infoEntrega ['cidadecomprador'];
        $data ["UF"] = $infoEntrega ['ufcomprador'];
        $data ["CEP"] = $infoEntrega ['cepcomprador'];
        
        $data ["BLC_FORMAENTREGA"] = array ();
        
        $this->load->model ( "PrecoEntrega_Model", "PrecoEntregaM" );
        
        $formasEntrega = $this->PrecoEntregaM->getPrecoEntrega ( $infoEntrega ['cepcomprador'], $this->getPesoCarrinho () );
        
        $checked = false;
        
        if ($formasEntrega) {
            foreach ( $formasEntrega as $fe ) {
                $data ["BLC_FORMAENTREGA"] [] = array (
                        "CODFORMAENTREGA" => $fe->codformaentrega,
                        "NOMEFORMAENTREGA" => $fe->nomeformaentrega,
                        "DIASENTREGA" => $fe->prazofaixaprecoformaentrega,
                        "CHECKED_FE" => (!$checked) ? "checked" : null,
                        "VALOR" => number_format ( $fe->valorfaixaprecoformaentrega, 2, ",", "." ) 
                );
                
                if ((!$checked)) {
                    $checked = true;
                }
            }
        }
        
        $this->load->model ( 'FormaEntrega_model', 'FormaEntregaM' );
        
        $formasDisponiveis = $this->FormaEntregaM->get ( array (
                "habilitaformaentrega" => 'S',
                "codigocorreiosformaentrega !=" => '' 
        ) );
        
        if ($formasDisponiveis) {
            foreach ( $formasDisponiveis as $fd ) {
                $xml = null;
                
                $pesoCarrinhoOriginal = $this->getPesoCarrinho ();
                
                $totalPacotes = 1;
                
                if ($pesoCarrinhoOriginal > 30) {
                    $totalPacotes = $pesoCarrinhoOriginal / 30;
                    $totalPacotes = ceil ( $totalPacotes );
                    $pesoCarrinho = 30;
                } else {
                    $pesoCarrinho = $pesoCarrinhoOriginal;
                }
                
                $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
                // $url .= "nCdEmpresa=";
                // $url .= "&nDsSenha=";
                $url .= "&sCepOrigem=9901030";
                $url .= "&sCepDestino=" . $infoEntrega ['cepcomprador'];
                $url .= "&nVlPeso=" . $pesoCarrinho;
                $url .= "&nCdServico=" . $fd->codigocorreiosformaentrega;
                $url .= "&nCdFormato=1&nVlComprimento=25&nVlAltura=2&nVlLargura=11";
                $url .= "&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n";
                $url .= "&nVlDiametro=0&StrRetorno=xml";
                
                $ch = curl_init ();
                curl_setopt ( $ch, CURLOPT_URL, $url );
                curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 3 );
                curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 3 );
                curl_setopt ( $ch, CURLOPT_USERAGENT, 'Checkout' );
                $query = curl_exec ( $ch );
                curl_close ( $ch );
                
                if ($query) {
                    
                    $xml = new SimpleXMLElement ( $query );
                    
                    foreach ( $xml as $cor ) {
                        
                        if ($cor->Erro == '0') {
                            
                            $data ["BLC_FORMAENTREGA"] [] = array (
                                    "CODFORMAENTREGA" => $fd->codformaentrega,
                                    "NOMEFORMAENTREGA" => $fd->nomeformaentrega,
                                    "DIASENTREGA" => $cor->PrazoEntrega,
                                    "CHECKED_FE" => (! $checked) ? "checked" : null,
                                    "VALOR" => number_format ( $totalPacotes * ( float ) $cor->Valor, 2, ',', '.' ) 
                            );
                            
                            if ((! $checked)) {
                                $checked = true;
                            }
                        }
                    }
                }
            }
        }
        
        $data ["BLC_PERMITECOMPRAR"] = array ();
        if ($checked) {
            $data ["URLPAGAMENTO"] = site_url ( 'checkout/pagamento' );
            $data ["BLC_PERMITECOMPRAR"] [] = array ();
        }
        
        $data ["URLALTERAENTREGA"] = site_url ( 'checkout/alteraendereco' );
        
        $this->parser->parse ( "formaentrega", $data );
    }
    public function alteraendereco() {
        $enderecocomprador = $this->input->post ( 'enderecocomprador' );
        $cidadecomprador = $this->input->post ( 'cidadecomprador' );
        $ufcomprador = $this->input->post ( 'ufcomprador' );
        $cepcomprador = $this->input->post ( 'cepcomprador' );
        
        $this->load->library ( 'form_validation' );
        
        $this->form_validation->set_rules ( 'enderecocomprador', 'Endereço', 'required' );
        $this->form_validation->set_rules ( 'cidadecomprador', 'Cidade', 'required' );
        $this->form_validation->set_rules ( 'ufcomprador', 'UF', 'required' );
        $this->form_validation->set_rules ( 'cepcomprador', 'CEP', 'required' );
        
        if ($this->form_validation->run () == FALSE) {
            $this->session->set_flashdata ( 'erro', 'Informe os campos corretamente.' . validation_errors () );
        } else {
            $infoEntrega = array ();
            $infoEntrega ['enderecocomprador'] = $enderecocomprador;
            $infoEntrega ['cidadecomprador'] = $cidadecomprador;
            $infoEntrega ['ufcomprador'] = $ufcomprador;
            $infoEntrega ['cepcomprador'] = $cepcomprador;
            
            $infoEntrega = serialize ( $infoEntrega );
            
            $this->session->set_userdata ( 'enderecoentrega', $infoEntrega );
        }
        
        redirect ( 'checkout/formaentrega' );
    }
    
    /**
     * Adiciona um produto ao carrinho
     */
    public function adicionar() {
    	
        $codproduto = $this->input->post ( "codproduto" );
        $codsku = $this->input->post ( "codsku" );
        
        $carrinho = $this->session->userdata( "carrinhoDoeumaCesta" );
        
        if (!$carrinho) {
            $carrinho = array();
        } else {
            $carrinho = unserialize( $carrinho );
        }
        
        $infoSKU = $this->SkuM->getPorSKU( $codsku );
        
        if ($infoSKU) {
            
            if (! isset ( $carrinho [$codsku] )) {
                if ($infoSKU->quantidade > 0) {
                    $carrinho [$codsku] = 1;
                }
            } else {
                
                if ($infoSKU->quantidade > $carrinho [$codsku] + 1) {
                    $carrinho [$codsku] = $carrinho [$codsku] + 1;
                }
            }
        }
        
        $carrinho = serialize( $carrinho );
        $this->session->set_userdata( "carrinhoDoeumaCesta", $carrinho );
        
        redirect ( "checkout" );
    }
    public function aumenta($codsku) {
        $carrinho = $this->session->userdata ( "carrinhoDoeumaCesta" );
        
        if (! $carrinho) {
            $carrinho = array ();
        } else {
            $carrinho = unserialize ( $carrinho );
        }
        
        $infoSKU = $this->SkuM->getPorSKU ( $codsku );
        
        if ($infoSKU) {
            
            if (! isset ( $carrinho [$codsku] )) {
                if ($infoSKU->quantidade > 0) {
                    $carrinho [$codsku] = 1;
                }
            } else {
                
                if ($infoSKU->quantidade > $carrinho [$codsku] + 1) {
                    $carrinho [$codsku] = $carrinho [$codsku] + 1;
                }
            }
        }
        
        $carrinho = serialize ( $carrinho );
        $this->session->set_userdata ( "carrinhoDoeumaCesta", $carrinho );
        
        redirect ( "checkout" );
    }
    public function diminui($codsku) {
        $carrinho = $this->session->userdata ( "carrinhoDoeumaCesta" );
        
        if (! $carrinho) {
            $carrinho = array ();
        } else {
            $carrinho = unserialize ( $carrinho );
        }
        
        $infoSKU = $this->SkuM->getPorSKU ( $codsku );
        
        if ($infoSKU) {
            
            if (! isset ( $carrinho [$codsku] )) {
                if ($infoSKU->quantidade > 0) {
                    $carrinho [$codsku] = 1;
                }
            } else {
                if (($carrinho [$codsku] - 1) <= 0) {
                    $carrinho [$codsku] = 1;
                } elseif ($infoSKU->quantidade > $carrinho [$codsku] - 1) {
                    $carrinho [$codsku] = $carrinho [$codsku] - 1;
                }
            }
        }
        
        $carrinho = serialize ( $carrinho );
        $this->session->set_userdata( "carrinhoDoeumaCesta", $carrinho );
        
        redirect ( "checkout" );
    }
    public function remove($codsku) {
        $carrinho = $this->session->userdata( "carrinhoDoeumaCesta" );
        
        if (! $carrinho) {
            $carrinho = array ();
        } else {
            $carrinho = unserialize ( $carrinho );
        }
        
        unset ( $carrinho [$codsku] );
        
        $carrinho = serialize ( $carrinho );
        $this->session->set_userdata ( "carrinhoDoeumaCesta", $carrinho );
        
        redirect ( "checkout" );
    }
    public function pagamento() {
    	
        clienteLogado ( true );
        $comprador = $this->session->userdata( 'UserDoeUmaCesta' );
        if($comprador){
        	
        	$infoComprador = $this->CompradorM->get ( array (
        			"codcomprador" => $comprador["codcomprador"]
        	), TRUE );        	
        	
        	//debug($infoComprador->nomecomprador,true);
        	if($infoComprador->nomecomprador == "" || $infoComprador->cpfcomprador == ""){
        		
        		$this->session->set_flashdata( 'erro', 'Favor, completar seu cadastro.' );
        		redirect ( "conta/editarconta/?re=/checkout/pagamento" );
        	}
        	
        }
        //$codformaentrega = $this->input->post ( "codformaentrega" );
        
        //if ($codformaentrega) {
          //  $this->session->set_userdata ( "codformaentrega", $codformaentrega );
        //} else {
          //  $codformaentrega = $this->session->userdata ( "codformaentrega" );
            
            //if (! $codformaentrega) {
              //  redirect ( "checkout/formaentrega" );
            //}
        //}
        
        $data = array ();
        $data ["SUBTOTAL"] = null;
        $data ["FRETE"] = null;
        $data ["TOTAL"] = null;
        $data ["URLPAGAMENTO"] = site_url ( "checkout/finalizar" );
        
        $data ["BLC_FORMAPAGAMENTO"] = array ();
        
        //$this->load->model( "FormaPagamento_Model", "FormaPagamentoM" );
        
        $formasPagamento = $this->FormaPagamentoM->get( array (
                "habilitaformapagamento" => 'S' 
        ) );
        
        $checked = false;
        
        $valorTotal = 0;
        
        //$enderecoentrega = $this->session->userdata( "enderecoentrega" );
        //$enderecoentrega = unserialize( $enderecoentrega );
        
       // $valorFrete = $this->getPrecoEntrega( $codformaentrega, $enderecoentrega ['cepcomprador'] );
        $valorSubTotal = $this->getPrecoCarrinho();
        $valorFrete = "0.00";
        $valorTotal += $valorSubTotal + $valorFrete;
        
        //$data ["FRETE"] = number_format( $valorFrete, 2, ",", "." );
        $data["FRETE"] = "0,00";
        $data["SUBTOTAL"] = number_format( $valorSubTotal, 2, ",", "." );
        $data["TOTAL"] = number_format( $valorTotal, 2, ",", "." );
        
        $data["BLC_PARCELACARTAO"] = array ();
        $data["BLC_ABAS"] = array ();
        
        
        $x = 1;
        if ($formasPagamento) {
            foreach( $formasPagamento as $fp ) {
                
                $valorComDesconto = $valorSubTotal;
                
                if ($fp->descontoformapagamento > 0) {
                    $valorComDesconto = $valorComDesconto - (($valorSubTotal * $fp->descontoformapagamento) / 100);
                }
                
                $Ativo = "";
                $Ative = "";
                if($x == 1){
                	$Ativo = " class='active'";
                	$Ative = "in active";
                
                }
                
                $valorComDesconto += $valorFrete;
                
                $data["BLC_ABAS"][] = array(
                
                		"NOMEFORMAPAGAMENTO" => $fp->nomeformapagamento,
                		"ATIVO" => $Ativo,
                		"LINK" => $x,
                		"ATIVO" => $Ativo
                );
                $descricao = " - Pagamento á vista";
                if($fp->codformapagamento == "2"){$descricao = " - Pagamento em até 18x";}
                
                $data ["BLC_FORMAPAGAMENTO"] [] = array (
                		"NOMEFORMAPAGAMENTO" 	=> $fp->nomeformapagamento,
                		"LINK" 					=> $x,
                		"VALOR" 				=> number_format ( $valorComDesconto, 2, ",", "." ),
                		"ID" 					=> $x,
                		"ATIVE" 				=> $Ative,
                		"DESCRICAO"				=> $descricao,
                		"CODFORMAPAGAMENTO" 	=> $fp->codformapagamento,
                );               
                    
                
                if ((! $checked)) {
                    $checked = true;
                }
                $x++;
            }
        }
        
        $data ["BLC_PERMITECOMPRAR"] = array ();
        
        if ($checked) {
            $data ["BLC_PERMITECOMPRAR"] [] = array ();
        }
        
        $valorTotalCarrinho = $this->getPrecoCarrinho(FALSE);
        $data ["BCL_TOTALCARRINHO"] [] = array (
        		"SUBTOTALCARRINHO" => number_format( $valorTotalCarrinho, 2, ",", "." ),
        		"TOTALCARRINHO" => number_format( $valorTotalCarrinho, 2, ",", "." )
        );
        
        $this->parser->parse( "pagamento", $data );
    }
    private function getPrecoCarrinho($codformapagamento = false) {
    	
        $carrinho =  get_cookie( "carrinhoDoeumaCesta" );//$this->session->userdata ( "carrinhoDoeumaCesta" );
        
        if (! $carrinho) {
            $carrinho = array ();
        } else {
            $carrinho = unserialize ( $carrinho );
        }
        
        $valorTotal = 0;
        
        foreach ( $carrinho as $codsku => $quantidade ) {
            $infoSKU = $this->SkuM->getPorSKU( $codsku );
            
            if (($infoSKU->valorpromocional > 0) && ($infoSKU->valorproduto > $infoSKU->valorpromocional)) {
                $valorFinal = $infoSKU->valorpromocional;
            } else {
                $valorFinal = $infoSKU->valorproduto;
            }
            $valorTotal += $valorFinal * $quantidade;
        }
        
        if ($codformapagamento) {
           // $this->load->model ( "FormaPagamento_Model", "FormaPagamentoM" );
            
            $formasPagamento = $this->FormaPagamentoM->get ( array (
                    "codformapagamento" => $codformapagamento 
            ), TRUE );
            
            if ($formasPagamento->descontoformapagamento > 0) {
                $valorTotal = $valorTotal - (($valorTotal * $formasPagamento->descontoformapagamento) / 100);
            }
        }
        
        return $valorTotal;
    }
    private function getPrecoEntrega($codformaentrega, $cep) {
        $pesoCarrinho = $this->getPesoCarrinho ();
        
        $this->load->model ( "PrecoEntrega_Model", "PrecoEntregaM" );
        $formasEntrega = $this->PrecoEntregaM->getPrecoEntrega ( $cep, $pesoCarrinho, $codformaentrega );
        
        if ($formasEntrega) {
            return $formasEntrega->valorfaixaprecoformaentrega;
        } else {
            $this->load->model ( 'FormaEntrega_Model', 'FormaEntregaM' );
            
            $formasEntrega = $this->FormaEntregaM->get ( array (
                    "codformaentrega" => $codformaentrega 
            ), TRUE );
            
            $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
            // $url .= "nCdEmpresa=";
            // $url .= "&nDsSenha=";
            $url .= "&sCepOrigem=9901030";
            $url .= "&sCepDestino=" . $cep;
            $url .= "&nVlPeso=" . $pesoCarrinho;
            $url .= "&nCdServico=" . $formasEntrega->codigocorreiosformaentrega;
            $url .= "&nCdFormato=1&nVlComprimento=25&nVlAltura=2&nVlLargura=11";
            $url .= "&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n";
            $url .= "&nVlDiametro=0&StrRetorno=xml";
            
            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $url );
            curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 2 );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 3 );
            curl_setopt ( $ch, CURLOPT_USERAGENT, 'Checkout' );
            $query = curl_exec ( $ch );
            curl_close ( $ch );
            
            if ($query) {
                
                $xml = new SimpleXMLElement ( $query );
                
                foreach ( $xml as $cor ) {
                    
                    if ($cor->Erro == '0') {
                        return ( float ) $cor->Valor;
                    }
                }
            }
        }
    }
    
   
    
    public function finalizar() {
    	
        clienteLogado ( true );
        
        $codformaentrega = 1;//$this->session->userdata ( "codformaentrega" );
        $codformapagamento = $this->session->userdata( "CodPagamentoDoeUmaCesta" );
        $carrinho = get_cookie( "carrinhoDoeumaCesta" );
        
      
        if (!$codformapagamento) {
        	
        	$this->session->set_flashdata ( 'erro', 'Escolha uma forma de Pagamento' );
        	redirect ( "checkout/pagamento");
        }
        
      //  $this->load->model( "FormaPagamento_Model", "FormaPagamentoM" );
        
        $formasPagamento = $this->FormaPagamentoM->get( array (
                "codformapagamento" => $codformapagamento 
        ), TRUE );
        
               
        if (!$codformaentrega) {
          //  redirect( "checkout/pagamento");
        }
        
        
        $enderecoentrega = "";
        $comprador = $this->session->userdata ( 'UserDoeUmaCesta' );
        
        if ((!$carrinho) || (sizeof ( $carrinho ) === 0)) {
            redirect();
        }
        //===============================================================
        
        
        $EmailTo = $comprador["emailcomprador"];
        $EmailFrom = "noreply@doeumacesta.com.br";
        $NomeFrom = "noreply";
             
        $carrinho = unserialize ( $carrinho );
        $enderecoentrega = "";// unserialize ( $enderecoentrega );
        
       // $valorFrete = $this->getPrecoEntrega ( $codformaentrega, $enderecoentrega ['cepcomprador'] );
        $valorFrete = "0.00";
        $valorSubTotal = $this->getPrecoCarrinho( $codformapagamento );
        
        $valorTotal = $valorFrete + $valorSubTotal;
        
        $this->load->model( "Carrinho_model", "CarrinhoM" );
        $this->load->model( "ItemCarrinho_model", "ItemCarrinhoM" );
        
        $data = array ();
        $data ["NOMECLIENTE"] = $comprador["nomecomprador"];
        $data ["TOTAL"] = "R$ " . number_format( $valorTotal, 2, ",", "." );         
                
        $data ["BLC_PRODUTOS"] = array ();     
        
        $objeto = array (
                "datahoracompra" => date ( "Y-m-d H:i:s" ),
                "valorcompra" => $valorSubTotal,
                "valorfrete" => $valorFrete,
                "valorfinalcompra" => $valorTotal,
                "situacao" => "A",
                "codcomprador" => $comprador["codcomprador"],
                "codformaentrega" => $codformaentrega,
                "codformapagamento" => $codformapagamento,
                "enderecoentrega" => "-",//$enderecoentrega['enderecocomprador'],
                "cidadeentrega" => "-",// $enderecoentrega ['cidadecomprador'],
                "ufentrega" => "-",// $enderecoentrega ['ufcomprador'],
                "cepentrega" => "-"// $enderecoentrega ['cepcomprador'] 
        );
        

        $codCarrinho = $this->CarrinhoM->post( $objeto );
          
        foreach ( $carrinho as $codsku => $quantidade ) {
            
            $infoSKU = $this->SkuM->getPorSKU ( $codsku );
            
            if (($infoSKU->valorpromocional > 0) && ($infoSKU->valorproduto > $infoSKU->valorpromocional)) {
                $valorFinal = $infoSKU->valorpromocional;
            } else {
                $valorFinal = $infoSKU->valorproduto;
            }
            
            if ($formasPagamento->descontoformapagamento > 0) {
                $valorFinal = $valorFinal - (($valorFinal * $formasPagamento->descontoformapagamento) / 100);
            }
            
            $valorTotalP = $valorFinal * $quantidade;
            $data ["BLC_PRODUTOS"] [] = array (
            		"NOMEPRODUTO" => $infoSKU->nomeproduto,
            		"QUANTIDADE" => $quantidade,
            		"VALOR" => number_format( $valorFinal, 2, ",", "." ),
            		"VALORTOTAL" => number_format ( $valorTotalP, 2, ",", "." )
            );
            
            $objetoItem = array (
                    "valoritem" => $valorFinal,
                    "quantidadeitem" => $quantidade,
                    "codcarrinho" => $codCarrinho,
                    "codsku" => $codsku 
            );

            //echo $codCarrinho;
  //print_r($objetoItem);
//exit;    
            
            $this->ItemCarrinhoM->post ( $objetoItem );
        }
        
        $Retorno = "";      
       
       
        
       //deposito transferencia
      //  if($formasPagamento->tipoformapagamento == 3){
        	
        	//$this->session->unset_userdata( 'carrinhoDoeumaCesta' );
        	//$this->session->unset_userdata( 'CodPagamentoDoeUmaCesta' );
        	//redirect("conta/resumo/".$codCarrinho);
        	//$this->EnviarEmail($codCarrinho);
        	//$retornoEmal = enviarEmail($EmailFrom, $NomeFrom, $EmailTo, "DoaÃ§Ã£o relaizada com sucesso! - doeumacesta.com.br", "Resumo", $dados);
        	//$Retorno = "checkout/resumo/".$codCarrinho;
        	
       // }
        
        //Pagseguro
       // if($formasPagamento->tipoformapagamento == 4){
        $codCarrinho = str_pad($codCarrinho, 10, "0", STR_PAD_LEFT);
        	//$this->EnviarEmail($codCarrinho);
        $Retorno = "checkout/resumo/" . $codCarrinho;
        	
      //  }
      //  enviarEmail($EmailFrom, $NomeFrom, $EmailTo, "Muito Obrigado pela sua colaboração! - doeumacesta.com.br", "Resumo", $data);
    //    $this->session->unset_userdata( 'carrinhoDoeumaCesta' );
        
        redirect($Retorno);
    }
    
    public function resumo($codcarrinho, $pg = "") {
    
    	clienteLogado( true );
    	$data = array();

        $carrinho = get_cookie( "carrinhoDoeumaCesta" );        
        
        if (!$carrinho) {
            $this->session->set_flashdata( 'erro', 'Carrinho não existente.' );
            redirect ( 'conta/minhasdoacoes' );
        } 
    	
    	//$codformapagamento = $this->session->userdata( "CodPagamentoDoeUmaCesta" );
    	//$data["PAGSEGURO"] = array();
		//$data["DEPOSITOTRANS"] = array();
    	
    
    	$comprador = $this->session->userdata( 'UserDoeUmaCesta' );
    
    	$this->load->model( "Carrinho_Model", "CarrinhoM" );
    	$this->load->model( "ItemCarrinho_model", "ItemCarrinhoM" );
    
    	$carrinho = $this->CarrinhoM->get ( array (
    			"c.codcarrinho" => $codcarrinho,
    			"c.codcomprador" => $comprador["codcomprador"]
    	), TRUE );
    	
        	
        if (!$carrinho) {
            $this->session->set_flashdata( 'erro', 'Carrinho não existente.' );
            redirect ( 'conta/minhasdoacoes' );
        } 
    	
    	    	
    	$data ["CODCARRINHO"] = $codcarrinho;
    
    	    
    	$data ["DATA"] = $carrinho->data;
    	$data ["NOMEFORMAPAGAMENTO"] = $carrinho->nomeformapagamento;
    	$data ["NOMEFORMAENTREGA"] = $carrinho->nomeformaentrega;
    	$data ["VALORFINALCOMPRA"] = number_format ( $carrinho->valorfinalcompra, 2, ",", "." );
    	
    	$codformapagamento = $carrinho->codformapagamento;
    	if(!$codformapagamento){
    	
    		$this->session->set_flashdata ( 'erro', 'Escolha uma forma de Pagamento' );
    		redirect ( "checkout/pagamento");
    		//redirect();
    	}
    	
    	$situacao = $carrinho->situacao;
    	$urlBoleto = "";
    	$DadosPagamento = "";
    	$data["LINK_BOLETO"] = array();
    	
    	// if($situacao == "A"){ //aberto  		
    		
    		
    	// 	$formasPagamento = $this->FormaPagamentoM->get( array (
    	// 			"codformapagamento" => $codformapagamento
    	// 	), TRUE );
    		
    	// 	$DadosPagamento = $formasPagamento->descricao;
    		
    	// 	if($formasPagamento->nomeformapagamento == "Pag Seguro"){
    			
    	// 		$this->load->model( "Pagseguro_model", "PagM" );
    			
    	// 		$infoPag = $this->PagM->getRetorno( array (
    	// 				"cod_carrinho" => $codcarrinho
    	// 		), TRUE );
    			
    	// 		if($infoPag) {
    				
    	// 			if($infoPag->tipoPagamento == "BOLETO"){
    				
    	// 				$urlBoleto = $infoPag->url_boleto;
    	// 				$data["LINK_BOLETO"][] = array(
    	// 						"URLBOLETO" => $urlBoleto
    	// 				);
    	// 				$DadosPagamento = "";
    				
    	// 			}
    				
    	// 		}
    			
    	// 	}  	
	    	
    	// }
    	$BtnPagamento = "";
        if($codformapagamento == 2){
            $BtnPagamento = '<a href="javascript:void(0)" onclick="CarregaPagamentoPagseguro(' . intval($codcarrinho) . ')" class="btn btn-success btn-block">Efetuar Pagamento</a>';
        }
    	if($situacao == "P"){
    		
    		$DadosPagamento = '<a href="javascript:void(0)" class="btn btn-default">Pagamento efetuado com sucesso</a>';
            $BtnPagamento = "";
    		
    	}
    	
    	if($situacao == "C"){
    	
    		$DadosPagamento = '<a href="javascript:void(0)" class="btn btn-danger">Pagamento Cancelado :(</a>';
    	
    	}
        $MsgFinal = ""; 
        if($pg == "pgOK"){
            $BtnPagamento = "";
            $DadosPagamento = "";
            $MsgFinal = '<h2 class="title">Doação! Muito Obrigado pela sua colaboração ;)</h2>'; 
        }
    	
    	$data ["DETALHESPAGAMENTO"][] = array(
    			"DADOS" => $DadosPagamento,
    			"COD" => $codcarrinho,
                "BTNPG" => $BtnPagamento,
                "MSG" => $MsgFinal
    	);
    	
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
    //	$this->session->unset_userdata( 'carrinhoDoeumaCesta' );
    	$this->session->unset_userdata( 'CodPagamentoDoeUmaCesta' );
        set_cookie("carrinhoDoeumaCesta", null, 86400*12);
    	
    	$this->parser->parse( "resumo", $data );
    }
    
    public function TesteEmailFinal() {
    	 
    	clienteLogado ( true );
    
    	// $codformapagamento = $this->input->post( "codformapagamento" );
    	$codformaentrega = "1";//$this->session->userdata ( "codformaentrega" );
    	$codformapagamento = $this->session->userdata( "CodPagamentoDoeUmaCesta" );
    	$carrinho = $this->session->userdata ( "carrinhoDoeumaCesta" );
    	$EmailFrom = "noreply@doeumacesta.com.br";
    	$NomeFrom = "noreply";
    	// $codformapagamento = $codPagamento["codPagamento"];
    	//  $this->session->unset_userdata( 'CodPagamentoDoeUmaCesta' );
    	//  debug($codformapagamento . "ffds", true);
    
    
    	
    
    	$formasPagamento = $this->FormaPagamentoM->get( array (
    			"codformapagamento" => $codformapagamento
    	), TRUE );
    
    	//$enderecoentrega = $this->session->userdata( "enderecoentrega" );
    	$enderecoentrega = "";
    	$comprador = $this->session->userdata ( 'UserDoeUmaCesta' );
    
    	if ((!$carrinho) || (sizeof ( $carrinho ) === 0)) {
    		redirect();
    	}
    	$EmailTo = $comprador["emailcomprador"];
    	 
    	$carrinho = unserialize ( $carrinho );
    	$enderecoentrega = "";// unserialize ( $enderecoentrega );
    
    	// $valorFrete = $this->getPrecoEntrega ( $codformaentrega, $enderecoentrega ['cepcomprador'] );
    	$valorFrete = "0.00";
    	$valorSubTotal = $this->getPrecoCarrinho( $codformapagamento );
    
    	$valorTotal = $valorFrete + $valorSubTotal;
    
    	$this->load->model( "Carrinho_model", "CarrinhoM" );
    	$this->load->model( "ItemCarrinho_model", "ItemCarrinhoM" );
    
    	$data = array ();
    	$data ["NOMECLIENTE"] = $comprador["nomecomprador"];
    	$data ["TOTAL"] = "R$ " . number_format( $valorTotal, 2, ",", "." );
    	 
    
    	$data ["BLC_PRODUTOS"] = array ();
    	 
    
    	$objeto = array (
    			"datahoracompra" => date ( "Y-m-d H:i:s" ),
    			"valorcompra" => $valorSubTotal,
    			"valorfrete" => $valorFrete,
    			"valorfinalcompra" => $valorTotal,
    			"codcomprador" => $comprador["codcomprador"],
    			"codformaentrega" => $codformaentrega,
    			"codformapagamento" => $codformapagamento,
    			"enderecoentrega" => "-",//$enderecoentrega['enderecocomprador'],
    			"cidadeentrega" => "-",// $enderecoentrega ['cidadecomprador'],
    			"ufentrega" => "-",// $enderecoentrega ['ufcomprador'],
    			"cepentrega" => "-"// $enderecoentrega ['cepcomprador']
    	);
    
    	$codCarrinho = $this->CarrinhoM->post( $objeto );
    
    	foreach ( $carrinho as $codsku => $quantidade ) {
    
    		$infoSKU = $this->SkuM->getPorSKU ( $codsku );
    
    		if (($infoSKU->valorpromocional > 0) && ($infoSKU->valorproduto > $infoSKU->valorpromocional)) {
    			$valorFinal = $infoSKU->valorpromocional;
    		} else {
    			$valorFinal = $infoSKU->valorproduto;
    		}
    
    		if ($formasPagamento->descontoformapagamento > 0) {
    			$valorFinal = $valorFinal - (($valorFinal * $formasPagamento->descontoformapagamento) / 100);
    		}
    
    		$valorTotalP = $valorFinal * $quantidade;
    		$data ["BLC_PRODUTOS"] [] = array (
    				"NOMEPRODUTO" => $infoSKU->nomeproduto,
    				"QUANTIDADE" => $quantidade,
    				"VALOR" => number_format( $valorFinal, 2, ",", "." ),
    				"VALORTOTAL" => number_format ( $valorTotalP, 2, ",", "." )
    		);
    
    		$objetoItem = array (
    				"valoritem" => $valorFinal,
    				"quantidadeitem" => $quantidade,
    				"codcarrinho" => $codCarrinho,
    				"codsku" => $codsku
    		);
    
    		$this->ItemCarrinhoM->post ( $objetoItem );
    	}
    	$this->load->view( 'email/resumo', $data );
    
    }
    
    public function enviarEmailold($codcarrinho, $nome){
    	
    	$comprador = $this->session->userdata ( 'UserDoeUmaCesta' );
    	
    	$infoComprador = $this->CompradorM->get ( array (
    			"codcomprador" => $comprador["codcomprador"]
    	), TRUE );
    	
    	$HTML = "";
    	//echo $infoComprador->emailcomprador . 'dfdf';
    	$this->load->library('email');
    	$this->email->clear();
    	$this->email->initialize();
    	
    	$this->email->from('sac@doeumacesta.com.br', 'Sac');
    	$this->email->to($infoComprador->emailcomprador);    	
    	$this->email->subject('Muito Obrigado - doeumacesta.com.br');
    	
    	$conteudoHtml = $this->load->view('email/'.$nome, "", TRUE);
    	
    	$this->email->message($conteudoHtml);
    	
    	$this->email->send();
    	echo $this->email->print_debugger();
    	
    }
}