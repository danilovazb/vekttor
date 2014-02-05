<?php
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");

if($vkt_id==1){
	$logo="../../../../fontes/img/vekttor.png";
}else{
	$logo="../../../modulos/vekttor/clientes/img/".$vkt_id.".png";
}
$os=mysql_fetch_object(mysql_query($t=" SELECT *,os.id as os_id, os.usuario_id as os_usuario_id FROM os , cliente_fornecedor cf WHERE cf.id=os.cliente_id AND os.id=".$_GET['id']." AND os.vkt_id=$vkt_id "));
									//echo $t;
$vendedor = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$os->vendedor_id'"));
$user  = mysql_fetch_object(mysql_query("SELECT * FROM usuario WHERE id='$os->os_usuario_id'"));
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
*{margin:0px; padding:0px}
table#table-equipamento{margin-bottom:10px}
table#table-equipamento td{border:0; font-size:12px}
.header{margin-bottom:8px; text-align:center; font-weight:bold; font-size:11pt; font-family:Arial,Helvetica,sans-serif}
a:link, a:visited{color:#333; text-decoration:underline}
table tr td{font-family:Tahoma,Geneva,sans-serif; border:1px solid #333}
table tr th{font-size:9pt}
hr{margin-top:8px; margin-bottom:8px; border:0; border-top:1px solid #ccc}
.col{float:left; width:45%; border:0px solid #000}
.info{font-size:10pt; padding:3px 13px; line-height:23px; font-family:arial,sans-serif}
#pagina{border:0px solid #999; width:210mm; height:297mm; margin:0px auto}
#cabecalho{height:75px; font-family:Tahoma,Geneva,sans-serif; font-size:14px; margin-top:10px}
#cliente, #info_os{font-size:10px; padding:4px}
#cliente{display:inline-block; width:100%}
.produtos{border-collapse:collapse; border-style:solid 1px}
#ordem_producao{margin-top:15px}
.rodape{width:100%}
.rodape div{width:140px; border:0px solid #999; text-align:right; padding:1px; margin-top:5px}
.rodape .valFinal{float:left; width:500px}
.rodape .valFinal div{text-align:left; float:left}
.rodape .ass{float:right; padding-right:40px; width:185px}
.rodape .linha{border-bottom:1px solid #999; width:200px; padding-top:10px; padding-bottom:10px}

#rodapea, #rodapeb{font-weight:500}
.infoclitec strong{font-family:Arial,Helvetica,sans-serif; font-size:11px; padding-left:15px}
.infoclitec p{font-family:Arial,Helvetica,sans-serif; font-size:10px; padding-left:15px}
.titulo_os{font-family:Arial,Helvetica,sans-serif; font-weight:bold}
.titulo_os_info{font-family:Arial,Helvetica,sans-serif; text-align:center; width:95%; border-top:1px solid #999; padding:4px}
body, td, th{font-size:10px}
#layout{ width:100%;  margin:0 auto 0 auto}
#texto_adicional{ width:450px;  float:left;  margin-top:3px;  float:right;  height:200px;  margin-right:15px}
#dados_os{ margin-top:5px;  width:100%;  height:530px;  float:left}
#impressao, #recorte{ width:280px;  float:left}
.titulo{ width:250px;  padding:2px;  border-radius:10px;  color:white;  text-align:center;  background-color:#000}
.conteudo_dados_os{margin-top:3%}
.opcao_impressao{ min-width:80px;  float:left;  margin-left:10px;  margin-bottom:2px}
.checkbox{ float:left;  border:solid 2px #000;  width:10px;  height:10px;  border-radius:4px}
#impressao, #impresso{ height:80px}
#titulo_impresso, #titulo_producao{ text-align:left;  font-size:15px;  font-weight:bold}
#impressao, #impresso{ margin-top:1%}
#observacoes{ width:100%}
#boxassinaturas{ width:100%;  margin-top:35px;  padding-left:40px}
.assinatura{ text-align:center;   float:left}
#img_rodape{margin-bottom:18px}

</style>
<script src="../../../../fontes/js/jquery.min.js"></script>	
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
    <!--<div class="titulo_os" style=" margin:0px auto; text-align:center; border-bottom:1px solid #999; padding:3px; width:95%;">
     ORDEM DE SERVIÇO - N&deg; <?=$os->numero_sequencial_empresa?>
    </div>-->
    <div class="header"> INFORMAÇ&Otilde;ES DO CLIENTE</div>
  	<div id="cliente">
        <div class="col info">
        	<strong>Cliente:</strong> <?=$os->razao_social?><br>
    		<strong>Tel. Comercial:</strong> <?=$os->telefone1?><br>
    		<strong>Endereço:</strong> <?=$os->endereco?><br>
            <strong>Bairro:</strong> <?=$os->bairro?> 
    		<strong>Cidade:</strong> <?=$os->cidade0?><br>
    		<strong>CEP:</strong> <?=$os->cep?><br>
        </div>
        <div class="col info">
        	 <strong>CPF / CNPJ:</strong> <?=$os->cnpj_cpf?><br>
            <strong>Pessoa p/ Contato:</strong> <?=$os->nome_contato?><br>
            <strong>Tel. Residencial:</strong> <?=$os->telefone1?><br>
    		<strong>Insc. Estadual/RG:</strong> <?=$os->inscricao_estadual." ".$os->rg?><br>
    		<strong>E-mail</strong>: <?=$os->email?><br>
        </div>    
    </div><!--/.cliente -->
    
    <hr>
     
    <div class="header"> INFORMAÇ&Otilde;ES DA OS</div>
    <div id="cliente">
      <div class="col info">
        <strong>Descriçao:</strong> <?=$os->descricao?><br>
        <strong>Solicitante:</strong> <?=$os->nome_fantasia?><br>
        <strong>Vendedor:</strong> <?=$vendedor->nome?><br>
        <strong>Atendente:</strong> <? if($user->id>0){ echo $user->nome;}?><br>
        <strong>Data de Cadastro:</strong> <?=dataUsaToBr($os->data_cadastro)?><br>
      </div>    
      <div class="col info">
        <strong>N&deg; de série:</strong> <?=$os->numero_sequencial_empresa?><br>
        <strong>Tel. Solicitante:</strong> <?=$os->telefone1?><br>
        <strong>Entrega:</strong> <?=dataUsatoBr($os->data_entrega)?><br>
        <strong>Data de Emiss&atilde;o:</strong> <?=dataUsatoBr($os->data_cadastro)?><br> 
        <strong>Nota Fiscal:</strong> <?=$os->nota_fiscal_servico?><br>   
      </div>
    </div> <!--/.info_os -->
    
    <hr>
    
    <?php
    	$sqlEquipamento = mysql_query(" SELECT *,DATE_FORMAT(data_cadastro, '%d/%m/%Y') AS dataCadastro FROM os_has_equipamento WHERE os_id = ".trim($_GET['id'])." GROUP BY equipamento_id ");
	   if(mysql_num_rows($sqlEquipamento) > 0){
	?>
    <div class="header"> EQUIPAMENTO </div>
    
    <div class="info">
	  <?php 
          
		 while($equipamentoItem=mysql_fetch_object($sqlEquipamento)){
			 $equipamento = mysql_fetch_object(mysql_query(" SELECT * FROM os_equipamento WHERE id = '".$equipamentoItem->equipamento_id."' "));
      ?>
          
        <strong>Equipamento:</strong> <?=$equipamento->nome?><br>
        <strong>Numero de Série:</strong> <?=$equipamento->numero_serie?><br>
        <strong>Marca:</strong> <?=$equipamento->marca?><br>
        <strong>Marca:</strong> <?=$equipamento->modelo?><br>
        <table id="table-equipamento" style="width:100%;">
        	<thead>
              <tr>
            	<th style="width:200px;text-align:left;">Solicitação / Defeito</th>
                <th style="width:200px;text-align:left;">Diagnóstico / Laudo</th>
                <th style="width:200px;text-align:left;">Estado Equipamento</th>
                <th style="width:90px;text-align:left;">Data</th>
              </tr>
            </thead>
            <tbody>
             <tr >
            	<td style="width:200px;text-align:left;"><?=$equipamentoItem->solicitacao_defeito?></td>
                <td style="width:200px;text-align:left;"><?=$equipamentoItem->diagnostico_laudo?></td>
                <td style="width:200px;text-align:left;"><?=$equipamentoItem->estado_equipamento?></td>
                <td style="width:90px;text-align:left;"><?=$equipamentoItem->dataCadastro?></td>
              </tr>
            </tbody>
        </table> 
        <? } ?>   
    </div>
    <div style="clear:both"></div>
    <hr>
    <? } ?>
  
        <div class="infoclitec">
        <div style="width:95%;float:left; padding-left:13px;  ">
    		<strong>Informaçoes do cliente</strong>
        	<p><?=$os->defeito_reclamado?></p>
    	</div>
        
        <div style="clear:both"></div>
        
        <div style="width:95%;float:left; padding-left:13px;">
    		<strong>Informaçoes Técnicas</strong>
        	<p><?=$os->reparo_manutencao?>.</p>
    	</div>
    	</div>
    
    
    <div style="clear:both"></div>
    
    <?php
		/*if(!empty($configuracao->img_rodape)){
			$tam_servicos = "145mm";
		}else{
			$tam_servicos = "170mm";
		}*/
	?>
    
    <div id="conteudo">
    	<div id="servicos" style="padding:1px;" >
    		<?
				$os_item_produto=mysql_query($t="SELECT * FROM os_item_produto WHERE os_id=$os->os_id AND vkt_id=$vkt_id");
				if(mysql_num_rows($os_item_produto)>0){
			?>
        	<table  width="100%" class="produtos">
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
       </div><!-- fim servicos -->
       
       
       
       <div style="margin-top:3px;"></div>
       <table  width="100%" class="produtos">
        	<tr align="center">
            	<td colspan="8" bgcolor="#CCCCCC" style="font-size:13px"><strong>Serviços Executados</strong></td>
            </tr>
            <tr align="center" bgcolor="#CCCCCC">
              <td style="font-size:12px">Item</td>
            	<td style="font-size:12px">Código</td>
                <td style="font-size:12px;width:250px;">Descriçao do Serviço</td>
                <td style="font-size:12px;width:160px;">Nome do Arquivo</td>
                <td style="font-size:12px;width:30px;">Medida</td>
                <td style="font-size:12px;width:40px;">Qtde.</td>
                <td style="font-size:12px">VLR Unit&aacute;rio</td>
                <td style="font-size:12px">VLR Total</td>
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
							<td style='font-size:12px;width:100px;padding-left:5px;'>$item->obs_item_producao</td>
							 <td style='font-size:12px;width:100px;padding-left:5px;'>$servico->und</td>
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
            	<td colspan="7" align="right" style="font-size:11px; padding-right:10px;"><strong>Valor Total dos Serviços</strong></td>
                <td style="font-size:10px; padding-left:5px;"><strong><?=moedaUsaToBr($total_servicos)?></strong></td>
            </tr>
            <tr>
                <td colspan="8" align="center" height="5">
                <pre>
                <font size="1" face="Verdana, Geneva, sans-serif">
                É de responsabilidade do cliente a regularização nos órgão públicos(IMPLURB) e pelo ponto de elétrica próximo ao local da
                instalação de placas back light e front light
                </font>
                </pre>
                </td>
            </tr>
       </table>
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
                   <div>Desconto: <span>
						<?php
							$descontoValor   =  $porcentDesconto * $total; 
								if(!empty($os->desconto))
									echo moedaUsaToBr($os->desconto);
								 else
									echo "0,00";
								
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
                
               
                	<div style="width:200px; margin:3px 4px;"> 
                        	<?php
                            	$formaPagamento = mysql_fetch_object(mysql_query(" SELECT * FROM  financeiro_movimento WHERE doc = ".$os->os_id." AND cliente_id = $vkt_id "));
								$parcelas = mysql_fetch_object(mysql_query($y="SELECT COUNT(id) AS qtdParcelaOS FROM financeiro_movimento WHERE doc = '".$os->os_id."' AND cliente_id = '$vkt_id'"));
								$proximas_parcelas = mysql_query($y="SELECT data_vencimento,valor_cadastro FROM financeiro_movimento WHERE doc = '".$os->os_id."' AND cliente_id = '$vkt_id' AND status='0'");
								if(!$formaPagamento->id>0){
									
									$forma_pagamento = $os->forma_pagamento_resumo;
									$qtd_parcelas    = $os->qtd_parcelas_resumo;
								}else{
									
									$forma_pagamento = $formaPagamento->forma_pagamento_resumo;
									$qtd_parcelas    = $parcelas->qtdParcelaOS;
								}
								
								if($qtd_parcelas<=1){
									$qtd_parcelas=1;
								}
								
								
								$valor_parcela = $os->valor_total/$qtd_parcelas;
								$valor_parcela = MoedaUsaToBr($valor_parcela);
							?>
                        	<div>
                            	
								<?php
                            			
										$sqlFP =  mysql_fetch_object(mysql_query(" SELECT * FROM financeiro_formas_pagamento WHERE vkt_id = '$vkt_id' AND id = '$forma_pagamento' "));
										$fp = $sqlFP->nome;
										
									echo "Forma Pagamento: <i>$fp</i><br> Parcelas:  <i>$qtd_parcelas</i> <br>";
									echo "<strong>Próximas Parcelas: </strong>";
									while($proxima_parcela = mysql_fetch_object($proximas_parcelas)){
									
										echo "<h6 style='margin-left:10px;'>".DataUsaToBr($proxima_parcela->data_vencimento)." -  ".MoedaUsaToBr($proxima_parcela->valor_cadastro)."</h6><div style='clear:both'></div>";
										
									}
								?> 
                            </div> 
                </div> <!-- fim-->
                
             </div> <!-- fim de valFinal -->              
	  	</div>
      </div><!-- fim conteudo-->
      
      <div style="clear:both"></div>
      
      <!--<div style="margin-top:100px; border-top:1px solid #000;margin:0px auto; text-align:center;padding:1px; width:100%;"></div>-->      
       <? if( $vkt_id == 185 ) { ?>
       <table class="produtos" width="100%" id="ordem_producao">
        	<tr align="center">
            	<td colspan="8" bgcolor="#CCCCCC" style="font-size:13px"><strong>Ordem de Produção</strong></td>
            </tr>
            <tr>
            	<td>Mídia com Gramatura</td>
                <td>Medida</td>
                <td>Quantidade</td>
                <td>Nome do Arquivo</td>                
            </tr>
            <?php
				$servicos = mysql_query($t="SELECT * FROM os_item os_i, servico s WHERE os_i.servico_id = s.id AND os_i.os_id='$os->os_id'");
				while($servico = mysql_fetch_object($servicos)){
					$s = mysql_fetch_object(mysql_query($t="SELECT * FROM servico WHERE id='$servico->servico_id'"));
			?>
            <tr>
            	<td><?=$servico->nome?></td>
                <td><?=$servico->und?></td>
                <td><?=$servico->qtd_servico?></td>
                <td style="font-size:8px;"><?=$servico->obs_item_producao?></td>                
            </tr>
            <?
				}
			?>
        </table>
       <? } ?>
       <div id="dados_os">
       
               
        <div id="layout">
        <?php
			if(is_file("../../../upload/ordem_servico/arquivos_modelos/".$os->os_id.".".$os->extensao_img)){
		?>
    		<img src="../../../upload/ordem_servico/arquivos_modelos/<?=$os->os_id.".".$os->extensao_img?>" width="100%"/>
    	<?php
			}
		?>
        </div>        
        
        
                    
       
            
    	
    
    </div>
     <div style="clear:both"></div>            
	<?php
    	if(!empty($configuracao->img_rodape)){
	?>	
		<img src="<?=$img_r?>" width="100%" height="60"/>
    <?php
		}
	?>	
             
</div>
	
    <div style="clear:both"></div>

	
</div>

<?php
	}
	else{
		echo "OS NAO EXISTE";
	}
?>
</body>
</html>