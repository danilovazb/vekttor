d<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
	
	//id do funcionario
	
	$id = $_GET['id'];
	
	$funcionario        = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$id'"));
	
	$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$funcionario->empresa_id'"));
	
	$demissao           = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario_demitidos WHERE funcionario_id='$funcionario->id'"));
	
	$data_demissao     = explode("-",$demissao->data_demissao);
	//print_r($data_demissao);
	$data_demissao     = $data_demissao[2]." de ".$mes_extenso[$data_demissao[1]-1]." de ".$data_demissao[0];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Aviso Prévio</title>
<style>
	#pagina{
		width:185mm;
		height:170mm;	
		font-family:"Times New Roman", Times, serif;
		border:solid 1px #000000;
		font-size:10pt;
		padding-left:10px;	
	}
	#cabecalho{		
		height:100px;		
	}
	h1{
		
		color:#000;
		text-align:center;
	}
	#conteudo{		
		
		width:98%;
		float:right;
		padding-right:15px;
	
	}
	
	.paragrafo{
		font-size:12pt;
		text-align:left;
		margin-top:15px;
		line-height:25px;
	}
	
	.linha_assinatura{
		width:100%;
		height:2px;
		border-bottom:solid 1px #000000;
		
	}
</style>
</head>

<body>
<div id="pagina">

	<div id="cabecalho">
    	<h1>PEDIDO DE DEMISSÃO</h1>
        <div>
    		Ilmo(s). Sr (a). <?=$funcionario->nome?>.
		</div>
    	
    
    </div>
    
    <div id="conteudo">
    	
        <div class="paragrafo">
        Através deste e por motivo de ordem particular, venho apresentar a V.S.as, em caráter definitivo e irrevogável, o meu pedido de demissão do emprego que ocupo nessa empresa desde a data de 03 de Setembro de 2012.
        </div>
        <div class="paragrafo">
        	Tendo interesse em retirar-me do serviço imediatamente, solicito de V. Sas, a dispensa de quaisquer formalidades.
        </div>
        
        <div style="clear:both"></div>
        
         <div style="margin-top:10px;float:right;">
        
		<?=$cliente_fornecedor->cidade?> <?=$cliente_fornecedor->estado?>, <?=date('d')?> de <?=$mes_extenso[date('m')-1]?> de <?=date('Y')?>.
        
        </div>
        
        <div style="margin-left:auto;margin-right:auto;margin-top:80px;">
        	            
            <div class="linha_assinatura" style="margin-left:auto;margin-right:auto;width:250px;">
    		</div>
        	
            <div style="clear:both"></div>
            
            <div style="text-align:center">
            Assinatura do Empregado
            </div>
    	</div>
        
        <div style="clear:both"></div>
        
        <div style="margin-left:auto;margin-right:auto;margin-top:80px;">
        	<div class="linha_assinatura" style="margin-top:30px; width:250px;margin-left:auto;margin-right:auto;">
    		</div>
        	
            <div style="clear:both"></div>
            
            <div style="text-align:center">
            Quando menor, Assinatura do Responsavel.
            </div>
    	</div>
        
       
        
    </div>
    
    
</div>
</body>
</html>