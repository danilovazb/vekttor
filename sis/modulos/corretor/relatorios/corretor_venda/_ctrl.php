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
	
	$id = $_GET['id'];
	
	$registro = mysql_fetch_object(mysql_query("SELECT * FROM corretor WHERE id='$id'"));
}

if($_GET["id_total"] > 0){
		$nome = $_GET["nome"];
		$registro_qtd = mysql_fetch_object(mysql_query("SELECT COUNT(ID) as cont FROM contrato AS c WHERE c.situacao = '1' AND corretor_id = '".$_GET["id_total"]."'"));
}

?>