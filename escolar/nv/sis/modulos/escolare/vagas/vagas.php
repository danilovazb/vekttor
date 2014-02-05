<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 

include ("_functions.php");
include ("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div id="conteudo">

	<!--
        ///////////////////////////////////////
        Barra de Navegação
        ///////////////////////////////////////
    -->
    <?
  //  pr($_POST);
	?>
    <div id="navegacao">
        <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo"><span></span>Vagas por Ano</a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
    <!-- 
          <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
       -->
          <input type="button" value="Resumo Geral" style="float:right; margin:3px 10px 0 0 " />
          Selecione um ano 
          <input name="" type="text" size="4" maxlength="4"  value="2013" />
          <select>
          	<option>Selecione uma Escola</option>
          	<option>Escolas Nossa Senhora do Carmo</option>
          	<option>Genir Bentes</option>
          	<option>Severino Herculano da Rocha</option>
          	<option>Senador Feijo</option>
          	<option>Sao Luiz de Gonzaga</option>
          	<option>Bom Jesus</option>
          	<option>Ezequiel Ruiz II</option>
          	<option>Profº Manoel Afonso Bit</option>
          	<option>Joze da Luz</option>
          
      </select>
      <input type="button" value="Selecionar" onclick="location='?tela_id=474&escola_id=1'"  />
          
          
          
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="200">Escola</td>
                <td width="80">S&eacute;rie</td>
                <td width="90"> Salas Manh&atilde;</td>
                <td width="90"> Salas Tarde</td>
                <td width="90"> Salas Noite</td>
                <td width="80">Salas</td>
                <td width="80">Vagas</td>
                <td></td>
            </tr>
        </thead>
    </table>
    
    
    <!--
        ///////////////////////////////////////
        Tabela de Dados
        ///////////////////////////////////////
    -->
<div id="dados">
    
		<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
        <?
        if($_GET[escola_id]>0){
		?>
        <table cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            
            
                <tr class="al">
                <td width="200"><strong>Nossa Senhora do Carmo</strong></td>
                <td width="80">2013</td>
                <td width="90">&nbsp;</td>
                <td width="90">&nbsp;</td>
                <td width="90">&nbsp;</td>
                <td width="80">&nbsp;</td>
                <td width="80">95</td>
                <td></td>
                </tr>
                <tr>
                  <td align="right"><strong>Ensino Infantil</strong></td>
                  <td>Infantil</td>
                  <td onclick="window.open('<?=$caminho?>/form.php','carregador')">1,3,4</td>
                  <td onclick="window.open('<?=$caminho?>/form.php','carregador')">1,3,4</td>
                  <td onclick="window.open('<?=$caminho?>/form.php','carregador')">1,3,4</td>
                  <td>9</td>
                  <td>90</td>
                  <td></td>
                </tr>
                <tr class="al">
                  <td align="right">&nbsp;</td>
                  <td>1 &deg; Per&iacute;odo</td>
                  <td>7</td>
                  <td>7</td>
                  <td>7</td>
                  <td>3</td>
                  <td>30</td>
                  <td></td>
                </tr>
                <tr>
                  <td align="right">&nbsp;</td>
                  <td>2 &deg; Per&iacute;odo</td>
                  <td>5,6</td>
                  <td>5,6</td>
                  <td>5,6</td>
                  <td>6</td>
                  <td>60</td>
                  <td></td>
                </tr>
                <tr class="al">
                  <td align="right"><strong>1&ordm; Siclo</strong></td>
                  <td>1&deg; Ano</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td align="right">&nbsp;</td>
                  <td>2&deg; Ano</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr class="al">
                  <td align="right">&nbsp;</td>
                  <td>3&deg; Ano</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr >
                  <td align="right"><strong>2&ordm;Ciclo</strong></td>
                  <td>4&deg; Ano</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr class="al">
                  <td align="right">&nbsp;</td>
                  <td>5&deg; Ano</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr >
                  <td align="right">&nbsp;</td>
                  <td>6&deg; Ano</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr class="al">
                  <td align="right"><strong>3&ordm; Ciclo</strong></td>
                  <td>7&deg; Ano</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td align="right">&nbsp;</td>
                  <td>8&deg; Ano</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr class="al">
                  <td align="right">&nbsp;</td>
                  <td>9&deg; Ano</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr >
                  <td align="right">&nbsp;</td>
                  <td>EJA</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
         
            </tbody>
        </table>
        <?
		}
		?>
    </div>
    
    <!--
        ///////////////////////////////////////
        Linha de layout
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="200"><strong>Total</strong></td>
                <td width="80">&nbsp;</td>
                <td width="90">&nbsp;</td>
                <td width="90">&nbsp;</td>
                <td width="90">&nbsp;</td>
                <td width="80">&nbsp;</td>
                <td width="80">180</td>
              <td></td>
            </tr>
        </thead>
    </table>

</div>

<!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<div id="rodape">

	    
</div>