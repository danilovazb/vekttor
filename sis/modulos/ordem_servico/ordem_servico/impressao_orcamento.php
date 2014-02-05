<?php
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
global $vkt_id;
	if(!empty($_GET['vkt_id'])){
			$vkt_id = $_GET['vkt_id'];
	}
function mes($mes){
	switch($mes){
		case 1: echo "Janeiro";break;
		case 2: echo "Fevereiro";break;
		case 3: echo "Março";break;
		case 4: echo "Abril";break;
		case 5: echo "Maio";break;
		case 6: echo "Junho";break;
		case 7: echo "Julho";break;
		case 8: echo "Agosto";break;
		case 9: echo "Setembro";break;
		case 10: echo "Outubro";break;
		case 11: echo "Novembro";break;
		case 12: echo "Dezembro";break;
		
	}
}
if($vkt_id==1){
	$logo="../../../../fontes/img/vekttor.png";
}else{
	$logo="../../../modulos/vekttor/clientes/img/".$vkt_id.".png";
}
$os=mysql_fetch_object(mysql_query($t="SELECT *,os.id as os_id, cf.id as cli_id FROM os,
									cliente_fornecedor cf
									WHERE cf.id=os.cliente_id
									AND os.id=".$_GET['id']." AND os.vkt_id=$vkt_id"));
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

if(!empty($_GET['email'])){
	if(!empty($configuracao->img_cabecalho)){
		$img_cab = "http://vkt.srv.br/~nv/sis/modulos/ordem_servico/configuracao/img/".$vkt_id."_c.".$configuracao->img_cabecalho;
		$img_r="http://vkt.srv.br/~nv/sis/modulos/ordem_servico/configuracao/img/".$vkt_id."_r.".$configuracao->img_rodape;
	}else{
		$img_cab = "http://vkt.srv.br/~nv/fontes/img/".$vkt_id.".png";
	}
}
?>
<html>
<head>
   	<title>ORDEM DE SERVIÇO</title>
    <style>
	
	body{ font-family:Verdana, Geneva, sans-serif; font-size: 12px;}
	table tr td {font-family:Tahoma, Geneva, sans-serif; border:1px solid #333;}
	#pagina{
		/*border:1px solid #000;*/
		width:840px;
		margin:0px auto;
					
	}
	#cliente{
		margin-top:70px;
		font-weight:bolder;
		margin-left:30px;
		height:60px;
	}
	#servicos{
		height:750px;
		
	}
	#produtos{
			border-collapse:collapse;
			border-style:solid 1px;;
			padding-left:13px;
			
	}
	#servicos table tr td{
		border-collapse:collapse;
		border-style:solid 1px;;
	}
    </style>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
</head>
<body>
<?
	if(!empty($os)){
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
    <div class="titulo_os" style=" margin:0px auto; text-align:right; padding:3px; width:95%;">
        Manaus, <?=substr($os->data_cadastro,8,2)?> de <?=mes(substr($os->data_cadastro,5,2))?> de <?=substr($os->data_cadastro,0,4)?>
        <div style="clear:both"></div>
        <!--<font size="1"><strong> Orc. nº <?=$os->numero_sequencial_empresa?></strong></font>-->
    </div>
    
  <div id="cliente">
    	
        	
            À<div style="clear:both"></div> 
            <?=$os->razao_social?><div style="clear:both"></div>
            A/C <?=$os->nome_contato?>
              
       
               
    </div>    
    
    <div style="clear:both"></div>
    
    <div id="servicos" align="center">
    	<?
			$os_item=mysql_query($t="SELECT * FROM os_item WHERE os_id=$os->os_id AND produto_id!=0 AND vkt_id=$vkt_id");
		?>
        <div style="font-size:10px;height:25px;">Apresentamos conforme Vossa Solicitação orçamento para prestação de serviços como abaixo apresentado:</div>
        <table  width="100%" id="produtos">
        	<tr align="center">
            	<td colspan="6" bgcolor="#CCCCCC" style="font-size:14px"><strong>Serviços Executados</strong></td>
            </tr>
            <tr align="center" bgcolor="#CCCCCC">
              <td style="font-size:13px"><strong>Item</strong></td>
            	<td style="font-size:13px"><strong>Código</strong></td>
                <td style="font-size:13px"><strong>Descriçao do Serviço</strong></td>
                <td style="font-size:13px"><strong>Qtde.</strong></td>
                <td style="font-size:13px"><strong>Valor Unit&aacute;rio</strong></td>
                <td style="font-size:13px"><strong>Valor Total</strong></td>
            </tr>
            <?	
             	$total_servicos=0;
				$desconto=0;
				$valor_deslocamento=0;
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
							if(!empty($item->obs_item_servico)){
								echo "<div style='clear:both'>- $item->obs_item_servico</div>";
							}
							echo"
							</td>
							<td style='font-size:12px;padding-left:5px;'>$item->qtd_servico</td>
							<td style='font-size:12px;padding-left:5px;'>".moedaUsaToBr($item->valor_servico)."</td>
							<td style='font-size:12px;padding-left:5px;'>".moedaUsaToBr($vlr_total)."</td>
						  </tr>";
						  $total_servicos+=$vlr_total;
						  $desconto+=$item->desconto;
						  $valor_deslocamento+=$item->valor_deslocamento;
				}
				$total=$total_produtos+$total_servicos+$valor_deslocamento-$desconto;
				$qtd_dias_os = mysql_fetch_object(mysql_query("SELECT DATEDIFF('$os->data_entrega','$os->data_cadastro')as dias"));
				$formaPagamento = mysql_fetch_object(mysql_query($t=" SELECT * FROM financeiro_movimento WHERE doc = '".$os->os_id."' AND cliente_id = '$vkt_id' AND internauta_id = '".$os->cli_id."'"));
				$parcelas = mysql_fetch_object(mysql_query($y="SELECT COUNT(id) AS qtdParcelaOS FROM financeiro_movimento WHERE doc = '".$os->os_id."' AND cliente_id = '$vkt_id'"));
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
				
				$sqlFP =  mysql_fetch_object(mysql_query(" SELECT * FROM financeiro_formas_pagamento WHERE vkt_id = '$vkt_id' AND id = '$forma_pagamento' "));
				$fp = $sqlFP->nome;
				
			?>
            <tr>
            	<td colspan="6" align="center" style="font-size:13px; padding-right:10px;">
                	
                   	<?php
						$total_produtos = mysql_fetch_object(mysql_query($t="SELECT SUM(valor_produto) as total_produto FROM os_item_produto WHERE os_id=$os->os_id"));
						//echo $t;
						$desconto = ($total_produtos->total_produto+$total_servicos)*$os->desconto/100;
					?>
                     
                    <strong>Sub-Total: </strong><?php echo moedaUsaToBr($total_produtos->total_produto+$total_servicos);?><br>
                    
                    <?php
					if($os->desconto>0){
						$desconto_porcentagem = $os->desconto*100/($total_produtos->total_produto+$total_servicos);
						
						echo "<strong>Desconto: </strong>".moedaUsaToBr($desconto_porcentagem)." %<br>";
					}
					if($os->acrescimo>0){
					    echo "<strong>Acréscimo: </strong>".moedaUsaToBr($os->acrescimo)."<br>";
					}
					?>
                    <strong>Total: </strong><?php echo moedaUsaToBr($total_produtos->total_produto+$total_servicos-$os->desconto+$os->acrescimo);?><br>
                    
                    <? 
						if($qtd_parcelas>=1){ echo "<strong>Forma de Pagamento: </strong> $fp <br> <strong>Parcelas: </strong> $qtd_parcelas <br>";}?>
                    
                    <strong>Prazo para Entrega: </strong><?=$qtd_dias_os->dias?> dia(s)<br>
                    <strong>Validade da Proposta: </strong>7 dias após recebimento
                    <br>
                    <strong>Observação: </strong><?=$os->os_obs?>
                 </td>
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