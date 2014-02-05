<?
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento

//$cpf_cnpj =  str_replace=

$q=mysql_query($as="SELECT * FROM projetos WHERE vkt_id ='$vkt_id' AND nome LIKE '%$_GET[busca_auto_complete]%' LIMIT 15");
$i=0;
while($r= mysql_fetch_object($q)){
	$cliente = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$r->cliente_fornecedor_id'"));
	
	echo urlencode("$r->nome|$r->id|$cliente->razao_social|$r->cliente_fornecedor_id\n");
	$i++;
}

if($i==0){
	echo urlencode("Não Encontrado,".mysql_error()."  Cadastre em Projetos|0|0\n ");
}

?>