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

$q=mysql_query("SELECT * FROM produto as p WHERE vkt_id ='$vkt_id' 
					AND (nome LIKE '%$_GET[busca_auto_complete]%' OR id='%$_GET[busca_auto_complete]%') LIMIT 15");
$i=0;
while($r= mysql_fetch_object($q)){
	$g=mysql_query("SELECT * FROM produto_grupo WHERE id='{$r->produto_id}' ");
	echo urlencode("$r->nome|$r->id|".str_replace('.',',',$r->preco_venda/$r->conversao/$r->conversao2)."\n");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado, Cadastre em Produto|0|0\n");
}
?> 