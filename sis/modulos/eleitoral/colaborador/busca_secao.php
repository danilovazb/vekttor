<?
/*
separacao por | campo
e  linha separado por qubra de linha ou para os leigos "\n"
@r0 = Mário Flávios JR
@r1 = 29/01/1983
@r2 = 10/10/2010

*/

include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento

//$cpf_cnpj =  str_replace=
$zona=$_GET['zona'];
$q=mysql_query("SELECT DISTINCT secao ,local, id FROM eleitoral_zonas WHERE vkt_id=$vkt_id AND (secao like '%$_GET[busca_auto_complete]%') AND zona='{$_GET['zona']}' LIMIT 15");
$i=0;
while($r= mysql_fetch_object($q)){
	echo urlencode("$r->secao|$r->local|$r->id|\n");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado, Cadastre Zonas");
	print_r($_GET);
	echo urlencode("|0|0\n");
}
?> 