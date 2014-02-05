<?php

if($_POST['action']== 'Salvar'){
	manipulaFuncionario($_POST,$vkt_id);
}

if($_POST['action']== 'Excluir'){
	excluiFuncionario($_POST,$vkt_id);
}

if($_GET['id'] > 0){
	
	$id = $_GET['id'];
	
	$funcionario = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$id'"));
}

?>