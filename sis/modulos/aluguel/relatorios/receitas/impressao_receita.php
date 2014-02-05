<?php
//Includes
// configuraçăo inicial do sistema
include("../../../../_config.php");
// funçőes base do sistema
include("../../../../_functions_base.php");
// funçőes do modulo empreendimento
global $vkt_id;
//echo $vkt_id;
include("_functions.php");
include("_ctrl.php"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Impressao Receita</title>
<style>
.tabela,.totais{ margin-left:20px; margin-top:5px; font-size:12px; }
.tabela{border-top:1px solid #000; border-left:1px solid #000;}
.tabela thead{ border:dashed 1px black;}
.tabela thead tr td{ height:15px; line-height:15px; color:black; text-transform:uppercase; background-color:#CCC; font-weight:normal;text-align:center;  }
.tabela td{ border-right:1px solid #000;border-bottom:1px solid #000;}
tabela tbody tr.p:nth-child(2n+1){}
.totais{
	line-height:125%;
}
body{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	width:600px;
}
.g{padding-left:5px; text-transform:uppercase; background:#CCCCCC}
</style>
</head>

<body>
<?php
	$cliente = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id=$aluguel->cliente_id"));
?>
<span style="margin-left:20px;"> <strong>Cliente</strong>: <?=$cliente->razao_social?> | <strong>Pedido no</strong> <?=$aluguel->id?> | <strong>Data: <?=DataUsatoBr($aluguel->data_aprovacao)?></strong>  </span>
<table cellpadding="0" cellspacing="0" width="100%" class="tabela">
                <thead>
                        <tr >
                          <td colspan="5">ITENS</td>                          
                        </tr>
                        <tr>
                          <td width="250">Descriçao</td>
                          <td width="70">Quantidade</td>
                          <td width="70">Dias</td>
                          <td width="70">Valor</td>
                          <td width="70">Vlr Total</td>
                                                    
                        </tr>
               </thead>
			
                <tbody id="tbody">
                	<?php
										
						$array_equipamentos = array();
						$c=0;
						while($itens=mysql_fetch_object($itens_aluguel)){							
						
							$equipamento = mysql_fetch_object(mysql_query($t="SELECT 
																			*,ae.id as id_equip 
																		   FROM 
																			aluguel_equipamentos_itens aei,
																			aluguel_equipamentos ae 
																		   WHERE 
																		   	aei.id='$itens->id' AND
																			aei.equipamento_id=ae.id AND
																			aei.vkt_id='$vkt_id'"));
							if(!in_array($equipamento->id_equip,$array_equipamentos)){
								$array_equipamentos[$c]=$equipamento->id_equip;
								$c++;	
							}
						
						}	
						$total_qtd = 0;
						$total_valor_aluguel_equipamento = 0;
						$total_locacao = 0;	 
						foreach($array_equipamentos as $equipamento_id){
							$equipamento = mysql_fetch_object(mysql_query("SELECT * FROM aluguel_equipamentos WHERE id='$equipamento_id'"));
							$vlr_equipamento =mysql_fetch_object(mysql_query($t="SELECT 
																				SUM(ae.vlr_aluguel) as valor, COUNT(*) as qtd
																			  FROM
																			  	aluguel_equipamentos ae,
																				aluguel_equipamentos_itens aei,
																				aluguel_locacao_itens ali
																			  WHERE
																			  	ae.id=$equipamento_id AND
																				ae.id=aei.equipamento_id AND
																				aei.id=ali.item_equipamento_id AND
																				ali.locacao_id='".$_GET['id']."' AND
																				ae.vkt_id='$vkt_id'
																			  ")); 
							if($vlr_equipamento->qtd>0){
								$total_qtd+=$vlr_equipamento->qtd;
								$total_valor_aluguel_equipamento+=$vlr_equipamento->valor;
								$valor = (($equipamento->vlr_aluguel*$qtd_dias_locacao->dias)/$equipamento->periodo)*$vlr_equipamento->qtd;
								$total_locacao +=$valor; 	
											
							
							
					?>
                    		<tr>
                            	<td width="250"><?=$equipamento->descricao?></td>
                          		<td width="70"><?=$vlr_equipamento->qtd?></td>
                                <td width="70"><?=$aluguel->dias?></td>
                          		<td width="70"><?=MoedaUsaToBr($vlr_equipamento->valor)?></td>
                          		<td width="70"><?=MoedaUsaToBr($valor)?></td>
                                
                            </tr>
                    <?php
							}
						}						
					?>
                    <tr>
                    	<td width="250" colspan="4" align="right">TOTAL:</td>
                        <td width="10"><?php echo moedaUsaToBr($total_locacao)?></td>
                    </tr>
                </tbody>
</table>

<table cellpadding="0" cellspacing="0" width="100%" class="tabela">
                 <thead>
                         <tr >
                          <td colspan="4">CUSTOS</td>                          
                        </tr>
                        <tr>
                          <td width="250">NOME</td>
                          <td width="70">Valor</td>
                          <td width="70">Quantidade</td>
                          <td width="70">VLR Total</td>
                                                   
                        </tr>
               </thead>
			
                <tbody id="tbody">
                <?php
						$custos = mysql_query($t="SELECT * FROM aluguel_custos WHERE locacao_id='".$_GET['id']."'");
						//echo $t;
						$vlr_total_custo=0;
						$total_item=0;
						while($custo=mysql_fetch_object($custos)){
							$vlr_total_custo+=$custo->valor*$custo->qtd;
							$total_item+=$custo->qtd;
					?>
                    <tbody id="tbody">
            			<tr>
							  <td width="250"><?=$custo->nome?></td>
							  <td width="70"><?=MoedaUsaToBr($custo->valor)?></td>
                              <td width="70"><?=$custo->qtd?></td>
                              <td width="70"><?=MoedaUsaToBr($custo->valor*$custo->qtd)?></td>
							  
						</tr>
                      </tbody>
                   <?php
						}
				   ?> 
                    <tr>
                    	<td width="250" colspan="3" align="right">TOTAL:</td>
                        <td width="10"><?php echo moedaUsaToBr($vlr_total_custo)?></td>
                    </tr>
                </tbody>
</table>
<!------------------------------------------------------------------------------>


<div class="totais">

<strong>Total Itens:</strong> <?php if(!$total_locacao>0){echo "0,00";}else{echo moedaUsaToBr($total_locacao);}?>
<div style="clear:both"></div>

<strong>Total Custos:</strong> <?php if(!$vlr_total_custo>0){echo "0,00";}else{echo moedaUsaToBr($vlr_total_custo);}?>
<div style="clear:both"></div>
<?php
	if(!$aluguel->comissao_vendedor>0){$comissao_vendedor="0,00";}else{$comissao_vendedor=$aluguel->comissao_vendedor*$total_locacao/100;}
?>
<strong>Comissao Vendedor:</strong> <?php echo MoedaUsaToBr($comissao_vendedor);?> 
<div style="clear:both"></div>

<strong>Lucro:</strong> <?php echo moedaUsaToBr($total_locacao-$vlr_total_custo-$comissao_vendedor)?>
</div>
</body>
</html>