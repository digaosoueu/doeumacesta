<!--Breadcrumbs-->
      <ol class="breadcrumb">
        <li><a href="index.html">Home</a></li>
        <li>Conta: Informações</li>
      </ol><!--Breadcrumbs Close-->
      
      <!--Account Personal Info-->
      <section>
      	<div class="container">
      		{MENSAGEM_SISTEMA_ERRO}
        	{MENSAGEM_SISTEMA_SUCESSO}
        	<div class="row space-top">
          
          	<!--Items List-->
          	<div class="col-sm-8 space-bottom">
            	<h2 class="title">Minha conta</h2>
              <ul class="list-unstyled space-bottom">
                <li><a class="large" href="<?php echo site_url("conta/minhasdoacoes"); ?>">Doações</a></li>
              </ul>
              <h3>Dados</h3>
         
              <div class="row">
                <form class="col-md-12 personal-info" method="post" action="<?php echo site_url("conta/salvar"); ?>">
                	<div class="row">
                    <div class="form-group col-sm-6">
                      <label for="api_first_name">Nome</label>
                      <input type="hidden" value="{CODCOMPRADOR}" name="codcomprador">
                      <input type="hidden" value="{REDIRECT}" name="redirect">
                      <input type="text" class="form-control" name="nomecomprador" id="nomecomprador" value="{NOME}" placeholder="Nome" required>
                    </div>
                    <div class="form-group col-sm-6">
                      <label for="api_last_name">SobreNome</label>
                      <input type="text" class="form-control" name="sobrenomecomprador" value="{SOBRENOME}" id="sobrenomecomprador" placeholder="SobreNome" required>
                    </div>
                  </div>
                	<div class="row">
	                    <div class="form-group col-sm-6">
	                      <label for="emailcomprador">Email</label>
	                      <input type="text" class="form-control" name="emailcomprador" id="emailcomprador" value="{EMAIL}" placeholder="Email" required>
	                    </div>
	                    <div class="form-group col-sm-6">
	                      <label for="api_email">Data Nascimento</label>
	                      <input type="text" class="form-control" name="datanascimentocomprador" id="datanascimentocomprador" value="{DATANASCIMENTO}" placeholder="Data de Nascimento" required>
	                    </div>
	                    
                    </div>
                    
                    <div class="row">
	                    <div class="form-group col-sm-6">
	                      <label for="api_phone">Estado</label>
	                      <select class="form-control" name="ufcomprador" id="ufcomprador">
	                      <option value="">Selecione o Estado</option> 
	                      	{LISTAUF}						    
						  </select>
	                    </div>
	                    <div class="form-group col-sm-6">
	                      <label for="api_phone">Cidade</label>
	                      <input type="text" class="form-control" name="cidadecomprador" id="cidadecomprador" value="{CIDADE}" placeholder="Cidade" required>
	                    </div>
                    </div>
                	<div class="row">
                	<div class="form-group col-sm-6">
                      <label for="api_phone">CPF</label>
                      <input type="text" class="form-control" name="cpfcomprador" id="cpfcomprador" value="{CPF}" placeholder="CPF" {DISABLED} />
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="api_phone">Telefone</label>
                        <input type="text" class="form-control" name="telefonecomprador" id="telefonecomprador" value="{TELEFONE}" placeholder="Telefone">
                      </div>
                    
                  </div>
                  <div class="form-group">
                    <div class="checkbox custom">
                      <label>
                        <input type="checkbox" name="newslettercomprador" {NEWSLETTER} value="1">Receber novidades?
                      </label>
                    </div>
                    
                  </div>
                  <input type="submit" class="btn btn-success" value="Salvar">
                </form>
              </div>
             
            </div>
            
            <!--Sidebar-->
            <div class="col-lg-3 col-lg-offset-1 col-sm-4">
            	
            </div>
          </div>
        </div>
      </section><!--Account Personal Info Close-->