<?php
 include("../../../_config.php");
 include("../../../_functions_base.php");
 global $vkt_id;
 
 $id            = $_GET['id'];
 $internauta_id = $_GET['paciente'];
 $atendimento_id= $_GET['atendimento_id'];
 
 $cliente_vekttor = mysql_fetch_object(mysql_query("SELECT * FROM clientes_vekttor WHERE id='$vkt_id'"));
 
 $sqlFinance = mysql_fetch_object(mysql_query("SELECT * FROM financeiro_movimento WHERE id = '$id' AND cliente_id = '$vkt_id' AND doc = '$atendimento_id' AND extorno <> '1' ORDER BY status ASC "));
 $cliente    = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id = '$sqlFinance->internauta_id' AND cliente_vekttor_id = '$vkt_id'"));
 $dia_pagamento_extenso = numero(substr($sqlFinance->data_vencimento,-2),'');
 $mes_pagamento_extendo = (int)substr($sqlFinance->data_vencimento,5,2);
 $mes_pagamento_extendo = $mes_extenso[$mes_pagamento_extendo];
 $ano_pagamento_extenso = numero(substr($sqlFinance->data_vencimento,0,4),'');
 //$atendimento_item = mysql_fetch_object(mysql_query("SELECT * FROM odontologo_atendimento_item WHERE id='$id' AND vkt_id='$vkt_id'"));		  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Odontólogo - Nota Promissória</title>
<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:9px;
}
#nota_promissoria, #numero_nota_promissoria,#nota_promissoria2{
	border:solid 1px #000000;
	border-radius: 5px;
	
}
#nota_promissoria,#nota_promissoria2{
	width:685px;
	height:350px;
	padding:10px;
}
#nota_promissoria2{
	margin-top:10px;
}
#descricao_nota_promissoria{
	float:left;
	width:30%;
}
#vencimento{
	width:60%;
	height:10px;
	float:right;
	clear:both;	
}
#numero{
	clear:both;
	margin-top:20px;
}
#valor{
	float:right;
	margin-right:10px;
}
#data_vencimento_extenso,#valor_extenso,#informacoes{
	margin-top:20px;
}

#vencimento i,#numero i,#valor i,#data_vencimento_extenso i,#valor_extenso i, #informacoes i{
	font-style:normal;
}
#informacoes i{
	font-weight:bold;
}
#vencimento i{
	float:right;
}
#data_vencimento_extenso i, #valor_extenso i,#informacoes i{
	float:left;
}
#numero i,#valor i{
	font-size:18px;
	float:left;
	margin-right:5px;
}

.caixa,.linha{
	font-size:12px;
	font-style:normal;
}

.linha{
	border-bottom:dashed 1px #000000;
	height:13px;
	float:right;
	margin-left:5px;
	margin-right:5px;
	padding-left:3px;
	margin-top:-3px;
}

#dia_vencimento,#ano_vencimento{
	width:50px;
	text-align:center;
}
#mes_vencimento{
	width:150px;
	text-align:center;
}
#linha_data_vencimento_extenso1{
	width:95%;
}
#linha_data_vencimento_extenso2,#linha_data_vencimento_extenso3,#linha_credor,#linha_credor_cpf{
	float:left;	
	margin-top:20px;
}
#linha_data_vencimento_extenso2{
	width:430px;
}
#linha_data_vencimento_extenso3{
	width:50px;
}
#linha_credor{
	width:450px;
}
#linha_credor_cpf{
	width:160px;
}


#informacoes_e{
	width:45%;
	float:left;
	line-height:25px;
}
#informacoes_d{
	width:45%;
	float:right;
	margin-right:50px;
	margin-top:15px;
}
.linha_informacoes{
	float:right;
	width:240px;
	height:20px;
	
	font-size:9px;
}

.caixa{
	border:solid 1px #000000;
	background-color:#E8E8E8;
	float:left;
	border-radius:5px;
	
	padding-top:3px;
	padding-left:4px;
}
#numero_nota{
	width:100px;
	height:20px;
		
}
#valor_nota{
	width:150px;
	height:18px;	
}
#valor_nota_extenso{
	width:99%;
	height:20px;	
}
</style>
</head>

<body>
<div id="nota_promissoria">
	<div id="descricao_nota_promissoria">
		<?=$sqlFinance->descricao?>
	</div>
    <div id="vencimento">
    	<i>Vencimento:<i>
        <div class="linha" id="dia_vencimento"><?=substr($sqlFinance->data_vencimento,0,4)?></div>
        <i>de</i>
        <div class="linha" id="mes_vencimento"><?=$mes_pagamento_extendo?></div>
        <i>de</i>
        <div class="linha" id="ano_vencimento"><?=substr($sqlFinance->data_vencimento,-2)?></div>
    </div>
    <div style="clear:both"></div>
    <!---------------------------------------->
    <div id="numero">
    	<i>N&ordm;</i>
        <div class="caixa" id="numero_nota"><?=$sqlFinance->id?></div>       
    </div>
    <!---------------------------------------->
     <div id="valor">
    	<i>R$</i>
        <div class="caixa" id="valor_nota"><?=moedaUsaToBr($sqlFinance->valor_cadastro)?></div>       
    </div>
   <!---------------------------------------->
   <div style="clear:both"></div>
   <div id="data_vencimento_extenso">
    	<i>Aos</i>
        <div class="linha" id="linha_data_vencimento_extenso1"><?=$dia_pagamento_extenso." de ".$mes_pagamento_extendo." de ".$ano_pagamento_extenso?></div>
        
        <div style="clear:both"></div>
        
        <div class="linha" id="linha_data_vencimento_extenso2"></div>
        <i style="margin-top:20px;">pagarei</i>
        <!--<div class="linha" id="linha_data_vencimento_extenso3"></div> -->
         <i style="margin-top:20px;">&nbsp;por esta via de</i>
         <i style="margin-top:16px;font-size:14px;font-weight:900;margin-left:4px;">NOTA PROMISSÓRIA</i> 
          
          <div style="clear:both"></div>
          
          <i style="margin-top:20px;">a</i>
          <div class="linha" id="linha_credor"><?=$cliente_vekttor->nome?></div> 
          <i style="margin-top:20px;">CPF/CNPJ</i>
           <div class="linha" id="linha_credor_cpf"><?=$cliente_vekttor->cnpj?></div> 
    </div>
    
   <!---------------------------------------->
   <div style="clear:both"></div>
   <div id="valor_extenso">
   	<i>A quantia de</i>
    <div class="caixa" id="valor_nota_extenso"><?=numero(MoedaUsaToBr($sqlFinance->valor_cadastro),'moeda')?></div>
   </div>
   
   <!---------------------------------------->
   <div style="clear:both"></div>
   <div id="informacoes">
   	<div id="informacoes_e">
   		<i>Pagável em</i>
    	<div class="linha linha_informacoes"></div>
         <div style="clear:both"></div>
         <i>Emitente</i>
        <div class="linha linha_informacoes"><?=$cliente->razao_social?></div>
        <div style="clear:both"></div>
         <i>CPF/CNPJ</i>
        <div class="linha linha_informacoes"><?=$cliente->cnpj_cpf?></div>
        <div style="clear:both"></div>
         <i>Endereço</i>
        <div class="linha linha_informacoes"><?="$cliente->endereco, $cliente->bairro - $cliente->cidade/".strtoupper($cliente->estado)?></div>
   	</div>
    <div id="informacoes_d">
   		
    	<div class="linha linha_informacoes" style="text-align:center;height:12px;margin-top:5px;"><?=DataUsaToBr(substr($sqlFinance->data_registro,0,10))?></div>
        <div id="data_emissao" style="text-align:center;font-weight:bold;font-style:normal;margin-left:50px;">Data de Emissão</div>
                
        <div class="linha linha_informacoes" style="margin-top:10px;text-align:center"></div>
        <div style="clear:both"></div>
        <div id="data_emissao" style="text-align:center;font-weight:bold;font-style:normal;margin-left:50px;">Assinatura do Emitente</div>
        
   	</div>
   </div>   
   
</div>
<div style="clear:both"></div>
<div id="nota_promissoria2"></div>
</body>
</html>
<script>
	document.getElementById('nota_promissoria2').innerHTML = document.getElementById('nota_promissoria').innerHTML; 
</script>