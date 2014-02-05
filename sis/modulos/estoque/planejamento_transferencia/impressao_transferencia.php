<?
include("../../../_config.php");
include '_ctrl.php';

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
if($_GET['id'] > 0) $id = $_GET['id'];
$trans=mysql_fetch_object(mysql_query("SELECT * FROM estoque_transferencia WHERE vkt_id = '$vkt_id' AND id = '$id'"));
$origem=mysql_fetch_object(mysql_query("SELECT * FROM cozinha_unidades WHERE vkt_id = '$vkt_id' AND id = '$trans->unidade_id_origem'"));
$para=mysql_fetch_object(mysql_query("SELECT * FROM cozinha_unidades WHERE vkt_id = '$vkt_id' AND id = '$trans->unidade_id_destino'"));
			$data_inicio = explode("-",$trans->data_inicio);
			$data_inicio = $data_inicio[2].'/'.$data_inicio[1].'/'.$data_inicio[0];
?> 
<span style="margin-left:20px; font-weight:bold;"> Transferência nº <?=$trans->id?> | Criado em: <?=$data_inicio?> | De:<?=$origem->nome?> | Para:<?=$para->nome?> </span>
<table cellpadding="1" cellspacing="0" border="0"  id="tabela">
<thead>
	<tr>
    	    	   	
    	<td width="30">Item</td>
        <td width="60">COD.</td>
        <td width="200">Produto</td>
        <td width="40" align="center">QTD</td>
        <td width="40" align="center">UND</td>
        <td width="80" align="center">Ocorr&ecirc;ncia</td>
    </tr>
</thead>
<tbody>
<?
	
	$grupos = mysql_query("SELECT DISTINCT gp.nome AS grupo, gp.id FROM estoque_transferencia_item i 
							JOIN 
								estoque_transferencia t  ON t.id = i.transferencia_id
							JOIN 
								produto p ON i.produto_id=p.id
							JOIN 
								produto_grupo gp ON gp.id = p.produto_grupo_id  
							WHERE 
								t.id = '".$trans->id."'
							ORDER BY gp.nome ASC
									 ");
		$cont=1;
		while($grupo=mysql_fetch_object($grupos)){
				$sql=mysql_query("SELECT *, p.nome AS produto_nome  FROM estoque_transferencia_item AS i 
									JOIN  
										produto AS p ON i.produto_id=p.id  
									WHERE 
										p.produto_grupo_id = '$grupo->id' AND i.transferencia_id = '".$trans->id."' ORDER BY p.nome ASC");			
		?>
	
    	<tr>
        <td colspan="6" class="g"><strong><?=$grupo->grupo?></strong></td>
        </tr>
   		<?php
			
        		while($itens=mysql_fetch_object($sql)){
				if($itens->unidade_tipo=='unidade_embalagem'){
					
					$qtd_enviada = $itens->qtd_enviada;
					$unidade     = $itens->unidade_embalagem;
				}else{
					
					$qtd_enviada = $itens->qtd_enviada*$itens->conversao2;
					$unidade     = $itens->unidade_uso;
				}
		?>
		<tr class="p">
   	  		<td ><?=$cont++?></td>
            <td ></td>
      		<td ><?=$itens->produto_nome;?></td>
        	<td align="center"><?=substr($qtd_enviada,0,4);?></td>
            <td align="center"><?=substr($unidade,0,4)?></td>
            <td ><?=$itens->ocorrencia?></td>
    	</tr>
	  <? 
				}
		}
	  ?>
		<tr>
        	<td colspan="6" class="g"><strong>Ocorrencia Pedido</strong></td>
        </tr>
        <tr>
        	<td colspan="6">
            &nbsp;
           		<?=$trans->ocorrencia_pedido?> 
           </td>
        </tr>
        <tr>
        	<td colspan="6" valign="top" style="font-size:9px;height:20px;">
           		Entregue por 
           </td>
        </tr>
        <tr>
        	<td colspan="6" valign="top" style="font-size:9px;height:20px;">
           		Recebido por 
           </td>
        </tr>
</tbody>
</table>
<div style="clear:both"></div>

</body>
</html>