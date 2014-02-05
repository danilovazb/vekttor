<?php
	//Includes
	include("../../../_config.php");
	include("../../../_functions_base.php");
	$id = $_GET['id'];
	$empregado = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id=$id"));
	
	$cliente_fornecedor     = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id=$empregado->empresa_id"));
	
	if($empregado->vale_transporte>0){
		
		$receber_transporte = 'sim';
		
	}else{
		
		$receber_transporte = 'nao';
	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Termo de Transporte</title>

<style>
	#pagina{		
		width:180mm;
		height:230mm;
		font-family: Arial, Helvetica, sans-serif;
		font-size:12px;		
	}
	h4{
		width:50%;
		font-size:16px;		
		text-align:center;
		margin:50px auto;		
	}
	#conteudo{
		font-size:14px;
		line-height:20px;
		width:100%;
		text-align:justify;
		
		
	}
	#adquirir_vale{
		width:35%;
		margin:auto;		
		margin-top:25px;
		margin-bottom:25px;
	}
	
	.vale_transporte > div{
		float:left;
	}
	p{
		width:160mm;
		clear:both;
		font-weight:100;
		letter-spacing: 1px;
		word-spacing:3px;
		text-indent:40px;
		
	}
	.linha{
		border-bottom:#000 solid 1px;
		float:left;
	}
	#sim,#nao{
		width:35px;		
		height:13px
	}
	#nao{
		margin-left:20px;
	}
	.vale_transporte{
		width:47%;
		font-weight:bold;
		font-size:12px;
		letter-spacing: 2px;
		margin-top:23px;
	}
	.titulo_qtd{
		width:49px;
		text-align:left;
	}
	.titulo_linha_oni{
		text-align:center;
		width:150px;
		margin:0 17px 0 20px;		
	}
	.titulo_tarifa{
		text-align:right;
		width:50px;
		float:right;
	}
	.qtde{
		width:40px;
		height:20px;		
	}
	.linha_oni{
		margin-left:20px;
		margin-right:30px;
		width:150px;
		height:20px;
	}
	.tarifa{
		width:45px;
		height:20px;
	}
	#data_impressao{
		margin-top:25px;
		text-align:center;
	}
	#assinatura{
		margin-top:25px;
		width:100%;
		text-align:center;
	}
	#linha_assinatura{		
		margin-left:160px;
		width:350px;
		height:10px;
	}
	#nome_assinatura{
		clear:both;
	}
</style>

</head>

<body>
<div id="pagina">

	<h4>							
             DECLARAÇÃO E TERMO DE COMPROMISSO VALE TRANSPORTE									
	</h4>
    
    <div id="conteudo">							
	
    	<p>Assinale com um X se você deseja adquirir vales-transporte:</p>
    
    	<div id="adquirir_vale">
        	<span class="linha" id="sim"></span>
            <div style="float:left;margin-left:10px;">SIM</div>
            <div class="linha" id="nao"></div> 
            <div style="float:left;margin-left:10px;">NÃO</div>
        </div>
        
        <div style="clear:both"></div>
        
        <p style="margin-top:20px;">
        	Se a sua opção for NÃO, apenas assinale o formulário, se for SIM,
            preencha-o com os dados necessários.
        </p>
        
        <p>
        	Eu, <?=strtoupper($empregado->nome)?>, funcionário(a) da empresa <?=strtoupper($cliente_fornecedor->razao_social)?>, desejando adquirir vales-transporte, declaro que estou morando no endereço 
            <?=$empregado->endereco?>,  bairro <?=$empregado->bairro?>, <?=strtoupper($empregado->cidade)?>-<?=strtoupper($empregado->estado)?> e necessito diariamente, no meu deslocamento residencia - trabalho - residencia, dos seguintes vales-transporte:
        </p>

		<?php
			for($i=0;$i<=2;$i++){
		?>
		<div class="vale_transporte" style="float:left">
        	 
             <div class="titulo_qtd">Qtde.</div>           	
           	 <div class="titulo_linha_oni">Linha</div>             
             <div class="titulo_tarifa">Tarifa</div>
             <div class="linha qtde"></div>
             <div class="linha linha_oni"></div>
             <div class="linha tarifa"></div>                
        </div>
        <div class="vale_transporte" style="float:right;margin-right:30px;">
        		<div class="titulo_qtd">Qtde.</div>            	
            	<div class="titulo_linha_oni">Linha</div>
                <div class="titulo_tarifa">Tarifa</div>
                <div class="linha qtde"></div>
                <div class="linha linha_oni"></div>                
                
                <div class="linha tarifa"></div>
        </div>
        <?php
			}
        ?>
        
         <div style="clear:both"></div>
        
        <p style="margin-top:20px;">
        	Assumo o compromisso de utilizar o vale-transporte exclusivamente para o meu efetivo deslocamento
            residencia - trabalho - residencia, e afirmo ter conhecimento do artigo 7o. paragrafo 3o. do decreto no.
            95.247, de 17/11/87, de que constitui falta grave o seu uso indevido ou a falsidade desta declaração.
        </p>
        
        <p>
        	Comprometo-me a atualizar anualmente as informações ou a qualquer tempo quando ocorrer mudanca residencial
            ou no(s) meio(s) de transporte.
        </p>
        
        <p>
        	Autorizo a empresa a descontar mensalmente, até <?=limitador_decimal_br($empregado->vale_transporte)?>% de meu salario-base o valor destinado a cobrir o fornecimento
            de vales-transporte por mim utilizados
        </p>
        
        <p>
        	Por ser a expressão da verdade, firmo a presente declaração e termo de compromisso.
        </p>
        <?php
			$mes = date('m')-1;
			if(strlen($mes)>1){
				$mes = $mes[1];
			}
		?>
        <div id="data_impressao"><?=strtoupper($cliente_fornecedor->cidade)?>, <?=date('d')?> DE <?=strtoupper($mes_extenso[$mes])?> DE <?=date('Y')?></div>
        
        <div id="assinatura">
        	<div class="linha" id="linha_assinatura"></div>
            
            <div id="nome_assinatura"><?=strtoupper($empregado->nome)?></div>            
        </div>
    </div><!--conteudo-->
    								
</div>									
									
									
									
									
									
</body>
</html>
