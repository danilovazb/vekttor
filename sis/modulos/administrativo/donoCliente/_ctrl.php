<?php

if($_POST['action']== 'Salvar'){
	if($_POST['id']>0){
		altera_corretor($_POST);
	}else{
		insere_corretor($_POST);
	}
}
if($_POST['action']== 'Excluir'){
	deletar_corretor($_POST['id']);
}

if($_GET['id'] > 0){
	
	
	$registro = mysql_fetch_object(mysql_query($t="SELECT * FROM contrato WHERE disponibilidade_id = ".$_GET['id']));
	
}



?>