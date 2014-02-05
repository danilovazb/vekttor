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
$_GET['busca_auto_complete']=trim($_GET['busca_auto_complete']);
$q=mysql_query($trace="SELECT * FROM eleitoral_colaboradores WHERE tipo_colaborador='0' AND (nome like '%$_GET[busca_auto_complete]%') AND vkt_id='$vkt_id' LIMIT 15");
//echo $trace;
$i=0;
while($r= mysql_fetch_object($q)){
	//$partido = mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_partidos WHERE id='$r->partido_id' "));
	//$coligacao=mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_coligacoes WHERE id ='$r->coligacao_id' "));;
	echo urlencode("$r->nome|$r->funcao|$r->id|\n");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado, Cadastre em Colaborador|0|0\n");
}
?> 