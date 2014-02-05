<?php
include("_functions.php");
include("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(document).ready(function(){	
	$("tr:odd").addClass('al');
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		window.open('modulos/campo_futebol/campo/form.php?id='+id,'carregador');
	});
});
</script>

<div id='conteudo'>
<div id='navegacao'>
  <div id="some">«</div>
    <a href="#" class='s1'> SISTEMA </a>
    <a href="" class='s2'> Campo Futebol </a>
    <a href="" class='navegacao_ativo'><span></span> Campo </a>
  </div>

  <div id="barra_info">
    <a href="modulos/campo_futebol/campo/form.php" target="carregador" class="mais"></a>
  </div>

<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="50">COD</td>
          <td width="200">Nome</td>
          <td width="100">Valor 1</td>
          <td width="100">Valor 2</td>
          <td width="100">Valor 3</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	  <?php 
          $sql = mysql_query(" SELECT * FROM  ".TBL_CAMPO." WHERE vkt_id = '$vkt_id' ");
		  while($campo=mysql_fetch_object($sql)){
      ?>      
    	<tr id="<?=$campo->id?>">
          <td width="50"><?=$campo->id?></td>
          <td width="200"><?=$campo->nome?></td>
          <td width="100"><?=moedaUsaToBr($campo->valor1)?></td>
          <td width="100"><?=moedaUsaToBr($campo->valor2)?></td>
          <td width="100"><?=moedaUsaToBr($campo->valor3)?></td>
          <td></td>
        </tr>
	  <?php
		  }
      ?>
    </tbody>
</table>
<script>


</script>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td width="20"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="50"><?=$q_total->horas?></td>
          <td width="580"><?=$q_total->hora_final?></td>
          <td width="80">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
	
</div>