<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
if(!empty($_GET['status'])){
	mysql_query($t="UPDATE estoque_compras SET status='".$_GET['status']."' WHERE id='".$_GET['compra_id']."'");
}

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
<span></span>Histórico de Produtos
</a>
</div>
<div id="barra_info">
<form method="get">
	<div style="float:left;margin-left:10px;">
	<?php
    if($_GET['produto_id']>0){
		$produto = mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id={$_GET['produto_id']}"));
	}	
		
	$unidade_id = $_GET['unidade_id'];
	
	$unidades = mysql_query("SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY nome");
	echo "<select name='unidade_id' id='unidade_id' style='width:150px;margin-top:5px'>";
	echo "<option value=''>Selecione uma unidade</option>";
	while($unidade = mysql_fetch_object($unidades)){
		if($unidade->id==$unidade_id){$selected="selected='selected'";}
			echo "<option value='$unidade->id' $selected>".$unidade->nome."</option>";
			$selected='';
	}
	echo "</select>";
			
	?>
    Produto: <input type="text" id='produto' name="produto" value="<?=$produto->nome?>" autocomplete='off' maxlength="44" busca="modulos/cozinha/ficha_tecnica/busca_materia_prima.php,@r0,@r1-value>produto_id,0" style="width:100px;height:10px;"/>
    <input type="hidden" name="produto_id" id="produto_id" value="<?=$_GET['produto_id']?>" />
    </div>
    
    <div id="opcoes_filtros" style="display:<?=$display?>;float:left;margin-left:10px;">
   
    	De: <input type="text" name="de" id="de" calendario="1" sonumero="1" mascara="__/__/____" value="<?=$_GET['de']?>" style="height:8px;width:70px;">
    	Até: <input type="text" name="ate" id="ate" calendario="1" sonumero="1" mascara="__/__/____" value="<?=$_GET['ate']?>" style="height:8px;width:70px;">
         <input type="button" name="filtrar" id="filtrar" value="Filtrar">
    </div>
    
</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="120">Data</td>
          	<td width="120">Tipo</td>
            <td width="100">Origem</td>
            <td width="100">Destino</td>
            <td width="140">Entrada</td>
            <td width="140">Saída</td>
            <td width="140">Saldo</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
	<?
	$fim='';
	if(!empty($_GET['de']) && !empty($_GET['ate'])){
		$fim="AND date(data_hora) BETWEEN '".dataBrToUsa($_GET['de'])."' AND '".dataBrToUsa($_GET['ate'])."'"; 
	}
	
?>	
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">
<?php
		if(!empty($_GET['produto_id'])){
	
		$movimentacoes = mysql_query($t="SELECT *, date(data_hora) as data,time(data_hora) as hora FROM estoque_mov WHERE produto_id='".$_GET['produto_id']."' AND almoxarifado_id = '".$_GET['unidade_id']."'  AND vkt_id='$vkt_id' $fim ORDER BY id DESC");
		//echo $t;
		while($movimentacao = mysql_fetch_object($movimentacoes)){
			$origem = "-";
			$destino = "-";
			if($movimentacao->doc_tipo=='compra'){
				$tipo  = mysql_fetch_object(mysql_query("SELECT * FROM estoque_compras WHERE id=$movimentacao->doc_id"));
				
				$origem  = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id=$tipo->fornecedor_id"));
				$origem = $origem->razao_social;
				
				$destino = mysql_fetch_object(mysql_query("SELECT * FROM cozinha_unidades WHERE id=$tipo->unidade_id"));
				$destino = $destino->nome;
				
								
			}
			
			if($movimentacao->doc_tipo=='venda'){
				$tipo  = mysql_fetch_object(mysql_query("SELECT * FROM estoque_vendas WHERE id=$movimentacao->doc_id"));
				
				$origem  = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id=$tipo->fornecedor_id"));
				$origem = $origem->razao_social;
				
				$destino = mysql_fetch_object(mysql_query("SELECT * FROM cozinha_unidades WHERE id=$tipo->unidade_id"));
				$destino = $destino->nome;
				
			}
			
			if($movimentacao->doc_tipo=='transferencia'){
				$tipo  = mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_transferencia WHERE id=$movimentacao->doc_id"));
				//echo $t;
				$origem  = mysql_fetch_object(mysql_query("SELECT * FROM cozinha_unidades WHERE id=$tipo->unidade_id_origem"));
				$origem = $origem->nome;
				
				$destino = mysql_fetch_object(mysql_query("SELECT * FROM cozinha_unidades WHERE id=$tipo->unidade_id_destino "));
				$destino = $destino->nome;
			}
			if($movimentacao->doc_tipo=='inventario'){
				$corletra = "#B22222";
				$font_weight = "800";
			}else{
				$corletra = "";
				$font_weight = "";
			}
		?>
    	<tr style="color:<?=$corletra?>;font-weight:<?=$font_weight?>">
            
            
            <td width="120"><?=DataUsaToBr($movimentacao->data) ." às ".$movimentacao->hora?></td>
          	<td width="120"><?=$movimentacao->doc_tipo." (".$movimentacao->doc_id.")"?></td>
            <td width="100"><?=$origem?></td>
            <td width="100"><?=$destino?></td>
            <td width="140" align="right"><? if($movimentacao->entrada>0){ echo MoedaUsaToBr($movimentacao->entrada)." ".substr($produto->unidade_uso,0,2);}else{ echo "0,00";}?> <?=($movimentacao->entrada/$produto->conversao2).substr($produto->unidade_embalagem,0,2)?></td>
            <td width="140" align="right"><? if($movimentacao->saida>0){ echo MoedaUsaToBr($movimentacao->saida)." ".substr($produto->unidade_uso,0,2);}else{ echo "0,00";}?> <?=($movimentacao->saida/$produto->conversao2).substr($produto->unidade_embalagem,0,2)?></td>
            <td width="140" align="right"><? if($movimentacao->saldo>0){ echo MoedaUsaToBr($movimentacao->saldo)." ".substr($produto->unidade_uso,0,2);}else{ echo "0,00";}?> <?=($movimentacao->saldo/$produto->conversao2).substr($produto->unidade_embalagem,0,2)?></td>
            <td></td>
        </tr>
		<?
			}
	}
		?>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="150">&nbsp;</td>
            <td width="400">&nbsp;</td>
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
