<?
include("../../_config.php");
// funções base do sistema
include("../../_functions_base.php");
// funções do modulo empreendimento

//$cpf_cnpj =  str_replace=

$q=mysql_query("SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id ='$vkt_id' AND (razao_social  like '%$_GET[busca_auto_complete]%' OR REPLACE(REPLACE(REPLACE(cnpj_cpf,'.','' ),'-',''),'/','') like '%$_GET[busca_auto_complete]%')  LIMIT 15");
$i=0;
while($r= mysql_fetch_object($q)){
	echo urlencode("$r->razao_social|$r->id|$r->cnpj_cpf\n");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado, Cadastre em Clinte ou Fornecedor|0|0\n");
}

?>