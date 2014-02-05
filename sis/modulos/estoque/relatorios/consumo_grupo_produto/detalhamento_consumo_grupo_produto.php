<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
include '_functions.php';
$almoxarifado_id = $_GET['almoxarifado_id'];
$grupo_id        = $_GET['grupo_id'];
$filtro = "AND ec.data_chegada_prevista BETWEEN '".DataBrToUsa($_GET['de'])."' AND '".DataBrToUsa($_GET['ate'])."'";
$tipo   = $_GET['tipo'];
?>

<script>
$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
})

$("#filtrar").live("click",function(){
	var unidade_id = $("#unidade_id").val();
	var produto_id    = $("#produto_id").val();
	var de            = $("#de").val();
	var ate          = $("#ate").val();
	if(unidade_id > 0 && produto_id>0){
		location.href='?tela_id=<?=$_GET['tela_id']?>&produto_id='+produto_id+'&unidade_id='+unidade_id+'&de='+de+'&ate='+ate;
	}else{
		alert('Selecione uma unidade e um produto');
	}
});
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<!--<form class='form_busca' action="" method="post" autocomplete="off">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" id='busca' name="busca" maxlength="44" value="" onkeydown="if(event.keyCode==13){this.parentNode.submit()}" busca='modulos/estoque/compras/busca_pedido.php,@r0,0' sonumero='1' autocomplete="off"/>
</form>-->
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="./" class='s1'>
    Estoque 
</a>
<a href="./" class='s2'>
    Relatórios
</a>
<a href="?tela_id=<?=$_GET['tela_id']?>" class="navegacao_ativo">
<span></span><?=$tela->nome?>
</a>
</div>
<div id="barra_info">

	<div style="float:left;">
	<input type="button" value="<<" onclick="location.href='?tela_id=501'" style="margin-top:3px;"/>		
	
    <strong>Almoxarifado:</strong> <?=$almoxarifados->nome?>
    </div>
    <div style="float:left;margin-left:10px;">
    <strong>De:</strong> <?=$_GET['de']?>
    <strong>Até:</strong> <?=$_GET['ate']?>
    </div>

</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="60">Data</td>
          	<td width="40">Pedido</td>
            <td width="120">Produto</td>
            <td width="70">Valor(R$)</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->

<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">
<?php
		if($tipo=='compra'){
			$total_compra_grupo = compras($almoxarifado_id,$grupo_id,$filtro);
		}
		if($tipo=='consumo'){
			$total_compra_grupo = consumo($almoxarifado_id,$grupo_id,$filtro);
		}
		$total_compra_grupo = mysql_query($total_compra_grupo);	
		$valor_total =0;
		while($compra = mysql_fetch_object($total_compra_grupo)){
			$valor = $compra->qtd_enviada * $compra->valor_fim;
			$valor_total +=$valor;
		?>
    	<tr>
            
            
            <td width="60"><?=DataUsaToBr($compra->data_inicio)?></td>
          	<td width="40"><?=$compra->compra_id?></td>
            <td width="120"><?=$compra->nome?></td>
            <td width="70"><?=moedaUsaToBr($valor)?></td>
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
            
            
            <td width="60"></td>
          	<td width="40"></td>
            <td width="120"></td>
            <td width="70"><?=moedaUsaToBr($valor_total)?></td>
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
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=1&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value+'&produto_id=<?=$_GET['produto_id']?>&unidade_id=<?=$_GET['unidade_id']?>&de=<?=$_GET['de']?>&ate=<?=$_GET['ate']?>'">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador],array('produto_id'=>$_GET['produto_id'],'unidade_id'=>$_GET['unidade_id'],'de'=>$_GET['de'],'ate'=>$_GET['ate'],'data_fim'=>$_GET['data_fim']))?>
    </div>
</div>
<script>
$('#sub3').show();
$('#sub396').show()
</script>