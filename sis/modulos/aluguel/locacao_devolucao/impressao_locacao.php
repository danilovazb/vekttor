<?php
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
global $vkt_id;
if($vkt_id==1){
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
												AND al.vkt_id='$vkt_id'"));

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
?>
<html>
<head>
   	<title>Loca&ccedil;&atilde;o</title>
    <style>
	*{ margin:0px ; padding:0px;}
	a:link, a:visited	{color: #333; text-decoration: underline;}
	a[href]:after		{content: " (" attr(href) ")";}
	body{ }
	table tr td {font-family:Tahoma, Geneva, sans-serif; border:1px solid #333;}
#pagina{
	border:1px solid #000;
	width:210mm;
	height:297mm;
	background:#FFFFFF;
	margin:0px auto;		
}
		#os{font-family:Tahoma, Geneva, sans-serif;font-size:11pt;}
		#cabecalho{
			height:100px;
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
			border-style:1px solid ;
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
.rodape{
	width:95%;	
	padding:5px 15px;
	bottom:0;	
}
.rodape div{
	width:200px; 
	border:0px solid #999;
	text-align:right;
	padding:3px;
	margin:2px;
}
.rodape .valFinal{
	float:right;
	
}
.rodape .ass{
	float:left;	
}.rodape .linha{
	border-bottom:1px solid #999;
	width:250px;
	padding-top:10px;
	padding-bottom:10px;	
}
.titulo_os{ font-family:Arial, Helvetica, sans-serif;font-weight:bold;}
.titulo_os_info{
		font-family:Arial, Helvetica, sans-serif;font-weight:bold;
		text-align:center; width:95%; 
		border-top:1px solid #999;
		padding:4px;
}
.TituloLocacao{ 
	font-family:Arial, Helvetica, sans-serif;font-weight:bold;
}
.cabecalho{
		width:880px;
		height:114px;
		font-family: arial, sans-serif;
		font-size:10pt;
		padding:10px;	
}
.cliente{
	width:880px;
	height:114px;
	font-family: arial, sans-serif;
	font-size:10pt;
	padding:10px;	
	padding-left:20px;	
}
.cliente p{ padding:2px; margin:3px;}
body,td,th {
	font-size: 10px;
}
</style>
</head>
<body>
<?
	if(!empty($locacao)){
?>

<div id="pagina" class="page">
	<?php
    	if(empty($configuracao->img_cabecalho)){
	?>		
   <img id="img_rodape" src="<?=$img_cab?>"/>
    <div class="cabecalho" style="padding:10px">
        <div style="clear:both"></div>
        <strong style="text-transform:capitalize;"><?=$empresa[nome]?></strong><br>
		<strong>CNPJ:</strong> <?=$empresa[cnpj]?><br>
		<strong>Endereço:</strong> <?=$empresa[endereco]?><br>
		<strong>Bairro:</strong> <?=$empresa[bairro]?><br>
		<strong>Cidade:</strong> <?=$empresa[cidade]?><br>
        <strong>Estado:</strong> <?=$empresa[estado]?><br>
        <strong>CEP:</strong> <?=$empresa[cep]?><br>
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
    <div class="TituloLocacao" style=" margin:0px auto; text-align:center; border-bottom:1px solid #999; padding:3px; width:95%;">
     LOCA&Ccedil;&Atilde;O - N&deg; <?=$locacao->al_id?>
    </div>
    
    <div class="cliente">
    	<div style="float:left; width:380px; border:0px solid #666;">
        	 <p><strong>Cliente:</strong> <?=$locacao->razao_social?></p>
             <p><strong>Tel. Comercial:</strong> <?=$locacao->telefone1?></p>
             <p><strong>Endereço:</strong> <?=$locacao->endereco?></p>
             <p><strong>Bairro:</strong> <?=$locacao->bairro?></p>
    		 <p><strong>Cidade:</strong> <?=$locacao->cidade?></p>
        </div>
        <div>
        	<p><strong>Pessoa p/ Contato:</strong> <?=$locacao->nome_contato?></p>
            <p><strong>Tel. Residencial:</strong> <?=$locacao->telefone1?></p>
    		<p><strong>Insc. Estadual/RG:</strong> <?=$locacao->inscricao_estadual." ".$locacao->rg?></p>
    		<p><strong>E-mail:</strong> <?=$locacao->email?></p>
            <p><strong>CPF / CNPJ:</strong> <?=$locacao->cnpj_cpf?></p>
        </div>           
    </div>
     
    <div style="clear:both;"></div>   
     <div class="titulo_os_info" style=" margin:0px auto; text-align:center; padding:3px; width:95%;">
     INFORMA&Ccedil;&Otilde;ES DA LOCA&Ccedil;&Atilde;O - N&deg; <?=$locacao->al_id?>
    </div>
   <div class="cliente">
    	<div style="float:left;width:380px; border:0px solid #666;">
    		<p><strong>Descriçao:</strong> <?=$locacao->descricao?></p>
            <p><strong>Cliente:</strong> <?=$locacao->nome_fantasia?></p>
            <p><strong>Data da Locaçao:</strong> <?=dataUsaToBr($locacao->data_locacao)?></p>
            <p><strong>Data da Devoluç&atilde;o:</strong> <?=dataUsaToBr($locacao->data_devolucao)?></p>
    	</div>
        
        <div>
    		<p><strong>N&deg; da Locacao:</strong> <?=$locacao->id?></p>
            <p><strong>Tel. Cliente:</strong> <?=$locacao->telefone1?></p>
            <p><strong>Data da Reserva:</strong> <?=dataUsatoBr($os->data_cadastro)?></p>
            <p><strong>Entregue em:</strong> <?=dataUsatoBr($locacao->data_entrega)?></p>        
    	</div>
        
    	<div style="width:95%;float:left; padding-left:13px; ">
    		
    	</div>
        <div style="width:95%;float:left; padding-left:13px;">
    		
    	</div>
    </div>
    
    <div style="clear:both"></div>
    
    <div id="servicos" style=" overflow:auto; padding:10px;height:12cm" >
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
            	<td colspan="7" style="font-size:13px" bgcolor="#999999" align="center"><strong>Itens da Locaçao</strong></td>
            </tr>
            <tr align="center" >
            	<td style="font-size:12px; width:150px" colspan="2">Descriçao</td>
                <td style="font-size:12px; width:50px;">QTD</td>
                <td style="font-size:12px; width:70px;">Dias</td>
                <td style="font-size:12px; width:110px;">Vlr. Unit. / Dia</td>
                <td style="font-size:12px;">Valor</td>
            </tr>
			<?
				$total_locacao = 0;
				foreach($equipamento_id as $equipamento){
					$eq=mysql_fetch_object(mysql_query($t="SELECT * FROM aluguel_equipamentos WHERE id='$equipamento' AND vkt_id='$vkt_id'"));			
					//echo $t."<br>";
					$eq_itens_locacao=mysql_query($t="SELECT * FROM  
						aluguel_locacao_itens ali,
						aluguel_equipamentos_itens aei
						WHERE 
						ali.item_equipamento_id=aei.id
						AND aei.equipamento_id='$equipamento'		   
						AND ali.locacao_id='".$_GET['id']."'
						AND ali.vkt_id='$vkt_id'
					");
					
					
					$qtd_dias_locacao = mysql_fetch_object(mysql_query("SELECT DATEDIFF('$locacao->data_devolucao','$locacao->data_locacao')as dias"));
					//echo $qtd_dias_locacao->dias;
					$valor = (($eq->vlr_aluguel*$qtd_dias_locacao->dias)/$eq->periodo)*mysql_num_rows($eq_itens_locacao);
					$total_locacao+=$valor;
			?>
            <tr>
            	<td style="font-size:12px;padding-left:5px;" colspan="2"><?=$eq->descricao?></td>
                <td style="font-size:12px;" align="center"><?=mysql_num_rows($eq_itens_locacao)?></td>
                <td style="font-size:12px;" align="center"><?=$qtd_dias_locacao->dias." dias";?></td>
                <td style="font-size:12px;" align="center"><?=MoedaUsaToBr($eq->vlr_aluguel)." / ".$eq->periodo;?></td>
                <td style="font-size:12px;" align="center"><?=MoedaUsaToBr($valor)?></td>
            <?
				}
			?>
				<tr>
						<td colspan='5' align="right" style="padding-right:5px; font-size:12px;"><strong>Total</strong></td>
						<td align="center" style="font-size:12px; font-weight:bold;"><?=moedaUsaToBr($total_locacao)?></td>
					  </tr>
				<?
				$desconto = $total_locacao*$locacao->desconto/100;
			?>
       </table>
         <div id="texto adicional" style="margin-top:100px;padding-left:13px;">
       	 <p align="justify"><?=$configuracao->texto_adicional?></p>
      </div>
    </div>
    
<div id="rodape" style="background:#FFFFFF; vertical-align:bottom; border-top:1px solid #666; margin-top:30px;">

<!--<div id="rodape1" style="vertical-align:bottom">
   		<center><strong><u>Locaçao</u></strong></center>
        <div style="float:left;width:60%" id="rodapea">
        	<div>Data: <?=dataUsaToBr($locacao->data_locacao)?></div>
        	<div>Entrega: <?=dataUsaToBr($locacao->data_devolucao)?></div>
        	
        </div>
        <div id="rodapeb">
        	Sub Total: <?=moedaUsaToBr($total_locacao)?><br>
        	Desconto: <?=moedaUsaToBr($desconto)?><br>
            Acréscimo: <? if(!empty($locacao->acrescimo)){ echo moedaUsaToBr($locacao->acrescimo);}else{ echo "0,00";}?><br>
            TOTAL: <?=moedaUsaToBr($total_locacao-$desconto+$locacao->acrescimo)?><br>
        </div>
</div>-->


<!--<div id="rodape2" style="float:right;">
    	<div style="border-top:1px solid #333; width:350px; text-align:center; margin-top:40px; margin-right:10px;">
        	Assinatura do Cliente
        </div>
</div>-->

 <div class="rodape">
                <div class="ass">
                	<div style="text-align:center">Assinatura do T&eacute;cnico</div>
                	<div class="linha"></div>
                    <div style="text-align:center">Assinatura do Cliente</div>
                	<div class="linha"></div>
                </div>
                
                <div class="valFinal">
                	<div><strong>Total Loca&ccedil;&atilde;o:</strong> <span><?=moedaUsatoBr($total_locacao);?></span></div>
                	<div><strong>Desconto</strong>: <span><?=moedaUsaToBr($locacao->desconto);?></span></div>
                    <div><strong>Acr&eacute;scimo</strong>: <span><?=moedaUsaToBr($locacao->acrescimo);?></span></div>
                	<div><strong>Sub - Total:</strong> <span><?=moedaUsaToBr($locacao->valor_total-$locacao->desconto+$locacao->acrescimo)?></span></div>
                </div>               
	  </div>




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
		echo "LOCACAO NAO EXISTE";
	}
?>
</body>
</html>