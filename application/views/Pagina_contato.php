<!--Breadcrumbs-->
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">Home</a></li>
        <li>Contato</li>
      </ol><!--Breadcrumbs Close-->
      
      <div class="container"><h2>Contato</h2></div>
      
           
      <!--Contacts-->
      <section class="container">
      	<div class="row">
          <!--Contact Info-->
        	<div class="col-lg-5 col-lg-offset-1 col-md-5 col-sm-5">
            
            <div class="cont-info-widget">
            <ul>
             
              <li><a href="#"><i class="fa fa-envelope"></i>contato@doeumacesta.com.br</a></li>
              <!-- <li><i class="fa fa-mobile"></i>11 98992-2990</li> -->
            </ul>
            </div>
          </div>
        	<div class="col-lg-5 col-md-7 col-sm-7">
          	
          	<form class="contact-form ajax-form" method="post">
            	<div class="form-group">
              	<label class="sr-only" for="cf-name">Nome</label>
              	<input type="text" class="form-control" name="nome" id="cf-name" placeholder="Nome">
              </div>
            	<div class="form-group">
              	<label class="sr-only" for="cf-email">Email</label>
              	<input type="email" class="form-control" name="email" id="cf-email" placeholder="Email">
              </div>
            	<div class="form-group">
              	<label class="sr-only" for="cf-message">Mensagem</label>
                <textarea class="form-control" name="mensagem" id="cf-message" rows="5" placeholder="Mensagem"></textarea>
              </div>
              <!-- Validation Response -->
              <div class="response-holder"></div>
              <!-- Response End -->
              <input class="btn btn-primary" type="submit" value="enviar">
            </form>
          </div>
        </div>
      </section><!--Contacts Close-->