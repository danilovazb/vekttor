<?
/*
separacao por | campo
e  linha separado por qubra de linha ou para os leigos "\n"
@r0 = M�rio Fl�vios JR
@r1 = 29/01/1983
@r2 = 10/10/2010

*/

include("../../_config.php");
// fun��es base do sistema
include("../../_functions_base.php");
// fun��es do modulo empreendimento

//$cpf_cnpj =  str_replace=

$q=mysql_query("SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id ='$cliente_id' AND (razao_social  like '%$_GET[busca_auto_complete]%' OR REPLACE(REPLACE(REPLACE(cnpj_cpf,'.','' ),'-',''),'/','') like '%$_GET[busca_auto_complete]%')  LIMIT 15");
$i=0;
while($r= mysql_fetch_object($q)){
	echo urlencode("$r->razao_social|$r->id|$r->cnpj_cpf\n");
	$i++;
}
if($i==0){
	echo urlencode("N�o Encontrado, Cadastre em Clinte ou Fornecedor|0|0\n");
}
?> 