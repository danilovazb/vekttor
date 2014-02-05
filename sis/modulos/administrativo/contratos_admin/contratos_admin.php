<?php
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

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
<a href="?tela_id=15" class="navegacao_ativo">
<span></span>    Contratos 
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
            <td width="240"><?=linkOrdem("Identificação","identificacao",1)?></td>
          	<td width="240">Cliente</td>
          	<td width="80">Situação</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND cf.nome_fantasia LIKE '%{$_GET[busca]}%'";
	}
	
	if($_GET['situacao']>0)$situacao="AND c.situacao='".($_GET['situacao']-1)."'";
	else $situacao=" AND c.situacao IS NOT NULL ";
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query("
	SELECT count(*) FROM contrato as c,disponibilidade as d, cliente_fornecedor as cf
	WHERE
		c.disponibilidade_id = d.id AND
		c.cliente_fornecedor_id = cf.id
	$situacao $busca_add ORDER BY d.identificacao"),0,0);
	
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="d.identificacao";
	}
	
	// colocar a funcao da paginação no limite
	$q= mysql_query($t="
	SELECT 
		c.id as id, d.identificacao as identificacao, cf.nome_fantasia as nome_fantasia, c.situacao as sit, d.id as disponibilidade_id
	FROM 
		contrato as c,disponibilidade as d, cliente_fornecedor as cf
	WHERE
		c.disponibilidade_id = d.id AND
		c.cliente_fornecedor_id = cf.id
		$situacao $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t.'<br>';
	//echo mysql_error();
	while($r=mysql_fetch_object($q)){
		$total++;
		
		$cliente=mysql_fetch_object(mysql_query("SELECT nome_fantasia FROM cliente_fornecedor WHERE id='".$r->cliente_fornecedor_id."'"));
		
		if($r->sit==0)$situacao="Disponível";
		if($r->sit==1)$situacao="Pré-Venda";
		if($r->sit==2)$situacao="Vendido";
		if($r->sit==3)$situacao="Pago";
	?>
	
    	<tr onclick="location='?tela_id=70&id=<?=$r->id;?>&disponibilidade_id=<?=$r->disponibilidade_id?>'">
            <td width="240"><?=$r->identificacao?></td>
          	<td width="240"><?=$r->nome_fantasia?></td>
          	<td width="80"><?=$situacao?> </td>
            <td></td>
        </tr>
	<?
	}
	?>	
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="130"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="80">&nbsp;</td>
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
