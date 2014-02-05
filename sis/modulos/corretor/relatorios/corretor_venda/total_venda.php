<?
session_start();
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
a{ text-decoration:none;}
</style>

<div id='conteudo'>
<div id='navegacao'>
<a href="?" class='s1'>
  	Sistema NV
</a>
<a href="?" class='s1'>
  	Relat&oacute;rios
</a>
<a href="?" class='s2'>
  	Vendas
</a>
<a href="?tela_id=96" class='navegacao_ativo'>
<span></span>    Total
</a>
</div>
<?php
			if(isset($_GET['ano'])){
					$ano = 	$_GET['ano'];
			} else {
					$ano = date('Y');	
			}
?>
<div id="barra_info">
	  	
</div>

<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>

<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="300">Corretor</td>
          <td width="100">Total Vendas</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	      
    	<tr <?=$sel?> id="<?=$r->id?>">
          <td width="300"><?=$nome;?></td>
          
          <td width="100"><?php echo $registro_qtd->cont;?></td>
         
       
          <td></td>
        </tr>
	
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
