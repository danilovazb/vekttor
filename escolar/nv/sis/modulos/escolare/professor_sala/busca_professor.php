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

$q=mysql_query($trace="SELECT *, p.id as p_id FROM escolar_professor p INNER JOIN cliente_fornecedor c
ON p.cliente_fornecedor_id=c.id WHERE p.vkt_id = '$vkt_id' AND (c.nome_contato LIKE '%$_GET[busca_auto_complete]%') AND p.status='1' LIMIT 15");
//echo $trace;
$i=0;
while($r= mysql_fetch_object($q)){
	//$partido = mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_partidos WHERE id='$r->partido_id' "));
	//$coligacao=mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_coligacoes WHERE id ='$r->coligacao_id' "));;
	echo urlencode("$r->nome_contato|$r->p_id|\n");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado\n");
}
?> 