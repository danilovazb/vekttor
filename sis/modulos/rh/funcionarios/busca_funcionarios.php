<?
/*
separacao por | campo
e  linha separado por qubra de linha ou para os leigos "\n"
@r0 = M�rio Fl�vios JR
@r1 = 29/01/1983
@r2 = 10/10/2010

*/

include("../../../_config.php");
// fun��es base do sistema
include("../../../_functions_base.php");
// fun��es do modulo empreendimento

//$cpf_cnpj =  str_replace=

global $vkt_id;
if($_GET['funcionario_id']>0){
	$filtro="AND id!=".$_GET['funcionario_id'];
}

$q=mysql_query($t="SELECT * FROM rh_funcionario WHERE (nome like '%$_GET[busca_auto_complete]%' OR id like '%$_GET[busca_auto_complete]%')  AND vkt_id='$vkt_id' $filtro LIMIT 15");
$i=0;
//echo $t;
while($r= mysql_fetch_object($q)){
	echo urlencode("$r->id|$r->nome|$r->cpf|\n");
	$i++;
}
if($i==0){
	echo urlencode("N�o Encontrado|0|0\n");
}
?> 