<?
include("../../../_config.php");


$ip = $_SERVER[REMOTE_ADDR];
$infos = explode('|',base64_decode($_GET[usr]));
$cliente_fornecedor_id 		= $infos[0];
$vkt_id 			= $infos[1];
$email_marketing_id = $infos[2];

$i = mysql_fetch_object(mysql_query("SELECT * from emailmarketing_retorno WHERE vkt_id='$vkt_id' AND  emailmarketing_id='$email_marketing_id' AND cliente_fornecedor_id='$cliente_fornecedor_id'"));
if($i->id<1){
	mysql_query("INSERT INTO emailmarketing_retorno SET ip='$ip',vkt_id='$vkt_id', emailmarketing_id='$email_marketing_id',cliente_fornecedor_id='$cliente_fornecedor_id',data=now()");
}
?>