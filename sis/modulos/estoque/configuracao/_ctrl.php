<?php

if($_POST['action']== 'Salvar'){
	if($_POST['id']>0){
		altera_config($_POST);
	}else{
		insere_config($_POST);
	}
}
if($_POST['action']== 'Excluir'){
	deletar_corretor($_POST['id']);
}

if($_GET['id'] > 0){
	
	$id = $_GET['id'];
	
	$registro = mysql_fetch_object(mysql_query("SELECT * FROM estoque_config WHERE id='$id'"));
}

?>