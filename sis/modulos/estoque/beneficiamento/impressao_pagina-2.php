<?php
include("../../../_config.php");
include("../../../_functions_base.php");	
	
	global $vkt_id;
	$produto_id = $_GET['produto_id'];
	$pedido_id  = $_GET['pedido_id'];
	//$beneficiamento_id = $_GET['beneficiamento_id'];

	$pedido = mysql_fetch_object(mysql_query($tb="
		SELECT 
			*, ebp.id as beneficiamento_id, ebp.pedido_id as pedido_id 
		FROM 
			estoque_beneficiamento_pedido ebp,
			produto p 
		WHERE
			ebp.vkt_id = '$vkt_id' AND
			ebp.produto_beneficiado_id = p.id AND
			ebp.id='$pedido_id'"));
		//echo $tb;
													
	$total_derivada = mysql_fetch_object(mysql_query($td="SELECT SUM(qtd_pedida) as total_derivada FROM estoque_beneficiamento_item WHERE beneficiamento_id = ".$pedido->beneficiamento_id));
	 //echo $td;
	$saldo = ($pedido->qtd_pedido - $total_derivada->total_derivada);
	$perda = ($pedido->qtd_pedido * $pedido->desperdicio)/100 ;
	$estoque_compras = mysql_fetch_object(mysql_query("SELECT * FROM estoque_compras WHERE id = ".$pedido->pedido_id));
	$fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id = ".$estoque_compras->fornecedor_id));
	
	
	$item = mysql_query($t="SELECT *, i.id as item_id FROM estoque_beneficiamento_item i
									JOIN produto p	on i.produto_id=p.id
										WHERE beneficiamento_id = ".$pedido->beneficiamento_id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Beneficiamento</title>
<style>
table{
	border:1px solid #333; 
	border-collapse:collapse;
}
table tr td{border:1px solid #333; font-family:Tahoma, Geneva, sans-serif; font-size:14px;}
table tr td#linha_grade div{ border:1px solid #333; border-collapse:collapse;}
table tr td div{margin:0px; padding:0px;}
</style>
</head>

<body>
<div>
		<div style="width:700px;">
        	<table style="width:100%;">
                  <tr>
                    <td width="200">Logo</td>
                    <td>PLANILHA DE BENEFICIAMENTO DE PROTEÍNAS</td>
                  </tr>
			</table>
            <div style="margin-top:3px;"></div>
            <div>
            <table style="width:100%">
              <tr>
                <td width="200">Responsável pelo Setor:</td>
                <td width="300"><strong>Ozéias Santos Pinto</strong></td>
                <td width="70">Funçao:</td>
                <td>Açougueiro</td>
              </tr>
			</table>
            </div>
            <div style="margin-top:3px;"></div>
            <div>
            <table style="width:100%">
            	<tr>
                	<td colspan="2" align="center">Procedencia</td>
                    <td colspan="2" align="center">Dados do Beneficiamento</td>
                </tr>
                <tr>
                	<td align="right">Fornecedor:</td>
                    <td align="center" style="text-transform:uppercase;background:#C6E2FF;"><?=$fornecedor->razao_social?></td>
                    <td align="right">Data do Beneficiamento:</td>
                    <td align="center" style="background:#FFE1C4;"><?=dataUsaToBr($pedido->data_pedido)?></td>
                </tr>
                <tr>
                    <td align="right">Data da Entrada:</td>
                    <td align="center" style="background:#FFE1C4;"><?=dataUsaToBr($pedido->data_entrega);?></td>
                    <td align="right">Tipo de Proteina</td>
                    <td align="center" style="background:#C6E2FF"><?=$pedido->nome?></td>
                </tr>
                <tr>
                    <td align="right">N do Docto:</td>
                    <td align="center"><?=$pedido->pedido_id?></td>
                    <td align="right">Qtd. para beneficiamento:</td>
                    <td align="center" style="background:#C6E2FF"><?=moedaUsaToBr($pedido->qtd_pedido)?> Kg</td>
                </tr>
                <tr>
                    <td align="right">Marca do Produto</td>
                    <td align="center" style="text-transform:uppercase;background:#C6E2FF;"><?=$pedido->marca?></td>
                    <td align="right">Validade:</td>
                    <td align="center"></td>
                </tr>
                <tr>
                    <td align="right"><?=moedaUsaToBr($saldo)?> KG</td>
                    <td align="center"><?=$pedido->desperdicio?></td>
                    <td align="right" style="background:#C6E2FF"><?=moedaUsaToBr($perda)?> Kg</td>
                    <td align="center" style="background:#C6E2FF">
					<? 
					$liquido = ($pedido->qtd_pedido - $pedido->perda);
					echo moedaUsaToBr($liquido);?> KG</td>
                </tr>
                 <tr>
                    <td align="right">Saldo</td>
                    <td align="center">Percentual de Perda</td>
                    <td align="right">Perda</td>
                    <td align="center">Peso LíQ.</td>
                </tr>
            </table>
            </div>
            <div style="margin-top:3px;"></div>
            <div>
            	<table style="width:100%">
                	<tr>
                    	<td colspan="2" align="center">Tipo de Corte</td>
                        <td align="center">QTD. EMBALAGEM</td>
                        <td align="center">Tipo de Embalagem</td>
                        <td align="center">QTD. KG</td>
                        <td align="center">
                        	<div style="font-size:15px;">Reservada ao Açougueiro</div>
                            <div>Embala. Produzida</div>
                         </td>
                    </tr>
                    <tr>
                    	<td align="center">CORTE</td>
                        <td align="center" style="margin:0px; padding:0px;">
                        	CUBO
                            
                        </td>
                        <td >
                        	<?
                            	while($itens=mysql_fetch_object($item)){
							?>
                        	<div style="float:left;width:60px; text-align:center; border-right:1px solid #333;"><?=$itens->qtd_pedida?></div>
                            <div style="border-bottom:1px solid #333; text-align:center"><?=$itens->unidade?></div>
                            <?
								}
							?>		
                        </td>
                        <td align="center"  style="margin:0px; padding:0px;">
                        	<div style="float:left;overflow:auto;">
                                <div style="width:50px;border-right:1px solid #333;border-bottom:1px solid #333">&nbsp;</div>
                                <div style="width:50px;border-right:1px solid #333;border-bottom:1px solid #333">&nbsp;</div>
                                <div style="width:50px;border-right:1px solid #333;border-bottom:1px solid #333">&nbsp;</div>
                                <div style="width:50px;border-right:1px solid #333;">&nbsp;</div>
                            </div>
                            <div style="border:0px solid #FFF;">
                            	<div style="">KG</div>
                            </div>
                        </td>
                        <td align="center" style="margin:0px; padding:0px;">
                        		<div style="border-bottom:1px solid #333; margin:0;padding:0;">&nbsp;</div>
                                <div style="border-bottom:1px solid #333;">&nbsp;</div>
                                <div style="border-bottom:1px solid #333;">&nbsp;</div>
                                <div>&nbsp;</div>
                        </td>
                        <td align="center" style="margin:0px; padding:0px;">
                        		<div style="border-bottom:1px solid #333; margin:0;padding:0;">&nbsp;</div>
                                <div style="border-bottom:1px solid #333;">&nbsp;</div>
                                <div style="border-bottom:1px solid #333;">&nbsp;</div>
                                <div>&nbsp;</div>
                         </td>
                    </tr>
                   
                    <tr>
                    	<td align="center">PREPARO</td>
                        <td align="center" style="font-size:18px;">Guisado com batata</td>
                        <td></td>
                        <td style="margin:0px; padding:0px;">
                         <div>
                        	<div style="float:left; font-size:12px; text-align:right;">Subtotal</div>
                            <div style="float:right;font-size:12px;">Produzido</div>
                         </div>
                        </td>
                        <td align="center">&nbsp;</td>
                        <td align="center"></td>
                    </tr>
                </table>
            </div>
            <div style="margin-top:10px;"></div>
            <div>
            	<table style="width:100%">
                      <tr>
                        <td width="80">Aparas:</td>
                        <td width="360"><?=$pedido->aparas?></td>
                        <td width="80">Perda:</td>
                        <td><?=$pedido->perda?></td>
                      </tr>
                      <tr>
                        <td>Descarte:</td>
                        <td><?=$pedido->descarte?></td>
                        <td>Desgelo:</td>
                        <td><?=$pedido->desgelo?></td>
                      </tr>
                      <tr>
                        <td colspan="4">OBS Pedido:<?=$pedido->obs?></td>
                      </tr>
                      <tr>
                        <td colspan="4">OBS Recebimento:<?=$pedido->obs_recebimento?></td>
                      </tr>
				</table>
            </div>
           
			            
<!-- fim -->
        </div>
</div>
</body>
</html>