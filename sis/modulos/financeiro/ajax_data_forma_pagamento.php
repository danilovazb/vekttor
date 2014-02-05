<?
require "../../_config.php";
require "../../_functions_base.php";
$id=$_POST['id'];
$prazo=$_POST['prazo'];
$taxa_pct=$_POST['taxa_pct'];
$taxa_fix=$_POST['taxa_fix'];
$valor=$_POST['valor'];
if($_POST['vencimento']!=''){
	$vencimento=dataBrToUsa($_POST['vencimento']);
}


if($taxa_fix>0||$taxa_pct>0){
	$valor_taxas = "Taxas: R$".moedaUsaToBr(($valor*($taxa_pct/100))+$taxa_fix);
}



if($prazo>0&&isset($vencimento)){
	$data_vencimento = mysql_result(mysql_query($a="SELECT DATE_FORMAT(DATE_ADD('$vencimento', INTERVAL $prazo DAY),'%d/%m/%Y')"),0,0);
	$str_retorno_forma[0]="Vencimento + $prazo dias";
	$str_retorno_vencimento=utf8_encode("Será lançado $data_vencimento");
}

if($taxa_fix>0){
	$str_retorno_forma_taxas[0]="R$".moedaUsaToBr($taxa_fix);
}
if($taxa_pct>0){
	$str_retorno_forma_taxas[1]=moedaUsaToBr($taxa_pct)."%";
}

$str_retorno_forma[1] = @implode(" + ",$str_retorno_forma_taxas);
if(count($str_retorno_forma)>0){
	$str_retorno_forma = implode("\n",$str_retorno_forma);
}



$retorno=array('obs_vencimento'=>"$str_retorno_vencimento",'obs_valor'=>"$valor_taxas",'obs_forma_pagamento'=>"$str_retorno_forma");

echo json_encode($retorno);
