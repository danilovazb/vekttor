<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
	global $vkt_id;
	
	$id=$_GET['id'];
	
	$contratado = mysql_fetch_object(mysql_query($t="SELECT 
														* 
													FROM
														rh_funcionario
													 WHERE
													 	id = '$id' AND 
														vkt_id='$vkt_id'
													 	"));
	
	$contratante = mysql_fetch_object(mysql_query($t="SELECT 
														* 
													FROM
														cliente_fornecedor
													 WHERE
													 	id = '$contratado->empresa_id' AND
													 	cliente_vekttor_id='$vkt_id'
														"));//echo $t." ".mysql_error();
	if($_GET['acao']=='entrega'){
		$titulo = "Recibo de Entrega de Carteira Profissional Para Anotações";
		$conteudo = "Recebemos a Carteira Profissional supra descriminada para antender as anotações e que será devolvida dentro de 48 horas, de acordo com a Lei em Vigor";
	}else{
		$titulo = "Comprovante de Devolução da Carteira Profissional";
		$conteudo = "Recebi a devolução da Carteira Profissional supra descriminada com as respectivas anotações";
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sem t&iacute;tulo</title>
</head>
<style>
#pagina{
	width:175mm;
	height:250mm;
	font:Arial, Helvetica, sans-serif;
	font-size:12px;
}
#cabecalho{
	width:175mm;
	height:22mm;
	border:solid 1px #000000;
	border-style:solid;
	font-size:22px;
	text-align:center;
	padding-top:10px;
	line-height:45px;
}
#conteudo{
	margin-top:100px;
}

#decreto_lei, #declaracao{
	font:Arial;
	font-size:14px;
	font-weight:100;
	margin-top:50px;
}

#declaracao{
	line-height:30px;
}

.campo{
	width:160px;
	height:40px;
	float:left;
}
#data{
	margin-top:90px;
	margin-left:30px;
	float:left;
	text-align:left;
}

.linha_assinatura{height:15px;		border-bottom:solid 1px #000000;}

</style>
<body>
<div id="pagina">
	<div id="cabecalho">
    	<img src="../../vekttor/clientes/img/<?=$vkt_id?>.png" />
        <div style="clear:both"></div>
        <?=$titulo?>
    </div>
    <div id="conteudo">
    	
        <div style="width:100%;margin-bottom:30px;">
    		Empresa: <?=$contratante->razao_social?>    
    	</div>
        
        <div class="campo">
    		Nome do Empregado:     
    	</div>
        <div class="linha_assinatura" style="float:left; width:74%;"><?="(".str_pad($contratado->numero_sequencial_empresa,5,'0',STR_PAD_LEFT).") ".$contratado->nome?></div>
        
        
        <div style="clear:both"></div>
        
        <div class="campo">
    		CTPS N&deg;:
             
    	</div>
        <div class="linha_assinatura" style="float:left;width:35%;"><?=$contratado->carteira_profissional_numero?></div>
        
        
        
               
        <div class="campo" style="width:50px;">
        	 Série:  
        </div>
        <div class="linha_assinatura" style="float:left;width:33%;"><?=$contratado->carteira_profissional_serie."/".$contratado->carteira_profissional_estado_emissor?></div>
        
        <div style="clear:both"></div>
        
        <div class="campo">
    		CBO:             
    	</div>
        <div class="linha_assinatura" style="float:left;width:35%;"><?=$contratado->cbo?></div>
        
        <div style="clear:both"></div>
        
        <div class="campo">
    		Data Admissão: 
    	</div>
        
        <div class="linha_assinatura" style="float:left;width:35%;"><?=DataUsaToBr($contratado->data_admissao)?></div>
        
         <div style="clear:both"></div>
        
        <div class="campo">
    		Função:             
    	</div>
        <div class="linha_assinatura" style="float:left;width:35%;"><?=$contratado->cargo?></div>
        
           
        
        
        <div style="clear:both"></div>
        
         <div id="decreto_lei">
        	Decreto Lei n&ordm; 229 de 28/02/1967
            <div style="clear:both"></div>
            (Alterando a Art.29 da Lei 5.452 CLT)
        </div>
        
        <div id="declaracao">
        	<!--Declaro ter recebido da empresa <?=$contratante->razao_social?>
            <div style="clear:both"></div>
            CNPJ <?=$contratante->cnpj_cpf?> a devolução a carteira de trabalho
            
            e previdência social acima, com suas respectivas anotações, 
            
            de acordo com as disposições legais vigentes-->
            <?=$conteudo?>
        </div>
        
        <div id="data">
        	<div style="float:left"><?=$contratante->cidade?>,</div>
             
            <div class="linha_assinatura" style="width:50px;float:left;margin-left:10px;text-align:center">
            <?php
				$data = mysql_fetch_object(mysql_query($t="SELECT DATE_ADD('$contratado->data_admissao', INTERVAL 1 DAY ) as data"));
				$data = explode("-",$data->data);
				echo $data[2];
			?>
            </div>
        
        	<div style="float:left;margin-left:2px;">de</div>
            
            <div class="linha_assinatura" style="width:50px;float:left;margin-left:10px;text-align:center"><?=$data[1]?></div>
            
            <div style="float:left;margin-left:2px;">de</div>
            
            <div style="float:left;margin-left:10px;"><?=$data[0]?></div>
        </div>
         
         <div style="clear:both"></div>
         
         <div class="linha_assinatura" style="float:left;margin-left:30px;width:50%;margin-top:50px;"></div>
         <div style="float:left;margin-left:70px;width:75%;"><?=strtoupper($contratado->nome)?></div>
    </div><!-- #conteudo -->
</div><!-- #pagina -->
</body>
</html>
