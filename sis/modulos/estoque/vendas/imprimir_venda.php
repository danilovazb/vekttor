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
<title>Impressão de Transferência</title>
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
$venda=mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_vendas WHERE id = '".$_GET['venda_id']."'"));
//echo $t."<br>";
?> 
<span style="margin-left:20px; font-weight:bold;">  Venda nº <?=$venda->id?> | Data: <?=DataUsatoBr($venda->data_inicio)?>  </span>
<table cellpadding="1" cellspacing="0" border="0"  id="tabela">
<thead>
	<tr>
    	<td width="200">Produto</td>
        <td width="200">Marca</td>
        <td width="50">Unidade</td>
        <td width="80">QTD</td>
        <td width="80">Valor Unitário</td>
        <td width="80">Valor Total</td>
    </tr>
</thead>
<tbody>
<?
	$itens = mysql_query($t="SELECT 
								*, pg.nome as grupo, p.nome as produto 
							FROM 
								estoque_vendas_item evi, 
								produto p, 
								produto_grupo pg
							WHERE 
								evi.produto_id = p.id AND
								p.produto_grupo_id = pg.id AND
								evi.vkt_id = '$vkt_id' AND
								pedido_id = '".$_GET['venda_id']."'
								GROUP BY pg.id
");
	//echo $t;
	$soma = 0;
	$grupo='';
	while($item_venda=mysql_fetch_object($itens)){
		
		$soma+=$item_venda->valor_ini*$item_venda->qtd_pedida;		
		if($item_venda->grupo!=$grupo){
			$grupo = $item_venda->grupo;
?>
	
    	<tr>
        <td colspan="6" class="g"><strong><?=$item_venda->grupo?></strong></td>
        </tr>
   <? } ?>
		<tr class="p">
   	  		<? $produto=mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id='".$item_venda->produto_id."'"));?>
            <td ><?=$item_venda->produto?></td>
        	<td ><?=$item_venda->marca?></td>
            <td ><?=$item_venda->unidade_embalagem?></td>
            <td ><?=$item_venda->qtd_pedida?></td>
        	<td ><?=moedaUsaToBr($item_venda->valor_ini)?></td>
            <td ><?=moedaUsaToBr($item_venda->valor_ini*$item_venda->qtd_pedida)?></td>
        </tr>
        
<? } ?>
		<tr>
        	<td colspan="5" align="right">TOTAL</td>
            <td><?=moedaUsaToBr($soma)?></td>
        </tr>
        <tr>
        	<td colspan="6" class="g"><strong>Ocorrencia Pedido</strong></td>
        </tr>
        <tr>
        	<td colspan="6">
           		<p><?=$venda->obs_pedido?></p> 
           </td>
        </tr>
</tbody>
</table>

</body>
</html>