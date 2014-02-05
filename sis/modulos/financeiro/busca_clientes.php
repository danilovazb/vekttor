<?
/*
separacao por | campo
e  linha separado por qubra de linha ou para os leigos "\n"
@r0 = Mário Flávios JR
@r1 = 29/01/1983
@r2 = 10/10/2010

*/
$mes_referencia = date("m");
include("../../_config.php");
// funções base do sistema
include("../../_functions_base.php");
// funções do modulo empreendimento

//$cpf_cnpj =  str_replace=
if($_GET['tipo']!=''){$filtro_cliente=" AND tipo='{$_GET['tipo']}'";}
$q=mysql_query($ss="SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id ='$cliente_id' $filtro_cliente 
AND (razao_social  like '%$_GET[busca_auto_complete]%' OR REPLACE(REPLACE(REPLACE(cnpj_cpf,'.','' ),'-',''),'/','') like '%$_GET[busca_auto_complete]%')  LIMIT 15");
$i=0;
while($r= mysql_fetch_object($q)){
	$FinanceiroReceber = mysql_fetch_object(mysql_query(" SELECT SUM(valor_cadastro) AS soma_receber FROM financeiro_movimento WHERE internauta_id = '$r->id' AND month(data_registro) = '$mes_referencia' AND tipo = 'receber' "));
	$FinanceiroPagar = mysql_fetch_object(mysql_query(" SELECT SUM(valor_cadastro) AS soma_pagar FROM financeiro_movimento WHERE internauta_id = '$r->id' AND month(data_registro) = '$mes_referencia' AND tipo = 'pagar' "));
	
	$saldo = (($r->limite + $FinanceiroReceber->soma_receber) - $FinanceiroPagar->soma_pagar);
	
	echo urlencode("$r->razao_social|$r->id|$r->cnpj_cpf|".($saldo)."\n");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado, Cadastre em Clinte ou Fornecedor|0|0\n");
}
?> 