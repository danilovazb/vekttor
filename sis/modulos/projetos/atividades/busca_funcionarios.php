<?
include("../../../_config.php");
// fun��es base do sistema
include("../../../_functions_base.php");
// fun��es do modulo empreendimento

//$cpf_cnpj =  str_replace=

$q=mysql_query($as="SELECT * FROM usuario WHERE cliente_vekttor_id ='$vkt_id' AND nome LIKE '%$_GET[busca_auto_complete]%' LIMIT 15");
$i=0;
while($r= mysql_fetch_object($q)){
	
	echo urlencode("$r->nome|$r->id \n");
	$i++;
}

if($i==0){
	echo urlencode("N�o Encontrado,".mysql_error()."  Cadastre em Usu�rios|0|0\n ");
}

?>