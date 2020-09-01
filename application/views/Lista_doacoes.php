<!--Breadcrumbs-->
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url()?>">Home</a></li>
        <li><a href="<?php echo site_url("conta/editarconta")?>">Conta</a></li>
        <li>Doações</li>
      </ol><!--Breadcrumbs Close-->
      
      <!--Orders History-->
      <section class="order-history extra-space-bottom">
      	<div class="container">
          <h2 class="text-center-mobile">Histórico</h2>
          <div class="inner">
            <table>
              <tbody>
                <tr align="center">
                  <th scope="col">Código<span class="toggles"></span></th>
                  <th scope="col">Total <span class="toggles"></span></th>
                  <th scope="col">Data <span class="toggles"></span></th>
                  <th scope="col">Status <span class="toggles"></span></th>
                  <th scope="col"><span class="toggles"></span></th>
                </tr>
                {BLC_DADOS}
                <tr>
                  <td class="bold">#{CODPEDIDO}</td>
                  <td class="bold">R$ {VALOR}</td>
                  <td>{DATA}</td>
                  {STATUS}
                  <td><a href="{URLRESUMO}" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-eye-open" style="margin:0"></i></a></td>
                </tr>
                {/BLC_DADOS}
                
              </tbody>
            </table>
          </div>
        </div>
      </section><!--Orders History Close-->