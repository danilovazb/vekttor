<?php
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
// funções base do sistema
include("_functions.php");
include("_ctrl.php");
?>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id='some'>«</div>
<a href="./" class='s1'>
  	Sistema NV
</a>
<a href="./" class='s2'>
    Administrativo 
</a>
<a href="?tela_id=172" class="navegacao_ativo">
<span></span>    Negociações Restritas 
</a>
</div>
<div id="barra_info">
    <select onchange="location='?tela_id=20&situacao='+this.value" name="situacao">
		<?
		if($_GET['situacao']==0||empty($_GET['situacao']))$todos = "selected='selected'";
		if($_GET['situacao']==1)$prevenda = "selected='selected'";
		if($_GET['situacao']==2)$aprov = "selected='selected'";
		if($_GET['situacao']==3)$confirm = "selected='selected'";
		if($_GET['situacao']==4)$cancel = "selected='selected'";
		?>
		<option value="0" <?=$todos?>>Todas as Vendas</option>
		<option value="1" <?=$prevenda?>>Apenas Pré-Vendas</option>
		<option value="2" <?=$aprov?>>Apenas Aprovados</option>
		<option value="3" <?=$confirm?>>Apenas Confirmados</option>
		<option value="4" <?=$cancel?>>Apenas Cancelados</option>
   </select>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="200">Empreendimento</td>
          	<td width="200">Nome</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <? 
	$negociacoes_q=mysql_query($u="SELECT * FROM negociacao WHERE restrito='1' AND vkt_id='$vkt_id' ORDER BY empreendimento_id ASC");
	while($negociacao=mysql_fetch_object($negociacoes_q)){
		$empreendimento=mysql_fetch_object(mysql_query("SELECT * FROM empreendimento WHERE id ='{$negociacao->empreendimento_id}' "));
	
	?>
    	<tr onclick="window.open('<?=$caminho?>form_negociacao.php?id=<?=$negociacao->id?>','carregador')">
            <td width="200"><?=$empreendimento->nome?></td>
          	<td width="200"><?=$negociacao->nome?></td>
            <td></td>
        </tr>
    <? } ?>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="200"><a>Total: <?=$total?></a></td>
           <td width="200">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	<?=$registros?> Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>
