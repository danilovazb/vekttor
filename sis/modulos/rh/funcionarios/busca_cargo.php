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

$empresa_id=$_GET['empresa_id'];

if($_GET['acao']=='cargo'){
	$q=mysql_query($t="SELECT * FROM cargo_salario WHERE vkt_id='$vkt_id' AND cargo like '%$_GET[busca_auto_complete]%' AND (empresa_id='$empresa_id' OR empresa_id='0') LIMIT 15");
	
}
if($_GET['acao']=='cbo'){
	$q=mysql_query($t="SELECT * FROM cargo_salario WHERE vkt_id='$vkt_id' AND cbo like '%$_GET[busca_auto_complete]%' AND (empresa_id='$empresa_id' OR empresa_id='0') LIMIT 15");
	
}
 
$i=0;

while($r= mysql_fetch_object($q)){
	echo urlencode("$r->id|$r->cbo|$r->cargo|".moedaUsaToBr($r->valor_salario)."|\n");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado|0|0\n");
}
?> 