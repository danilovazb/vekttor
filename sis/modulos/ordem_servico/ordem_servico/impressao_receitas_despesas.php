<?php
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
global $vkt_id;
if($vkt_id==1){
	$logo="../../../../fontes/img/vekttor.png";
}else{
	$logo="../../../modulos/vekttor/clientes/img/".$vkt_id.".png";
}
$os=mysql_fetch_object(mysql_query($t=" SELECT *,os.id as os_id FROM os ,
									cliente_fornecedor cf
									WHERE cf.id=os.cliente_id
									AND os.id=".$_GET['id']." AND os.vkt_id=$vkt_id"));
									//echo $t;
$configuracao = mysql_fetch_object(mysql_query("SELECT * FROM os_configuracao WHERE id='$vkt_id'"));
if(empty($configuracao->img_cabecalho)){
	$img_cab = $logo;
}else{
	$img_cab = "../../../modulos/ordem_servico/configuracao/img/".$vkt_id."_c.".$configuracao->img_cabecalho;
	//echo $img_cab;
}
if(empty($configuracao->img_rodape)){
	$img_r = $logo;
}else{
	$img_r = $img_r="../../../modulos/ordem_servico/configuracao/img/".$vkt_id."_r.".$configuracao->img_rodape;
}
?>
<html>
<head>
   	<title>ORDEM DE SERVIÇO</title>
<style>
*{ margin:0px ; padding:0px;}
a:link, a:visited	{color: #333; text-decoration: underline;}
a[href]:after		{content: " (" attr(href) ")";}
body{ }
table tr td {font-family:Tahoma, Geneva, sans-serif; border:1px solid #333;}
#pagina{
	border:0px solid #999;
	width:210mm;
	height:297mm;
	margin:0px auto;
}
#cabecalho{
	/*border-bottom:solid 1px;*/
	height:75px;
	font-family:Tahoma, Geneva, sans-serif;
	font-size:14px;
	margin-top:10px;
}
#cliente{
	width:880px;
	height:114px;
	font-family: arial, sans-serif;
	font-size:10pt;
	padding:10px;
}
#cliente br{
	margin:8px;	
}
#produtos{
	border-collapse: collapse;	
	border-style:solid 1px;
}
.rodape{
	width:100%;	
	padding:0px 0px;	
}
.rodape div{
	width:140px; 
	border:0px solid #999;
	text-align:right;
	padding:2px;
	margin:2px;
}
.rodape .valFinal{
	float:left;
	width:480px;
}
.rodape .valFinal div{
	text-align:left;
	float:left;
}
.rodape .ass{
	float:right;
	padding-right:40px;
	width:185px;	
}
.rodape .linha{
	border-bottom:1px solid #999;
	width:200px;
	padding-top:10px;
	padding-bottom:10px;	
}

#rodapea,#rodapeb{
	font-weight:500;
	
}
#servicos{
	
	/*height:230px;*/
}
.infoclitec strong{
		font-family:Arial, Helvetica, sans-serif;
		font-size:11px;
		padding-left:15px;
}
.infoclitec p{
		font-family:Arial, Helvetica, sans-serif;
		font-size:10px;
		padding-left:15px;
}
.titulo_os{ 
	font-family:Arial, Helvetica, sans-serif;font-weight:bold;
}
.titulo_os_info{
	font-family:Arial, Helvetica, sans-serif;
	text-align:center; 
	width:95%; 
	border-top:1px solid #999; padding:4px;
}
body,td,th {
	font-size: 10px;
}
    </style>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
</head>
<body>
<?
	if(!empty($os)){
		if($os->status_os==1){
			$status='Orçamento';
		}elseif($os->status_os==2){
			$status='Aprovado';
		}elseif($os->status_os==3){
			$status='Entrega';
		}else{
			$status='';
		}

?>

<div id="pagina">
	<?php
    	if(empty($configuracao->img_cabecalho)){
	?>		
   <img id="img_rodape" src="<?=$img_cab?>"/>
    <div id="cabecalho" style="padding:10px">
		
        <div style="clear:both"></div>
        <strong style="text-transform:capitalize;"><?=$empresa[nome]?></strong><br>
		CNPJ: <?=$empresa[cnpj]?>
		<?=$empresa[endereco]?><br>
		<?=$empresa[bairro]?><br>
		<br>
        <br>
    </div>
    <?php
		}else{
    ?> 
    	<img id="img_rodape" src="<?=$img_cab?>" width="100%"/>
	<?php
		}
	?>
    <div class="titulo_os" style=" margin:0px auto; text-align:center; border-bottom:1px solid #999; padding:3px; width:95%;">
     ORDEM DE SERVIÇO - N&deg; <?=$os->numero_sequencial_empresa?>
    </div>
    
  <div id="cliente">
    	
        <div style="float:left;width:400px; padding-left:13px;">
        	<strong>Cliente:</strong>
<?=$os->razao_social?><br>
    		<strong>Tel. Comercial:</strong>
<?=$os->telefone1?><br>
    		<strong>Endereço:</strong>
<?=$os->endereco?><br>
            <strong>Bairro:</strong>
<?=$os->bairro?> 
    		<strong>Cidade:</strong>
<?=$os->cidade?><br>
    		<strong>CPF / CNPJ:</strong>
<?=$os->cnpj_cpf?><br>
    		
        </div>
        
        <div style="float:left;width:450px; padding-left:13px;">
        	<strong>Pessoa p/ Contato:</strong>
<?=$os->nome_contato?><br>
            <strong>Tel. Residencial:</strong>
<?=$os->telefone1?><br>
    		<strong>Insc. Estadual/RG:</strong>
<?=$os->inscricao_estadual." ".$os->rg?><br>
    		<strong>E-mail</strong>:
<?=$os->email?><br>
            
        </div>
        
    </div><!-- Fim #cliente-->
       
    <div class="titulo_os" style="border-top:1px solid #999;margin:0px auto; text-align:center;padding:3px; width:95%;"> INFORMAÇ&Otilde;ES DA OS</div>
    
    <div id="cliente"> <!-- informações da os -->
   
    	<div style="float:left;width:400px; padding-left:15px;">
    		<strong>Descriçao:</strong> <?=$os->descricao?><br>
            <strong>Solicitante:</strong> <?=$os->nome_fantasia?><br>
            <strong>Data de Cadastro:</strong> <?=dataUsaToBr($os->data_cadastro)?><br>
            <strong>Nota Fiscal:</strong> <?=$os->nota_fiscal_servico?><br>
    	</div>
        
        <div style="">
    		<strong>N&deg; de série:</strong> <?=$os->numero_sequencial_empresa?><br>
            <strong>Tel. Solicitante:</strong> <?=$os->telefone1?><br>
            <strong>Entrega:</strong> <?=dataUsatoBr($os->data_entrega)?><br>
            <strong>Data de Emiss&atilde;o:</strong> <?=dataUsatoBr($os->data_cadastro)?><br>
    	</div>        
    </div> <!-- Fim das Informações da O.S -->
    <div class="titulo_os" style="border-top:1px solid #999;margin:0px auto; text-align:center;padding:3px; width:95%;">&nbsp;</div>
    <div style="clear:both; margin-top:10px;"></div>    
        
        <div class="infoclitec">
        <div style="width:95%;float:left; padding-left:13px;  ">
    		<strong>Informaçoes do cliente</strong>
        	<p><?=$os->defeito_reclamado?></p>
    	</div>
        
        <div style="width:95%;float:left; padding-left:13px;">
    		<strong>Informaçoes Técnicas</strong>
        	<p><?=$os->reparo_manutencao?>.</p>
    	</div>
    	</div>
    
    
    <div style="clear:both"></div>
    
    <?php
		if(!empty($configuracao->img_rodape)){
			$tam_servicos = "130mm";
		}else{
			$tam_servicos = "150mm";
		}
	?>
    
    <div id="servicos" style="padding:10px; height:<?=$tam_servicos?>;" >
    	<?
			$os_item_produto=mysql_query($t="SELECT * FROM os_item_produto WHERE os_id=$os->os_id AND vkt_id=$vkt_id");
			if(mysql_num_rows($os_item_produto)>0){
		?>
        <table  width="100%" id="produtos">
        	<tr align="center">
            	<td colspan="6" bgcolor="#CCCCCC" style="font-size:13px"><strong>Produtos</strong></td>
            </tr>
            <tr align="center" bgcolor="#CCCCCC">
              <td style="font-size:12px">Item</td>
            	<td style="font-size:12px">Código</td>
                <td style="font-size:12px; width:430px;">Descriçao do Produto</td>
                <td style="font-size:12px; width:40px;">Qtde.</td>
                <td style="font-size:12px">Valor Unit&aacute;rio</td>
                <td style="font-size:12px">Valor Total</td>
            </tr>
            <?	
             	//$total_produtos=0;
				//$desconto=0;
				//$valor_deslocamento=0;
				//$os_item=mysql_query($t="SELECT * FROM os_item WHERE os_id=$os->os_id and vkt_id=$vkt_id AND status='1'");
										//echo $t;
				while($item=mysql_fetch_object($os_item_produto)){
					$produto=mysql_fetch_object(mysql_query($t="SELECT * FROM produto WHERE id=$item->produto_id"));
					//echo $t;
					//$funcionario=mysql_fetch_object(mysql_query($t="SELECT * FROM rh_funcionario WHERE id=$item->funcionario_id"));
					
					$vlr_total=$item->valor_produto*$item->qtd_produto;
					$ys++;
					echo "<tr>
            			  <td align=\"center\">$ys</td>
							<td style='font-size:12px;padding-left:5px;' align='center' >$item->id</td>
							<td style='font-size:12px;padding-left:5px;'>$produto->nome";
							echo"
							</td>
							<td style='font-size:12px;padding-left:5px;'>$item->qtd_produto</td>
							<td style='font-size:12px;padding-left:5px;'>".moedaUsaToBr($item->valor_produto)."</td>
							<td style='font-size:12px;padding-left:5px;'>".moedaUsaToBr($vlr_total)."</td>
						  </tr>";
						  $total_produtos+=$vlr_total;
						  //$desconto+=$item->desconto;
						  //$valor_deslocamento+=$item->valor_deslocamento;
				}
				$total=$total_produtos+$total_servicos+$valor_deslocamento-$desconto;
			?>
            <tr>
            	<td colspan="5" align="right" style="font-size:11px; padding-right:10px;"><strong>Valor Total dos Serviços</strong></td>
                <td style="font-size:10px; padding-left:5px;"><strong><?=moedaUsaToBr($total_produtos)?></strong></td>
            </tr>
       </table>
       <?
			}
	   ?>
       <div style="margin-top:8px;"></div>
       <table  width="100%" id="produtos">
        	<tr align="center">
            	<td colspan="6" bgcolor="#CCCCCC" style="font-size:13px"><strong>Serviços Executados</strong></td>
            </tr>
            <tr align="center" bgcolor="#CCCCCC">
              <td style="font-size:12px">Item</td>
            	<td style="font-size:12px">Código</td>
                <td style="font-size:12px;width:430px;">Descriçao do Serviço</td>
                <td style="font-size:12px;width:40px;">Qtde.</td>
                <td style="font-size:12px">Valor Unit&aacute;rio</td>
                <td style="font-size:12px">Valor Total</td>
            </tr>
            <?	
             	$total_servicos=0;
				//$desconto=0;
				//$valor_deslocamento=0;
				$os_item=mysql_query($t="SELECT * FROM os_item WHERE os_id=$os->os_id and vkt_id=$vkt_id AND status='1'");
										//echo $t;
				while($item=mysql_fetch_object($os_item)){
					$servico=mysql_fetch_object(mysql_query($t="SELECT * FROM servico WHERE id=$item->servico_id"));
					$funcionario=mysql_fetch_object(mysql_query($t="SELECT * FROM rh_funcionario WHERE id=$item->funcionario_id"));
					//echo $t;
					$vlr_total=$item->valor_servico*$item->qtd_servico;
					$ys++;
					echo "<tr>
            			  <td align=\"center\">$ys</td>
							<td style='font-size:12px;padding-left:5px;' align='center' >$item->id</td>
							<td style='font-size:12px;padding-left:5px;'>$servico->nome";
							/*if(!empty($item->altura_servico)&&!empty($item->largura_servico)){
								echo " - ($item->altura_servico X $item->largura_servico) ".($item->altura_servico * $item->largura_servico)." M2";
							}*/
							echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - $item->obs_item_servico";
							echo"
							</td>
							<td style='font-size:12px;padding-left:5px;'>$item->qtd_servico</td>
							<td style='font-size:12px;padding-left:5px;'>".moedaUsaToBr($item->valor_servico)."</td>
							<td style='font-size:12px;padding-left:5px;'>".moedaUsaToBr($vlr_total)."</td>
						  </tr>";
						  $total_servicos+=$vlr_total;
						  //$desconto+=$item->desconto;
						  $valor_deslocamento+=$item->valor_deslocamento;
				}
				$total=$total_produtos+$total_servicos;
				$desconto = $total*$os->desconto/100;
				
			?>
            <tr>
            	<td colspan="5" align="right" style="font-size:11px; padding-right:10px;"><strong>Valor Total dos Serviços</strong></td>
                <td style="font-size:10px; padding-left:5px;"><strong><?=moedaUsaToBr($total_servicos)?></strong></td>
            </tr>
            <tr>
                <td colspan="6" align="center">
                <pre>
                <font size="1" face="Verdana, Geneva, sans-serif">
                É de responsabilidade do cliente a regularização nos órgão públicos(IMPLURB) e pelo ponto de elétrica próximo ao local da
                instalação de placas back light e front light
                </font>
                </pre>
                </td>
            </tr>
       </table>
       <div style="margin-top:20px;"></div>
       <div  style="border:1px solid #666; margin:0 auto; padding:8px; font-family:Arial, Helvetica, sans-serif; font-size:10pt;">
       		 <p align="justify;"><?=$configuracao->texto_adicional;?></p>
       </div>
             
</div>
	<div class="rodape" style=" font-family:Arial, Helvetica, sans-serif;font-size:9pt; border:0px solid #999">
                <div class="ass" style="border:0px solid #999;">
                	<div style="margin-top:8px;"></div>
                    <div style="text-align:center; width:220px; border-top:1px solid #666;">Assinatura do T&eacute;cnico</div>
                    <div style="margin-top:19px;"></div>
                    <div style="text-align:center;width:220px; border-top:1px solid #666;">Assinatura do Cliente</div>
                
                </div>
                
                <div class="valFinal" style="border:1px solid #999;">
                	<div style="width:130px; border-right:1px solid #CCC;">
                    	<div>Total Produto: 
                    		<span>
						  <?php 
                              if(!empty($total_produtos)){
                                  echo moedaUsatoBr($total_produtos);	
                              }else{
                                  echo "0,00";
                              }	
                          ?>
                         </span>
                       </div>
                      <div>Total Serviço:
                          <span>
                              <?php
                                  if(!empty($total_servicos)){
                                      echo moedaUsatoBr($total_servicos);
                                  } else{
                                      echo "0,00";
                                  }
                              ?>
                          </span>
                        </div>
                      <div><strong>Subtotal:</strong> <span><?=moedaUsaToBr($total)?></span></div>
                   </div> <!-- fim-->
                   <div style="width:130px; border-right:1px solid #CCC;">
                   <div>Desconto: 
                    	<span>
						<?php
							//$porcentDesconto = ($os->desconto / 100);
							$descontoValor   =  $porcentDesconto * $total; 
								if(!empty($os->desconto)){
									echo moedaUsaToBr($os->desconto);
								} else{
									echo "0,00";
								}
						?>
                       </span>
                   </div>
                   <div>Acr&eacute;scimo: 
                    	<span>
						<?php 
								if(!empty($os->acrescimo)){
									echo moedaUsaToBr($os->acrescimo);
								} else{
									echo "0,00";
								}
						?>
                        </span>
                    </div>
                	
                	<div><strong>Total:</strong>
                    <span><?php echo moedaUsaToBr($total - $os->desconto + $os->acrescimo);?></span></div> 
                </div><!-- fim-->
                
                <div>
                	<div> 
                    	<strong>Forma de Pagamento:</strong><br/>
                        	<?php
							// 0, 1=dinheiro,2=cheque,3=cartao,4=boleto,5=permuta,6=Transferência,7=Outros
                            	$formaPagamento = mysql_fetch_object(mysql_query(" SELECT * FROM  financeiro_movimento WHERE doc = ".$os->os_id." AND cliente_id = $vkt_id "));
								$parcelas = mysql_fetch_object(mysql_query($y="SELECT COUNT(id) AS qtdParcelaOS FROM financeiro_movimento WHERE doc = '".$reg_os->id."' AND cliente_id = '$vkt_id' AND internauta_id = '".$reg_os->cliente_id."'"));
								echo $formaPagamento->id;
								if($formaPagamento->id>0){
									
									$forma_pagamento = $os->forma_pagamento;
									$qtd_parcelas    = $os->qtd_parcelas_resumo;
								}else{
									
									$forma_pagamento = $formaPagamento->forma_pagamento;
									$qtd_parcelas    = $parcelas->qtdParcelaOS;
								}
								
								echo $qtd_parcelas;
								
								if($qtd_parcelas<=1){
									$qtd_parcelas=1;
								}
								
								$valor_parcela = $os->valor_total/$qtd_parcelas;
								$valor_parcela = MoedaUsaToBr($valor_parcela);
							?>
                        	<div>
								<?php
                            			if($forma_pagamento == '1')
											$fp="Dinheiro";
										if($forma_pagamento == '2')
											$fp="Cheque";
										if($forma_pagamento == '3')
											$fp="Cart&atilde;o";
										if($forma_pagamento == '4')
											$fp="Boleto";
										if($forma_pagamento == '5')
											$fp="Permuta";
										if($forma_pagamento == '6')
											$fp="Outros";
										if($forma_pagamento == '8'){$fp='Depósito';}	
								
									if($qtd_parcelas>1){ echo "$qtd_parcelas X no(a) $fp, com parcelas no valor de R$ $valor_parcela";}else{ echo "A Vista";}
								?> 
                            </div> 
                    </div>
                </div> <!-- fim-->
                
             </div> <!-- fim de valFinal -->              
	  </div>

	<?php
    	if(!empty($configuracao->img_rodape)){
	?>	
		<img id="img_rodape" src="<?=$img_r?>" width="100%"/>
    <?php
		}
	?>
</div>

<?php
	}
	else{
		echo "OS NAO EXISTE";
	}
?>
</body>
</html>