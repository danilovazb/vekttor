<?php
include("_functions.php");
include("_ctrl.php");
$caminho = $tela->caminho;
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(document).ready(function(){	
	$("tr:odd").addClass('al');
	window.open('modulos/campo_futebol/configuracao/form.php','carregador');
});
  
</script>
<link href="../fontes/css/select2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../fontes/js/select2.min.js"></script>
<script type="text/javascript" src="../fontes/js/select2_locale_pt-BR.js"></script>
<div id='conteudo'>
<div id='navegacao'>
  <div id="some">«</div>
    <a href="#" class='s1'> SISTEMA </a>
    <a href="" class='s2'> Campo Futebol </a>
    <a href="" class='navegacao_ativo'><span></span> Configuração de reserva</a>
  </div>

  <div id="barra_info"></div>

<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="120">Plano de conta</td>
          <td width="120">Centro de custo</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	  <?php 
          $sql = mysql_query(" 
		  SELECT 
			c.id as id,
			fc.nome as centro, 
			fp.nome as plano 
		FROM 
			campo_futebol_reserva_config_pagamento as c, 
			(SELECT * FROM financeiro_centro_custo WHERE cliente_id='$vkt_id' AND plano_ou_centro='centro') as fc,
			(SELECT * FROM financeiro_centro_custo WHERE cliente_id='$vkt_id' AND plano_ou_centro='plano') as fp 
		WHERE 
			c.vkt_id = '$vkt_id' 
		AND 
			fc.id=c.centro_custo_id 
		AND 
			fp.id=c.plano_conta_id
		");
		  echo mysql_error();
		  while($config=mysql_fetch_object($sql)){
      ?>      
    	<tr id="<?=$config->id?>">
          <td width="120"><?=($config->centro)?></td>
          <td width="120"><?=($config->plano)?></td>
          <td></td>
        </tr>
	  <?php
		  }
      ?>
    </tbody>
</table>
<script>


</script>

</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td width="200"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
	
</div>