<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $dadosboleto["identificacao"]; ?></title>
    <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" />
    <meta name="generator" content="HTML Tidy for Linux/x86 (vers 11 February 2007), see www.w3.org" />
    <style type="text/css">
/*<![CDATA[*/
    <!--
    .ti {font: 9px Arial, Helvetica, sans-serif}
    -->
    /*]]>*/
    </style>
    <style type="text/css">
/*<![CDATA[*/

    @media screen,print {

    /* *** TIPOGRAFIA BASICA *** */

    * {
        font-family: Arial;
        font-size: 12px;
        margin: 0;
        padding: 0;
    }

    .notice {
        color: red;
    }


    /* *** LINHAS GERAIS *** */

    #container {
        width: 666px;
        margin: 0px auto;
        padding-bottom: 30px;
    }

    #instructions {
        margin: 0;
        padding: 0 0 20px 0;
    }

    #boleto {
        width: 666px;
        margin: 0;
        padding: 0;
    }


    /* *** CABECALHO *** */

    #instr_header {
        background: url('imagens/logo_empresa.png') no-repeat top left;
        padding-left: 160px;
        height: 65px;
    }

    #instr_header h1 {
        font-size: 16px;
        margin: 5px 0px;
    }

    #instr_header address {
        font-style: normal;
    }

    #instr_content {

    }

    #instr_content h2 {
        font-size: 10px;
        font-weight: bold;
    }

    #instr_content p {
        font-size: 10px;
        margin: 4px 0px;
    }

    #instr_content ol {
        font-size: 10px;
        margin: 5px 0;
    }

    #instr_content ol li {
        font-size: 10px;
        text-indent: 10px;
        margin: 2px 0px;
        list-style-position: inside;
    }

    #instr_content ol li p {
        font-size: 10px;
        padding-bottom: 4px;
    }


    /* *** BOLETO *** */

    #boleto .cut {
        width: 666px;
        margin: 0px auto;
        border-bottom: 1px navy dashed;
    }

    #boleto .cut p {
        margin: 0 0 5px 0;
        padding: 0px;
        font-family: 'Arial Narrow';
        font-size: 9px;
        color: navy;
    }

    table.header {
        width: 666px;
        height: 38px;
        margin-top: 20px;
        margin-bottom: 10px;
        border-bottom: 2px navy solid;
        
    }


    table.header div.field_cod_banco {
        width: 46px;
        height: 19px;
    margin-left: 5px;
        padding-top: 3px;
        text-align: center;
        font-size: 14px;
        font-weight: bold;
        color: navy;
        border-right: 2px solid navy;
        border-left: 2px solid navy;
    }

    table.header td.linha_digitavel {
        width: 464px;
        text-align: right;
        font: bold 15px Arial; 
        color: navy
    }

    table.line {
        margin-bottom: 0px;
        padding-bottom: 0px;
        border-bottom: 1px gray solid;
    }

    table.line tr.titulos td {
        height: 13px;
        font-family: 'Arial Narrow';
        font-size: 9px;
        color: navy;
        border-left: 5px #ffe000 solid;
        padding-left: 2px;
    }

    table.line tr.campos td {
        height: 12px;
        font-size: 10px;
        color: black;
        border-left: 5px #ffe000 solid;
        padding-left: 2px;
    }

    table.line td p {
        font-size: 10px;
    }


    table.line tr.campos td.ag_cod_cedente,
    table.line tr.campos td.nosso_numero,
    table.line tr.campos td.valor_doc,
    table.line tr.campos td.vencimento2,
    table.line tr.campos td.ag_cod_cedente2,
    table.line tr.campos td.nosso_numero2,
    table.line tr.campos td.xvalor,
    table.line tr.campos td.valor_doc2
    {
        text-align: right;
    }

    table.line tr.campos td.especie,
    table.line tr.campos td.qtd,
    table.line tr.campos td.vencimento,
    table.line tr.campos td.especie_doc,
    table.line tr.campos td.aceite,
    table.line tr.campos td.carteira,
    table.line tr.campos td.especie2,
    table.line tr.campos td.qtd2
    {
        text-align: center;
    }

    table.line td.last_line {
        vertical-align: top;
        height: 25px;
    }

    table.line td.last_line table.line {
        margin-bottom: -5px;
        border: 0 white none;
    }

    td.last_line table.line td.instrucoes {
        border-left: 0 white none;
        padding-left: 5px;
        padding-bottom: 0;
        margin-bottom: 0;
        height: 20px;
        vertical-align: top;
    }

    table.line td.cedente {
        width: 298px;
    }

    table.line td.valor_cobrado2 {
        padding-bottom: 0;
        margin-bottom: 0;
    }


    table.line td.ag_cod_cedente {
        width: 126px;
    }

    table.line td.especie {
        width: 35px;
    }

    table.line td.qtd {
        width: 53px;
    }

    table.line td.nosso_numero {
        /* width: 120px; */
        width: 115px;
        padding-right: 5px;
    }

    table.line td.num_doc {
        width: 113px;
    }

    table.line td.contrato {
        width: 72px;
    }

    table.line td.cpf_cei_cnpj {
        width: 132px;
    }

    table.line td.vencimento {
        width: 134px;
    }

    table.line td.valor_doc {
        /* width: 180px; */
        width: 175px;
        padding-right: 5px;
    }

    table.line td.desconto {
        width: 113px;
    }

    table.line td.outras_deducoes {
        width: 112px;
    }

    table.line td.mora_multa {
        width: 113px;
    }

    table.line td.outros_acrescimos {
        width: 113px;
    }

    table.line td.valor_cobrado {
        /* width: 180px; */
        width: 175px;
        padding-right: 5px;
        background-color: #ffc ;
    }

    table.line td.sacado {
        width: 659px;
    }

    table.line td.local_pagto {
        width: 472px;
    }

    table.line td.vencimento2 {
        /* width: 180px; */
        width: 175px;
        padding-right: 5px;
        background-color: #ffc;
    }

    table.line td.cedente2 {
        width: 472px;
    }

    table.line td.ag_cod_cedente2 {
        /* width: 180px; */
        width: 175px;
        padding-right: 5px;
    }

    table.line td.data_doc {
        width: 93px;
    }

    table.line td.num_doc2 {
        width: 173px;
    }

    table.line td.especie_doc {
        width: 72px;
    }

    table.line td.aceite {
        width: 34px;
    }

    table.line td.data_process {
        width: 72px;
    }

    table.line td.nosso_numero2 {
        /* width: 180px; */
        width: 175px;
        padding-right: 5px;
    }

    table.line td.reservado {
        width: 93px;
        background-color: #ffc;
    }

    table.line td.carteira {
        width: 93px;
    }

    table.line td.especie2 {
        width: 53px;
    }

    table.line td.qtd2 {
        width: 133px;
    }

    table.line td.xvalor {
        /* width: 72px; */
        width: 67px;
        padding-right: 5px;
    }

    table.line td.valor_doc2 {
        /* width: 180px; */
        width: 175px;
        padding-right: 5px;
    }
    table.line td.instrucoes {
        width: 475px;
    }

    table.line td.desconto2 {
        /* width: 180px; */
        width: 175px;
        padding-right: 5px;
    }

    table.line td.outras_deducoes2 {
        /* width: 180px; */
        width: 175px;
        padding-right: 5px;
    }

    table.line td.mora_multa2 {
        /* width: 180px; */
        width: 175px;
        padding-right: 5px;
    }

    table.line td.outros_acrescimos2 {
        /* width: 180px; */
        width: 175px;
        padding-right: 5px;
    }

    table.line td.valor_cobrado2 {
        /* width: 180px; */
        width: 175px;
        padding-right: 5px;
        background-color: #ffc ;
    }

    table.line td.sacado2 {
        width: 659px;
    }

    table.line td.sacador_avalista {
        width: 659px;
    }

    table.line tr.campos td.sacador_avalista {
        width: 472px;
    }

    table.line td.cod_baixa {
        color: navy;
        width: 180px;
    }




    div.footer {
        margin-bottom: 30px;
    }

    div.footer p {
        width: 88px;
        margin: 0;
        padding: 0;
        padding-left: 525px;
        font-family: 'Arial Narro';
        font-size: 9px;
        color: navy;
    }


    div.barcode {
        width: 666px;
        margin-bottom: 20px;
    }

    }



    @media print {

    #instructions {
        height: 1px;
        visibility: hidden;
        overflow: hidden;
    }

    }

    /*]]>*/
    </style>
</head>

<body>


<div id="container">

<!--      <div>
          <table width="666" border="0" align="center" cellpadding="0" cellspacing="0">
            <tbody>
              <tr>
                <td width="650"><h2 align="center">
                  <strong>Cart&atilde;o de Identifica&ccedil;&atilde;o - <?=$_POST['escola_nome']?></strong>
                </h2></td>
              </tr>
              <tr>
                <td valign="top"><p><strong>Nome:</strong> <?php echo $dadosboleto["sacado"]?></p></td>
              </tr>
              <tr>
                <td valign="top"><p><strong>Curso:</strong> <?php echo $_POST['curso']; ?></p></td>
              </tr>
              <tr>
                <td valign="top">
                
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" valign="top"><p><strong>Documentos para sele&ccedil;ao e matr&iacute;culas:</strong></p>
      <p><strong>ALUNOS VETERANOS</strong>: Este cart&atilde;o quitado        , Comprovante Resid&ecirc;ncia<br> 
        <strong>ENTREGA DE DOCUMENTOS</strong><strong>: </strong>Este cart&atilde;o quitado, RG, CPF, Comprovante Resid&ecirc;ncia.<br>
        <br>
      </p></td>
    <td width="46%" valign="top"><p><strong>Observa&ccedil;&atilde;o:</strong> Em virtude do armazenamento eletr�nico, dever�o ser apresentado os originais e c&oacute;pias de todos os documentos. Ap&oacute;s a confer�ncia, os originais ser�o devolvidos ao candidato no ato da matr&iacute;cula.</p></td>
  </tr>
</table>

        <p><strong><br>
        </strong></p>
        <div>
          <p><strong>Declara&ccedil;&atilde;o:</strong> Eu, <?php echo $dadosboleto["sacado"]?> declaro ter lido e  aceito os termos constantes no ato do cadatro         . </p>
        </div>  
                </td>
              </tr>
            </tbody>
          </table>
          <p>&nbsp;</p>
        </div>
		-->

        <div id="boleto">
            <!--<div class="cut">
                <p>Corte na linha pontilhada</p>
            </div>-->

            <table cellspacing="0" cellpadding="0" width="666" border="0">
                <tbody>
                    <tr>
                        <td class="ct" width="666">
                            <div align="right">
                                <b class="cp">Recibo do Sacado</b>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="header" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td width="150"><img src="i/logobb.jpg" /></td>

                        <td width="50">
                            <div class="field_cod_banco">
                                <?php echo $dadosboleto["codigo_banco_com_dv"]?>
                            </div>
                        </td>

                        <td class="linha_digitavel"><?php echo $dadosboleto["linha_digitavel"]?></td>
                    </tr>
                </tbody>
            </table>

            <table class="line" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr class="titulos">
                        <td class="cedente">Cedente</td>

                        <td class="ag_cod_cedente">Ag&#234;ncia / C&#243;digo do Cedente</td>

                        <td class="especie">Esp&eacute;cie</td>

                        <td class="qtd">Quantidade</td>

                        <td class="nosso_numero">Nosso n&#250;mero</td>
                    </tr>

                    <tr class="campos">
                        <td class="cedente"><?php echo $dadosboleto["cedente"]; ?>&nbsp;</td>

                        <td class="ag_cod_cedente"><?php echo $dadosboleto["agencia_codigo"]?>&nbsp;</td>

                        <td class="especie"><?php echo $dadosboleto["especie"]?>&nbsp;</td>

                        <td class="qtd"><?php echo $dadosboleto["quantidade"]?>&nbsp;</td>

                        <td class="nosso_numero"><?php echo $dadosboleto["nosso_numero"]?>&nbsp;</td>
                    </tr>
                </tbody>
            </table>

            <table class="line" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr class="titulos">
                        <td class="num_doc">N&#250;mero do documento</td>

                        <td class="contrato">Contrato</td>

                        <td class="cpf_cei_cnpj">CPF/CEI/CNPJ</td>

                        <td class="vencmento">Vencimento</td>

                        <td class="valor_doc">Valor documento</td>
                    </tr>

                    <tr class="campos">
                        <td class="num_doc"><?php echo $dadosboleto["numero_documento"]?></td>

                        <td class="contrato"><?php echo $dadosboleto["contrato"]?></td>

                        <td class="cpf_cei_cnpj"><?php echo $dadosboleto["cpf_cnpj"]?></td>

                        <td class="vencimento"><?php echo $dadosboleto["data_vencimento"]?></td>

                        <td class="valor_doc"><?php echo $dadosboleto["valor_boleto"]?></td>
                    </tr>
                </tbody>
            </table>

            <table class="line" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr class="titulos">
                        <td class="desconto">(-) Desconto / Abatimento</td>

                        <td class="outras_deducoes">(-) Outras dedu&#231;&#245;es</td>

                        <td class="mora_multa">(+) Mora / Multa</td>

                        <td class="outros_acrescimos">(+) Outros acr&#233;scimos</td>

                        <td class="valor_cobrado">(=) Valor cobrado</td>
                    </tr>

                    <tr class="campos">
                        <td class="desconto">&nbsp;</td>

                        <td class="outras_deducoes">&nbsp;</td>

                        <td class="mora_multa">&nbsp;</td>

                        <td class="outros_acrescimos">&nbsp;</td>

                        <td class="valor_cobrado">&nbsp;</td>
                    </tr>
                </tbody>
            </table>

            <table class="line" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr class="titulos">
                        <td class="sacado">Sacado</td>
                    </tr>

                    <tr class="campos">
                        <td class="sacado"><?php echo $dadosboleto["sacado"]?></td>
                    </tr>
                </tbody>
            </table>

            <div class="footer">
                <p>Autentica��o mec�nica</p>
            </div>

            <div class="cut">
                <p>Corte na linha pontilhada</p>
            </div>

            <table class="header" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td width="150"><img src="i/logobb.jpg" /></td>

                        <td width="50">
                            <div class="field_cod_banco">
                                <?php echo $dadosboleto["codigo_banco_com_dv"]?>
                            </div>
                        </td>

                        <td class="linha_digitavel"><?php echo $dadosboleto["linha_digitavel"]?></td>
                    </tr>
                </tbody>
            </table>

            <table class="line" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr class="titulos">
                        <td class="local_pagto">Local de pagamento</td>

                        <td class="vencimento2">Vencimento</td>
                    </tr>

                    <tr class="campos">
                        <td class="local_pagto"><span class="cedente2"><?php echo $dadosboleto["local_pagamento"]?></span></td>

                        <td class="vencimento2"><?php echo $dadosboleto["data_vencimento"]?></td>
                    </tr>
                </tbody>
            </table>

            <table class="line" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr class="titulos">
                        <td class="cedente2">Cedente</td>

                        <td class="ag_cod_cedente2">Ag&#234;ncia/C&#243;digo cedente</td>
                    </tr>

                    <tr class="campos">
                        <td class="cedente2"><?php echo $dadosboleto["cedente"]?></td>

                        <td class="ag_cod_cedente2"><?php echo $dadosboleto["agencia_codigo"]?></td>
                    </tr>
                </tbody>
            </table>

            <table class="line" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr class="titulos">
                        <td class="data_doc">Data do documento</td>

                        <td class="num_doc2">No. documento</td>

                        <td class="especie_doc">Esp&#233;cie doc.</td>

                        <td class="aceite">Aceite</td>

                        <td class="data_process">Data process.</td>

                        <td class="nosso_numero2">Nosso n&#250;mero</td>
                    </tr>

                    <tr class="campos">
                        <td class="data_doc"><?php echo $dadosboleto["data_documento"]?></td>

                        <td class="num_doc2"><?php echo $dadosboleto["numero_documento"]?></td>

                        <td class="especie_doc"><?php echo $dadosboleto["especie_doc"]?></td>

                        <td class="aceite"><?php echo $dadosboleto["aceite"]?></td>

                        <td class="data_process"><?php echo $dadosboleto["data_processamento"]?></td>

                        <td class="nosso_numero2"><?php echo $dadosboleto["nosso_numero"]?></td>
                    </tr>
                </tbody>
            </table>

            <table class="line" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr class="titulos">
                        <td class="reservado">Uso do banco</td>

                        <td class="carteira">Carteira</td>

                        <td class="especie2">Esp&eacute;cie</td>

                        <td class="qtd2">Quantidade</td>

                        <td class="xvalor">x Valor</td>

                        <td class="valor_doc2">(=) Valor documento</td>
                    </tr>

                    <tr class="campos">
                        <td class="reservado">&nbsp;</td>

                        <td class="carteira"><?php echo $dadosboleto["carteira"]?><?php echo isset($dadosboleto["variacao_carteira"]) ? $dadosboleto["variacao_carteira"] : '&nbsp;' ?></td>

                        <td class="especie2"><?php echo $dadosboleto["especie"]?></td>

                        <td class="qtd2"><?php echo $dadosboleto["quantidade"]?></td>

                        <td class="xvalor"><?php echo $dadosboleto["valor_unitario"]?></td>

                        <td class="valor_doc2"><?php echo $dadosboleto["valor_boleto"]?></td>
                    </tr>
                </tbody>
            </table>

            <table class="line" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td class="last_line" rowspan="6">
                            <table class="line" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr class="titulos">
                                        <td class="instrucoes">Instru&#231;&#245;es (Texto de responsabilidade do cedente)</td>
                                    </tr>

                                    <tr class="campos">
                                        <td class="instrucoes" rowspan="5">
                                            <p><?php echo $dadosboleto["demonstrativo1"]; ?></p>

                                            <p><?php echo $dadosboleto["demonstrativo2"]; ?></p>

                                            <p><?php echo $dadosboleto["demonstrativo3"]; ?></p>

                                            <p><?php echo $dadosboleto["instrucoes1"]; ?></p>

                                            <p><?php echo $dadosboleto["instrucoes2"]; ?></p>

                                            <p><?php echo $dadosboleto["instrucoes3"]; ?></p>

                                            <p><?php echo $dadosboleto["instrucoes4"]; ?></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table class="line" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr class="titulos">
                                        <td class="desconto2">(-) Desconto / Abatimento</td>
                                    </tr>

                                    <tr class="campos">
                                        <td class="desconto2">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table class="line" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr class="titulos">
                                        <td class="outras_deducoes2">(-) Outras dedu&#231;&#245;es</td>
                                    </tr>

                                    <tr class="campos">
                                        <td class="outras_deducoes2">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table class="line" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr class="titulos">
                                        <td class="mora_multa2">(+) Mora / Multa</td>
                                    </tr>

                                    <tr class="campos">
                                        <td class="mora_multa2">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table class="line" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr class="titulos">
                                        <td class="outros_acrescimos2">(+) Outros Acr&#233;scimos</td>
                                    </tr>

                                    <tr class="campos">
                                        <td class="outros_acrescimos2">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td class="last_line">
                            <table class="line" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr class="titulos">
                                        <td class="valor_cobrado2">(=) Valor cobrado</td>
                                    </tr>

                                    <tr class="campos">
                                        <td class="valor_cobrado2">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="line" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr class="titulos">
                        <td class="sacado2">Sacado</td>
                    </tr>

                    <tr class="campos">
                        <td class="sacado2">
                            <p><?php echo $dadosboleto["sacado"]?></p>

                            <p><?php echo $dadosboleto["endereco1"]?></p>

                            <p><?php echo $dadosboleto["endereco2"]?></p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="line" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr class="titulos">
                        <td class="sacador_avalista" colspan="2">Sacador/Avalista</td>
                    </tr>

                    <tr class="campos">
                        <td class="sacador_avalista">&nbsp;</td>

                        <td class="cod_baixa">C&#243;d. baixa</td>
                    </tr>
                </tbody>
            </table>

            <table cellspacing="0" cellpadding="0" width="666" border="0">
                <tbody>
                    <tr>
                        <td width="666" align="right"><font style="font-size: 10px;">Autentica&#231;&#227;o mec&#226;nica - Ficha de Compensa&ccedil;&atilde;o</font></td>
                    </tr>
                </tbody>
            </table>

            <div class="barcode">
                <p><?php fbarcode($dadosboleto["codigo_barras"]); ?></p>
            </div>

            <div class="cut">
                <p>Corte na linha pontilhada</p>
            </div>
        </div>
    </div>
</body>
</html>