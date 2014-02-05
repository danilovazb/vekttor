<?
include("sis/_config.php");


$ip = $_SERVER[REMOTE_ADDR];

if(isset($_GET['email_odonto'])){
	
	$infos = explode('|',base64_decode($_GET['email_odonto']));
	$email_id=$infos[0];
	$vkt_id=$infos[1];
	$paciente_id=$infos[2];

	mysql_query("INSERT INTO odonto_relacionamento_retorno SET ip='$ip',vkt_id='$vkt_id', email_id='$email_id',paciente_id='$paciente_id',data=now()");
	exit();
}

$infos = explode('|',base64_decode($_GET[usr]));
$eleitor_id 		= $infos[0];
$vkt_id 			= $infos[1];
$email_marketing_id = $infos[2];
print_r($infos);
$i = mysql_fetch_object(mysql_query("SELECT * from eleitoral_emailmarketing_retorno WHERE vkt_id='$vkt_id' AND  email_marketing_id='$email_marketing_id' AND eleitor_id='$eleitor_id'"));
if($i->id<1){
	mysql_query("INSERT INTO eleitoral_emailmarketing_retorno SET ip='$ip',vkt_id='$vkt_id', email_marketing_id='$email_marketing_id',eleitor_id='$eleitor_id',data=now()");
}
?>