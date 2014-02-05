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
} /*fim da funcao*/
if($vkt_id == '1'){
	$logo="../../../../fontes/img/vekttor.png";
}else{
	$logo="../../../../sis/modulos/vekttor/clientes/img/".$vkt_id.".png";
}

$locacao=mysql_fetch_object(mysql_query($t="SELECT *,
												al.id as al_id,
												cf.id as cli_id												
											FROM 
												aluguel_locacao al,
												cliente_fornecedor cf 
											WHERE
												al.cliente_id=cf.id
												AND	al.id='".$_GET[id]."' 
												AND al.vkt_id='".$vkt_id."'"));

												
$configuracao = mysql_fetch_object(mysql_query("SELECT * FROM aluguel_configuracao WHERE id='$vkt_id'"));
if(empty($configuracao->img_cabecalho)){
	$img_cab = $logo;
}else{
	$img_cab = "../../../modulos/aluguel/configuracao/img/".$vkt_id."_c.".$configuracao->img_cabecalho;
	//echo $img_cab;
}
if(empty($configuracao->img_rodape)){
	$img_r = $logo;
}else{
	$img_r = $img_r="../../../modulos/aluguel/configuracao/img/".$vkt_id."_r.".$configuracao->img_rodape;
}

if(!empty($_GET['email'])){
	if(!empty($configuracao->img_cabecalho)){
		$img_cab = "http://vkt.srv.br/~nv/sis/modulos/aluguel/configuracao/img/".$vkt_id."_c.".$configuracao->img_cabecalho;
		$img_r="http://vkt.srv.br/~nv/sis/modulos/aluguel/configuracao/img/".$vkt_id."_r.".$configuracao->img_rodape;
	}else{
		$img_cab = "http://vkt.srv.br/~nv/fontes/img/".$vkt_id.".png";
	}
}
?>
<html>
<head>
   	<title>ORÇAMENTO DE ALUGUEL</title>
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
			border-style:solid 1px;
			padding-left:13px;
			
	}
	#servicos table tr td{
		border-collapse:collapse;
		border-style:solid 1px;
		
	}
    </style>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
</head>
<body>
<?
	if(!empty($locacao)){
?>

<div id="pagina">
	<?php
    	if(empty($configuracao->img_cabecalho)){
	?>		
   <img id="img_rodape" src="<?=$img_cab?>"/>
    <div id="cabecalho" style="padding:10px">
		
        <div style="clear:both"></div>
        <strong style="text-transform:capitalize;"><?=$empresa[nome]?></strong><br>
		CNPJ: <?=$empresa[cnpj]?><br>
		Endereço: <?=$empresa[endereco]?><br>
		Bairro: <?=$empresa[bairro]?><br>
		Cidade: <?=$empresa[cidade]?><br>
        Estado: <?=$empresa[estado]?><br>
        CEP: <?=$empresa[cep]?><br>
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
        Manaus, <?=substr($locacao->data_locacao,8,2)?> de <?=mes(substr($locacao->data_locacao,5,2))?> de <?=substr($locacao->data_locacao,0,4)?>
        <div style="clear:both"></div>
        <font size="1"><strong> Orc. nº <?=$locacao->al_id?></strong></font>
    </div>
    
  <div id="cliente">
    	
        	
            À<div style="clear:both"></div> 
            <?=$locacao->razao_social?><div style="clear:both"></div>
            A/C <?=$locacao->nome_contato?>
              
       
               
    </div>    
    
    <div style="clear:both"></div>
    
    <div id="servicos" align="center">
    	<?
			$locacao_item=mysql_query($t="SELECT * FROM aluguel_locacao_itens WHERE locacao_id='$locacao->al_id' AND vkt_id='$vkt_id'");
			$equipamento_id = array();
			$c=0;
				while($item=mysql_fetch_object($locacao_item)){
				$equipamento = mysql_fetch_object(mysql_query($t="SELECT ae.id as eq_id FROM 
																aluguel_equipamentos ae,
																aluguel_equipamentos_itens aei 
			 													WHERE 
																ae.id=aei.equipamento_id AND 
																aei.id = $item->item_equipamento_id AND
																ae.vkt_id='$vkt_id'"));
				
				if(!in_array($equipamento->eq_id,$equipamento_id)){
					$equipamento_id[$c] = $equipamento->eq_id;
					$c++;
				}
				
			}
			unset($c);
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
				$total_locacao = 0;
				//conta itens
				$num_it = 0;
				foreach($equipamento_id as $equipamento){
					$eq=mysql_fetch_object(mysql_query($t="SELECT * FROM aluguel_equipamentos WHERE id='$equipamento' AND vkt_id='$vkt_id'"));			
					//echo $t;
					$eq_itens_locacao=(mysql_query($t="SELECT * FROM  
						aluguel_locacao_itens ali,
						aluguel_equipamentos_itens aei
						WHERE 
						ali.item_equipamento_id=aei.id
						AND aei.equipamento_id='$equipamento'		   
						AND ali.locacao_id='".$_GET['id']."'
						AND ali.vkt_id='$vkt_id'
					"));
					$qtd_dias_locacao = mysql_fetch_object(mysql_query("SELECT DATEDIFF('$locacao->data_devolucao','$locacao->data_locacao')as dias"));
					//echo "Periodo: ".$eq->id;
					$valor = (($eq->vlr_aluguel*$qtd_dias_locacao->dias)/$eq->periodo)*mysql_num_rows($eq_itens_locacao);
					$total_locacao+=$valor;
					
			?>
             <tr>
            	<td style="font-size:13px"><?=++$num_it;?></td>
                <td style="font-size:13px"><?=$eq->id?></td>
                <td style="font-size:13px" colspan="1"><?=$eq->descricao?></td>
                <td style="font-size:13px"><?=mysql_num_rows($eq_itens_locacao)?></td>
                <td style="font-size:13px"><?=MoedaUsaToBr($eq->vlr_aluguel)."/".($eq->periodo)?> dia(s)</td>
                <td style="font-size:13px"><?=MoedaUsaToBr($valor)?></td>
                
         
            <?
				}
				$parcelas = mysql_fetch_object(mysql_query($t="SELECT * FROM aluguel_pagamento_parcela WHERE locacao_id = '".$locacao->al_id."' AND vkt_id = '$vkt_id'"));
				//echo $t;
				$qtd_parcelas = mysql_fetch_object(mysql_query($t=" SELECT COUNT(*) as qtd FROM aluguel_pagamento_parcela WHERE locacao_id = '".$locacao->al_id."' AND vkt_id = '$vkt_id'"));
				//echo $t;
				
				if($locacao->forma_pagamento == '1'){$fp='Dinheiro';}
				if($locacao->forma_pagamento == '2'){$fp='Cheque';}
				if($locacao->forma_pagamento == '3'){$fp='Cartão de Crédito';}
				if($locacao->forma_pagamento == '4'){$fp='Boleto';}
				if($locacao->forma_pagamento == '5'){$fp='Permuta';}
				if($locacao->forma_pagamento == '6'){$fp='Transferência';}
				if($locacao->forma_pagamento == '7'){$fp='Outros';}					
			?>
            <tr>
            	<td colspan="6" align="center" style="font-size:13px; padding-right:10px;">
                	<strong>Valor Total da Locação: </strong><?=moedaUsaToBr($total_locacao)?><br>
                    
                    <strong>Forma de Pagamento: </strong><?=$qtd_parcelas->qtd."x no(a) ".$fp." - Valor Parcela: R$ ".MoedaUsaToBr($parcelas->valor_parcela);?><br>
                    
                    <strong>Período: </strong><?=$qtd_dias_locacao->dias?> dia(s)<br>
                    <strong>Validade da Proposta: </strong>7 dias após recebimento
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