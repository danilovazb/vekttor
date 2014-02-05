<?
include("../../../_config.php");
include("../../../_functions_base.php");
include '_ctrl.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Impressão de Transferência</title>
<style>
#body{
	margin:0;
}
#tabela{ margin-top:5px; font-size:8px; border-top:1px solid #000; border-left:1px solid #000}
#tabela thead{ border:dashed 1px black;}
#tabela thead tr td{ height:15px; line-height:15px; color:black; text-transform:uppercase; background-color:#CCC; font-weight:bold  }
#tabela td{ border-right:1px solid #000;border-bottom:1px solid #000;}
#tabela tbody tr.p:nth-child(2n+1){}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 9px;
}
.g{padding-left:5px; text-transform:uppercase; background:#CCCCCC}
#via1,#via2{
	width:349px;
	float:left;
}
#via2{
	margin-left:5px;
}
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
$ultimo_inventario = mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_inventario WHERE vkt_id='$vkt_id' AND almoxarifado_id='$para->id' ORDER BY id DESC LIMIT 1"));
?> 
<div id="via1">
<span style="margin-left:20px; font-weight:bold;"> Transferência nº <?=$trans->id?> | Criado em: <?=$data_inicio?> | De:<?=$origem->nome?> | Para:<?=$para->nome?> </span>
<table cellpadding="1" cellspacing="0" border="0"  id="tabela">
<thead>
	<tr>
    	    	   	
    	<td width="30">Item</td>
        <td width="30">COD.</td>
        <td width="200">Produto</td>
        <td width="80" align="center">QTD Transf.</td>
        <!--<td width="40" align="center">UND</td>-->
        <td width="110" align="center">Inv. Dest. - <?=$ultimo_inventario->id." ".dataUsaToBr(substr($ultimo_inventario->data_criado,0,10))?></td>        
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
										p.produto_grupo_id = '$grupo->id' AND i.transferencia_id = '".$trans->id."' AND
										i.qtd_enviada>0
										
										
										ORDER BY p.nome ASC");			
				
		
		if(mysql_num_rows($sql)>0){
		?>
	
    	<tr>
        <td colspan="9" class="g"><strong><?=$grupo->grupo?></strong></td>
        </tr>
   		<?php
		}
        		while($itens=mysql_fetch_object($sql)){
				$qtd_destino = mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_mov WHERE vkt_id='$vkt_id' AND almoxarifado_id='$para->id' AND produto_id='$itens->produto_id' ORDER BY id LIMIT 1"));
				
				if(!$qtd_destino->saldo>0){
					$qtd_destino=0;
				}else{
					$qtd_destino=$qtd_destino->saldo;
				}
				if($itens->unidade_tipo=='unidade_embalagem'){
					
					$qtd_enviada = $itens->qtd_enviada;
					$unidade     = $itens->unidade_embalagem;
				}else{
					
					$qtd_enviada = $itens->qtd_enviada*$itens->conversao2;
					$unidade     = $itens->unidade_uso;
				}
					if($qtd_enviada>0||$qtd_destino>0){
		?>
		<tr class="p">
   	  		<td ><?=$cont++?></td>
            <td ></td>
      		<td ><?=$itens->produto_nome;?></td>
        	<td align="center"><?=qtdUsaToBr($qtd_enviada,2)." ".substr($unidade,0,2)?></td>
            
            <td align="center" width="110"><?=qtdUsaToBr($qtd_destino,2)." ".substr($itens->unidade_uso,0,2)?></td>
             
        
            <td ><?=$itens->ocorrencia?></td>
    	</tr>
	  <? 	
					}
				}
		}
	  ?>
		<tr>
        	<td colspan="9" class="g"><strong>Ocorrencia Pedido</strong></td>
        </tr>
        <tr>
        	<td colspan="9">
            &nbsp;
           		<?=$trans->ocorrencia_pedido?> 
           </td>
        </tr>
        <tr>
        	<td colspan="9" valign="top" style="font-size:9px;height:20px;">
           		Entregue por 
           </td>
        </tr>
        <tr>
        	<td colspan="9" valign="top" style="font-size:9px;height:20px;">
           		Recebido por 
           </td>
        </tr>
</tbody>
</table>
</div>
<div id="via2">
 
</div>
<div style="clear:both"></div>

</body>
</html>
<script>
	document.getElementById('via2').innerHTML = document.getElementById('via1').innerHTML;
</script>