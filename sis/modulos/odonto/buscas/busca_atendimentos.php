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

$q=mysql_query("
SELECT a.id as id, c.razao_social as razao_social, c.cnpj_cpf as cpf 
	FROM odontologo_atendimentos as a, cliente_fornecedor as c WHERE a.vkt_id='$vkt_id' AND a.cliente_fornecedor_id=c.id 
	AND c.razao_social  like '%$_GET[busca_auto_complete]%'  
	LIMIT 15
");
$i=0;
echo mysql_error();
while($r= mysql_fetch_object($q)){
	echo urlencode("$r->id|$r->razao_social|$r->cpf|\n");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado, Crie um atendimento para este cliente|0|0\n");
}
?> 