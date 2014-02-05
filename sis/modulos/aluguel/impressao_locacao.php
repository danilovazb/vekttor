<?php
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
global $vkt_id;
if($vkt_id==1){
	$logo="../../../../fontes/img/vekttor.png";
}else{
	$logo="modulos/vekttor/clientes/img/".$vkt_id.".png";
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
												AND al.vkt_id='$vkt_id'"));
?>
<html>
<head>
   	<title>Loca&ccedil;&atilde;o</title>
    <style>
	*{ margin:0px ; padding:0px;}
	a:link, a:visited	{color: #333; text-decoration: underline;}
	a[href]:after		{content: " (" attr(href) ")";}
	body{ background:#999999;}
	table tr td {font-family:Tahoma, Geneva, sans-serif; border:1px solid #333;}
		#pagina{
			border:1px solid #000;
			width:840px;
			height:29cm;
			background:#FFFFFF;
			margin:0px auto;
			box-shadow:2px 1px 2px #333333;
		}
		#os{font-family:Tahoma, Geneva, sans-serif;font-size:11pt;}
		#cabecalho{
			/*border-bottom:solid 1px;*/
			height:75px;
			font-family:Tahoma, Geneva, sans-serif;
			font-size:14px;
		}
		#cliente{
			/*border-bottom:1px solid #666;*/
			width:880px;
			height:100px;
			font-family:Tahoma, Geneva, sans-serif;
			font-size:11pt;
			padding:10px;
		}
		#produtos{
			border-collapse:collapse;
			border-style:solid ;
			padding-left:13px;
			margin-left:18px;
		}
		#produtos tr td{ 
			/*border:solid 1px;*/
		}
		#rodape{
			width:780px;
			font-family:Tahoma, Geneva, sans-serif;
			font-size:10pt;
			margin-left:auto;
			margin-right:auto;
			vertical-align:text-bottom;
			padding:3px;	
		}
		#rodape1{
			float:left;
			width:50%;
			height:114px;
			border-right:solid 1px;
		
		}
		#rodape2{			
			
			height:113px;
		}
		#rodapea,#rodapeb{
			font-weight:500;
			
		}
		.titulo_os{ font-family:Arial, Helvetica, sans-serif;font-weight:bold;}
		.titulo_os_info{
				font-family:Arial, Helvetica, sans-serif;font-weight:bold;
				text-align:center; width:95%; border-top:1px solid #999; padding:4px;
		}
	</style>
</head>
<body>
<?
	if(!empty($locacao)){
?>

<div id="pagina">
	<div id="cabecalho" style="padding:10px">
		<strong style="text-transform:capitalize;"><?=$empresa[nome]?></strong><br>
		<?=$empresa[cnpj]?><br>
		<?=$empresa[endereco]?><br>
		
		<br>
        <br>
      	<div style="background:url('<?=$logo?>') no-repeat; background-position:center;float:right; width:100px;height:50px;margin-top:-70px; padding-right:50px;">&nbsp;</div>
        
	</div>
    <div class="titulo_os" style=" margin:0px auto; text-align:center; border-bottom:1px solid #999; padding:3px; width:95%;">
     Locaçao - N&deg; <?=$locacao->al_id?>
    </div>
    
    <div id="cliente">
    	<div style="float:left;width:300px; padding-left:13px;">
        	<div>Cliente: <?=$locacao->razao_social?></div>
    		Tel. Comercial: <?=$locacao->telefone1?><br>
    		Endereço: <?=$locacao->endereco?><br>
            Bairro: <?=$locacao->bairro?> 
    		Cidade: <?=$locacao->cidade?><br>
    		CPF / CNPJ: <?=$locacao->cnpj_cpf?><br>
    		
        </div>
        
        <div style="float:left;width:450px; padding-left:13px;">
        	Pessoa p/ Contato: <?=$locacao->nome_contato?><br>
            Tel. Residencial: <?=$locacao->telefone1?><br>
    		Insc. Estadual/RG: <?=$locacao->inscricao_estadual." ".$locacao->rg?><br>
    		E-mail: <?=$locacao->email?><br>
            
        </div>
        
        <div>
        	<br>
    		<br>
    		<br>
    		<br>
    		<br>
			<br>
        </div>
    </div>    
    <div class="titulo_os_info" style="font-size:13pt; margin:0px auto; text-decoration:underline">
        INFORMAÇ&Otilde;ES DA LOCAÇ&Atilde;O
        </div>
   <div id="os" style="height:70px; padding:10px">
   
    	<div style="float:left;width:400px;height:100px; padding-left:15px;">
    		Descriçao: <?=$locacao->descricao?><br>
            Cliente: <?=$locacao->nome_fantasia?><br>
            Data da Locaçao: <?=dataUsaToBr($locacao->data_locacao)?><br>
            Data da Devoluç&atilde;o: <?=dataUsaToBr($locacao->data_devolucao)?><br>
            <br>
    	</div>
        
        <div style="height:100px;">
    		N&deg; da Locacao: <?=$locacao->id?><br>
            Tel. Cliente: <?=$locacao->telefone1?><br>
            Data da Reserva: <?=dataUsatoBr($os->data_cadastro)?><br>
            Entregue em: <?=dataUsatoBr($locacao->data_entrega)?>            
    	</div>
    	<div style="width:95%;float:left; padding-left:13px; ">
    		
    	</div>
        <div style="width:95%;float:left; padding-left:13px;">
    		
    	</div>
    </div>
    
    <div style="clear:both"></div>
    
    <div id="servicos" style=" overflow:auto; padding:10px;height:14cm" >
    	<?php
			//Seleciona os Itens da Locacao
			$locacao_item=mysql_query($t="SELECT * FROM aluguel_locacao_itens WHERE locacao_id='$locacao->al_id' AND vkt_id='$vkt_id'");
			//echo $t;
			//Vetor para armazenar equipamentos
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
        <table  width="95%" id="produtos">
        	<tr>
            	<td colspan="6" style="font-size:14px" bgcolor="#999999" align="center"><strong>Itens da Locaçao</strong></td>
            </tr>
            <tr align="center" >
            	<td style="font-size:13px" colspan="2"><strong>Descriçao</strong></td>
                <td width="14%" style="font-size:13px;"><strong>QTD</strong></td>
                <td width="12%" style="font-size:13px;"><strong>Período</strong></td>
                <td width="12%" style="font-size:13px;"><strong>Vlr. Unit.</strong></td>
                <td width="19%" style="font-size:13px;"><strong>Valor</strong></td>
            </tr>
			<?
				$total_locacao = 0;
				foreach($equipamento_id as $equipamento){
					$eq=mysql_fetch_object(mysql_query("SELECT * FROM aluguel_equipamentos WHERE id='$equipamento' AND vkt_id='1'"));			
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
					//echo $qtd_dias_locacao->dias;
					$valor = (($eq->vlr_aluguel*$qtd_dias_locacao->dias)/$eq->periodo)*mysql_num_rows($eq_itens_locacao);
					$total_locacao+=$valor;
			?>
            <tr>
            	<td style="font-size:13px" colspan="2"><?=$eq->descricao?></td>
                <td style="font-size:13px"><?=mysql_num_rows($eq_itens_locacao)?></td>
                <td style="font-size:13px"><?=$qtd_dias_locacao->dias." dias";?></td>
                <td style="font-size:13px"><?=MoedaUsaToBr($eq->vlr_aluguel);?></td>
                <td style="font-size:13px"><?=MoedaUsaToBr($valor)?></td>
                
         
            <?
				}
				echo "<tr>
						<td colspan='5' align='right'>Total</td>
						<td>".MoedaUsaToBr($total_locacao)."</td>
					  </tr>"
				
			?>
       </table>
    </div>
    
<div id="rodape" style="background:#FFFFFF; vertical-align:bottom; border-top:1px solid #666; margin-top:30px;">
<div id="rodape1" style="vertical-align:bottom">
   		<center><strong><u>Locaçao</u></strong></center>
        <div style="float:left;width:60%" id="rodapea">
        	<div>Data: <?=DataUsatoBr($locacao->data_locacao)?></div>
        	<div>Entrega: <?=DataUsatoBr($locacao->data_devolucao)?></div>
        	
        </div>
        <div id="rodapeb">
        	VALOR TOTAL: <?=moedaUsaToBr($total_locacao)?><br>
        </div>
</div>
<div id="rodape2" style="float:right;">
    	<div style="border-top:1px solid #333; width:350px; text-align:center; margin-top:40px; margin-right:10px;">
        	Assinatura do Cliente
        </div>
</div>
</div>
    
</div>

<?php
	}
	else{
		echo "LOCACAO NAO EXISTE";
	}
?>
</body>
</html>