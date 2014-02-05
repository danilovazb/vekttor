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

$q=mysql_query($t="SELECT 
						cf.id, cf.razao_social 
				   FROM 
				   		estoque_vendas ev,
						cliente_fornecedor cf 
				   WHERE 
				   		ev.vkt_id ='$vkt_id' AND 
						ev.fornecedor_id=cf.id AND
						(cf.razao_social LIKE '%$_GET[busca_auto_complete]%') 
						LIMIT 15");
echo $t;
$i=0;
while($r= mysql_fetch_object($q)){
	echo urlencode("$r->id|$r->razao_social");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado|0|0\n");
}
?> 