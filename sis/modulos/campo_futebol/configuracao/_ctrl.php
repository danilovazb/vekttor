<?
if($_POST['id']>0){$config_id=$_POST['id'];}
if($_GET['id']>0){$config_id=$_GET['id'];}

if($_POST['action']=='Salvar'){
	manipulaConfiguracaoReserva($_POST);
}
if($_POST['action']=='Excluir'){
	deletaConfiguracaoReserva($_POST['id']);
}


	$config=mf(mq("SELECT * FROM campo_futebol_reserva_config_pagamento WHERE vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));