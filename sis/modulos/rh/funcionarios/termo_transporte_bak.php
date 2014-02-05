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
		width:230mm;
		height:280mm;
		border:solid 1px #000000;
		font-family: Arial, Helvetica, sans-serif;
		font-size:12px;
	}
	h4{
		width:40%;
		font-size:16px;		
		text-align:center;
		margin:50px auto;
		font-weight:100;	
	}
	#conteudo{
		font-size:14px;
		line-height:20px;
		width:90%;
		text-align:justify;
		padding-left:10px;
		padding-right:5px;
	}
</style>

</head>

<body>
<div id="pagina">

	<h4>							
             DECLARAÇÃO E TERMO DE COMPROMISSO VALE TRANSPORTE									
	</h4>								
									
	<div id="conteudo">								
	O vale transporte é um direito do trabalhador, faça sua opção se quer adquiri-lo ou não 								
assinalando com um  X.

	<div style="clear:both"></div>    
    								
	<div style="text-align:center"><?php if($receber_transporte=='sim'){echo 'X';}else{echo '____';}?>	SIM	<?php if($receber_transporte=='nao'){echo 'X';}else{echo '____';}?>	NÃO </div>
    
    <div style="clear:both"></div>					
	Se sua opção for não, apenas assine o formulário;
    
    <div style="clear:both"></div>
    								
	Se for sim , preencha o formulário com os dados necessários.	
    
    <div style="clear:both"></div>							
									
	Eu, 	<?=$empregado->nome?>					, empregado (a) da 		
	<?=$cliente_fornecedor->razao_social?>. Desejando adquirir  vales transportes, declaro que estou morando 								
na <?=$empregado->endereco?> nº <?=$empregado->casa_numero?>
									
Bairro:<?=$empregado->bairro?> Cidade: <?=$empregado->cidade?>  , Estado: <?=$empregado->estado?> e uso _______									
meio (s) de transporte ____________________com __________segmento(s), que se constitui (em)									
no meio mais adequado para o meu deslocamento residencia-trabalho e virse-versa.									
	Assumo o compromisso de utilizar o vale transporte exclusivamente para o efetivo deslo								
camento residencia-trabalho e virce-versa; e afirmo ter conhecimento do artigo 7º, § 3º do Declaro nº									
95.247, de 17-11-87, de que constitui falta grave o uso indevido ou que essa declaração seja falsa.									
	Comprometo-me a atualizar anualmente as informações, ou a qualquer tempo    quando 								
ocorrer mudança residencial ou  ou meio(s) de transportes(s) a empresa com antecedencia minima 									
de 30 dias.									
	Autorizo a empresa a descontar mensalidade, ate 6% do eu salário-base, o valor   desti								
nado a cobrir o fornecimento de vales transportes por mim utilizados.									
	Fico ciente que o uso indevido do Vale-transporte será considerado falta grave,    ocasio								
nando rescisão por justa causa. 									
	Por ser a expressão da verdade , afirmo a presente declaração e termo de compromisso.								
	
    <div style="margin-top:10px;">
    								
	Manaus,  ____ de ___________________de __________.								
									
	</div>								
	<div style="margin-top:20px;width:320px;float:right">
    		______________________________________________						
				<div style="clear:both"></div>
                <div style="text-align:center">Assinatura do Empregado(a)</div>					
									
	</div>	
    </div>								
									
									
</div>									
									
									
									
									
									
</body>
</html>
