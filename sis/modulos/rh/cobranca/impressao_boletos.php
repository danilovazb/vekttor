<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");

global $vkt_id;
$data_vencimento = DataBrToUsa($_GET['data_vencimento']);


if($_GET['acao']=='um'){
	$boletos = mysql_query("SELECT * FROM rh_cobranca_empresas WHERE id='".$_GET['cobranca']."' AND vkt_id='$vkt_id' $filtro");
}
if($_GET['acao']=='todos'){
	$data_vencimento=DataBrToUsa($_GET['data_vencimento']);
	$boletos = mysql_query($t="SELECT * FROM rh_cobranca_empresas WHERE data_vencimento='$data_vencimento' AND vkt_id='$vkt_id' $filtro");
	//echo $t;
}

function mes($mes){
	
	switch($mes){
		case '01': $mes="Janeiro";break;
		case '02': $mes="Fevereiro";break;
		case '03': $mes="Março";break;
		case '04': $mes="Abril";break;
		case '05': $mes="Maio";break;
		case '06': $mes="Junho";break;
		case '07': $mes="Julho";break;
		case '08': $mes="Agosto";break;
		case '09': $mes="Setembro";break;
		case '10': $mes="Outubro";break;
		case '11': $mes="Novembro";break;
		case '12': $mes="Dezembro";break;
		
		
	}
		
	return $mes;
}

$mes = mes(date('m'))
//$empregado = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id=$id"));
	
?>

<style>
	*{
		font-family:Arial, Helvetica, sans-serif;
		font-size:14px;
	}
	
	#boleto{
		border:#000 solid 1px;
		width:500px;
		height:280px;
		margin-top:15px;
		float:left;
	}
	h1{
		text-align:center;
		font-size:18px;
	}
	#conteudo{
		line-height:50px;
		
	}
	.quebra_pagina{
		page-break-after:always;
	}
</style>
<?php
	if(mysql_num_rows($boletos)<=0){
		alert('Nao há boletos para esta data de vencimento');
	}else{
		
		
		$c=1;
		while($boleto = mysql_fetch_object($boletos)){
			$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id=$boleto->cliente_fornecedor_id"));
			
?>
<div id="boleto">
	
    <div style="width:130px;float:left;"> RECIBO N&ordm; <?=$boleto->id?></div>       
    <div style="width:100px;float:left;"> R$ <?=MoedaUsaToBr($boleto->valor)?></div>
    
    <div style="clear:both"></div>
    
    <div id="conteudo">
    	
        Recebi da Empresa <?=strtoupper($cliente_fornecedor->razao_social)?>
   	  
      <div style="clear:both"></div>
    	
         A importância de: <?=MoedaUsaToBr($boleto->valor)?> <div style="clear:both"></div>
      
      <div style="clear:both"></div>
        
        proveniente de: <?=$boleto->descricao?> <div style="clear:both"></div>
       
        para maior clareza firmo o presente: recibo
         <div style="clear:both"></div>
         
         <div style="margin-top:25px;">
         	<?=$cliente_fornecedor->cidade.", ".date('d')." de ".$mes." de ".date('Y')?> 
         </div> 	
    </div>
    
</div>
<div style="clear:both"></div>
<?php
			if($c%3==0&&$c>1){
				echo "<div class='quebra_pagina'></div>";
    			//echo $c;
			}
			$c++;
		}
		
	}
?>