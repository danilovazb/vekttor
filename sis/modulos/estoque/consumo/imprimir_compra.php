<?
include("../../../_config.php");
include("../../../_functions_base.php");
//include '_functions.php';
//include '_ctrl.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Impressão de Compra</title>
<style>
#tabela{ margin-left:20px; margin-top:5px; font-size:12px; border-top:1px solid #000; border-left:1px solid #000}
#tabela thead{ border:dashed 1px black;}
#tabela thead tr td{ height:15px; line-height:15px; color:black; text-transform:uppercase; background-color:#CCC; font-weight:bold  }
#tabela td{ border-right:1px solid #000;border-bottom:1px solid #000;}
#tabela tbody tr.p:nth-child(2n+1){}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
}
.g{padding-left:5px; text-transform:uppercase; background:#CCCCCC}
</style>

</head>
<body>
<?
$compra=mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_consumos WHERE id = '".$_GET['compra_id']."'"));
$fornecedor=mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id = '".$compra->fornecedor_id."'"));
$almoxarifado=mysql_fetch_object(mysql_query($t="SELECT * FROM cozinha_unidades WHERE id = '".$compra->unidade_id."'"));
?> 
<span style="margin-left:20px;"> <strong>Fornecedor</strong>: <?=$fornecedor->razao_social?> | <strong>Almoxarifado</strong>: <?=$almoxarifado->nome?> | <strong>Pedido nº</strong> <?=$compra->id?> | <strong>Data: <?=DataUsatoBr($compra->data_inicio)?></strong>  </span>
<table cellpadding="1" cellspacing="0" border="0"  id="tabela">
<thead>
	<tr>
    	<td width="200">Produto</td>
        <td width="200">Marca</td>
        <td width="80" align="right">QTD</td>
        <td width="50" align="right">Unidade</td>
        <td width="80" align="right">VALOR UNITÁRIO</td>
        <td width="80" align="right">VALOR TOTAL</td>
    </tr>
</thead>
<tbody>
<?
	$itens = mysql_query($t="SELECT * FROM estoque_consumos_item WHERE pedido_id = '".$_GET['compra_id']."' ORDER BY produto_id");
	//echo $t;
	$soma = 0;
	while($item_compra=mysql_fetch_object($itens)){
		if($item_compra->qtd_pedida>0){
		$soma+=$item_compra->valor_ini*$item_compra->qtd_pedida;		
?>
	
    	<tr class="p">
   	  		<? $produto=mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id='".$item_compra->produto_id."'"));?>
            <td ><?=$produto->nome?></td>
        	<td ><?=$item_compra->marca?></td>
            <td align="right" ><?php if($item_compra->qtd_enviada>0){echo $item_compra->qtd_enviada;}else{echo $item_compra->qtd_pedida;}?></td>
            <td align="right" ><?=$item_compra->unidade?></td>
            <td align="right" ><?=moedaUsaToBr($item_compra->valor_ini)?></td>
            <td align="right" ><?=moedaUsaToBr($item_compra->valor_ini*$item_compra->qtd_pedida)?></td>
        </tr>
        
<? }} ?>
		<tr>
        	
        	<td colspan="5" align="right"><strong>TOTAL</strong></td>
            <td align="right"><strong>
            <?=moedaUsaToBr($soma)?>
            </strong></td>
        </tr>
        <tr>
        	<td colspan="6" class="g"><strong>OBSERVA&Ccedil;&Atilde;O</strong></td>
        </tr>
        <tr>
        	<td colspan="6">
           		<p><?=$compra->obs_pedido?></p> 
           </td>
        </tr>
</tbody>
</table>

</body>
</html>