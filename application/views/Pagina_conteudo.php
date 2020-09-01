<!--Breadcrumbs-->
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">Home</a></li>
        <li>Cesta básica completa</li>
      </ol><!--Breadcrumbs Close-->
      
      <!--Shopping Cart Message-->
      <section class="cart-message">
      	<i class="fa fa-check-square"></i>
        <p class="p-style3">Item adicionado com sucesso!</p>
        <a class="btn-outlined-invert btn-success btn-sm" href="<?php echo site_url("checkout"); ?>">Ver carrinho</a>
      </section><!--Shopping Cart Message Close-->
      
      <!--Catalog Single Item-->
      <section class="catalog-single">
      	<div class="container">
          <div class="row">
          
          	<!--Product Gallery-->
            <div class="col-lg-6 col-md-6">
            	<div class="prod-gal master-slider" id="prod-gal">
              	<!--Slide1-->
                <div class="ms-slide">
                	<img src="" data-src="<?php echo base_url("assets/img/produto/original/3.jpg"); ?>" alt="Cesta básica 18 itens"/>
                  <img class="ms-thumb" src="<?php echo base_url("assets/img/produto/150x150/3.jpg"); ?>" alt="Cesta básica 18 itens" />
                </div>
              	
              </div>
            </div>
            
            <!--Product Description-->
            <div class="col-lg-6 col-md-6">
              <h1>Cesta básica 18 itens</h1>     
              
              <div class="price">R$ 50,00</div>
              <div class="buttons group">
                <!--  <div class="qnt-count">
                  <a class="incr-btn" href="#">-</a>
                  <input id="quantity" class="form-control" type="text" value="2">
                  <a class="incr-btn" href="#">+</a>
                </div>-->
                <a class="btn btn-primary btn-sm" id="addItemToCart" href="#" onclick="addCard(1);"><i class="icon-shopping-cart"></i>Add carrinho</a>
                
              </div>
              <p class="p-style2">1Kg de Feijão<br />
500g de Fuba<br />
500g de Farinha de Mandioca<br />
300g de Tempero Completo<br />
1kg de Açucar Refinado
1 L Ervilha em Conserva<br />
1 L Sardinha 125grs<br />
1 L Milho Verde 200g<br />
400g de Leite Composto Lacteo<br />
1kg de Sal<br />
400g de Achocolatado<br />
5Kg de Arroz<br />
1Kg de Farinha de Trigo<br />
340g de Molho Refogado<br />
1 P Biscoito Salgado<br />
500g de Macarrao c/ ovos<br />
900g de Oleo de Soja Refinado<br />
500g de Café<br /></p>
             
              <div class="promo-labels">
                
               
                
              </div>
            </div>
          </div>
        </div>
      </section><!--Catalog Single Item Close-->
      {PRODUTOSEMELHANTES}