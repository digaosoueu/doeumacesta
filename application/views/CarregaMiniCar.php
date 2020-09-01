<a class="btn btn-outlined-invert" href="<?php echo site_url('checkout')?>"><i class="icon-shopping-cart-content"></i><span>{QTD_TOTAL}</span></a>
            
            <!--Cart Dropdown-->
            <div class="cart-dropdown">
              <span></span><!--Small rectangle to overlap Cart button-->
              <div class="body">
                <table>
                  <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                  </tr>
                  {BLC_PRODUTOS}
                  <tr class="item">
                    <td><a href="#">{NOMEPRODUTO}</a></td>
                    <td><input type="text" value="{QUANTIDADE}" disabled="disabled"></td>
                    <td class="price">R$ {VALORTOTAL}</td>
                  </tr>
                  {/BLC_PRODUTOS}
                </table>
              </div>
              <div class="footer group">
                <div class="buttons">
                  
                  <a class="btn btn-outlined-invert" href="<?php echo site_url("checkout"); ?>"><i class="icon-shopping-cart-content"></i>Carrinho</a>
                </div>
                <div class="total">R$ {SUBTOTALCARRINHO}</div>
              </div>
            </div><!--Cart Dropdown Close-->