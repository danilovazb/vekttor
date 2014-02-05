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

$q=mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE cnpj_cpf='%$_GET[busca_auto_complete]%' AND vkt_id='$vkt_id'"));
echo $t;
if(!empty($q)){
	echo urlencode("$r->nome_contato|$r->rg|\n");
}
?> 