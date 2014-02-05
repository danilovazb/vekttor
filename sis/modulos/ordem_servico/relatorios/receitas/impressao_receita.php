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
	$cliente = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id=$os->cliente_id"));
?>
<span style="margin-left:20px;"> <strong>Cliente</strong>: <?=$cliente->razao_social?> | <strong>Pedido no</strong> <?=$os->id?> | <strong>Data:</strong> <?=DataUsatoBr($os->data_aprovacao)?>  </span>
<table cellpadding="0" cellspacing="0" width="100%" class="tabela">
                <thead>
                         <tr>
                          <td colspan="3" align="center" style="font-weight:bold">SERVIÇOS</td>                                                                           
                        </tr>
                        <tr>
                          <td width="150">Identificacao</td>
                          <td width="10">Qtd</td>
                          <td width="10">Valor</td>
                                                  
                        </tr>
               </thead>
			
                <tbody id="tbody">
                	<?php
						$total_servico = 0;
						while($servico=mysql_fetch_object($servicos)){							
							$s= mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id='$servico->servico_id'"));
							$total_servico+=($servico->valor_servico*$servico->qtd_servico);
					?>
                    		<tr>
                            	<td width='250'>
                                	<?=$s->nome?>                  	
                                </td>
                                <td width='70'>
                                	<?=$servico->qtd_servico?>                                                      	
                                </td>
                                <td width='70' align="right">
                                	<?=moedaUsaToBr($servico->valor_servico)?>                                                      	
                                </td>
                                
                            </tr>
                    <?php
						}						
					?>
                    <tr style="font-weight:bold;text-align:right">
                    	<td width="250" colspan="2">TOTAL</td>
                        <td width="10"><?php echo moedaUsaToBr($total_servico)?></td>
                    </tr>
                </tbody>
</table>

<!------------------------------------------------------------------------------>

<table cellpadding="0" cellspacing="0" width="100%" class="tabela">
                 <thead>
                         <tr>
                          <td colspan="3" align="center" style="font-weight:bold">PRODUTOS</td>
                                                                            
                        </tr>
                        <tr>
                          <td width="250">Identificacao</td>
                          <td width="70">Qtd</td>
                          <td width="70" align="right">Valor</td>                                                  
                        </tr>
               </thead>
               <tbody id="tbody">
                	<?php
						$total_produto = 0;
						while($produto=mysql_fetch_object($produtos)){							
							$s= mysql_fetch_object(mysql_query($t="SELECT * FROM produto WHERE id='$produto->produto_id'"));
							//echo $t;
							$total_produto+=($produto->valor_produto*$produto->qtd_produto);
					?>
                    		<tr>
                            	<td width='250'>
                                	<?=$s->nome?>                  	
                                </td>
                                <td width='70'>
                                	<?=$produto->qtd_produto?>                                                      	
                                </td> 
                                <td width='70' align="right">
                                	<?=moedaUsaToBr($produto->valor_produto)?>                                                      	
                                </td>
                               
                            </tr>
                    <?php
						}						
					?>
                    <tr style="font-weight:bold;text-align:right">
                    	<td width="250" colspan="2" align="right">TOTAL</td>
                        <td width="10"><?php echo moedaUsaToBr($total_produto)?></td>
                    </tr>
                </tbody>
</table>

<table cellpadding="0" cellspacing="0" width="100%" class="tabela">
                 <thead>
                         <tr>
                          <td colspan="4" align="center" style="font-weight:bold">DESPESAS</td>
                                                                            
                        </tr>
                        <tr>
                          <td width="250">Descriçao</td>
                          <td width="35">QTD</td>
                          <td width="35">VLR</td>
                          <td width="70">Total</td>                                                    
                        </tr>
                  </thead>
                  
                <tbody id="tbody">
                	<?php
						$total_custo = 0;
						while($custo=mysql_fetch_object($custos_os)){							
							//$s= mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$funcionario->funcionario_id'"));
							$total_custo+=$custo->total_item;
					?>
                    		<tr>
                            	<td width="250"><?=$custo->descricao?></td>
                          		<td width="35"><?=$custo->qtd?></td>
                          		<td width="35"><?=$custo->valor?></td>
                          		<td width="70" align="right"><?=moedaUsaToBr($custo->total_item)?></td>
                            </tr>
                    <?php
						}						
					?>
                    <tr style="font-weight:bold;text-align:right">
                    	<td width="250" colspan="3" align="right">TOTAL</td>
                        <td width="10"><?php echo moedaUsaToBr($total_custo)?></td>
                    </tr>
                </tbody>
             </table>
</table>

<table cellpadding="0" cellspacing="0" width="100%" class="tabela">
                 <thead>
                         <tr>
                          <td colspan="2" align="center" style="font-weight:bold">COM. FUNCIONÁRIO</td>
                                                                            
                        </tr>
                        <tr>
                          <td width="320">Identificaçao</td>
                          
                          <td width="70">Valor</td>
                                                                              
                        </tr>
                  </thead>
                                <tbody id="tbody">
                	<?php
						$total_funcionario = 0;
						while($funcionario=mysql_fetch_object($comissao_funcionario)){							
							$s= mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$funcionario->funcionario_id'"));
							$total_funcionario+=$funcionario->valor_funcionario;
					?>
                    		<tr>
                            	<td width='250'>
                                	<?=$s->nome?>                  	
                                </td>
                                <td width='70' align="right">
                                	<?=moedaUsaToBr($funcionario->valor_funcionario)?>                                                    	
                                </td>
                                
                            </tr>
                    <?php
						}						
					?>
                    <tr style="font-weight:bold;text-align:right">
                    	<td width="250" colspan="1" align="right">TOTAL</td>
                        <td width="10"><?php echo moedaUsaToBr($total_funcionario)?></td>
                    </tr>
                </tbody>
             </table>
</table>       
<div class="totais">

<table class="tabela" style="border-collapse:collapse;">
<tr>
	<td>SERVIÇOS </td>
	<td align="right"><?php if(!$total_servico>0){echo "0,00";}else{echo moedaUsaToBr($total_servico);}?></td></tr>
<tr>
    <td>PRODUTOS </td>
	<td align="right"><?php if(!$total_produto>0){echo "0,00";}else{echo moedaUsaToBr($total_produto);}?></td>
    </tr>
<tr style="font-weight:bold;background-color:#CCC">
    <td>Total Receitas </td>
	<td align="right"><?php if(!($total_produto+$total_servico)>0){echo "0,00";}else{echo moedaUsaToBr($total_produto+$total_servico);}?></td>
</tr>
    
<tr>
    <td >DESPESAS</td>
	<td align="right"><?php if(!$total_custo>0){echo "0,00";}else{echo moedaUsaToBr($total_custo);}?></td>
</tr>
<tr>
    <td >COMISSAO FUNCIONÁRIO</td>
	<td align="right"><?php if(!$total_funcionario>0){echo "0,00";}else{echo moedaUsaToBr($total_funcionario);}?></td>
</tr>
<tr>
    <td >COMISSAO VENDEDOR</td>
	<td align="right">
			<?php
            if($os->comissao_vendedor>0){
				$comissao_vendedor = $os->comissao_vendedor*($total_servico+$total_produto)/100;
			}else{
				$comissao_vendedor = 0.00;
			}
			echo moedaUsaToBr($comissao_vendedor);
			?>
    </td>
</tr>
<tr style="font-weight:bold;background-color:#CCC">
    <td>Total Despesas</td>
	<td align="right">
		<?php 
			
			$total_despesas = $total_custo + $total_funcionario + $comissao_vendedor;
			if(!($total_despesas)>0){echo "0,00";}else{echo moedaUsaToBr($total_despesas);}?>
     </td>
</tr>
<tr style="font-weight:bold;background-color:#CCC">
    <td>LUCRO</td>
	<td align="right">
		<?php 
			echo moedaUsaToBr($total_servico+$total_produto-$total_custo-$total_funcionario-$comissao_vendedor-$soma_vlr_produtos)
		?>
     </td>
</tr>


</table>

<?php
	
?>
</div>
</body>
</html>