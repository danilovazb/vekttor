<?php

if($_POST['action']== 'Salvar'){
	manipulaServico($_POST,$vkt_id);
}

if($_POST['action']== 'Excluir'){
	excluiServico($_POST,$vkt_id);
}

if($_GET['id'] > 0){
	
	$id = $_GET['id'];
	
	$servico = mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id='$id'"));
}

?>