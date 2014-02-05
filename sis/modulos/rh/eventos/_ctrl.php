<?php

if($_POST['action']== 'Salvar'){
	manipulaEventos($_POST);
}

if($_POST['action']== 'Excluir'){
	excluiCargosSalarios($_POST,$vkt_id);
}

if($_GET['id'] > 0){
	
	$id = $_GET['id'];
	
	$evento = mysql_fetch_object(mysql_query("SELECT * FROM rh_eventos WHERE id='$id'"));
}

?>