<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
	
	global $vkt_id;
	//id do funcionario
	
	$mes        = $_GET['mes'];
	$ano        = $_GET['ano'];
	$empresa_id = $_GET['empresa_id'];
	
	$cliente_fornecedor = mysql_query($t="SELECT 
								* 
							FROM 
								rh_hora_extra rh_he,
								cliente_fornecedor cf								
							WHERE 
							 cf.id = rh_he.empresa_id AND
							 MONTH(rh_he.data) = '$mes' AND 
							 YEAR(rh_he.data)='$ano' AND
							 rh_he.vkt_id='$vkt_id'AND
							 rh_he.empresa_id='$empresa_id'
							 GROUP BY rh_he.empresa_id
							 ORDER BY rh_he.empresa_id
							 
							 ");
							 
							 //echo $t." ".mysql_error();	

?>
<style>
	#pagina{
		margin-left:auto;
		margin-right:auto;
		width:230mm;
		height:300mm;
		font-size:12pt;
		border:solid 1px;
		margin-top:20px;
	}
	table{
		margin-top:5px;
		margin-left:auto;
		margin-right:auto;
		border-collapse:collapse;
		width:98%;
		
	}
	
	#hora_extra{
		
		margin-top:10px;
		text-align:center;
		border-left: solid 1px #000000;
		border-bottom: solid 1px #000000;
	}
	
	#hora_extra tr td{
		border-right: solid 1px #000000;
		border-top: solid 1px #000000;
	}
	
	.quebra_pagina{
		page-break-after:always;
	}
	#assinatura{
		float:right;
		width:350px;
		margin-top:100px;
		margin-right:20px;
		text-align:center;
	}
	.linha_assinatura{
		
		height:2px;
		border-bottom:solid 1px #000000;		
	}
	.campo{
		font-size:10px;
		font-weight:bold;
	}
</style>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Relatório Hora Extra</title>
</head>

<body>
<?php
	//while empresas
	while($cliente = mysql_fetch_object($cliente_fornecedor)){
		
		$funcionarios = mysql_query("SELECT * FROM rh_funcionario WHERE empresa_id = '$cliente->id' and vkt_id='$vkt_id' ORDER BY nome");
		echo mysql_error();
		while($funcionario = mysql_fetch_object($funcionarios)){
			$horas_extras = mysql_query("SELECT * FROM rh_hora_extra WHERE funcionario_id = '$funcionario->id' and vkt_id='$vkt_id' AND MONTH(data)='$mes' AND YEAR(data)='$ano'");
			if(mysql_num_rows($horas_extras)>0){
				//verifica se o saldo é maior que zero
				//e se a hora extra é de 50 ou cem 100%  
				
?>
<div id="pagina">
<table>
	
    <tr>
		<td width="80%"><div class="campo">Empresa:</div><?=$cliente->razao_social?></td>
        <td width="10%" ><div class="campo">Mês:</div><?=$mes_abreviado[$mes-1]?></td>
        <td width="10%" ><div class="campo">Empresa:</div><?=$ano?></td>
    </tr>
    <tr>
		<td colspan="3"><div class="campo">CNPJ</div><?=$cliente->cnpj_cpf?></td>
     
    </tr>
    <tr>
		<td colspan="3"><div class="campo">Funcionário</div><?=$funcionario->nome?></td>
    </tr>
    <tr>
     	<td>
        	<div style="float:left;width:100px;">
        	<div class="campo">CTPS:</div> <?=$funcionario->carteira_profissional_numero?>
            </div>
             <div style="float:left;width:100px;">
             <div class="campo">Série:</div> <?=$funcionario->carteira_profissional_serie?> 
             </div>
        	<div style="float:left;width:100px;">
        <div class="campo">UF de Emissão:</div> <?=$funcionario->carteira_profissional_estado_emissor?>
        </div>
        </td>
        <td>
           
        </td>
        <td>
         
        </td>
     	
    </tr>
</table>

<table id="hora_extra">
	<tr bgcolor="#CCCCCC">
    	<td width="14%">Data</td>
    	<td width="14%">Hora Chegada</td>
    	<td width="14%">Saída Almoço</td>
    	<td width="14%">Retorno Almoço</td>
        <td width="14%">Saída</td>
    	<td width="14%">Total</td>
    	<td width="14%">Saldo</td>
        <td width="14%">Adicional Noturno</td>
        <td width="14%">Hora Extra</td>
     </tr>
     <?php
	 	
	 
		while($hora_extra = mysql_fetch_object($horas_extras)){
			if($hora_extra->saldo_horas>0&&$hora_extra->hora_extra_100=='0'){
					
					$porcentagem_extra = "50%";
					
				}else if($hora_extra->saldo_horas>0&&$hora_extra->hora_extra_100=='1'){
				
					$porcentagem_extra = "100%";
				
				}else{
					$porcentagem_extra = "-";
				}
	 ?>
     <tr>
    	<td width="14%"><?=DataUsaToBr($hora_extra->data)?></td>
    	<td width="14%"><?=$hora_extra->hora_entrada?></td>
    	<td width="14%"><?=$hora_extra->hora_saida_almoco?></td>
    	<td width="14%"><?=$hora_extra->hora_retorno_almoco?></td>
         <td width="14%"><?=$hora_extra->hora_saida?></td>
    	<td width="14%"><?=MoedaUsaToBr($hora_extra->total)?></td>
    	<td width="14%"><?=MoedaUsaToBr($hora_extra->saldo_horas)?></td>
         <td width="14%"><?=MoedaUsaToBr($hora_extra->adicional_noturno)?></td>
        <td width="14%"><?=$porcentagem_extra?></td>
     </tr>
     <?
			}// fim while $hora_extra
	 ?>
</table>
	
	<div style="clear:both"></div>    
    
    <div id="assinatura">
    
		<div class="linha_assinatura"></div>
    
    	<div style="clear:both"></div>
        
    	Assinatura do Funcionário
    </div>
    
</div>

<div class="quebra_pagina"></div>

<?php
			}
		}// fim while $funcionario
	}// fim while $cliente
?>
</body>
</html>