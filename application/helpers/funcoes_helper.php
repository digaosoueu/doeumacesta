<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists ( 'setURL' )) {
    function setURL(&$data, $controller) {
       // $data ['URLLISTAR'] = site_url ( "painel/{$controller}" );
       // $data ['ACAOFORM'] = site_url ( "painel/{$controller}/salvar" );
    }
}

if(!function_exists ( 'listaEstado' )){
	
	function listaEstado($UF){
		
		
		$Array = array("AC" => 'Acre',"AL" => 'Alagoas',"AM" => 'Amazonas',"AP" => 'Amapá',"BA" => 'Bahia',
				"CE" => 'Ceará', "DF" => 'Distrito Federal',"ES" => 'Espírito Santo',"GO" => 'Goiás',
				"MA" => 'Maranhão',	"MT" => 'Mato Grosso',"MS" => 'Mato Grosso do Sul',
				"MG" => 'Minas Gerais',"PA" => 'Pará',"PB" => 'Paraíba', "PR" => 'Paraná',"PE" => 'Pernambuco',
				"PI" => 'Piauí', "RJ" => 'Rio de Janeiro',"RN" => 'Rio Grande do Norte',"RO" => 'Rondônia',
				"RS" => 'Rio Grande do Sul',"RR" => 'Roraima',"SC" => 'Santa Catarina',
				"SE" => 'Sergipe',"SP" => 'São Paulo',"TO" => 'Tocantins');
		
		$html = "";
		foreach($Array as $key => $value):
			
			$select = "";
			if($key == $UF){$select = "selected";}
		
			$html .= '<option value="'.$key.'" ' . $select . '>'.$value.'</option>';
			
		endforeach;
		
				
		return $html;
	}
}

if (!function_exists ( 'enviarEmail' )) {
	

 function enviarEmail($EmailFrom, $NomeFrom, $EmailTo, $Assunto, $Pagina, $data = Array()){
	 
	 	$CI = &get_instance ();
		$HTML = "";
		//echo $infoComprador->emailcomprador . 'dfdf';
		$CI->load->library('email');
		$CI->email->clear();
		$CI->email->initialize();
		 
		$CI->email->from($EmailFrom, $NomeFrom);
		$CI->email->to($EmailTo);
		$CI->email->subject($Assunto);
		 
		$conteudoHtml = $CI->load->view('email/'.$Pagina, $data, TRUE);
		 
		$CI->email->message($conteudoHtml);
		 
		$retorno = $CI->email->send();
		//echo $this->email->print_debugger();
		if($retorno){
			return "";
		}else{
			return $CI->email->print_debugger();
		}
	
	 
	}
}

if (!function_exists ( 'debug' )) {
    function debug($data, $die = false) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if ($die) {
            die();
        }
    }
}

if (!function_exists ( 'modificaDinheiroBanco' )) {
    
    /**
     * Modifica o valor de moeda para de banco de dados
     *
     * @param string $valor            
     * @return numeric
     */
    function modificaDinheiroBanco($valor) {
        if (!$valor) {
            return 0;
        }
        $valor = str_replace ( '.', null, $valor );
        $valor = str_replace ( ',', '.', $valor );
        return $valor;
    }
}

if (! function_exists ( 'modificaNumericValor' )) {
    
    /**
     * Modifica o valor de numeric para valor em R$
     *
     * @param string $valor            
     * @return numeric
     */
    function modificaNumericValor($valor) {
        $valor = number_format ( $valor, 2, ',', '.' );
        return $valor;
    }
}

if (! function_exists ( 'modificaNumericPeso' )) {
    
    /**
     * Modifica o valor de numeric para valor em KG
     *
     * @param string $valor            
     * @return numeric
     */
    function modificaNumericPeso($valor) {
        $valor = number_format ( $valor, 3, ',', '.' );
        return $valor;
    }
}

if (!function_exists( 'mascara' )) {
    
    /**
     * Modifica o valor para uma máscara
     *
     * @param string $valor            
     * @return string
     */
    function mascara($valor, $mascara) {
        $mascarado = '';
        $k = 0;
        
        for($i = 0; $i <= strlen ( $mascara ) - 1; $i ++) {
            if ($mascara [$i] == '#') {
                if (isset ( $valor [$k] )) {
                    $mascarado .= $valor [$k ++];
                }
            } else {
                if (isset ( $mascara [$i] )) {
                    $mascarado .= $mascara [$i];
                }
            }
        }
        
        return $mascarado;
    }
}

if (! function_exists ( 'validaCPF' )) {
    
    /**
     * Valida se o CPF informado é válido
     *
     * @param integer $cpf            
     */
    function validaCPF($cpf) {
        if (! is_numeric ( $cpf )) {
            return false;
        }
        
        $aCPFsBloqueados = array (
                "00000000000",
                "11111111111",
                "22222222222",
                "33333333333",
                "44444444444",
                "55555555555",
                "66666666666",
                "77777777777",
                "88888888888",
                "99999999999" 
        );
        
        if (in_array ( $cpf, $aCPFsBloqueados )) {
            return false;
        }
        
        // DÍGITO VERIFICADOR
        
        $dv_informado = substr ( $cpf, 9, 2 );
        
        for($i = 0; $i <= 8; $i ++) {
            $digito [$i] = substr ( $cpf, $i, 1 );
        }
        
        // CALCULA O VALOR DO 10º DÍGITO DE VERIFICAÇÃO
        
        $posicao = 10;
        $soma = 0;
        
        for($i = 0; $i <= 8; $i ++) {
            $soma = $soma + $digito [$i] * $posicao;
            $posicao = $posicao - 1;
        }
        
        $digito [9] = $soma % 11;
        
        if ($digito [9] < 2) {
            $digito [9] = 0;
        } else {
            $digito [9] = 11 - $digito [9];
        }
        
        // CALCULA O VALOR DO 11º DÍGITO DE VERIFICAÇÃO
        $posicao = 11;
        $soma = 0;
        
        for($i = 0; $i <= 9; $i ++) {
            $soma = $soma + $digito [$i] * $posicao;
            $posicao = $posicao - 1;
        }
        
        $digito [10] = $soma % 11;
        
        if ($digito [10] < 2) {
            $digito [10] = 0;
        } else {
            $digito [10] = 11 - $digito [10];
        }
        
        $dv = $digito [9] * 10 + $digito [10];
        
        if ($dv != $dv_informado) {
            return false;
        }
        
        return true;
    }
}

if (! function_exists ( 'dateBR2MySQL' )) {
    
    /**
     * Converte dd/mm/yyyy -> Y-m-d
     *
     * @param string $valor            
     * @return numeric
     */
    function dateBR2MySQL($valor) {
        $valor = explode ( "/", $valor );
        $valor = $valor [2] . '-' . $valor [1] . '-' . $valor [0];
        return $valor;
    }
}

if (! function_exists ( 'dateMySQL2BR' )) {
    
    /**
     * Converte Y-m-d - > dd/mm/yyyy
     *
     * @param string $valor            
     * @return numeric
     */
    function dateMySQL2BR($valor) {
        $date = date_create ( $valor );
        return date_format ( $date, 'd/m/Y' );
    }
}

if (! function_exists ( 'clienteLogado' )) {
    
    /**
     * Verifica se o cliente está logado
     *
     * @return mixed
     */
    function clienteLogado($redirecionaLogin = false) {
        $CI = &get_instance ();
        
        $redirect = str_replace(site_url(), "", current_url());
        $sessao = $CI->session->userdata ( 'UserDoeUmaCesta' );
        
        if (isset( $sessao['codcomprador'] )) {
            return TRUE;
        } else {
            if ($redirecionaLogin) {
                redirect('conta/novaconta/?re=' . $redirect);
            }
            return FALSE;
        }
    }
}

if (!function_exists( 'montaListaProduto' )) {
    
    /**
     * Verifica se o cliente está logado
     *
     * @return mixed
     */
    function montaListaProduto($produto) {
    	
        $CI = &get_instance();
        
        $CI->load->model( "ProdutoFoto_model", "ProdutoFotoM" );
        $CI->load->model( "Sku_model", "SkuM" );
        $CI->load->model( "Produto_Model", "ProdutoM" );
        
        $data ["BLC_LINHA"] = array ();
        
        $produtosExibidos = 0;
        $coluna = array ();
        
        foreach ( $produto as $p ) {
            
            $filtroFoto = array (
                    "p.codproduto" => $p->codproduto 
            );
            
            $foto = $CI->ProdutoFotoM->get($filtroFoto, TRUE );
            
            $url = base_url ( "assets/img/foto-indisponivel.jpg" );
            
            if ($foto) {
                $url = base_url ( "assets/img/produto/150x150/" . $foto->produtofoto );
            }
            
            $urlFicha = site_url ( "produto/" . $p->codproduto . "/" . $p->urlseo );
            
            $precoPromocional = array ();
            
            $valorFinal = $p->valorproduto;
            
            if (($p->valorpromocional > 0) && ($p->valorpromocional < $p->valorproduto)) {
                $precoPromocional [] = array (
                        "VALORANTIGO" => number_format ( $p->valorproduto, 2, ",", "." ) 
                );
                
                $valorFinal = $p->valorpromocional;
            }
            
            $nomefabricante = null;
            $filtrofabricante = array (
            	"codfabricante" => $p->codfabricante
            );
            //var_dump($filtrofabricante);exit;
            $fabricante	= $CI->ProdutoM->listaFabricates($filtrofabricante, TRUE);
           // print($fabricante->nomefabricante) ;
            
            if($fabricante){            	
            	$nomefabricante = $fabricante->nomefabricante;
            }
            $codSku = null;
            $sku = $CI->SkuM->getPorProdutoSimples( $p->codproduto );
            if($sku){
            	$codSku = $sku->codsku;
            }
            
            $mostraLink = array();           
            
            if($codSku == "1"){           
            	
            	//$mostraLink[] = array();
            }
                       
            $coluna [] = array (
                "URLFOTO" => $url,
            		"FABRICANTE" => $nomefabricante,
            		"CODSKU" => $codSku,
                "URLPRODUTO" => $urlFicha,
                "NOMEPRODUTO" => $p->nomeproduto,
                "BLC_PRECOPROMOCIONAL" => $precoPromocional,
                "VALOR" => number_format ( $valorFinal, 2, ",", "." ),
            		"MOSTRALINKCESTA" => $mostraLink
            );
            
            $produtosExibidos ++;
            
           // if ($produtosExibidos === 4) {
              //  $produtosExibidos = 0;
              //  $data ["BLC_LINHA"] [] = array (
                    ////    "BLC_COLUNA" => $coluna,
                	//	"MOSTRALINKCESTA" => $mostraLink
               // );
                
               // $coluna = array ();
           // }
        }
        
        if ($produtosExibidos > 0) {
            $data ["BLC_LINHA"] [] = array (
                    "BLC_COLUNA" => $coluna                	
            );
        }
        
        $html = $CI->parser->parse( "Produtos_lista", $data, TRUE );
        
        return $html;
    }
}
