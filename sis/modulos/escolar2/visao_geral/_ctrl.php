<?php

//Ações do Formulário

// Cadastrar
if ( $_POST['action'] == "Salvar" ) {

	//cadastra();
	
}

// Excluir
if ( $_POST['action'] == "Excluir" ) {
	//remover($_POST['id']);
}

// Seleciona
if ( isset( $_GET['id'] )) {
	
	//$registro = mysql_fetch_object(mysql_query( "SELECT * FROM escolar2_series WHERE id = '" . mysql_real_escape_string($_GET['id']) . "'" ));
	
}

?>