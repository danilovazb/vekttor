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

$q=mysql_query("SELECT * FROM rh_empresas 
				 JOIN cliente_fornecedor ON rh_empresas.cliente_fornecedor_id = cliente_fornecedor.id			
					WHERE (cliente_fornecedor.razao_social like '%$_GET[busca_auto_complete]%') AND  cliente_fornecedor.cliente_vekttor_id = '$vkt_id' LIMIT 15");
$i=0;
while($r= mysql_fetch_object($q)){
	echo urlencode("$r->razao_social|$r->cliente_fornecedor_id|$r->cnpj_cpf\n");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado|0|0\n");
}
?> 