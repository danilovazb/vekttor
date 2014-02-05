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
global $vkt_id;

$q=mysql_query("SELECT * FROM cliente_fornecedor WHERE razao_social LIKE '%$_GET[busca_auto_complete]%' AND cliente_vekttor_id='$vkt_id' LIMIT 15");
$i=0;
while($r= mysql_fetch_object($q)){
	echo urlencode("$r->id|$r->razao_social|\n");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado|0|0\n");
}
?> 