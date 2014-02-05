<?php

if($_POST['action']== 'Salvar'){
	manipulaAtendimento($_POST,$vkt_id);
}

if($_POST['action']== 'Excluir'){
	excluiAtendimento($_POST,$vkt_id);
}

if($_GET['id'] > 0){
	$id = $_GET['id'];
	
	$atendimento = mysql_fetch_object(mysql_query("SELECT * FROM os_atendimento WHERE id='$id'"));
}

?>