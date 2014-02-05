<?php
// configuraçao inicial do sistema
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");

$eleitor_id = base64_decode($_GET['eleitor_id']);

mysql_query("UPDATE eleitoral_eleitores SET recebe_email = 'nao' WHERE id=$eleitor_id");

$email = mysql_fetch_object(mysql_query($t="SELECT vkt_id,email FROM eleitoral_eleitores WHERE id='$eleitor_id'"));
$rementente = mysql_fetch_object(mysql_query("SELECT nome FROM clientes_vekttor WHERE id='$email->vkt_id'"));
?>
<html>
<head>
<style>
body {
    background: url("http://vkt.srv.br/~nv/fontes/img/bglogin.png") repeat-x scroll 0 0 transparent;
	
}
#mensagem{
	width:40%;
	margin-top:10%;
	margin-left:auto;
	margin-right:auto;
	font-size:18px;
}
</style>
</head>
<body>
<div id="topo" style="width:100%; float:left; ">
<img style="display:block; margin:50px auto 20px auto; " src="http://vkt.srv.br/~nv/sis/modulos/vekttor/clientes/img/<?=$email->vkt_id?>.png">
</div>
<div style="clear:both"></div>
<div id="mensagem">
	O envio autom&aacute;tico de emails para o e-mail <strong><?=$email->email?></strong> foi cancelado
</div>
</body>
</html>