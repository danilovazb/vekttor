<?php

$tb='financeiro_cociliacao_item';
global $tb;
//Ações do Formulário

// Cadastrar
if ( $_POST['action'] == "Importar" && !empty($_FILES['arquivo']) ) {
	mov_arquivo($_POST,$_FILES['arquivo']);
}


// Seleciona
if ( isset ( $_GET['id'] ) ) {
//	$q = mysql_query( "SELECT * FROM $tabela WHERE id = '" . mysql_real_escape_string($_GET['id']) . "'" );
	//$d = mysql_fetch_object ($q);
}

?>