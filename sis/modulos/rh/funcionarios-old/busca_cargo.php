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

if($_GET['acao']=='cargo'){
	$q=mysql_query($t="SELECT * FROM cargo_salario WHERE vkt_id='$vkt_id' AND (cargo like '%$_GET[busca_auto_complete]%' OR id like '%$_GET[busca_auto_complete]%') LIMIT 15");
	//echo $t;
}
if($_GET['acao']=='cbo'){
	$q=mysql_query($t="SELECT * FROM cargo_salario WHERE vkt_id='$vkt_id' AND (cbo like '%$_GET[busca_auto_complete]%' OR id like '%$_GET[busca_auto_complete]%') LIMIT 15");
	//echo $t;
}
$i=0;
//echo $t;
while($r= mysql_fetch_object($q)){
	echo urlencode("$r->id|$r->cargo|$r->valor_salario|$r->cbo\n");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado|0|0\n");
}
?> 