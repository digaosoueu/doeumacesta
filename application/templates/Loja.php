<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{TITLE}</title>
    <!--SEO Meta Tags-->
    <meta name="description" content="{DESCRIPTION}" />
	<meta name="keywords" content="{KEYWORDS}" />
	<meta name="author" content="" />
    <!--Mobile Specific Meta Tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
   
   <!--Master Slider Styles-->
    <link href="<?php echo base_url('assets/loja/css/masterslider.css')?>" rel="stylesheet" media="screen">
    <!--Styles-->
    <link href="<?php echo base_url('assets/loja/css/styles.css')?>" rel="stylesheet" media="screen">
    <!--Color Scheme-->
    <link class="color-scheme" href="<?php echo base_url('assets/loja/css/color-default.css')?>" rel="stylesheet" media="screen">
    <!--Color Switcher-->
    <link href="<?php echo base_url('assets/loja/css/color-switcher.css')?>" rel="stylesheet" media="screen">
    
    <script src="<?php echo base_url('assets/loja/js/jquery-1.11.1.min.js')?>"></script>
    <!--Modernizr-->
		<script src="<?php echo base_url('assets/loja/js/modernizr.custom.js')?>"></script>
    <!--Adding Media Queries Support for IE8-->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url('assets/loja/js/respond.js')?>"></script>
    <![endif]-->
    
    <script src="<?php echo base_url('assets/loja/js/jquery-ui-1.10.4.custom.min.js')?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.maskedinput.min.js')?>"></script>
	<script src="<?php echo base_url('assets/loja/js/bootstrap.min.js')?>"></script>
   
    
    
  
 
  </head>

  <!--Body-->
  <body>
 
 <!--  <a href="#" onclick="CarregaPagamentoPagseguro()">rere</a>-->
	
	<!--Login Modal-->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <form method="post" class="login-form" action="{ACAOFORMLOGIN}">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h2>Logar ou <a href="<?php echo site_url("conta/novaconta")?>">Registrar</a></h2>
            
          </div>
          <div class="modal-body">
          <form class="login-form" id="loginModal">
          
          <span id="NovaConta">
            <div class="form-group group" id="IdCampoSenha">
            	<input type="hidden" value="{REDIRECT}" name="redirect">
            	<label for="log-email">Email</label>
              <input type="email" class="form-control" name="email2comprador" id="email2comprador" placeholder="Digite seu email" required>
              
            </div>
            <div class="form-group group">
            	<label for="log-password">Login</label>
              <input type="password" class="form-control" name="password2comprador" id="password2comprador" placeholder="Digite sua senha" required>
              <a class="help-link" href="javascript:MostrarFormConEsq('esq','Modal')">Esqueceu a senha?</a>
            </div>
           </span> 
            <span id="EsqueciMinhaSenha" style="display:none">              	
              	
              	<div class="form-group group">
	                <label for="log-CPF-Esq">Email ou CPF</label>
	                <input type="text" class="form-control" name="CPFesquecicomprador" id="CPFesquecicomprador" placeholder="Email ou CPF">
	                <a class="help-link" href="javascript:MostrarFormConEsq('voltar','Modal')">voltar</a>
	              </div>	
	              
              </span>
            
            <input class="btn btn-success" type="submit" value="Login">
          </form>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
      </form>
    </div><!-- /.modal -->
    
    <div class="modal fade" id="modalCarrinho">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
	        <h4 class="modal-title" id="textAdicionar">Adicionando...</h4>
	      </div>
	     
	      <div class="modal-footer" style="display: none" id="footerModalCarrinho">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Continuar</button>
	        <button type="button" class="btn btn-primary" onClick="javascript:location.href='<?php echo site_url('checkout')?>'">Finalizar</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div>
    
    <!--Header-->
    <header data-offset-top="{DATAOFFSETTOP}" data-stuck="{DATASTUCK}"><!--data-offset-top is when header converts to small variant and data-stuck when it becomes visible. Values in px represent position of scroll from top. Make sure there is at least 100px between those two values for smooth animation-->
    
      <!--Search Form-->
      <form class="search-form closed" method="get" action="<?php echo site_url('busca/')?>" role="form" autocomplete="off">
      	<div class="container">
          <div class="close-search"><i class="icon-delete"></i></div>
            <div class="form-group">
              <label class="sr-only" for="search-hd">Buscar</label>
              <input type="text" class="form-control" name="pesquisa" id="pesquisa" placeholder="Buscar">
              <button type="submit"><i class="icon-magnifier"></i></button>
          </div>
        </div>
      </form>
      
    	<!--Split Background-->
    	<div class="left-bg"></div>
    	<div class="right-bg"></div>
      
    	<div class="container">
      	<a class="logo" href="<?php echo base_url()?>"><img src="<?php echo base_url("assets/loja/img/logo.png")?>" alt="Doe uam cesta"/></a>
        
        
      
      	<!--Mobile Menu Toggle-->
        <div class="menu-toggle"><i class="fa fa-list"></i></div>
        <div class="mobile-border"><span></span></div>
        
        <!--Main Menu-->
        <nav class="menu">
          <ul class="main">          	          	
          	<li class="hide-sm"><a href="<?php echo site_url( 'conta/editarconta' ); ?>" title="Acessar sua Conta">Minha Conta</a></li>
          	<li class="hide-sm"><a href="<?php echo site_url( 'conta/minhasdoacoes' ); ?>" title="Minhas Doações">Minhas Doações</a></li>
          	
          	<logado>
          	<li class="hide-sm"><a href="<?php echo site_url('conta/sair')?>" title="Sair da Loja">Sair</a></li>
          	</logado>
          </ul>
          <ul class="catalog">
          
          	<li><a href="<?php echo site_url("conteudo/quemsomos") ?>">Quem Somos?</a></li>
          	<li><a href="<?php echo site_url("conteudo/quemajudamos") ?>">Quem Ajudamos?</a></li>
          	<li><a href="<?php echo site_url("conteudo/contato") ?>">Contato</a></li>
          </ul>
        </nav>
        
        <!--Toolbar-->
        <div class="toolbar group">
          <button class="search-btn btn-outlined-invert"><i class="icon-magnifier"></i></button>
          <div class="middle-btns">
	          <logado2>
	            <!--  a class="btn-outlined-invert" style="background-color:#fff;color:#2ba8db" href="#">
	            <i class="icon-profile" style="color:#2ba8db"></i> <span>Cadastrado</span></a>-->
	            <a class="login-btn btn-outlined-invert" style="background-color:#fff;color:#2ba8db;margin-top: 30px;" href="#">
	            <i class="icon-profile" style="color:#2ba8db"></i> <span>Logado</span></a>
	          </logado2>
	          
	          <naologado>
	          	<a class="btn-outlined-invert" href="<?php echo site_url('conta/novaconta') ?>">
	            <i class="icon-profile"></i> <span>Cadastrar</span></a>
	            <a class="login-btn btn-outlined-invert" href="#" data-toggle="modal" data-target="#loginModal">
	            <i class="icon-profile"></i> <span>Login</span></a>
	          </naologado>          
          </div>
          <div class="cart-btn" id="CarregaMiniCar"></div>
        </div><!--Toolbar Close-->
      </div>
    </header><!--Header Close-->
    
    <!--Page Content-->
    <div class="page-content">
    
    	{CONTEUDO}
   
      
    </div><!--Page Content Close-->
    
    <!--Sticky Buttons-->
    <div class="sticky-btns">
    	<form class="quick-contact ajax-form" method="post" name="quick-contact">
      	<h3>Contato</h3>
        
        <div class="form-group">
        	<label for="qc-name">Nome</label>
          <input class="form-control input-sm" type="text" name="nome" id="qc-name" placeholder="Nome">
        </div>
        <div class="form-group">
        	<label for="qc-email">Email</label>
          <input class="form-control input-sm" type="email" name="email" id="qc-email" placeholder="Email">
        </div>
        <div class="form-group">
        	<label for="qc-message">Mensagem</label>
          <textarea class="form-control input-sm" name="mensagem" id="qc-message" placeholder="Mensagem"></textarea>
        </div>
        <!-- Validation Response -->
        <div class="response-holder"></div>
        <!-- Response End -->
        <input class="btn btn-success btn-sm btn-block" type="submit" value="Enviar">
      </form>
    	<span id="qcf-btn"><i class="fa fa-envelope"></i></span>
      <span id="scrollTop-btn"><i class="fa fa-chevron-up"></i></span>
    </div><!--Sticky Buttons Close-->
    
    <!--Subscription Widget-->
    <section class="subscr-widget">
      <div class="container">
      	<div class="row">
        	<div class="col-md-12">
            	<p>{AVISOPAGAMENTO}</p>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-7 col-md-8 col-sm-8">
            <h2 class="light-color">Novidades</h2>
            
            <!--Mail Chimp Subscription Form-->
            <form class="subscr-form" role="form" method="post" autocomplete="off" >
              <div class="form-group">
                <label class="sr-only" for="subscr-name">Nome</label>
                <input type="text" class="form-control" name="NomeNews" id="NomeNews" placeholder="Nome" required>
                
              </div>
              <div class="form-group fff">
                <label class="sr-only" for="subscr-email">Email</label>
                <input type="email" class="form-control" name="EmailNews" id="EmailNews" placeholder="Email" required>
                <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                <div style="position: absolute; left: -5000px;"><input type="text" tabindex="-1" value=""></div>
                <button type="button" id="subscr-submit" onClick="CadastrarNews()"><i class="icon-check"></i></button>
              </div>
            </form>
            <!--Mail Chimp Subscription Form Close-->
            <p class="p-style2" id="RespostaNews" style="display:none;"></p>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-1">
            <p class="p-style3">A humildade não está na pobreza,
não está na indigência,
na penúria, na necessidade,
na nudez e nem na fome.
A humildade está na pessoa que tendo
o direito de reclamar, julgar, reprovar
e tomar qualquer atitude
compreensível no brio pessoal, apenas abençoa.<br><span style="color:#000">Emmanuel - Chico Xavier</span></p>
          </div>
        </div>
      </div>
    </section><!--Subscription Widget Close-->
      
  	<footer class="footer">
    	<div class="container">
      	<div class="row">
        	<div class="col-lg-5 col-md-5 col-sm-5">
          	<div class="info">
              <a class="logo" href="index.html"><img src="<?php echo base_url("assets/loja/img/logo.png")?>" alt="Doe uma cesta"/></a>
              <!--  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>-->
              <div class="social">
              	<!--  <a href="#" target="_blank"><i class="fa fa-instagram"></i></a>
              	<a href="#" target="_blank"><i class="fa fa-youtube-square"></i></a>
              	<a href="#" target="_blank"><i class="fa fa-tumblr-square"></i></a>
              	<a href="#" target="_blank"><i class="fa fa-vimeo-square"></i></a>
              	<a href="#" target="_blank"><i class="fa fa-pinterest-square"></i></a>-->
              	<a href="#" target="_blank"><i class="fa fa-facebook-square"></i></a>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4">
          	
          </div>
          <div class="contacts col-lg-3 col-md-3 col-sm-3">
          	<h2>Contato</h2>
            <p class="p-style3">
              <br/>
              <a href="contato@doeumacesta.com.br">contato@doeumacesta.com.br</a><br/>
              
            </p>
          </div>
        </div>
        <div class="copyright">
        	<div class="row">
          	<div class="col-lg-7 col-md-7 col-sm-7">
              <p>&copy; 2020. Todos os direitos reservados.</p>
            </div>
          	<div class="col-lg-5 col-md-5 col-sm-5">
              <div class="payment">
                <img src="<?php echo base_url("assets/loja/img/banner-pagseguro.gif")?>" alt="Pagseguro"/>               
              </div>
            </div>
          </div>
        </div>
      </div>
      
      
      
    </footer><!--Footer Close-->
    
    <!--Javascript (jQuery) Libraries and Plugins-->
		
	<script src="<?php echo base_url('assets/loja/js/smoothscroll.js')?>"></script>
	<script src="<?php echo base_url('assets/loja/js/jquery.validate.min.js')?>"></script>
	<script src="<?php echo base_url('assets/loja/js/jquery.placeholder.js')?>"></script>
	<script src="<?php echo base_url('assets/loja/js/icheck.min.js')?>"></script>
	<script src="<?php echo base_url('assets/loja/js/masterslider.min.js')?>"></script>
	<script src="<?php echo base_url('assets/loja/js/scripts.js')?>"></script>    	
    <script src="<?php echo base_url('assets/loja/js/loja.js')?>"></script>
    
    
    
    <script src="<?php echo base_url('assets/loja/js/pagseguro.js')?>"></script>    
    <script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
   
    </noscript>
    
  </body><!--Body Close-->
</html>
