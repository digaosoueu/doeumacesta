<!--Breadcrumbs-->
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>">Home</a></li>
        <li>Login/ registrar</li>
      </ol><!--Breadcrumbs Close-->
      
      <!--Login / Register-->
      <section class="log-reg container">
      {MENSAGEM_SISTEMA_ERRO}
      {MENSAGEM_SISTEMA_SUCESSO}
       <h2>Login/ registrar</h2>
      
      	<div class="row">
        	<!--Login-->
        	<div class="col-lg-5 col-md-5 col-sm-5">
            <form method="post" class="login-form" action="{ACAOFORMLOGIN}" id="loginLocal">
            
            {FORMVALIDAR}
            <span id="NovaConta">
              <div class="form-group group">
                <label for="log-email2">Email</label>
                <input type="hidden" value="{REDIRECT}" name="redirect">
                <input type="email" class="form-control" value="{EMAIL2}" name="email2comprador" id="email2comprador" placeholder="Email" required>
              </div>
              <div class="form-group group">
                <label for="log-password2">Password</label>
                <input type="password" class="form-control" name="password2comprador" value="{SENHA2}" id="password2comprador" placeholder="senha" required>
                <a class="help-link" href="javascript:MostrarFormConEsq('esq','Local')">Esqueceu a senha?</a>
              </div>
             </span>
             {/FORMVALIDAR}
              <!-- Esqueci minha senha -->
              <span id="EsqueciMinhaSenha" style="display:none">              	
              	
              	<div class="form-group group">
	                <label for="log-CPF-Esq">Email ou CPF</label>
	                <input type="text" class="form-control" name="CPFesquecicomprador" id="CPFesquecicomprador" placeholder="Email ou CPF">
	                <a class="help-link" href="javascript:MostrarFormConEsq('voltar','Local')">voltar</a>
	              </div>	
	              
              </span>
              
              {NOVASENHA}
              <span id="novasenha">              	
              	
              	<div class="form-group group">
	                <label for="log-novasenha">Nova senha</label>
	                <input type="hidden" value="{CD}" name="codcomprador">
	                <input type="hidden" value="{VALID}" name="VALID">
	                <input type="hidden" value="{REDIRECT}" name="redirect">
	                <input type="password" class="form-control" name="novasenhacomprador" id="novasenhacomprador" placeholder="Digite uma nova senha">
	                <a class="help-link" href="{URLVOLTA}">voltar</a>
	              </div>	
	              
              </span>
              {/NOVASENHA}
              
              <!-- Esqueci minha senha -->
              
              <!--  <div class="checkbox">
                <label><input type="checkbox" name="remember"> Remember me</label>
              </div>-->
              <input class="btn btn-success" id="btn-success" type="submit" value="Logar">
            </form>
          </div>
          <!--Registration-->
          {REGISTRO}
          <div class="col-lg-7 col-md-7 col-sm-7">
            <form method="post" class="registr-form" action="{ACAOFORM}">
              <div class="form-group group">
                <label for="rf-email">Email</label>
                <input type="hidden" value="{REDIRECT}" name="redirect">
                <input type="email" class="form-control" name="emailcomprador" value="{EMAIL}" id="emailcomprador" placeholder="Email" required>
              </div>
              <div class="form-group group">
                <label for="rf-email">CPF</label>
                <input type="cpf" class="form-control" name="cpfcomprador" value="{CPF}" id="cpfcomprador" placeholder="CPF" required>
              </div>
              <div class="form-group group">
                <label for="rf-password">Senha</label>
                <input type="password" class="form-control" name="senhacomprador" value="{SENHA}" id="senhacomprador" placeholder="Senha" required>
              </div>
              
              
              <input class="btn btn-success" type="submit" value="Registrar">
            </form>
          </div>
          {/REGISTRO}
        </div>
      </section><!--Login / Register Close-->