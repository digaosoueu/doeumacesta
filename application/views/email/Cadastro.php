<body style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
<div style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
<table cellspacing="0" cellpadding="0" border="0" height="100%" width="100%">
        <tr>
            <td align="center" valign="top" style="padding:20px 0 20px 0">
                <!-- [ header starts here] -->
                <table bgcolor="FFFFFF" cellspacing="0" cellpadding="10" border="0" width="650" style="border:1px solid #E0E0E0;">
                    <tr>
                        <td valign="top">
                            <a href="{{store url=""}}"><img src="{{var logo_url}}" alt="{{var logo_alt}}" style="margin-bottom:10px;" border="0"/></a></td>
                    </tr>
                <!-- [ middle starts here] -->
                    <tr>
                        <td valign="top">
                            <h1 style="font-size:22px; font-weight:normal; line-height:22px; margin:0 0 11px 0;"">Ol&aacute; {{htmlescape var=$customer.name}},</h1>
                            <p style="font-size:12px; line-height:16px; margin:0 0 16px 0;">Seja muito bem vindo(a) &agrave; {{var store.getFrontendName()}}. Acesse sua conta clicando em <a href="{{store url="customer/account/"}}" style="color:#1E7EC8;">Entrar</a> ou <a href="{{store url="customer/account/"}}" style="color:#1E7EC8;">Minha Conta</a> no alto de nossas p&aacute;ginas, ent&atilde;o informe seu email e senha.</p>
                            <p style="border:1px solid #E0E0E0; font-size:12px; line-height:16px; margin:0; padding:13px 18px; background:#f9f9f9;">
                                Utilize as seguintes informa&ccedil;&otilde;es de acesso:<br/>
                                <strong>Email</strong>: {{var customer.email}}<br/>
                                <strong>Senha</strong>: {{htmlescape var=$customer.password}}<p>
                            <p style="font-size:12px; line-height:16px; margin:0 0 8px 0;">Quando acessar sua conta, voc&ecirc; poder&aacute;:</p>
                            <ul style="font-size:12px; line-height:16px; margin:0 0 16px 0; padding:0;">
                                <li style="list-style:none inside; padding:0 0 0 10px;">Fechar compras com maior agilidade;</li>
                                <li style="list-style:none inside; padding:0 0 0 10px;">Acompanhar seus pedidos;</li>
                                <li style="list-style:none inside; padding:0 0 0 10px;">Visualizar hist&oacute;rico de pedidos;</li>
                                <li style="list-style:none inside; padding:0 0 0 10px;">Alterar informa&ccedil;&otilde;es de conta;</li>
                                <li style="list-style:none inside; padding:0 0 0 10px;">Alterar sua senha;</li>
                                <li style="list-style:none inside; padding:0 0 0 10px;">Cadastrar novos endere&ccedil;os de entrega (como endere&ccedil;o de familiares e amigos!)</li>
                            </ul>
                            <p></p>
                            <p style="font-size:12px; line-height:16px; margin:0;">Se voc&ecirc; tiver alguma d&uacute;vida sobre sua conta ou qualquer outra informa&ccedil;&atilde;o do site, n&atilde;o deixe de entrar em contato atrav&eacute;s do email <a href="mailto:{{config path='trans_email/ident_support/email'}}" style="color:#1E7EC8;">{{config path='trans_email/ident_support/email'}}</a> ou por telefone {{config path='general/store_information/phone'}}.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#EAEAEA" align="center" style="background:#EAEAEA; text-align:center;"><center><p style="font-size:12px; margin:0;">Obrigado, <strong>{{var store.getFrontendName()}}</strong></p></center></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>