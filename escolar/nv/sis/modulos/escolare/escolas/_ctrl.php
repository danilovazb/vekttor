<?php

//Ações do Formulário

// Cadastrar
if ( $_POST['action'] == "Salvar" ) {
	cadastra();
}

// Excluir
if ( $_POST['action'] == "Excluir" ) {
	remover();
}

// Seleciona
if ( isset ( $_GET['id'] ) ) {
	$q = mysql_query( "SELECT * FROM $tabela WHERE id = '" . mysql_real_escape_string($_GET['id']) . "'" );
	$d = mysql_fetch_object ($q);
}

?>