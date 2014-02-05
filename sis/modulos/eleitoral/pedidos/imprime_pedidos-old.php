<?
//Includes
// configuraçao inicial do sistema
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");
// funçoes do modulo pedido eleitoral
include("_functions.php");
include("_ctrl.php");
//print_r($_POST);
//print_r($_GET);
?>
<form onsubmit="return validaForm(this)" class="form_float" method="post">
<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
  <fieldset id='campos_1' style="width:60%">
<legend>
<strong>Comprovante de Pedido</strong>
</legend>
<br />
<label>
<strong>Eleitor:</strong> <?=$pedido_q->eleitor_id?> 
</label>
<br /><br />
<label style="width:200px">
<strong>Data do Pedido: </strong><? echo DataUsaToBr($pedido_q->data_inicio)?> 
</label>
&nbsp;&nbsp;
<label style="width:200px">
<strong>Data do Retorno: </strong><? echo DataUsaToBr($pedido_q->data_retorno);?> 
</label>
<br />
<br />
<label style="width:200px">
<div style="clear:both"></div>
	<strong>Assunto/Solicitacao</strong><br>
	<p><?= $pedido_q->solicitacao ?></p>
</label>	
<br />
<br />
<div style="clear:both"></div>
	<strong>Narrativa da Solucao/Motivo</strong><br>
	<p><?= $pedido_q->solicitacao ?></p>
<div style="clear:both"></div>
<br />
<label style="width:200px">
	<?
    	$setor_q = mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_setor WHERE id=".$pedido_q->setor_id));
	?>
   	<strong>Setor Responsavel: </strong>
   	<?= $setor_q->nome ?>
</label>
<br />
<br />
<label style="width:200px">
   	<strong>Coordenador: </strong>
    <?= $pedido_q->coordenador_id ?>
</label> 
<div style="clear:both"></div>
<br />
<label style="width:200px">
   	<strong>Prioridade do pedido: </strong>
   	<?=strtoupper($pedido_q->prioridade)?>
</label> 
<br />
<br />
<label style="width:200px">
   	<strong>Staus do pedido: </strong>
   	<? if($pedido_q->status_pedido=="emandamento"){echo "EM ANDAMENTO";}else if($pedido_q->status_pedido=="naoresolvido"){echo "NAO RESOLVIDO";}else{echo "RESOLVIDO";}?>
</label>
<br />
<br />
<label style="width:200px">
<strong>Coordenador:</strong>
</label>
<br />
<br />
<label style="width:200px">
<strong>Responsável: </strong>
</label>
</fieldset>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<!---------------------------------------------------Dados cadastrais----------------------->
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
</div>
</form>
<script>top.openForm()</script>


