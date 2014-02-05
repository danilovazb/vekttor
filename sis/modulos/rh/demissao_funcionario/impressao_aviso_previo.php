<?php
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
		font-family:Arial, Helvetica, sans-serif;
		border:solid 1px #000000;
		font-size:10pt;
		padding-left:10px;	
	}
	#cabecalho{		
		height:200px;		
	}
	h1{
		color:#999;
		text-align:center;
	}
	#conteudo{		
		text-align:right;
		width:100%;
		float:right;
		padding-right:15px;
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
    	<h1>AVISO PRÉVIO</h1>
        <div>
    		Sr(s) <?=$funcionario->nome?>.
		</div>
    	<div style="margin-top:40px;">Nos termos do Artigo 487, da Consolida&ccedil;&atilde;o das Leis do trabalho, fica V.Sa. Avisado (a) de que, a partir do dia <?=$data_demissao?>, n&atilde;o mais ser&atilde;o necess&aacute;rios os seus servi&ccedil;os neste estabelecimento, quando ent&atilde;o, faremos a recis&atilde;o do seu contrato de trabalho.
        </div>
    
    </div>
    
    <div id="conteudo">
    	
        A presente serve de AVISO PRÉVIO, em obediência ao que manda a Lei.
        
        <div style="clear:both"></div>
        
        <div style="margin-top:10px;">
        <?=$cliente_fornecedor->cidade?> <?=$cliente_fornecedor->estado?>, <?=date('d')?> de <?=$mes_extenso[date('m')-1]?> de <?=date('Y')?>.
        </div>
        
        <div style="clear:both"></div>
        
        <div style="float:right;margin-right:50px;">
        	<div class="linha_assinatura" style="margin-top:30px; width:250px;">
    		</div>
        	
            <div style="clear:both"></div>
            
            <div style="text-align:center">
            Carimbo e assinatura do empregador
            </div>
    	</div>
        
        <div style="clear:both"></div>
        
        <div style="float:left;margin-left:50px;">
        	<div style="text-align:left">CIENTE:</div>
            
            <div class="linha_assinatura" style="margin-top:30px; width:250px;">
    		</div>
        	
            <div style="clear:both"></div>
            
            <div style="text-align:center">
            Assinatura do Empregado
            </div>
    	</div>
        
        <div style="clear:both"></div>
        
        <div style="float:right;margin-right:50px;">
        	<div class="linha_assinatura" style="margin-top:30px; width:250px;">
    		</div>
        	
            <div style="clear:both"></div>
            
            <div style="text-align:center">
            Quando menor, Assinatura do Responsavel.
            </div>
    	</div>
        
        <div style="clear:both"></div>
        
        <div style="text-align:center;margin-top:60px;">
        	
            NOTA – É necessário a apresentação da Cart. Prof. Para as devidas anotações.
        	
        </div>
        
    </div>
    
    
</div>
</body>
</html>