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

$q=mysql_query("SELECT * FROM alunos WHERE  (nome  like '%$_GET[busca_auto_complete]%' OR cpf like '%$_GET[busca_auto_complete]%')  LIMIT 15");
$i=0;
while($r= mysql_fetch_object($q)){
	echo urlencode("$r->nome|$r->id|$r->cpf\n");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado, Cadastre em Clinte ou Fornecedor|0|0\n");
}
?> 